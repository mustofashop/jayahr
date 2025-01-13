<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	public function get_login($username, $password, $ip)
	{
		//$pass = md5(mysql_real_escape_string($password));
		$q 		= $this->db->query("SELECT a.id_karyawan, a.status, a.nama_lengkap, a.flag_hapus, 
		a.id_perusahaan, a.nip, c.level, a.department
		from mst_karyawan a
		join mst_perusahaan b on a.id_perusahaan = b.id_perusahaan
		join mst_level_login_p c on a.id_karyawan = c.id_karyawan
		where a.nip = '$username' and a.password = '$password' and b.ip_perusahaan = '$ip'");
		$query 	= $q->num_rows();
		$status = $q->row()->status;
		$hapus	= $q->row()->flag_hapus;
		if ($status == '1' || $status == '2') {
			$this->session->set_flashdata('result_login', '<br>User Sudah Tidak Aktif.');
			header('location:' . base_url() . 'login');
		} elseif ($hapus == '1') {
			$this->session->set_flashdata('result_login', '<br>User Sudah Tidak Terdaftar Sebagai Karyawan.');
			header('location:' . base_url() . 'login');
		} else {
			if ($query > 0) {
				//cek level login
				$k	= $q->row()->id_karyawan;
				$l	= $this->db->query("SELECT id_level_login
				FROM mst_level_login_p
				where id_karyawan = '$k'");
				if ($l->num_rows() > 0) {
					foreach ($q->result() as $qad) {
						$sess_data['masuk_k'] 		= 'JAYA HR APPS';
						$sess_data['id_karyawan'] 	= $qad->id_karyawan;
						$sess_data['department']	= $qad->department;
						$sess_data['level'] 		= $qad->level;
						$sess_data['nrp'] 			= $qad->nip;
						$sess_data['id_perusahaan']	= $qad->id_perusahaan;
						$sess_data['nama_lengkap'] 	= $qad->nama_lengkap;
						$this->session->set_userdata($sess_data);
					}
					header('location:' . base_url() . 'dashboard');
				} else {
					// $this->session->set_flashdata('result_login', '<br>Maaf Anda tidak punya akses untuk masuk ke web.');
					// header('location:'.base_url().'login');
					foreach ($q->result() as $qad) {
						$sess_data['masuk_k'] 		= 'ITMS_RAMBA';
						$sess_data['id_karyawan'] 	= $qad->id_karyawan;
						$sess_data['level'] 		= $qad->level;
						$sess_data['id_perusahaan']	= $qad->id_perusahaan;
						$sess_data['nama_lengkap'] 	= $qad->nama_lengkap;
						$this->session->set_userdata($sess_data);
					}
					header('location:' . base_url() . 'dashboard');
				}
			} else {
				$this->session->set_flashdata('result_login', '<br>Username / Password yang anda masukkan SALAH.');
				header('location:' . base_url() . 'login');
			}
		}
	}
}
