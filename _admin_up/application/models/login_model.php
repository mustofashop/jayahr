<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
    public function get_login($username,$password){
		$pass = md5($password);
        $q = $this->db->query("SELECT * from admins where username='$username' and password = '$pass'");
		$query = $q->num_rows();
		if($query > 0)
		{
			foreach($q->result() as $qad)
			{
				$sess_data['logged_in'] 			= 'ITMS_RAMBA';
				$sess_data['id_admin'] 				= $qad->id_username;
				$sess_data['username_admin']		= $qad->username;
				$sess_data['nama_lengkap_admin']	= $qad->nama_lengkap;
				$sess_data['level_admin'] 			= $qad->level;
				$this->session->set_userdata($sess_data);
				
			}
			header('location:'.base_url().'dashboard');
		}else{
			$this->session->set_flashdata('result_login', '<br>Username / Password yang anda masukkan SALAH.');
			header('location:'.base_url().'login');
		}
    }
}