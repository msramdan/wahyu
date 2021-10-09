<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produksi_model extends CI_Model
{

    public $table = 'produksi';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all($status = '')
    {
        $this->db->like('status',$status);
        $this->db->order_by($this->id, $this->order);
        $this->db->limit(100);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('', $q);
	$this->db->or_like('id', $q);
	$this->db->or_like('tanggal_produksi', $q);
	$this->db->or_like('total_barang_jadi', $q);
	$this->db->or_like('id_detail_material', $q);
	$this->db->or_like('user_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }


    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function insert_detailproduksi($data)
    {
        $this->db->insert('detail_produksi',$data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function delete_detailproduksi($idproduksi)
    {
        $this->db->where('kode_produksi', $idproduksi);
        $this->db->delete('detail_produksi');   
    }

    function buat_kode(){
        $q = $this->db->query("SELECT MAX(RIGHT(id,4)) AS kd_max FROM produksi WHERE DATE(tanggal_produksi)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'P'.date('dmy').$kd;
    }

    function cek_karyawan_bekerja($karyawan_id)
    {
        $this->db->where('operator', $karyawan_id);
        $this->db->group_start()
            ->where('status', 'IN USE')
            ->or_where('status', 'PAUSED')
        ->group_end();
        return $this->db->get('mesin')->num_rows();
    }

    function get_production_ready()
    {
        return $this->db->query("
            SELECT *, datediff(produksi.rencana_selesai,produksi.tanggal_produksi) as 'DIFF'
            FROM produksi
            WHERE status = 'READY'
            ORDER BY DIFF ASC;
            ")->result();
    }

    function get_production_ongoing()
    {
        return $this->db->query("
            SELECT *, datediff(produksi.rencana_selesai,produksi.tanggal_produksi) as 'DIFF'
            FROM produksi
            JOIN mesin ON mesin.kd_produksi = produksi.id
            WHERE produksi.status = 'ON GOING'
            ORDER BY DIFF ASC;
            ")->result();   
    }

    function get_production_done()
    {
        return $this->db->query("
            SELECT *, datediff(produksi.rencana_selesai,produksi.tanggal_produksi) as 'DIFF'
            FROM produksi
            WHERE produksi.status = 'DONE'
            ORDER BY aktual_selesai ASC
            LIMIT 10;
            ")->result();
    }

}

/* End of file Produksi_model.php */
/* Location: ./application/models/Produksi_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-06 08:45:29 */
/* http://harviacode.com */