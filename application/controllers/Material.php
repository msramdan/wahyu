<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Material_model');
        $this->load->model('Bentuk_model');
        $this->load->model('Jenis_material_model');
        $this->load->model('Setting_app_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $material = $this->Material_model->get_all();
        $data = array(
            'sett_apps' => $this->Setting_app_model->get_by_id(1),
            'material_data' => $material,
            'classnyak' => $this
        );
        $this->template->load('template','material/material_wrapper', $data);
    }

    public function list()
    {
        is_allowed($this->uri->segment(1),null);
        $material = $this->Material_model->get_all();
        $data = array(
            'material_data' => $material
        );
        $this->load->view('material/material_list', $data);
    }

    public function read() 
    {
        is_allowed($this->uri->segment(1),'read');
        $id = $this->input->post('id');
        $row = $this->Material_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
        		'id' => $row->id,
        		'kd_material' => $row->kd_material,
        		'id_bentuk' => $row->id_bentuk,
        		'id_jenis_material' => $row->id_jenis_material,
        		'dimensi' => $row->dimensi,
        		'berat_per_pcs' => $row->berat_per_pcs,
        		'berat_total' => $row->berat_total,
        		'qty' => $row->qty,
        		'masa_jenis_material' => $row->masa_jenis_material,
        		'volume' => $row->volume,
    	    );
            $this->load->view('material/material_read', $data);
        } else {
            echo "no data";
        }
    }

    public function create() 
    {
        is_allowed($this->uri->segment(1),'create');

        $list_bentuk = $this->Bentuk_model->get_all();
        $list_jenis_material = $this->Jenis_material_model->get_all();

        $data = array(
            'button' => 'Create',
            'action' => 'form_create_action',
    	    'id' => set_value('id'),
    	    'kd_material' => set_value('kd_material'),
    	    'id_bentuk' => set_value('id_bentuk'),
    	    'id_jenis_material' => set_value('id_jenis_material'),
    	    'diametertebal' => set_value('diametertebal', 0),
            'panjang' => set_value('panjang', 0),
            'lebar' => set_value('lebar', 0),
    	    'berat_per_pcs' => set_value('berat_per_pcs',0),
    	    'berat_total' => set_value('berat_total',0),
    	    'qty' => set_value('qty',0),
    	    'masa_jenis_material' => set_value('masa_jenis_material',0),
    	    'volume' => set_value('volume',0),
            'list_bentuk' => $list_bentuk,
            'list_jenis_material' => $list_jenis_material,
            'sett_apps' => $this->Setting_app_model->get_by_id(1),
    	);
        $this->load->view('material/material_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');

        $arr = array(
            'diametertebal' => $this->input->post('diametertebal',TRUE),
            'panjang' => $this->input->post('panjang',TRUE),
            'lebar' => $this->input->post('lebar',TRUE)
        );

        $data = array(
    		'kd_material' => $this->input->post('kd_material',TRUE),
    		'id_bentuk' => $this->input->post('id_bentuk',TRUE),
    		'id_jenis_material' => $this->input->post('id_jenis_material',TRUE),
    		'dimensi' => json_encode($arr),
    		'berat_per_pcs' => $this->input->post('berat_per_pcs',TRUE),
    		'berat_total' => $this->input->post('berat_total',TRUE),
    		'qty' => $this->input->post('qty',TRUE),
    		'masa_jenis_material' => $this->input->post('masa_jenis_material',TRUE),
    		'volume' => $this->input->post('volume',TRUE),
        );
        // print_r($data);
        $this->Material_model->insert($data);
        $this->list();
    }
    
    public function update() 
    {
        is_allowed($this->uri->segment(1),'update');

        $id = $this->input->post('id');

        $row = $this->Material_model->get_by_id(decrypt_url($id));

        if ($row) {
            $list_bentuk = $this->Bentuk_model->get_all();
            $list_jenis_material = $this->Jenis_material_model->get_all();
            $pecah = json_decode($row->dimensi, TRUE);
            $data = array(
                'button' => 'Update',
                'action' => 'form_update_action',
        		'id' => $row->id,
        		'kd_material' => set_value('kd_material', $row->kd_material),
        		'id_bentuk' => set_value('id_bentuk', $row->id_bentuk),
        		'id_jenis_material' => set_value('id_jenis_material', $row->id_jenis_material),
        		'diametertebal' => set_value('diametertebal', $pecah['diametertebal']),
                'panjang' => set_value('panjang', $pecah['panjang']),
                'lebar' => set_value('lebar', $pecah['lebar']),
        		'berat_per_pcs' => set_value('berat_per_pcs', $row->berat_per_pcs),
        		'berat_total' => set_value('berat_total', $row->berat_total),
        		'qty' => set_value('qty', $row->qty),
                'list_bentuk' => $list_bentuk,
                'list_jenis_material' => $list_jenis_material,
        		'masa_jenis_material' => set_value('masa_jenis_material', $row->masa_jenis_material),
        		'volume' => set_value('volume', $row->volume),
    	    );
            $this->load->view('material/material_form', $data);
        } else {
            echo 'not found';
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');
        $arr = array(
            'diametertebal' => $this->input->post('diametertebal'),
            'panjang' => $this->input->post('panjang'),
            'lebar' => $this->input->post('lebar')
        );

        $data = array(
            'kd_material' => $this->input->post('kd_material',TRUE),
            'id_bentuk' => $this->input->post('id_bentuk',TRUE),
            'id_jenis_material' => $this->input->post('id_jenis_material',TRUE),
            'dimensi' => json_encode($arr),
            'berat_per_pcs' => $this->input->post('berat_per_pcs',TRUE),
            'berat_total' => $this->input->post('berat_total',TRUE),
            'qty' => $this->input->post('qty',TRUE),
            'masa_jenis_material' => $this->input->post('masa_jenis_material',TRUE),
            'volume' => $this->input->post('volume',TRUE),
        );

        $this->Material_model->update($this->input->post('id', TRUE), $data);
        $this->list();
    }
    
    public function delete() 
    {
        is_allowed($this->uri->segment(1),'delete');
        $id = $this->input->post('id');
        $row = $this->Material_model->get_by_id(decrypt_url($id));
        if ($row) {
            $this->Material_model->delete(decrypt_url($id));
        } else {
            echo 'tidak ada';
        }
        $this->list();
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kd_material', 'id material', 'trim|required');
	$this->form_validation->set_rules('id_bentuk', 'id bentuk', 'trim|required');
	$this->form_validation->set_rules('id_jenis_material', 'id jenis material', 'trim|required');
	$this->form_validation->set_rules('dimensi', 'dimensi', 'trim|required');
	$this->form_validation->set_rules('berat_per_pcs', 'berat per pcs', 'trim|required');
	$this->form_validation->set_rules('berat_total', 'berat total', 'trim|required');
	$this->form_validation->set_rules('qty', 'qty', 'trim|required');
	$this->form_validation->set_rules('masa_jenis_material', 'masa jenis material', 'trim|required');
	$this->form_validation->set_rules('volume', 'volume', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'read');
        $this->load->helper('exportexcel');
        $namaFile = "material.xls";
        $judul = "material";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Id Material");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Bentuk");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Jenis Material");
	xlsWriteLabel($tablehead, $kolomhead++, "Dimensi");
	xlsWriteLabel($tablehead, $kolomhead++, "Berat Per Pcs");
	xlsWriteLabel($tablehead, $kolomhead++, "Berat Total");
	xlsWriteLabel($tablehead, $kolomhead++, "Qty");
	xlsWriteLabel($tablehead, $kolomhead++, "Masa Jenis Material");
	xlsWriteLabel($tablehead, $kolomhead++, "Volume");

	foreach ($this->Material_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kd_material);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_bentuk);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_jenis_material);
	    xlsWriteLabel($tablebody, $kolombody++, $data->dimensi);
	    xlsWriteLabel($tablebody, $kolombody++, $data->berat_per_pcs);
	    xlsWriteLabel($tablebody, $kolombody++, $data->berat_total);
	    xlsWriteNumber($tablebody, $kolombody++, $data->qty);
	    xlsWriteLabel($tablebody, $kolombody++, $data->masa_jenis_material);
	    xlsWriteNumber($tablebody, $kolombody++, $data->volume);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function detect_kd_material()
    {
        $kd_material = $this->input->post('kd_material');
        $data = $this->Material_model->detect_availibilty_karyawan_kd($kd_material);
        $arr = '';

        if ($data > 0) {
            $arr = array(
                'class' => 'is-invalid',
                'appendedelement' => '<div class="invalid-feedback">Kode sudah digunakan oleh material lain</div>',
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

/* End of file Material.php */
/* Location: ./application/controllers/Material.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-05 08:53:19 */
/* http://harviacode.com */