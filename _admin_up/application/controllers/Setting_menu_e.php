<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_menu_e extends CI_Controller {
    public function index()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = '';
            $d['header']    = 'Setting Menu Enterprise';
            $d['content']   = 'menu_e/setting_menu/index_setting_menu';
            $this->load->view('master',$d);
        }
    }
    public function list_menu()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $perusahaan     = $this->input->get('perusahaan');
            $detail_p       = $this->menu_e_model->detail_perusahaan($perusahaan);
            $nama_p         = $detail_p->row()->nama_perusahaan;
            $d['p']         = $perusahaan;
            $d['class']     = '';
            $d['header']    = 'List Menu Enterprise | '.$nama_p;
            $d['content']   = 'menu_e/setting_menu/list_menu';
            $this->load->view('master',$d);
        }
    }
    public function simpan_menu_utama()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_menu_parent = $this->input->post('menu_u',TRUE);
            $id_perusahaan  = $this->input->post('perusahaan');
            foreach ($id_menu_parent as $id_m => $a) {
                $id['id_menu_parent'] = $a;
                $id['id_perusahaan']  = $id_perusahaan;
                $c = $this->db->get_where("mst_menu_parent_e_trans",$id);
                if($c->num_rows() > 0){

                }else{
                    $this->db->insert("mst_menu_parent_e_trans",$id);
                }
            }
            $this->session->set_flashdata('msg', 'Menu Utama berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_menu_e($id_trans_parent_menu)
    {
        $id['id_trans_parent_menu'] = $id_trans_parent_menu;
        $this->db->delete("mst_menu_parent_e_trans",$id);
        $this->db->delete("mst_menu_e_trans",$id);
        $this->session->set_flashdata('msg', 'Menu Utama berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function list_submenu($id_trans_parent_menu,$id_parent_menu,$id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_p       = $this->menu_e_model->detail_perusahaan($id_perusahaan);
            $nama_p         = $detail_p->row()->nama_perusahaan;

            $detail_pm      = $this->menu_e_model->detail_parent_menu($id_parent_menu);
            $nama_pm        = $detail_pm->row()->nama_parent;
            $d['id_tpm']    = $id_trans_parent_menu;
            $d['id_pm']     = $id_parent_menu;
            $d['id_p']      = $id_perusahaan; 
            $d['class']     = '';
            $d['header']    = 'List Isi Menu Enterprise | '.$nama_p.' | '.$nama_pm;
            $d['content']   = 'menu_e/setting_menu/list_isi_menu';
            $this->load->view('master',$d);
        }
    }
    public function simpan_isi_menu()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_menu        = $this->input->post('id_menu',TRUE);
            $id_perusahaan  = $this->input->post('perusahaan');
            $id_t_p_menu    = $this->input->post('id_trans_parent_menu');
            foreach ($id_menu as $im => $a) {
                $id['id_menu']              = $a;
                $id['id_trans_parent_menu'] = $id_t_p_menu;
                $id['id_perusahaan']        = $id_perusahaan;
                $c = $this->db->get_where("mst_menu_e_trans",$id);
                if($c->num_rows() > 0){

                }else{
                    $this->db->insert("mst_menu_e_trans",$id);
                }
            }
            $this->session->set_flashdata('msg', 'Isi Menu berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_isi_menu($id_trans_menu)
    {
        $id['id_trans_menu']    = $id_trans_menu;
        $this->db->delete("mst_menu_e_trans",$id);
        $this->session->set_flashdata('msg', 'Isi Menu berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //menu user
    public function list_user()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $perusahaan     = $this->input->get('perusahaan');
            //cek menu mapping perusahaan
            // $c              = $this->menu_e_model->list_trans_menu_utama($perusahaan);
            // if($c->num_rows() > 0){
                $detail_p       = $this->menu_e_model->detail_perusahaan($perusahaan);
                $nama_p         = $detail_p->row()->nama_perusahaan;

                $d['id_p']      = $perusahaan;
                $d['class']     = '';
                $d['header']    = 'List User Enterprise | '.$nama_p;
                $d['content']   = 'menu_e/setting_menu_user/list_user';
                $this->load->view('master',$d);
            // }else{
            //     $this->session->set_flashdata('msg_error', 'Menu Per Perusahaan belum dimapping.');
            //     redirect($_SERVER['HTTP_REFERER']);
            // }
        }
    }
    public function setting_menu_u($id_karyawan,$id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_k       = $this->menu_e_model->detail_karyawan($id_karyawan);
            $nama_k         = $detail_k->row()->nama_lengkap;

            $d['id_p']      = $id_perusahaan;
            $d['id_k']      = $id_karyawan;
            $d['class']     = '';
            $d['header']    = 'List Menu Utama User | '.$nama_k;
            $d['content']   = 'menu_e/setting_menu_user/list_menu_utama';
            $this->load->view('master',$d);
        }
    }
    public function simpan_menu_utama_user()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_karyawan    = $this->input->post('karyawan');
            $id_menu_parent = $this->input->post('menu_u',TRUE);
            foreach ($id_menu_parent as $id_m => $a) {
                $id['id_menu_parent']   = $a;
                $id['id_karyawan']      = $id_karyawan;
                $c = $this->db->get_where("mst_menu_parent_e_users",$id);
                if($c->num_rows() > 0){

                }else{
                    $this->db->insert("mst_menu_parent_e_users",$id);
                }
            }
            $this->session->set_flashdata('msg', 'Menu Utama User berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function list_submenu_user($id_menu_parent,$id_karyawan,$id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_pm      = $this->menu_e_model->detail_parent_menu($id_menu_parent);
            $nama_pm        = $detail_pm->row()->nama_parent;

            $detail_k       = $this->menu_e_model->detail_karyawan($id_karyawan);
            $nama_k         = $detail_k->row()->nama_lengkap;

            $d['id_pr']     = $id_menu_parent;
            $d['id_k']      = $id_karyawan;
            $d['id_p']      = $id_perusahaan;
            $d['class']     = '';
            $d['header']    = 'List Isi Menu User | '.$nama_pm.' | '.$nama_k;
            $d['content']   = 'menu_e/setting_menu_user/list_isi_menu';
            $this->load->view('master',$d);
        }
    }
    public function simpan_isi_menu_user()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_isi_menu    = $this->input->post('isi',TRUE);
            $id_karyawan    = $this->input->post('id_karyawan');
            $id_menu_parent = $this->input->post('id_menu_parent');
            foreach ($id_isi_menu as $i => $im) {
                $dt['id_menu']          = $im;
                $dt['id_karyawan']      = $id_karyawan;
                $dt['id_menu_parent']   = $id_menu_parent;
                $this->db->insert("mst_menu_e_users",$dt);
            }
            $this->session->set_flashdata('msg', 'Isi menu user berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_menu_utama_user($id_menu_parent,$id_karyawan)
    {
        $id['id_karyawan']      = $id_karyawan;
        $id['id_menu_parent']   = $id_menu_parent;
        $this->db->delete("mst_menu_parent_e_users",$id);
        $this->db->delete("mst_menu_e_users",$id);
        $this->session->set_flashdata('msg', 'Menu Utama User & isi menu user berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function delete_isi_menu_user($id_menu_e_user)
    {
        $id['id_menu_e_user']   = $id_menu_e_user;
        $this->db->delete("mst_menu_e_users",$id);
        $this->session->set_flashdata('msg', 'Isi menu user berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
}