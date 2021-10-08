<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mesin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Mesin_model');
        $this->load->model('Setting_app_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $mesin = $this->Mesin_model->get_all();
        $data = array(
            'mesin_data' => $mesin,
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
            'classnyak' => $this
        );
        $this->template->load('template','mesin/mesin_wrapper', $data);
    }

    public function list()
    {
        is_allowed($this->uri->segment(1),null);
        $mesin = $this->Mesin_model->get_all();
        $data = array(
            'mesin_data' => $mesin,
        );
        $this->load->view('mesin/mesin_list', $data);
    }

    public function read() 
    {
        is_allowed($this->uri->segment(1),'read');
        $id = $this->input->post('id');
        $row = $this->Mesin_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
        		'mesin_id' => $row->mesin_id,
        		'kd_mesin' => $row->kd_mesin,
        		'nama_mesin' => $row->nama_mesin,
        		'Keterangan' => $row->Keterangan,
    	    );
            $this->load->view('mesin/mesin_read', $data);
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
    	    'mesin_id' => set_value('mesin_id'),
    	    'kd_mesin' => set_value('kd_mesin'),
    	    'nama_mesin' => set_value('nama_mesin'),
    	    'Keterangan' => set_value('Keterangan'),
    	);
        $this->load->view('mesin/mesin_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');

        $data = array(
    		'kd_mesin' => $this->input->post('kd_mesin',TRUE),
    		'nama_mesin' => $this->input->post('nama_mesin',TRUE),
    		'Keterangan' => $this->input->post('Keterangan',TRUE),
            'status' => 'READY',
            'operator' => 'N/A',
            'kd_produksi' => 'N/A',
            'tindakan_terakhir' => null
	    );

        $this->Mesin_model->insert($data);
        $this->list();
    }
    
    public function update() 
    {
        is_allowed($this->uri->segment(1),'update');
        $id = $this->input->post('id');
        $row = $this->Mesin_model->get_by_id(decrypt_url($id));

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => 'form_update_action',
        		'mesin_id' => $row->mesin_id,
        		'kd_mesin' => set_value('kd_mesin', $row->kd_mesin),
        		'nama_mesin' => set_value('nama_mesin', $row->nama_mesin),
        		'Keterangan' => set_value('Keterangan', $row->Keterangan),
    	    );
            $this->load->view('mesin/mesin_form', $data);
        } else {
            echo 'not found';
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        
        $data = array(
    		'kd_mesin' => $this->input->post('kd_mesin',TRUE),
    		'nama_mesin' => $this->input->post('nama_mesin',TRUE),
    		'Keterangan' => $this->input->post('Keterangan',TRUE),
	    );

        $this->Mesin_model->update($this->input->post('mesin_id', TRUE), $data);
        $this->list();
    
    }
    
    public function delete() 
    {
        is_allowed($this->uri->segment(1),'delete');
        $id = $this->input->post('id');
        $row = $this->Mesin_model->get_by_id(decrypt_url($id));

        if ($row) {
            $this->Mesin_model->delete(decrypt_url($id));
        } else {
            echo 'not found';
        }
        $this->list();
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kd_mesin', 'kd mesin', 'trim|required');
	$this->form_validation->set_rules('nama_mesin', 'nama mesin', 'trim|required');
	$this->form_validation->set_rules('Keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('mesin_id', 'mesin_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'read');
        $this->load->helper('exportexcel');
        $namaFile = "mesin.xls";
        $judul = "mesin";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Kd Mesin");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Mesin");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

	foreach ($this->Mesin_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_mesin);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_mesin);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Keterangan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function detect_kd_mesin()
    {
        $kd_mesin = $this->input->post('kd_mesin');
        $data = $this->Mesin_model->detect_availibilty_mesin_id($kd_mesin);
        $arr = '';

        if ($data > 0) {
            $arr = array(
                'class' => 'is-invalid',
                'appendedelement' => '<div class="invalid-feedback">Kode sudah digunakan oleh mesin lain</div>',
                'a' => 'none'
            );
        } else {
            $arr = array(
                'class' => 'is-valid',
                'appendedelement' => '<div class="valid-feedback">Kode Bisa Digunakan</div>',
                'a'=>'inline'
            );
        }

        echo json_encode($arr);
    }

}

/* End of file Mesin.php */
/* Location: ./application/controllers/Mesin.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-09-27 15:51:44 */
/* http://harviacode.com */