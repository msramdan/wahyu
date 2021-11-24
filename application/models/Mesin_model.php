<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mesin_model extends CI_Model
{

    public $table = 'mesin';
    public $id = 'mesin_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all($jenis_mesin = null)
    {
        $this->db->like('jenis_mesin', $jenis_mesin);
        $this->db->order_by($this->id, 'ASC');
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_kd_mesin($id)
    {
        $this->db->where('kd_mesin', $id);
        return $this->db->get($this->table)->row();
    }

    function get_operator_mesin($kode_produksi)
    {
        $this->db->where('kd_produksi', $kode_produksi);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('mesin_id', $q);
	$this->db->or_like('kd_mesin', $q);
	$this->db->or_like('nama_mesin', $q);
	$this->db->or_like('Keterangan', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }


    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
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

    function detect_availibilty_mesin_id($kd_mesin)
    {
        $this->db->where('kd_mesin', $kd_mesin);
        return $this->db->get($this->table)->num_rows();
    }

}

/* End of file Mesin_model.php */
/* Location: ./application/models/Mesin_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-09-27 15:51:44 */
/* http://harviacode.com */