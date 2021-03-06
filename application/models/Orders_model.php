<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders_model extends CI_Model
{

    public $table = 'orders';
    public $id = 'order_id';
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

    function get_step_for_signer($level_id, $priority)
    {
        $this->db->where('order_category',$priority);
        $this->db->where('level_id', $level_id);
        return $this->db->get('flow_approved')->row();
    }

    function get_all_waiting()
    {
        $this->db->where('status', 'WAITING');
        $this->db->like('approved_by','-');
        return $this->db->get('orders')->result();
    }

    function get_all_tertentu($status)
    {
        $this->db->where('status', $status);
        return $this->db->get($this->table)->result();
    }

    function get_all_by_thisuser($userid)
    {
        $this->db->where('user_id',$userid);
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();   
    }

    function get_by_kd_orders($kd_order, $status = null)
    {
        $where = array(
            'kd_order' => $kd_order,
            'status' => $status
        );

        $this->db->where($where);
        return $this->db->get('orders')->row();
    }

    function get_by_kd_orders_pure($kd_order)
    {
        $this->db->where('kd_order', $kd_order);
        return $this->db->get('orders')->row();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('order_id', $q);
	$this->db->or_like('nama_pemesan', $q);
	$this->db->or_like('bagian', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('priority', $q);
	$this->db->or_like('approved_by', $q);
	$this->db->or_like('attachment', $q);
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

    function update_by_kd_order($id, $data)
    {
        $this->db->where('kd_order', $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function buat_kode(){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_order,4)) AS kd_max FROM orders WHERE DATE(tanggal_order)=CURDATE()");
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
        return 'O'.date('dmy').$kd;
    }

    function get_all_approval_name_and_step($priority)
    {
        $this->db->join('level','level.level_id = flow_approved.level_id');
        $this->db->where('flow_approved.order_category',$priority);
        $this->db->order_by('step','ASC');
        return $this->db->get('flow_approved')->result();
    }

    function deteksi_already_signed($order_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->like('approved_by', 'sekarang');
        return $this->db->get('orders')->result();
    }
}

/* End of file Orders_model.php */
/* Location: ./application/models/Orders_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-10-21 04:38:29 */
/* http://harviacode.com */