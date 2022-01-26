<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Schedule extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        
        $this->load->model('Setting_app_model');
    }

	
}