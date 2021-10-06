<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bentuk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Bentuk_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $bentuk = $this->Bentuk_model->get_all();
        $data = array(
            'bentuk_data' => $bentuk,
        );
        $this->template->load('template','bentuk/bentuk_list', $data);
    }

    public function read($id) 
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Bentuk_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
		'kode_bentuk' => $row->kode_bentuk,
		'nama_bentuk' => $row->nama_bentuk,
	    );
            $this->template->load('template','bentuk/bentuk_read', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('bentuk'));
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');
        $data = array(
            'button' => 'Create',
            'action' => site_url('bentuk/create_action'),
	    'kode_bentuk' => set_value('kode_bentuk'),
	    'nama_bentuk' => set_value('nama_bentuk'),
	);
        $this->template->load('template','bentuk/bentuk_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_bentuk' => $this->input->post('nama_bentuk',TRUE),
	    );

            $this->Bentuk_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('bentuk'));
        }
    }
    
    public function update($id) 
    {
        is_allowed($this->uri->segment(1),'update');
        $row = $this->Bentuk_model->get_by_id(decrypt_url($id));

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('bentuk/update_action'),
		'kode_bentuk' => set_value('kode_bentuk', $row->kode_bentuk),
		'nama_bentuk' => set_value('nama_bentuk', $row->nama_bentuk),
	    );
            $this->template->load('template','bentuk/bentuk_form', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('bentuk'));
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_bentuk', TRUE));
        } else {
            $data = array(
		'nama_bentuk' => $this->input->post('nama_bentuk',TRUE),
	    );

            $this->Bentuk_model->update($this->input->post('kode_bentuk', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('bentuk'));
        }
    }
    
    public function delete($id) 
    {
        is_allowed($this->uri->segment(1),'delete');
        $row = $this->Bentuk_model->get_by_id(decrypt_url($id));

        if ($row) {
            $this->Bentuk_model->delete(decrypt_url($id));
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('bentuk'));
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('bentuk'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_bentuk', 'nama bentuk', 'trim|required');

	$this->form_validation->set_rules('kode_bentuk', 'kode_bentuk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'read');
        $this->load->helper('exportexcel');
        $namaFile = "bentuk.xls";
        $judul = "bentuk";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Bentuk");

	foreach ($this->Bentuk_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_bentuk);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Bentuk.php */
/* Location: ./application/controllers/Bentuk.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-05 10:13:24 */
/* http://harviacode.com */