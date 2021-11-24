<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Machine_schedule extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Mesin_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Produksi_model');
        $this->load->model('Orders_model');
        $this->load->model('Setting_app_model');
    }

	public function index()
	{
		$getallmachine = $this->Mesin_model->get_all();
		$data = array(
			'classnyak' => $this,
            'mesin_data' => $getallmachine,
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
        );
		$this->template->load('template','schedule_machine/schedule_machine_wrapper',$data);
	}

	function detail($machine,$month,$year)
	{
		$machinedata = $this->Mesin_model->get_by_kd_mesin($machine);
		$dataproduksi = $this->Produksi_model->find_produksi($machine, $month, $year);
		$data =  array(
			'machine_id' => $machinedata->mesin_id,
			'machine_name' => $machinedata->nama_mesin,
			'month' => $month,
			'year' => $year,
			'dataproduksi' => $dataproduksi,
			'classnyak' => $this,
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('template','schedule_machine/schedule_machine_detail',$data);
	}

	function get_data_order_njson($kdorder,$kdprod)
    {
        $data = $this->Orders_model->get_by_kd_orders_pure($kdorder);
        $dataprod = $this->Produksi_model->get_by_id($kdprod);

        $dt = array(
            'kdorder' => $kdorder,
            'tanggal_order' => $data->tanggal_order,
            'due_date' => $data->due_date,
            'nama_pemesan' => $data->nama_pemesan,
            'priority' => $data->priority,
            'status' => $data->status,
            'attachment' => $data->attachment,
            'barang' => $data->nama_barang,
            'qty' => $data->qty,
            'tanggal_produksi' => $dataprod->tanggal_produksi,
            'rencana_selesai' => $dataprod->rencana_selesai
        );

        return $dt;
    }
}