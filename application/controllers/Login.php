<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
		$this->load->view('login');
    }
    public function masuk(){
		$u = $this->input->post('no_telepon');
		$p = md5($this->input->post('password'));
		$i = 1;
		$this->login_model->get_login($u,$p,$i);
    }
    function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
