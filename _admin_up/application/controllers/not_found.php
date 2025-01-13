<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Not_found extends CI_Controller {
    public function index(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'dashboard';
            $d['header']    = '404 Not Found';
            $d['content']   = 'errors/404';
            $this->load->view('master',$d);
        }
    }
}