<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class History_order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Orders_model');
        $this->load->model('Bagian_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $list_order = $this->Orders_model->get_all();
        $data = array(
            'classnyak' => $this,
            'orders_data' => $list_order,
            'sett_apps' => $this->Setting_app_model->get_by_id(1),
        );
        $this->template->load('template','history_order/history_order_list', $data);
    }

    public function getbagiandata($id)
    {
        $data = $this->Bagian_model->get_by_id($id);
        return $data;
    }
}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-21 05:46:32 */
/* http://harviacode.com */
