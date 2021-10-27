<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Orders extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Orders_model');
        $this->load->model('Setting_app_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $data = array(
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
            'classnyak' => $this
        );
        $this->template->load('template','orders/orders_wrapper', $data);
    }

    public function list()
    {
        is_allowed($this->uri->segment(1),null);
        $orders = $this->Orders_model->get_all();
        $data = array(
            'orders_data' => $orders,
        );
        $this->load->view('orders/orders_list', $data);
    }

    public function read() 
    {
        is_allowed($this->uri->segment(1),'read');
        $id = $this->input->post('id');
        $row = $this->Orders_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
		'order_id' => $row->order_id,
		'nama_pemesan' => $row->nama_pemesan,
		'bagian' => $row->bagian,
		'keterangan' => $row->keterangan,
		'priority' => $row->priority,
		'approved_by' => $row->approved_by,
		'attachment' => $row->attachment,
	    );
            $this->load->view('orders/orders_read', $data);
        } else {
            echo 'not found';
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => 'form_create_action',
    	    'order_id' => set_value('order_id'),
    	    'nama_pemesan' => set_value('nama_pemesan'),
    	    'bagian' => set_value('bagian'),
    	    'keterangan' => set_value('keterangan'),
    	    'priority' => set_value('priority'),
    	    'approved_by' => set_value('approved_by'),
    	    'attachment' => set_value('attachment'),
            'datee' => date('Y-m-d h:m:s')
    	);
        $this->load->view('orders/orders_form', $data);
    }
    
    function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');

        $kode = $this->Orders_model->buat_kode();

   
        $this->load->library('upload'); //call library upload 

        if($_FILES['attachment']['name']){
            $filenamee = 'prodattach-'.date('ymdhms').'-'.substr(sha1(rand()),0,10);

            $config['upload_path']          = './assets/internal'; 
            $config['allowed_types']        = 'jpg|png|pdf';
            $config['max_size']             = 10000;
            $config['file_name']            = $filenamee;

            $_FILES['file']['name'] = $_FILES['attachment']['name'];
            $_FILES['file']['type'] = $_FILES['attachment']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['attachment']['error'];
            $_FILES['file']['size'] = $_FILES['attachment']['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('file');
            $uploadData = $this->upload->data();
            $data = array(
                'nama_pemesan' => $this->input->post('nama_pemesan',TRUE),
                'tanggal_order' => date('Y-m-d h:m:s'),
                'kd_order' => $kode,
                'bagian' => $this->input->post('bagian',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
                'priority' => $this->input->post('priority',TRUE),
                'approved_by' => $this->input->post('approved_by',TRUE),
                'attachment' => $uploadData['file_name'],
                'status' => 'READY'
            );
            // print_r($data);

            $this->Orders_model->insert($data);
            $this->list();
        } else {
            echo 'no files for'.$_FILES['attachment']['name'].'???';
        }
        
    }

    function create_action_then_production() 
    {
        $nama_pemesan = $this->input->post('nama_pemesan',TRUE);
        $bagian = $this->input->post('bagian',TRUE);
        $keterangan = $this->input->post('keterangan',TRUE);
        $priority = $this->input->post('priority',TRUE);
        $approved_by = $this->input->post('approved_by',TRUE);
        $kode = $this->Orders_model->buat_kode();

        $this->load->library('upload'); //call library upload 

        if($_FILES['attachment']['name']){
            $filenamee = 'prodattach-'.date('ymdhms').'-'.substr(sha1(rand()),0,10);

            $config['upload_path']          = './assets/internal'; 
            $config['allowed_types']        = 'jpg|png|pdf';
            $config['max_size']             = 10000;
            $config['file_name']            = $filenamee;

            $_FILES['file']['name'] = $_FILES['attachment']['name'];
            $_FILES['file']['type'] = $_FILES['attachment']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['attachment']['error'];
            $_FILES['file']['size'] = $_FILES['attachment']['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('file');
            $uploadData = $this->upload->data();
            $data = array(
                'nama_pemesan' => $nama_pemesan,
                'tanggal_order' => date('Y-m-d h:m:s'),
                'kd_order' => $kode,
                'bagian' => $bagian,
                'keterangan' => $keterangan,
                'priority' => $priority,
                'approved_by' => $approved_by,
                'attachment' => $uploadData['file_name'],
                'status' => 'READY'
            );
            // print_r($data);

            $this->Orders_model->insert($data);
            
            $a = array(
                'kode_order' => $kode
            );

            echo json_encode($a);
        }
    }

    public function redirect($towhere, $data = null)
    {
        if ($towhere == 'productionaddform') {
            $this->session->set_flashdata('kode_order', $data);
            redirect('produksi/', 'refresh');
        }
    }
    
    public function update() 
    {
        is_allowed($this->uri->segment(1),'update');
        $id = $this->input->post('id');
        $row = $this->Orders_model->get_by_id(decrypt_url($id));

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => 'form_update_action',
        		'order_id' => set_value('order_id', $row->order_id),
        		'nama_pemesan' => set_value('nama_pemesan', $row->nama_pemesan),
        		'bagian' => set_value('bagian', $row->bagian),
        		'keterangan' => set_value('keterangan', $row->keterangan),
        		'priority' => set_value('priority', $row->priority),
        		'approved_by' => set_value('approved_by', $row->approved_by),
        		'attachment' => set_value('attachment', $row->attachment),
    	    );
            $this->load->view('orders/orders_form', $data);
        } else {
            echo 'not found';
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');

        $this->load->library('upload'); //call library upload 

        if($_FILES['attachment']['name']){

            unlink('./assets/internal/'.$this->input->post('attachment_old', TRUE));


            $filenamee = 'prodattach-'.date('ymdhms').'-'.substr(sha1(rand()),0,10);

            $config['upload_path']          = './assets/internal'; 
            $config['allowed_types']        = 'jpg|jpeg|png|pdf';
            $config['max_size']             = 10000;
            $config['file_name']            = $filenamee;

            $_FILES['file']['name'] = $_FILES['attachment']['name'];
            $_FILES['file']['type'] = $_FILES['attachment']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['attachment']['error'];
            $_FILES['file']['size'] = $_FILES['attachment']['size'];
            $this->upload->initialize($config);
            $this->upload->do_upload('file');
            $uploadData = $this->upload->data();
            $data = array(
                'nama_pemesan' => $this->input->post('nama_pemesan',TRUE),
                'bagian' => $this->input->post('bagian',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
                'priority' => $this->input->post('priority',TRUE),
                'approved_by' => $this->input->post('approved_by',TRUE),
                'attachment' => $uploadData['file_name'],
            );
            // print_r($data);

            $this->Orders_model->update($this->input->post('order_id', TRUE), $data);
            $this->list();

        } else {

            $this->list();
        }
    }
    
    public function delete() 
    {
        is_allowed($this->uri->segment(1),'delete');
        $id = $this->input->post('id');
        $row = $this->Orders_model->get_by_id(decrypt_url($id));

        if ($row) {
            unlink('./assets/internal/'.$row->attachment);
            $this->Orders_model->delete(decrypt_url($id));
        } else {
            echo 'not found';
        }

        $this->list();
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_pemesan', 'nama pemesan', 'trim|required');
	$this->form_validation->set_rules('bagian', 'bagian', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('priority', 'priority', 'trim|required');
	$this->form_validation->set_rules('approved_by', 'approved by', 'trim|required');
	$this->form_validation->set_rules('attachment', 'attachment', 'trim|required');

	$this->form_validation->set_rules('order_id', 'order_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        // is_allowed($this->uri->segment(1),'read');
        $this->load->helper('exportexcel');
        $namaFile = "orders.xls";
        $judul = "orders";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Kode Order");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Order");
    	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pemesan");
    	xlsWriteLabel($tablehead, $kolomhead++, "Bagian");
    	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
    	xlsWriteLabel($tablehead, $kolomhead++, "Priority");
    	xlsWriteLabel($tablehead, $kolomhead++, "Approved By");
    	xlsWriteLabel($tablehead, $kolomhead++, "Attachment");

    	foreach ($this->Orders_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->kd_order);
            xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_order);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pemesan);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->bagian);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
    	    xlsWriteNumber($tablebody, $kolombody++, $data->priority);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->approved_by);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->attachment);

    	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-21 04:38:29 */
/* http://harviacode.com */