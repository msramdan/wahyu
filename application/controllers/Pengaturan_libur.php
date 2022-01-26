<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengaturan_libur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Pengaturan_libur_model');
        $this->load->model('Setting_app_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $pengaturan_libur = $this->Pengaturan_libur_model->get_all();
        $data = array(
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
            'pengaturan_libur_data' => $pengaturan_libur,
        );
        $this->template->load('template','pengaturan_libur/tanggal_libur_list', $data);
    }

    public function read($id) 
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Pengaturan_libur_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nama_hari_libur' => $row->nama_hari_libur,
		'tanggal' => $row->tanggal,
        'sett_apps' =>$this->Setting_app_model->get_by_id(1),
	    );
            $this->template->load('template','pengaturan_libur/tanggal_libur_read', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('pengaturan_libur'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('pengaturan_libur/create_action'),
	    'id' => set_value('id'),
	    'nama_hari_libur' => set_value('nama_hari_libur'),
	    'tanggal' => set_value('tanggal'),
        'sett_apps' =>$this->Setting_app_model->get_by_id(1),
	);
        $this->template->load('template','pengaturan_libur/tanggal_libur_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_hari_libur' => $this->input->post('nama_hari_libur',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
	    );

            $this->Pengaturan_libur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pengaturan_libur'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Pengaturan_libur_model->get_by_id(decrypt_url($id));

        if ($row) {
            $data = array(
                'sett_apps' =>$this->Setting_app_model->get_by_id(1),
                'button' => 'Update',
                'action' => site_url('pengaturan_libur/update_action'),
		'id' => set_value('id', $row->id),
		'nama_hari_libur' => set_value('nama_hari_libur', $row->nama_hari_libur),
		'tanggal' => set_value('tanggal', $row->tanggal),
	    );
            $this->template->load('template','pengaturan_libur/tanggal_libur_form', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('pengaturan_libur'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nama_hari_libur' => $this->input->post('nama_hari_libur',TRUE),
		'tanggal' => $this->input->post('tanggal',TRUE),
	    );

            $this->Pengaturan_libur_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pengaturan_libur'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Pengaturan_libur_model->get_by_id(decrypt_url($id));

        if ($row) {
            $this->Pengaturan_libur_model->delete(decrypt_url($id));
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengaturan_libur'));
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('pengaturan_libur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_hari_libur', 'nama hari libur', 'trim|required');
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'read');
        $this->load->helper('exportexcel');
        $namaFile = "tanggal_libur.xls";
        $judul = "tanggal_libur";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Hari Libur");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");

	foreach ($this->Pengaturan_libur_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_hari_libur);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Pengaturan_libur.php */
/* Location: ./application/controllers/Pengaturan_libur.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-01-23 06:15:02 */
/* http://harviacode.com */