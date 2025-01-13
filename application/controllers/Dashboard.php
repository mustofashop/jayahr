<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function index()
	{   
        $d['header']    = 'Dashboard';
        $d['content']   = 'dashboard';
		$this->load->view('master',$d);
    }
    
}