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
		$data = array(
			'classnyak' => $this,
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
        );
		$this->template->load('template','schedule/schedule_wrapper',$data);
	}

	function machine_list()
	{
		$getallmachine = $this->Mesin_model->get_all();
		$data = array(
            'machine_list' => $getallmachine,
			'classnyak' => $this
        );
		$this->load->view('schedule/machine_lists',$data);
	}

	function show_machine($mesin_id)
	{
		$getalloperator = $this->Karyawan_model->get_all();
		$getallproduksi = $this->Produksi_model->get_all('READY');
		$datamesin = $this->Mesin_model->get_by_id($mesin_id);

		$data = array(
			'getalloperator' => $getalloperator,
			'getallproduksi' => $getallproduksi,
			'datamesin' => $datamesin
		);
		$this->load->view('schedule/machine_data',$data);
	}

	function show_machineJSON($mesin_id)
	{
		$getalloperator = $this->Karyawan_model->get_all();
		$getallproduksi = $this->Produksi_model->get_all('READY');
		$datamesin = $this->Mesin_model->get_by_id($mesin_id);

		$data = array(
			'getalloperator' => $getalloperator,
			'getallproduksi' => $getallproduksi,
			'datamesin' => $datamesin,
			'classnyak' => $this
		);
		return $this->load->view('schedule/machine_data',$data, true);
	}

	function update_machine()
	{
		$id_mesin = $this->input->post('id_mesin');
		$operator = $this->input->post('operator_name');
		$kode_produksi = $this->input->post('kode_produksi');
		// $status_mesin = $this->input->post('status_mesin');
		$action = $this->input->post('action');

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

			$dataproduksi = array(
				'status' => 'ON GOING'
			);

			$this->Produksi_model->update($kode_produksi,$dataproduksi);
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

			$dataaa = array(
				'operator' => 'N/A',
				'kd_produksi' => 'N/A',
				'status' => 'READY',
				'tindakan_terakhir' => date('Y-m-d h:m:s')
			);

			$this->Mesin_model->update($id_mesin, $dataaa);

			$dataproduksi = array(
				'status' => 'DONE',
				'aktual_selesai' => date('Y-m-d h:m:s')
			);
			$this->Produksi_model->update($kode_produksi,$dataproduksi);
		}


		$data = array(
			'status' => $status,
			'msg' => $msg,
			'page' => $this->show_machineJSON($id_mesin)
		);

		echo json_encode($data);
	}

	function getdataoperator($id)
	{
		return $this->Karyawan_model->get_by_id($id);
	}
}