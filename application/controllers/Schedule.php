<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Schedule extends CI_Controller {

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
		$this->template->load('template','schedule/schedule_wrapper',$data);
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

			$dick = 'DEEEEEEEECK!';

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
			$str .= '<li>'.$this->Mesin_model->get_by_id($value['machine_id'])->nama_mesin.'</li>';
		}

		$op = $data->priority;
		$ex = '';
        if ($op == 0) {
            
          $ex = '<label class="badge bg-success">Biasa</label>';
            
        }

        if ($op == 1) {
            
          $ex = '<label class="badge bg-warning">Urgent</label>';
            
        }

        if ($op == 2) {
            $ex = '<label class="badge bg-danger">Top Urgent</label>';
        }

		$arr = array(
			'id' => $data->id,
			'kd_order' => $data->kd_order,
			'tanggal_produksi' => $data->tanggal_produksi,
			'rencana_selesai' => $data->rencana_selesai,
			'total_barang_jadi' => $data->total_barang_jadi,
			'priority' => $ex,
			'machine_use' => $str
		);

		echo json_encode($arr);
	}
}