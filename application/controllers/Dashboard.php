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

	function showtotalmaterial()
	{
		return $this->db->query("SELECT SUM(qty) AS 'total' FROM `material`")->row();
	}

	function showtotalactiveproduction()
	{
		$valarray = array('ON GOING','FINISHING','READY FINISHING');
		return $this->db->where_in('status',$valarray)->from('produksi')->get()->num_rows();
	}

	function getaveragetimesdone()
	{
		$q = $this->db->query("
			SELECT 
			    AVG(@diff:=ABS( UNIX_TIMESTAMP(aktual_selesai) - UNIX_TIMESTAMP())) , 
			    AVG(CAST(@days := IF(@diff/86400 >= 1, floor(@diff / 86400 ),0) AS SIGNED)) as days, 
			    AVG(CAST(@hours := IF(@diff/3600 >= 1, floor((@diff:=@diff-@days*86400) / 3600),0) AS SIGNED)) as hours, 
			    AVG(CAST(@minutes := IF(@diff/60 >= 1, floor((@diff:=@diff-@hours*3600) / 60),0) AS SIGNED)) as minutes, 
			    AVG(CAST(@diff-@minutes*60 AS SIGNED)) as seconds
			 FROM produksi;
			");
		return $this->db->get($q)->row();
	}



}