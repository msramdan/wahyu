<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Mesin_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Produksi_model');
        $this->load->model('Setting_app_model');
    }

	public function index()
	{
		$getallmachine = $this->Mesin_model->get_all();
		$data = array(
			'classnyak' => $this,
          	'machine_list' => $getallmachine,
          	'sett_apps' =>$this->Setting_app_model->get_by_id(1),
        );
		$this->template->load('template','dashboard',$data);
	}

	function showtotallogin($day)
	{
		return $this->db->query("SELECT COUNT(user_id) AS 'tl' FROM `history_login` WHERE day(tanggal) = ".$day.";")->row();
	}

	// function showactivemachine()
	// {
	// 	return $this->db->query("SELECT COUNT(user_id) AS 'tl' FROM `history_login` WHERE day(tanggal) = ".$day.";")->row();
	// }

	function showtotalmaterial()
	{
		return $this->db->query("SELECT SUM(qty) AS 'total' FROM `material`")->row();
	}

	function showtotalactiveproduction()
	{
		$valarray = array('ON GOING','FINISHING','READY FINISHING');
		return $this->db->where_in('status',$valarray)->from('produksi')->get()->num_rows();
	}

	function getaveragetimesdone()
	{
		$q = $this->db->query("
			SELECT 
			    AVG(@diff:=ABS( UNIX_TIMESTAMP(aktual_selesai) - UNIX_TIMESTAMP())) , 
			    AVG(CAST(@days := IF(@diff/86400 >= 1, floor(@diff / 86400 ),0) AS SIGNED)) as days, 
			    AVG(CAST(@hours := IF(@diff/3600 >= 1, floor((@diff:=@diff-@days*86400) / 3600),0) AS SIGNED)) as hours, 
			    AVG(CAST(@minutes := IF(@diff/60 >= 1, floor((@diff:=@diff-@hours*3600) / 60),0) AS SIGNED)) as minutes, 
			    AVG(CAST(@diff-@minutes*60 AS SIGNED)) as seconds
			 FROM produksi;
			");
		return $this->db->get($q)->row();
	}

	function getallschedule()
	{
		$stringobject = '';
		$getall = $this->Produksi_model->get_all_schedule();
		foreach ($getall as $key => $value) {
			
			$tanggal_produksi = new DateTime($value->tanggal_produksi);
			$rencana_selesai = new DateTime($value->rencana_selesai);

			$color = '';

			if ($value->priority == 0) {
				$color = '#04c142';
			}

			if ($value->priority == 1) {
				$color = '#ff7b01';
			}

			if ($value->priority == 2) {
				$color = '#ff3502';
			}

			$stringobject.=
				'{
					title: "'. $value->id.'",
					start: "'. $tanggal_produksi->format(DateTime::ATOM).'",
					end: "'. $rencana_selesai->format(DateTime::ATOM).'",
					color: "' .$color.'"
				},';
		}

		echo $stringobject;
	}

	function getdataoperator($id)
	{
		return $this->Karyawan_model->get_by_id($id);
	}

	function getdetailschedule($id)
	{
		$data = $this->Produksi_model->get_by_id($id);

		$dm = json_decode($data->machine_use, TRUE);

		$str = '';

		foreach ($dm as $key => $value) {
			$str .= '<li>'.$this->Mesin_model->get_by_kd_mesin($value['machine_id'])->nama_mesin.'</li>';
		}

		$op = $data->priority;

		$sts = $data->status;
		$ex = '';
		$st = '';

		if ($op == 0) {
		$ex = '<label class="badge bg-success">Biasa</label>';        
		}

		if ($op == 1) {
		$ex = '<label class="badge bg-warning">Urgent</label>';
		}

		if ($op == 2) {
			$ex = '<label class="badge bg-danger">Top Urgent</label>';
		}

		if ($op == 0) {
		$ex = '<label class="badge bg-success">Biasa</label>';        
		}

		if ($op == 1) {
		$ex = '<label class="badge bg-warning">Urgent</label>';
		}

		if ($op == 2) {
			$ex = '<label class="badge bg-danger">Top Urgent</label>';
		}

		if ($sts == 'WAITING'){
			$st = '<label class="badge bg-warning">Dalam Review</label>';
		}

		if ($sts == 'DONE') {
			$st = '<label class="badge bg-success">Selesai</label>';
		}

		if ($sts == 'ON PROGRESS') {
			$st = '<label class="badge bg-info">Diproses</label>';
		}

		if ($sts == 'REJECTED') {
			$st = '<label class="badge bg-danger">Perlu Revisi</label>';
		}

		$arr = array(
			'id' => $data->id,
			'kd_order' => $data->kd_order,
			'tanggal_produksi' => $data->tanggal_produksi,
			'rencana_selesai' => $data->rencana_selesai,
			'total_barang_jadi' => $data->total_barang_jadi,
			'priority' => $ex,
			'status' => $st,
			'machine_use' => $str
		);

		echo json_encode($arr);
	}

}