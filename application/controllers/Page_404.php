<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_404 extends CI_Controller {
    public function index()
	{   
        $d['header']    = '404 Not Found';
        $d['content']   = '404';
		$this->load->view('master',$d);
	}
}