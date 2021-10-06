<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_model extends CI_Model
{

    public $table = 'material';
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
        $this->db->like('id', $q);
	$this->db->or_like('id_material', $q);
	$this->db->or_like('id_bentuk', $q);
	$this->db->or_like('id_jenis_material', $q);
	$this->db->or_like('dimensi', $q);
	$this->db->or_like('berat_per_pcs', $q);
	$this->db->or_like('berat_total', $q);
	$this->db->or_like('qty', $q);
	$this->db->or_like('masa_jenis_material', $q);
	$this->db->or_like('volume', $q);
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

    function detect_availibilty_karyawan_kd($kd_material)
    {
        $this->db->where('kd_material', $kd_material);
        return $this->db->get($this->table)->num_rows();   
    }

}

/* End of file Material_model.php */
/* Location: ./application/models/Material_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-05 08:53:19 */
/* http://harviacode.com */