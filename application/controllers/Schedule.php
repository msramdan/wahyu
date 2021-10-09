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

	function machine_list()
	{
		$getalloperator = $this->Karyawan_model->get_all();
		$getallreadyproduksi = $this->Produksi_model->get_all_ready();
		$getallreadyfinishingproduksi = $this->Produksi_model->get_all_ready_finishing();

		$getallmachineproduction = $this->Mesin_model->get_all('PRODUCTION');
		$getallmachinefinishing = $this->Mesin_model->get_all('FINISHING');

		$data = array(

			'classnyak' => $this,
			'getalloperator' => $getalloperator,
			'getallreadyproduksi' => $getallreadyproduksi,
			'getallreadyfinishingproduksi' => $getallreadyfinishingproduksi,
			'machine_list_production' => $getallmachineproduction,
            'machine_list_finishing' => $getallmachinefinishing
        );
		$this->load->view('schedule/machine_list',$data);
	}

	function schedule_list()
	{
		$data = array(
			'classnyak' => $this,
        );
		$this->load->view('schedule/schedule_list',$data);
	}

	function machine_listJSON()
	{
		$getalloperator = $this->Karyawan_model->get_all();
		$getallreadyproduksi = $this->Produksi_model->get_all_ready();
		$getallreadyfinishingproduksi = $this->Produksi_model->get_all_ready_finishing();

		$getallmachineproduction = $this->Mesin_model->get_all('PRODUCTION');
		$getallmachinefinishing = $this->Mesin_model->get_all('FINISHING');

		$data = array(

			'classnyak' => $this,
			'getalloperator' => $getalloperator,
			'getallreadyproduksi' => $getallreadyproduksi,
			'getallreadyfinishingproduksi' => $getallreadyfinishingproduksi,
			'machine_list_production' => $getallmachineproduction,
            'machine_list_finishing' => $getallmachinefinishing
        );
		return $this->load->view('schedule/machine_list',$data, true);
	}

	function update_machine()
	{
		$id_mesin = $this->input->post('id_mesin');
		$operator = $this->input->post('operator_name');
		$kode_produksi = $this->input->post('kode_produksi');
		// $status_mesin = $this->input->post('status_mesin');
		$action = $this->input->post('action');
		$jenis_mesin = $this->input->post('machine_type');

		$arrayName = array(
			'mesinid' => $id_mesin,
			'operator' => $operator,
			'kd_produksi' => $kode_produksi,
			// 'statusmesin' => $status_mesin,
			'action' => $action
		);

		$status = '';
		$msg = '';

		if ($action == 'activate') {
			$status = 'ok';
			$msg = 'Mesin ditandai sebagai sedang digunakan';

			$dataaa = array(
				'operator' => $operator,
				'kd_produksi' => $kode_produksi,
				'status' => 'IN USE',
				'tindakan_terakhir' => date('Y-m-d h:m:s')
			);

			$this->Mesin_model->update($id_mesin, $dataaa);

			if ($jenis_mesin == 'PRODUCTION') {
				$dataproduksi = array(
					'status' => 'ON GOING'
				);

				$this->Produksi_model->update($kode_produksi,$dataproduksi);
			}

			if ($jenis_mesin == 'FINISHING') {
				$dataproduksi = array(
					'status' => 'FINISHING',
				);
				$this->Produksi_model->update($kode_produksi,$dataproduksi);
			}
		}

		if ($action == 'pause') {
			$status = 'ok';
			$msg = 'Mesin ditandai sebagai ditahan penggunaannya';

			$dataaa = array(
				'operator' => $operator,
				'kd_produksi' => $kode_produksi,
				'status' => 'PAUSED',
				'tindakan_terakhir' => date('Y-m-d h:m:s')
			);

			$this->Mesin_model->update($id_mesin, $dataaa);
		}

		if($action == 'stop') {
			$status = 'ok';
			$msg = 'Mesin ditandai sebagai sedang tidak digunakan';

			if ($jenis_mesin == 'PRODUCTION') {
				$dataproduksi = array(
					'status' => 'READY FINISHING',
				);
				$this->Produksi_model->update($kode_produksi,$dataproduksi);
			}

			if ($jenis_mesin == 'FINISHING') {
				$dataproduksi = array(
					'status' => 'DONE',
					'aktual_selesai' => date('Y-m-d h:m:s')
				);
				$this->Produksi_model->update($kode_produksi,$dataproduksi);
			}

			$dataaa = array(
				'operator' => 'N/A',
				'kd_produksi' => 'N/A',
				'status' => 'READY',
				'tindakan_terakhir' => date('Y-m-d h:m:s')
			);

			$this->Mesin_model->update($id_mesin, $dataaa);
		}


		$data = array(
			'status' => $status,
			'msg' => $msg,
			'page' => $this->machine_listJSON()
		);

		echo json_encode($data);
	}

	function getdataoperator($id)
	{
		return $this->Karyawan_model->get_by_id($id);
	}
	function get_production_ready_schedule()
	{
		$data = array(
			'listofready' => $this->Produksi_model->get_production_ready()
		); 
		$this->load->view('schedule/produksi_ready',$data);
	}
	function get_production_ongoing_schedule()
	{
		$data = array(
			'listofongoing' => $this->Produksi_model->get_production_ongoing(),
			'classnyak' => $this
		);
		$this->load->view('schedule/produksi_ongoing',$data);
	}

	function get_production_done_schedule()
	{
		$data = array(
			'listofdone' => $this->Produksi_model->get_production_done(date('d'))
		);
		$this->load->view('schedule/produksi_done',$data);
	}

	function cekkodeproduksipadamesin($kode_produksi)
	{
		$cek = $this->Mesin_model->get_operator_mesin($kode_produksi);
		return $cek;
	}
}