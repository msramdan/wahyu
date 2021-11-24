<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

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
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->limit(100);
        return $this->db->get($this->table)->result();
    }

    function get_all_ready()
    {
        $this->db->where('status', 'READY');
        $this->db->order_by($this->id, $this->order);
        $this->db->limit(100);
        return $this->db->get($this->table)->result();
    }

    function get_all_ready_finishing()
    {
        $this->db->where('status', 'READY FINISHING');
        $this->db->order_by($this->id, $this->order);
        $this->db->limit(100);
        return $this->db->get($this->table)->result();
    }

    function get_all_schedule()
    {
        $year = date('Y');
        return $this->db->query("SELECT * FROM `produksi` WHERE date(tanggal_produksi) >= '01-01-".$year." 00:00:00' AND status = 'READY'; ")->result();
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

    function get_by_kd_order($kdorder) {
        $this->db->where('kd_order', $kdorder);
        return $this->db->get('produksi')->row();
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

    function buat_kode($tanggal_produksi){
        $q = $this->db->query("SELECT MAX(RIGHT(id,4)) AS kd_max FROM produksi WHERE DATE(created_at)='".$tanggal_produksi."'");
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
            SELECT *, datediff(produksi.rencana_selesai,produksi.tanggal_produksi) as 'DIFF',produksi.status AS 'status_produksi' 
            FROM produksi 
            WHERE produksi.status IN ('ON GOING','READY FINISHING', 'FINISHING');")->result();   
    }

    function get_production_done($tanggal)
    {
        return $this->db->query("
            SELECT *, datediff(produksi.rencana_selesai,produksi.tanggal_produksi) as 'DIFF'
            FROM produksi
            WHERE produksi.status = 'DONE' AND day(produksi.aktual_selesai) = ".$tanggal."
            ORDER BY aktual_selesai ASC
            LIMIT 10;
            ")->result();
    }

    function deteksi_pengunaan_mesin_pada_tanggal($date_start, $date_end)
    {
        return $this->db->query("
            SELECT * FROM `produksi` WHERE tanggal_produksi <= '".$date_end."' AND rencana_selesai >= '".$date_start."'; 
            ")->result();
    }

    function find_produksi($machine, $month, $year)
    {
        return $this->db->query("
            SELECT * FROM `produksi` WHERE machine_use LIKE '%".$machine."%' AND month(tanggal_produksi) = '".$month."' AND year(tanggal_produksi) = '".$year."' AND status = 'READY';
            ")->result();
    }

}

/* End of file Produksi_model.php */
/* Location: ./application/models/Produksi_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-06 08:45:29 */
/* http://harviacode.com */