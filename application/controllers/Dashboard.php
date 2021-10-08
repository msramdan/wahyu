<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
    }

	public function index()
	{
		$data = array(
			'classnyak' => $this,
            'sett_apps' =>$this->Setting_app_model->get_by_id(1),
        );
		$this->template->load('template','dashboard',$data);
	}

	function showtotallogin($day)
	{
		return $this->db->query("SELECT COUNT(user_id) AS 'tl' FROM `history_login` WHERE day(tanggal) = ".$day.";")->row();
	}

	function showactivemachine()
	{
		return $this->db->query("SELECT COUNT(user_id) AS 'tl' FROM `history_login` WHERE day(tanggal) = ".$day.";")->row();
	}



}