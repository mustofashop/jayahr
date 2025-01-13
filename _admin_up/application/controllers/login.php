<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
		$this->load->view('login');
    }
    public function masuk(){
        $this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('login');	
		}else{
			$u = $this->input->post('username');
			$p = $this->input->post('password');
			$this->login_model->get_login($u,$p);
		}
    }
    function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
