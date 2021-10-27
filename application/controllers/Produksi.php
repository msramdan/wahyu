<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Produksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Produksi_model');
        $this->load->model('Material_model');
        $this->load->model('Orders_model');
        $this->load->model('Mesin_model');
        $this->load->model('Setting_app_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_allowed($this->uri->segment(1),null);
        $produksi = $this->Produksi_model->get_all();

        $data = array(
            'produksi_data' => $produksi,
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
            'kode_order' => $this->session->flashdata('kode_order'),
            'classnyak' => $this
        );
        $this->template->load('template','produksi/produksi_wrapper', $data);
    }

    public function list()
    {
        is_allowed($this->uri->segment(1),null);
        $produksi = $this->Produksi_model->get_all();
        $data = array(
            'produksi_data' => $produksi,
        );
        $this->load->view('produksi/produksi_list', $data);
    }

    public function read()
    {
        is_allowed($this->uri->segment(1),'read');

        $id = $this->input->post('id');

        $row = $this->Produksi_model->get_by_id(decrypt_url($id));
        if ($row) {
            $data = array(
        		'id' => $row->id,
        		'tanggal_produksi' => $row->tanggal_produksi,
                'rencana_selesai' => $row->rencana_selesai,
        		'total_barang_jadi' => $row->total_barang_jadi,
        		'priority' => $row->priority,
                'materialsdata' => $this->Material_model->get_material_for($row->id),
                'machine_used' => $row->machine_use,
        		'user_id' => $row->user_id,
                'classnyak' => $this,
    	    );
            $this->load->view('produksi/produksi_read', $data);
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
            'material' => $this->Material_model->get_all(),
            'machine_list' => $this->Mesin_model->get_all(),
    	    'id' => set_value('id'),
    	    'tanggal_produksi' => set_value('tanggal_produksi',date('Y-m-d')),
    	    'total_barang_jadi' => set_value('total_barang_jadi',1),
            'rencana_selesai' => set_value('rencana_selesai',date('Y-m-d')),
    	    'material_needs' => null,
    	    'user_id' => set_value('user_id'),
            'classnyak' => $this
        );
        $this->load->view('produksi/produksi_form', $data);
    }
    
    public function create_action() 
    {
        is_allowed($this->uri->segment(1),'create');

        $material_dibutuhkan = $this->input->post('material_dibutuhkan');
        $stok_dibutuhkan = $this->input->post('stok_dibutuhkan');

        $id_material_stock = $this->input->post('id_material_in_stock');
        $qty_material_stock = $this->input->post('qty_material_in_stock');

        $kode = $this->Produksi_model->buat_kode(date('Y-m-d'));
        $kd_order = $this->input->post('kode_order', TRUE);

        for ($i = 0; $i < count($material_dibutuhkan); $i++) { 
            $readytouse = array(
                'kode_produksi' => $kode,
                'kd_material' => $material_dibutuhkan[$i],
                'jumlah_bahan' => $stok_dibutuhkan[$i]
            );
            $this->Produksi_model->insert_detailproduksi($readytouse);
        }

        for ($x=0; $x < count($id_material_stock); $x++) { 
            $datastok = array(
                'qty' => $qty_material_stock[$x]
            );

            $this->Material_model->update($id_material_stock[$x], $datastok);
        }

        $machine_used = $this->input->post('machine_use');
        $estimateddonepergoodsinminute = $this->input->post('troughputperproduct');
        $materialallocated = $this->input->post('materialallocated');
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
                    'materialallocated' => $materialallocated[$i],
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
            'status' => 'READY',
            'rencana_selesai' => $this->input->post('rencana_selesai',TRUE).' '.$this->input->post('jam_akhir', TRUE).':00',
            'aktual_selesai' => null,
            'machine_use' => json_encode($arraydetail, true),
    		'user_id' => $this->session->userdata('userid'),
	    );

        $this->Produksi_model->insert($data);

        $updatedataorder = array(
            'status' => 'ON PROGRESS'
        );

        $this->Orders_model->update_by_kd_order($kd_order, $updatedataorder);

        $this->list();
    }
    
    public function delete() 
    {
        is_allowed($this->uri->segment(1),'delete');

        $id = $this->input->post('id');

        $row = $this->Produksi_model->get_by_id(decrypt_url($id));

        if ($row) {
            $this->Produksi_model->delete_detailproduksi(decrypt_url($id));
            $this->Produksi_model->delete(decrypt_url($id));
        } else {
            echo 'not found';
        }

        $this->list();
    }

    public function excel()
    {
        is_allowed($this->uri->segment(1),'read');
        $this->load->helper('exportexcel');
        $namaFile = "produksi.xls";
        $judul = "produksi";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Produksi");
	xlsWriteLabel($tablehead, $kolomhead++, "Total Barang Jadi");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Detail Material");
	xlsWriteLabel($tablehead, $kolomhead++, "User Id");

	foreach ($this->Produksi_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_produksi);
	    xlsWriteNumber($tablebody, $kolombody++, $data->total_barang_jadi);
	    xlsWriteLabel($tablebody, $kolombody++, $data->priority);
	    xlsWriteNumber($tablebody, $kolombody++, $data->user_id);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function getmachinedetail($id)
    {
        $data = $this->Mesin_model->get_by_id($id);
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
                    <td><a href="#modaldetailproduksi" data-bs-toggle="modal" style="text-decoration: none;">'.$value->id.'</a></td>
                    <td><label class="badge bg-danger">'.$value->priority.'</label></td>
                </tr>';
            }


            $arr = array(
                'message' => $ds.'/'.$de.' (oops)',
                'smart_assist_title' => 'Jadwal Ditemukan',
                'smart_assist_message' => '<p>Ada proses produksi yang berjalan pada tanggal tersebut, untuk informasi detail mengenai masalah ini, berikut temuan data terkait...</p>
                <table class="table table-sm table-hover">'.$data_temuan.'</table>',
                'smart_assist_recommendation_action' => 'Anda bisa memilih mesin tertentu untuk digunakan oleh produksi saat ini',
                // 'machinelist' => $this->load->view('produksi/machine_list', $datax, true)
            );
            echo json_encode($arr);
        } else {


            $arr = array(
                'message' => $ds.'/'.$de.'jadwal_tersedia',
                'smart_assist_title' => 'Jadwal tersedia',
                'smart_assist_message' => 'Tanggal ini belum di isi oleh jadwal produksi apapun, semua aman!',
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
                    if (!in_array($value->mesin_id, $datamesin)) {
                        //ambil data mesin pada produksi
                        array_push($machine_id_list, $value->mesin_id);
                    }
                }
            } else {
                foreach ($machine_list as $key => $value) {
                    array_push($machine_id_list, $value->mesin_id);
                }
            }
        }

        echo json_encode($machine_id_list);
    }

    function get_machine_data($id)
    {
        $data = $this->Mesin_model->get_by_id($id);

        $datax = array(
            'value' => $data
        );
        $this->load->view('produksi/machine', $datax);
    }

    // public function machineList()
    // {

    //     $ds = $this->input->post('ds');
    //     $de = $this->input->post('de');

    //     $machinelist = $this->Mesin_model->get_all();

    //     $data_penggunaan_mesin_oleh_produksi_lain = $this->Produksi_model->deteksi_pengunaan_mesin_pada_tanggal($ds,$de);

    //     $data = array(
    //         'machine_list' => $machinelist,
    //         'data_produksi' => $data_penggunaan_mesin_oleh_produksi_lain
    //     );
        
    // }

    function cek_kode_order_ready()
    {
        $kd_order = $this->input->post('id');

        $detect = $this->Orders_model->get_by_kd_orders($kd_order, 'READY');

        if ($detect) {
            if ($detect->status != 'READY') {
                $arr = array(
                    'status' => 'no'
                );

                echo json_encode($arr);
            } else {

                $op = $detect->priority;
                $badge = '';
                if ($op == 0) {
                    $badge = '<label class="badge bg-success">Biasa</label>';
                }
                if ($op == 1) {         
                    $badge = '<label class="badge bg-warning">Urgent</label>';
                }
                if ($op == 2) {
                    $badge = '<label class="badge bg-danger">Top Urgent</label>';
                 
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
                            <td>'.$detect->keterangan.'</td>
                        </tr>
                    </table>
                    <a href="#modal-dialog-sketch-preview" picture="'.$detect->attachment.'" class="btn btn-green btn-sm sketsa_preview" style="width: 100%;" data-bs-toggle="modal">Sketsa</a>
                ';
                $arr = array(
                    'status' => 'ok',
                    'message' => $data,
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

}

/* End of file Produksi.php */
/* Location: ./application/controllers/Produksi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-06 08:45:29 */
/* http://harviacode.com */