<?php
defined('BASEPATH') or exit('No direct script access allowed');

class users_k extends CI_Controller
{
    public function login_user()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = '';
            $d['header']    = 'User Karyawan';
            $d['content']   = 'enterprise/login_karyawan/index_login_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function list_user_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $perusahaan     = $this->input->get('perusahaan');
            $detail_p       = $this->enterprise_model->get_detail_perusahaan($perusahaan);
            $nama_p         = ' | ' . $detail_p->row()->nama_perusahaan;

            $d['perusahaan'] = $perusahaan;
            $d['class']     = '';
            $d['header']    = 'List User ' . $nama_p;
            $d['content']   = 'enterprise/login_karyawan/list_login_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function edit_user_k()
    {
        $id     = $this->input->post('id');
        $q      = $this->db->query("SELECT a.id_level_login,
        a.id_karyawan,
        a.level,
        b.nama_lengkap
        FROM mst_level_login_p a
        join mst_karyawan b on a.id_karyawan = b.id_karyawan
        where a.id_level_login = '$id'");
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_level_login']    = $dt->id_level_login;
                $d['id_karyawan']       = $dt->id_karyawan;
                $d['nama_lengkap']      = $dt->nama_lengkap;
                $d['level']             = $dt->level;
            }
            echo json_encode($d);
        } else {
            $d['id_level_login']    = '';
            $d['id_karyawan']       = '';
            $d['nama_lengkap']      = '';
            $d['level']             = '';
            echo json_encode($d);
        }
    }
    public function simpan_level_user()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_karyawan        = $this->input->post('karyawan');
            $level              = $this->input->post('level', TRUE);
            $detail             = $this->enterprise_model->detail_karyawan($id_karyawan);
            $nama               = $detail->row()->nama_lengkap;
            foreach ($level as $l => $lvl) {
                $id['id_karyawan']  = $id_karyawan;
                $id['level']        = $lvl;
                $c = $this->db->get_where("mst_level_login_p", $id);
                if ($c->num_rows() > 0) {
                } else {
                    $this->db->insert("mst_level_login_p", $id);
                }
            }
            $this->session->set_flashdata('msg', 'Level Login' . $nama . 'Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_level($id_karyawan, $perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail         = $this->enterprise_model->detail_karyawan($id_karyawan);
            $nama           = $detail->row()->nama_lengkap;
            $d['id_k']      = $id_karyawan;
            $d['id_p']      = $perusahaan;
            $d['class']     = '';
            $d['header']    = 'List Level Karyawan ' . $nama;
            $d['content']   = 'enterprise/login_karyawan/list_level_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function hapus_level_user($id_level_login)
    {
        $id['id_level_login']   = $id_level_login;
        $this->db->delete("mst_level_login_p", $id);
        $this->session->set_flashdata('msg', 'Level Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function delete_user_k($id_karyawan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_karyawan'] = $id_karyawan;
            $this->db->delete("mst_level_login_p", $id);
            $this->session->set_flashdata('msg', 'User dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
