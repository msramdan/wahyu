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
        $this->load->model('Mesin_model');
        $this->load->model('Material_model');
        $this->load->model('Produksi_model');
        $this->load->model('Bagian_model');
        $this->load->model('Setting_app_model');
        $this->load->model('Level_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);

        $action = $this->input->get('action');

        if ($action == 'waiting') {
            if ($this->session->userdata('level_id') == 219) {
                redirect('not_access');
            }
        }
        
        $data = array(
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
            'action' => $action,
            'classnyak' => $this
        );
        $this->template->load('template','orders/orders_wrapper', $data);
    }

    public function list()
    {
        is_allowed($this->uri->segment(1),null);
        $orders = $this->Orders_model->get_all_by_thisuser($this->session->userdata('userid'));
        $data = array(
            'orders_data' => $orders,
            'classnyak' => $this
        );
        $this->load->view('orders/orders_list', $data);
    }

    public function waiting()
    {
        is_allowed($this->uri->segment(1),null);

        $role = $this->session->userdata('level_id');
        $orders = $this->Orders_model->get_all_waiting();
        $data = array(
            'orders_data' => $orders,
            'rolenya'=> $role,
            'action'=> 'waiting',
            'classnyak' => $this
        );
        $this->load->view('orders/orders_waiting_list', $data);
    }

    public function update_approve($action)
    {
        $id = $this->input->post('id');

        $attachment = $this->input->post('attachmentapprovestatus');
        $material = $this->input->post('materialavailablestatus');
        $etproduction = $this->input->post('kalkulasi');

        $kd_order = $this->input->post('kd_order');
        $reason = $this->input->post('txtrejectreason');

        $responsecode = 1;


        if ($action == 'approve') {

            $cekdataproduksi = $this->Produksi_model->get_by_kd_order($kd_order);

            if (!$cekdataproduksi) {
                $kode = $this->Produksi_model->buat_kode(date('Y-m-d'));

                $dataorder = $this->Orders_model->get_by_kd_orders_pure($kd_order);

                $machine_used = $this->input->post('machine_use');
                $estimateddonepergoodsinminute = $this->input->post('troughputperproduct');
                $goodsallocated = $this->input->post('goodsallocated');
                $etapermachine = $this->input->post('timespentpermachine');


                $arraydetail = [];

                if (count($machine_used) > 0) {
                    for ($i=0; $i < count($machine_used); $i++) {

                        $shift1machine = $this->input->post('shift1machine'.$machine_used[$i]);
                        $shift2machine = $this->input->post('shift2machine'.$machine_used[$i]);

                        $arraydetail[] = array(
                            'machine_id' => $machine_used[$i],
                            'estimateddonepergoods' => $estimateddonepergoodsinminute[$i],
                            'goodsallocated' => $goodsallocated[$i],
                            'shift1' => $shift1machine,
                            'shift2' => $shift2machine,
                            'etapermachine' => $etapermachine[$i],
                        );
                    }
                }

                
                $data = array(
                    'id' => $kode,
                    'created_at' => date('Y-m-d h:m:s'),
                    'kd_order' => $kd_order,
                    'tanggal_produksi' => $this->input->post('tanggal_produksi',TRUE).' '.$this->input->post('jam_awal', TRUE).':00',
                    'total_barang_jadi' => $this->input->post('totalproductions',TRUE),
                    'priority' => $this->input->post('priority',TRUE),
                    'status' => 'WAITING',
                    'rencana_selesai' => $this->input->post('rencana_selesai',TRUE).' '.$this->input->post('jam_akhir', TRUE).':00',
                    'aktual_selesai' => null,
                    'machine_use' => json_encode($arraydetail),
                    'user_id' => $this->session->userdata('userid'),
                );
                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';

                $this->Produksi_model->insert($data);
            }

            $signer = $this->input->post('signer');

            $dataorder = $this->Orders_model->get_by_kd_orders_pure($kd_order);

            $arr_appr = json_decode($dataorder->approved_by,true);


            $detectstepforthissigner = $this->Orders_model->get_step_for_signer($signer, $dataorder->priority)->step;

            $realstep = $detectstepforthissigner;

            // echo 'before <br>';
            // echo '<pre>';
            //     print_r($arr_appr);
            // echo '</pre>';

            $counted = count($arr_appr);

            $a = 'WAITING';


            if ($realstep <= $counted) {
            
                $init = $arr_appr;

                $init[$realstep - 1]['status'] = 'true';
                $init[$realstep - 1]['tanda_tangan'] = 'sudah';
                
                $stepforupcomersigner = $this->Orders_model->get_step_for_signer($init[$realstep - 1]['level_id'], $dataorder->priority)->step;


                if ($stepforupcomersigner > $counted - 1) {
                    $a = 'ON PROGRESS';
                    $responsecode = 2;
                    //echo $a;


                    $idprod = $this->input->post('idproduksi', TRUE);
                    //last approval
                    $dtoupdate = array(
                        'status'=> 'READY'
                    );
                    $this->Produksi_model->update($idprod,$dtoupdate);
                }
                else
                {
                    $init[$stepforupcomersigner]['tanda_tangan'] = 'sekarang';
                }
            }

            // echo '<br><br>aFTER';
            // echo '<pre>';
            //     print_r($init);
            // echo '</pre>';

            $updatedataorder = array(
                'status' => $a,
                'approved_by' => json_encode($init)
            );

            // print_r($updatedataorder);

            $this->Orders_model->update($id, $updatedataorder);


            $orders = $this->Orders_model->get_all_waiting();
            $data = array(
                'orders_data' => $orders,
                'action'=> 'waiting',
                'classnyak' => $this
            );


            $arr = array(
                'response' => $responsecode,
                'page' => $this->load->view('orders/orders_waiting_list', $data, true)//$this->approve($id);
            );

            echo json_encode($arr);



            // if ($responsecode == 2) {
            //     $arr = array(
            //         'response' => $responsecode,
            //         'kd_order' => $kd_order//$this->approve($id);
            //     );

            //     echo json_encode($arr);
            // }


        }

        if($action == 'reject'){


            $signer = $this->input->post('signer');

            if ($signer == 220) {
                if (!$attachment) {
                    $reason.= '[Attachment perlu Perbaikan]';
                }

                if (!$material) {
                    $reason.= '[Kendala Material]';
                }

                if (!$etproduction) {
                    $reason.= '[Estimasi Waktu/Kendala Mesin]';
                }
            }

            $dataorder = $this->Orders_model->get_by_kd_orders_pure($kd_order);

            $arr_appr = json_decode($dataorder->approved_by,true);

            $detectstepforthissigner = $this->Orders_model->get_step_for_signer($signer, $dataorder->priority)->step;

            $realstep = intval($detectstepforthissigner) - 1;

            $init = $arr_appr;

            $init[$realstep]['status'] = 'false';
            $init[$realstep]['tanda_tangan'] = 'sudah';

            //print_r($pp);
            $updatedataorder = array(
                'status' => 'REJECTED',
                'approved_by' => json_encode($init),
                'reject_note' => $reason
            );

            $this->Orders_model->update($id, $updatedataorder);

            $orders = $this->Orders_model->get_all_waiting();
            $data = array(
                'orders_data' => $orders,
                'action'=> 'waiting',
                'classnyak' => $this
            );

            $arr = array(
                'response' => $responsecode,
                'page' => $this->load->view('orders/orders_waiting_list', $data, true)//$this->approve($id);
            );

            echo json_encode($arr);
        }
    }

    public function count_waiting_orders()
    {
        $count = $this->db->where('status', 'WAITING')->get('orders')->num_rows();

        echo json_encode($count);
    }

    // public function approve($id)
    // {
    //     $updatedataorder = array(
    //         'status' => 'ON PROGRESS',
    //         'approved_by' => $this->session->userdata('userid') 
    //     );

    //     $this->Orders_model->update($id, $updatedataorder);
    //     $this->waiting();
    // }

    public function reject($id, $reason)
    {
        $updatedataorder = array(
            'status' => 'REJECTED',
            'approved_by' => $this->session->userdata('userid'),
            'reject_note' => $reason
        );

        $this->Orders_model->update($id, $updatedataorder);
        $this->waiting();
    }

    public function read_w_order() 
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
                'kd_order' => $row->kd_order,
                'nama_barang' => $row->nama_barang,
                'qty' => $row->qty,
                'due_date' => $row->due_date,
                'note' => $row->note,
                'no_kontak' => $row->no_kontak,

                
                'machine_list' => $this->Mesin_model->get_all(),
                'tanggal_produksi' => set_value('tanggal_produksi',date('Y-m-d')),
                'total_barang_jadi' => set_value('total_barang_jadi',1),
                'rencana_selesai' => set_value('rencana_selesai',date('Y-m-d')),

                'priority' => $row->priority,
                'approved_by' => $row->approved_by,
                'attachment' => $row->attachment,
                'status' => $row->status,
                'reject_note' => $row->reject_note,
                'whoisreviewing' => $row->approved_by,
                'classnyak' => $this,
                'material' => $this->Material_model->get_all()

            );
            $this->load->view('orders/orders_waiting_read', $data);

        } else {
            echo 'not found';
        }
    }

    public function detail_order($kd_order)
    {
        is_allowed($this->uri->segment(1),'read');
        $row = $this->Orders_model->get_by_kd_orders_pure($kd_order);
        if ($row) {
            $data = array(
                'order_id' => $row->order_id,
                'nama_pemesan' => $row->nama_pemesan,
                'bagian' => $row->bagian,
                'keterangan' => $row->keterangan,
                'kd_order' => $row->kd_order,
                'nama_barang' => $row->nama_barang,
                'qty' => $row->qty,
                'due_date' => $row->due_date,
                'note' => $row->note,
                'no_kontak' => $row->no_kontak,

                'priority' => $row->priority,
                'approved_by' => $row->approved_by,
                'attachment' => $row->attachment,
                'status' => $row->status,
                'reject_note' => $row->reject_note,
                'classnyak' => $this
            );
            $this->load->view('orders/orders_detail', $data);
        } else {
            echo 'not found';
        }
    }

    public function getlevelname($id)
    {
        $this->load->model('Level_model');
        $data = $this->Level_model->get_by_id($id);
        return $data;
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

                'nama_barang' => $row->nama_barang,
                'qty' => $row->qty,
                'due_date' => $row->due_date,
                'note' => $row->note,
                'no_kontak' => $row->no_kontak,

        		'priority' => $row->priority,
        		'approved_by' => $row->approved_by,
        		'attachment' => $row->attachment,
                'status' => $row->status,
                'reject_note' => $row->reject_note,
                'classnyak' => $this
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
            'no_kontak' => set_value('no_kontak'),

            'nama_barang' => set_value('nama_barang'),
            'qty' => set_value('qty'),
            'due_date' => set_value('due_date'),
            'note' => set_value('note'),

    	    'keterangan' => set_value('keterangan'),
    	    'priority' => set_value('priority'),
    	    'approved_by' => set_value('approved_by'),
    	    'attachment' => set_value('attachment'),
            'datee' => date('Y-m-d h:m:s'),
            'bagian_list' => $this->Bagian_model->get_all()
    	);
        $this->load->view('orders/orders_form', $data);
    }

    function generate_approval_list($priority)
    {
        $data = $this->Orders_model->get_all_approval_name_and_step($priority);

        $arr = [];

        $i = 0;
        
        foreach ($data as $key => $value) {

            $arr[$i]['level_id'] = $value->level_id;
            $arr[$i]['status'] = '-';
            
            if ($i == 0) {
            
                $arr[$i]['tanda_tangan'] = 'sekarang';
            } else {
                $arr[$i]['tanda_tangan'] = 'belum';
            }
            
            $i++;
        }

        return json_encode($arr);

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

                'nama_barang' => $this->input->post('nama_barang',TRUE),
                'qty' => $this->input->post('qty',TRUE),
                'due_date' => $this->input->post('due_date',TRUE),
                'note' => $this->input->post('note',TRUE),
                'no_kontak' => $this->input->post('no_kontak',TRUE),

                'priority' => $this->input->post('priority',TRUE),
                'approved_by' => $this->generate_approval_list($this->input->post('priority',TRUE)),
                'attachment' => $uploadData['file_name'],
                'status' => 'WAITING',

                'reject_note' => null,

                'user_id' => $this->session->userdata('userid')
            );
            // print_r($data);

            $this->Orders_model->insert($data);
            $this->list();
        } else {
            echo 'no files for'.$_FILES['attachment']['name'].'???';
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

                'nama_barang' => set_value('nama_barang', $row->nama_barang),
                'qty' => set_value('qty', $row->qty),
                'due_date' => set_value('due_date', $row->due_date),
                'note' => set_value('note', $row->note),
                'no_kontak' => set_value('no_kontak', $row->no_kontak),

        		'priority' => set_value('priority', $row->priority),
        		'attachment' => set_value('attachment', $row->attachment),
                'bagian_list' => $this->Bagian_model->get_all()
    	    );
            $this->load->view('orders/orders_form', $data);
        } else {
            echo 'not found';
        }
    }

    public function detectalreadysigned($order_id)
    {
        $data = $this->Orders_model->deteksi_already_signed($order_id);
        if ($data) {
            return 1;
        }

        if (!$data) {
            return 0;
        }
    }
    
    public function update_action() 
    {
        is_allowed($this->uri->segment(1),'update');

        $id_order = $this->input->post('order_id', TRUE);

        $cekdataproduksi = $this->Produksi_model->get_by_id($id_order);

        if ($cekdataproduksi) {
            $this->Produksi_model->delete($id_order);
        }

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

                'nama_barang' => $this->input->post('nama_barang',TRUE),
                'qty' => $this->input->post('qty',TRUE),
                'due_date' => $this->input->post('due_date',TRUE),
                'note' => $this->input->post('note',TRUE),
                'no_kontak' => $this->input->post('no_kontak',TRUE),

                'priority' => $this->input->post('priority',TRUE),
                'approved_by' => $this->generate_approval_list($this->input->post('priority',TRUE)),
                'attachment' => $uploadData['file_name'],

                'status' => 'WAITING'
            );
            // print_r($data);

            $this->Orders_model->update($id_order, $data);
            $this->list();

        } else {

            $data = array(
                'nama_pemesan' => $this->input->post('nama_pemesan',TRUE),
                'bagian' => $this->input->post('bagian',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),

                'nama_barang' => $this->input->post('nama_barang',TRUE),
                'qty' => $this->input->post('qty',TRUE),
                'due_date' => $this->input->post('due_date',TRUE),
                'note' => $this->input->post('note',TRUE),
                'no_kontak' => $this->input->post('no_kontak',TRUE),

                'priority' => $this->input->post('priority',TRUE),
                'approved_by' => $this->generate_approval_list($this->input->post('priority',TRUE)),
                'attachment' => $this->input->post('attachment_old',TRUE),

                'status' => 'WAITING'
            );
            // print_r($data);

            $this->Orders_model->update($id_order, $data);
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

    public function search_material($keyword)
    {
        $data = $this->db->like('kd_material',$keyword)->get('material')->result();

        if ($data) {
            $strbuttonresult = '';

            foreach ($data as $key => $value) {

                $dimensi = json_decode($value->dimensi, true);

                $dt = $dimensi['diametertebal'];
                $p = $dimensi['panjang'];
                $l = $dimensi['lebar'];

                $strbuttonresult.= '
                    <button class="btn btn-xs btn-primary btn-fetch-material" data-kdmaterial="'.$value->kd_material.'" data-diametertebal="'.$dt.'" data-panjang="'.$p.'" data-lebar="'.$l.'" data-weight="'.$value->berat_per_pcs.'" data-massamaterial="'.$value->masa_jenis_material.'" data-stok="'.$value->qty.'">'.$value->kd_material.' </button>
                ';
            }

            $output = array(
                'response' => 'found',
                'search_result' => $strbuttonresult,
                'message' => 'found'
            );

            echo json_encode($output);
        } else {
            $strbuttonresult = '';

            $output = array(
                'response' => 'not found',
                'search_result' => '-',
                'message' => '<p style="text-align: center;"><i class="fas fa-comment-alt"></i> Material tidak ditemukan</p></td>'
            );

            echo json_encode($output);
        }

    }

    function getmachinedetail($id)
    {
        $data = $this->Mesin_model->get_by_kd_mesin($id);
        return $data;
    }

    function deteksi_ketersediaan_jadwal() {

        $ds = $this->input->post('ds');
        $de = $this->input->post('de');

        $data = $this->Produksi_model->deteksi_pengunaan_mesin_pada_tanggal($ds,$de);

        $machinelist = $this->Mesin_model->get_all();

        $data_penggunaan_mesin_oleh_produksi_lain = $this->Produksi_model->deteksi_pengunaan_mesin_pada_tanggal($ds,$de);

        $datax = array(
            'machine_list' => $machinelist,
            'data_produksi' => $data_penggunaan_mesin_oleh_produksi_lain
        );

        if ($data) {

            $data_temuan = '';
            $modal = '';

            foreach ($data as $key => $value) {
                $data_temuan .= '
                <tr>
                    <td><i class="fas fa-cog fa-spin"></i></td>
                    <td><a href="#modalDetailOrder" class="modal-dtl-produksi-right btn-info-order" id="'.$value->kd_order.'" data-bs-toggle="modal" style="text-decoration: none;">'.$value->id.'</a></td>
                    <td><label class="badge bg-danger">'.$value->priority.'</label></td>
                </tr>';
            }


            $arr = array(
                'message' => $ds.'/'.$de.' (oops)',
                'smart_assist_title' => 'Jadwal Ditemukan',
                'smart_assist_message' => '<div class="alert alert-danger"><b>Jadwal Ditemukan.</b> Ada proses produksi yang berjalan pada tanggal tersebut, untuk informasi detail mengenai masalah ini, berikut temuan data terkait.</div>
                <table class="table table-sm table-hover">'.$data_temuan.'</table>',
                'smart_assist_recommendation_action' => 'Anda bisa memilih mesin tertentu untuk digunakan oleh produksi saat ini',
                // 'machinelist' => $this->load->view('produksi/machine_list', $datax, true)
            );
            echo json_encode($arr);
        } else {


            $arr = array(
                'message' => $ds.'/'.$de.'jadwal_tersedia',
                'smart_assist_title' => 'Jadwal tersedia',
                'smart_assist_message' => '<div class="alert alert-success"><b>Jadwal Tersedia.</b> Tanggal ini belum di isi oleh jadwal produksi apapun.</div>',
                'smart_assist_recommendation_action' => 'test',
                // 'machinelist' => $this->load->view('produksi/machine_list', $datax, true)
            );
            echo json_encode($arr);
        }
    }

    function get_machine_list()
    {
        $ds = $this->input->post('ds');
        $de = $this->input->post('de');

        $machine_list = $this->Mesin_model->get_all();

        $data_produksi = $this->Produksi_model->deteksi_pengunaan_mesin_pada_tanggal($ds,$de);

        $machine_id_list = [];

        if ($machine_list) {
            
            if ($data_produksi) {

                $dataproduksi = [];

                foreach ($data_produksi as $value) {
                    array_push($dataproduksi, $value->machine_use);
                }

                // print_r($dataproduksi);

                $datamesin = [];

                foreach ($dataproduksi as $key => $value) {
                    $data_mesin_produksi_aktif = json_decode($value, true);

                    foreach ($data_mesin_produksi_aktif as $x) {

                        if (!in_array($x['machine_id'], $datamesin)) {
                            array_push($datamesin, $x['machine_id']);
                        }
                    }
                }

                foreach ($machine_list as $key => $value) {

                    //deteksi penggunan mesin bila ada data produksi pada tanggal tsb
                    if (!in_array($value->kd_mesin, $datamesin)) {
                        //ambil data mesin pada produksi
                        array_push($machine_id_list, $value->kd_mesin);
                    }
                }
            } else {
                foreach ($machine_list as $key => $value) {
                    array_push($machine_id_list, $value->kd_mesin);
                }
            }
        }

        echo json_encode($machine_id_list);
    }

    //-----------DETEKSI JADWAL AREA-----------------//


    function get_machine_data($id)
    {
        $data = $this->Mesin_model->get_by_kd_mesin($id);

        $datax = array(
            'value' => $data
        );
        $this->load->view('produksi/machine', $datax);
    }

    function cek_kode_order_ready()
    {
        $kd_order = $this->input->post('id');

        $detect = $this->Orders_model->get_by_kd_orders($kd_order, 'ON PROGRESS');

        if ($detect) {
            if ($detect->status != 'ON PROGRESS') {
                $arr = array(
                    'status' => 'no'
                );

                echo json_encode($arr);
            } else {

                $op = $detect->priority;
                $badge = '';
                if ($op == 1) {
                    $badge = '<label class="badge bg-success">Biasa</label>';
                }
                if ($op == 2) {         
                    $badge = '<label class="badge bg-warning">Urgent</label>';
                }
                if ($op == 3) {
                    $badge = '<label class="badge bg-danger">Top Urgent</label>';
                 
                }

                $ktr = $detect->keterangan;
                $ktrstr = '';
                if ($ktr == 1) {
                    $ktrstr = 'PART BARU';
                }
                if ($ktr == 2) {         
                    $ktrstr = 'REPAIR';
                }
                if ($ktr == 3) {
                    $ktrstr = 'MODIFIKASI';
                }

                $data = '
                    <b>'.$detect->kd_order.'</b>
                    <table class="table table-sm table-hover">
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td>'.$detect->tanggal_order.'</td>
                        </tr>
                        <tr>
                            <td>Pemesan</td>
                            <td>:</td>
                            <td>'.$detect->nama_pemesan.' ('.$detect->bagian.')</td>
                        </tr>
                        <tr>
                            <td>Prioritas</td>
                            <td>:</td>
                            <td>'.$badge.'</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td>'.$ktrstr.'</td>
                        </tr>
                    </table>
                    <a href="#modal-dialog-sketch-preview" picture="'.$detect->attachment.'" class="btn btn-green btn-sm sketsa_preview" style="width: 100%;" data-bs-toggle="modal">Sketsa</a>
                ';
                $arr = array(
                    'status' => 'ok',
                    'message' => $data,
                    'qty' => $detect->qty,
                    'priority' => $op
                );

                echo json_encode($arr);
            }
        } else {
            $arr = array(
                'status' => 'no'
            );

            echo json_encode($arr);
        }
    }

    public function getbagiandata($id)
    {
        $data = $this->Bagian_model->get_by_id($id);
        return $data;
    }

    function get_data_order($kdorder,$kdprod)
    {
        $data = $this->Orders_model->get_by_kd_orders_pure($kdorder);
        $dataprod = $this->Produksi_model->get_by_id($kdprod);
        
        $op = $data->priority;
        $badge = '';
        if ($op == 1) {
            $badge = '<label class="badge bg-success">Biasa</label>';
        }
        if ($op == 2) {         
            $badge = '<label class="badge bg-warning">Urgent</label>';
        }
        if ($op == 3) {
            $badge = '<label class="badge bg-danger">Top Urgent</label>';
         
        }

        $dt = array(
            'kdorder' => $kdorder,
            'tanggal_order' => $data->tanggal_order,
            'due_date' => $data->due_date,
            'nama_pemesan' => $data->nama_pemesan,
            'bagian' => $this->getbagiandata($data->bagian)->nama_bagian,
            'priority' => $badge,
            'status' => $data->status,
            'attachment' => $data->attachment,
            'barang' => $data->nama_barang,
            'qty' => $data->qty,
            'tanggal_produksi' => $dataprod->tanggal_produksi,
            'rencana_selesai' => $dataprod->rencana_selesai
        );

        echo json_encode($dt);
    }

    public function read_data_produksi($kd_order)
    {

        $row = $this->Produksi_model->get_by_kd_order($kd_order);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'tanggal_produksi' => $row->tanggal_produksi,
                'rencana_selesai' => $row->rencana_selesai,
                'total_barang_jadi' => $row->total_barang_jadi,
                'priority' => $row->priority,
                'materialsdata' => $this->Material_model->get_material_for($row->id),
                'machine_used' => $row->machine_use,
                'user_id' => $row->user_id
            );
            return $data;
        } else {
            echo 'not found';
        }
    }

}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-21 04:38:29 */
/* http://harviacode.com */