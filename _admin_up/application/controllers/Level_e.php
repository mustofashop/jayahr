<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_e extends CI_Controller {
    public function index()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = '';
            $d['header']    = 'Level Enterprise';
            $d['content']   = 'level_e/master_level_e/index_m_level_e';
            $this->load->view('master',$d);
        }
    }
    public function edit_master_level()
    {
        $id['id_level_e']   = $this->input->post('id');
        $c = $this->db->get_where("mst_level_e",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_level_e']    = $dt->id_level_e;
                $d['kode_level_e']  = $dt->kode_level_e;
                $d['nama_level_e']  = $dt->nama_level_e;
            }
            echo json_encode($d);
        }else{
            $d['id_level_e']        = '';
            $d['kode_level_e']      = '';
            $d['nama_level_e']      = '';
            echo json_encode($d);
        }
    }
    public function simpan_master_level()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_level_e             = $this->input->post('id_level_e');
            $kode_level_e           = $this->input->post('kode_level_e');
            if(empty($id_level_e)){
                $id2   = '0';
            }else{
                $id2   = $id_level_e;
            }
            if($id2 > 0){
                $id['id_level_e']       = $id_level_e;
                $dt['kode_level_e']     = $kode_level_e;
                $dt['nama_level_e']     = $this->input->post('nama_level_e');
                $this->db->update("mst_level_e",$dt,$id);
                $this->session->set_flashdata('msg', 'Level berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $id1['kode_level_e']    = $kode_level_e;
                $c1 = $this->db->get_where("mst_level_e",$id1);
                if($c1->num_rows() > 0){
                    $this->session->set_flashdata('msg_error', 'Kode Level sudah tersedia');
                    redirect($_SERVER['HTTP_REFERER']);
                }else{
                    $dt1['kode_level_e']     = $kode_level_e;
                    $dt1['nama_level_e']     = $this->input->post('nama_level_e');
                    $this->db->insert("mst_level_e",$dt1);
                    //insert aksi
                    $aksi   = $this->input->post('aksi',TRUE);
                    foreach ($aksi as $a => $ak) {
                        $dt2['kode_level_e']    = $kode_level_e;
                        $dt2['aksi']            = $ak;
                        $this->db->insert("mst_level_e_aksi",$dt2);
                    }
                    $this->session->set_flashdata('msg', 'Level berhasil disimpan');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
    }
    // aksi level
    public function level_aksi($kode_level_e)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_l       = $this->level_e_model->detail_level($kode_level_e);
            $nama_l         = $detail_l->row()->nama_level_e;
            $d['kode_level']= $kode_level_e;
            $d['class']     = '';
            $d['header']    = 'Aksi Level | '.$nama_l;
            $d['content']   = 'level_e/master_level_e/index_aksi_level';
            $this->load->view('master',$d);
        }
    }
    public function simpan_aksi_level()
    {
        $kode_level_e       = $this->input->post('kode_level_e');
        $aksi               = $this->input->post('aksi',TRUE);
        foreach ($aksi as $a => $ak) {
            $dt['kode_level_e'] = $kode_level_e;
            $dt['aksi']         = $ak;
            $c  = $this->db->get_where("mst_level_e_aksi",$dt);
            if($c->num_rows() > 0){

            }else{
                $this->db->insert("mst_level_e_aksi",$dt);
            }
        }
        $this->session->set_flashdata('msg', 'Aksi berhasil ditambah');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus_aksi_level($id)
    {
        $id1['id_level_e_aksi']  = $id;
        $this->db->delete("mst_level_e_aksi",$id1);
        $this->session->set_flashdata('msg', 'Aksi berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //mapping level
    public function simpan_mapping_level()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $perusahaan     = $this->input->post('perusahaan');
            $detail_p       = $this->menu_e_model->detail_perusahaan($perusahaan);
            $nama_p         = $detail_p->row()->nama_perusahaan;
            $level          = $this->input->post('level',TRUE);
            foreach($level as $l => $a){
                $dt['kode_level_e']     = $a;
                $dt['id_perusahaan']    = $perusahaan;
                $c = $this->db->get_where("mst_level_e_trans",$dt);
                if($c->num_rows() > 0){

                }else{
                    $this->db->insert("mst_level_e_trans",$dt);
                }
            }
            $this->session->set_flashdata('msg2', 'Mapping Level '.$nama_p.' Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_mapping_level($perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_p       = $this->menu_e_model->detail_perusahaan($perusahaan);
            $nama_p         = $detail_p->row()->nama_perusahaan;

            $d['perusahaan']= $perusahaan;
            $d['class']     = '';
            $d['header']    = 'Edit Level '.$nama_p;
            $d['content']   = 'level_e/mapping_level/edit_mapping_level';
            $this->load->view('master',$d);
        }
    }
    public function hapus_mapping_level($perusahaan)
    {
        $detail_p       = $this->menu_e_model->detail_perusahaan($perusahaan);
        $nama_p         = $detail_p->row()->nama_perusahaan;

        $id['id_perusahaan']    = $perusahaan;
        $this->db->delete("mst_level_e_trans",$id);
        $this->session->set_flashdata('msg2', 'Mapping Level '.$nama_p.' Berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus_detail_mapping($id_level_trans)
    {
        $id['id_level_e_trans'] = $id_level_trans;
        $this->db->delete("mst_level_e_trans",$id);
        $this->session->set_flashdata('msg', 'Level berhasil dihapus'); 
        redirect($_SERVER['HTTP_REFERER']);
    }
    // level menu
    public function level_menu($kode_level_e)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_l       = $this->level_e_model->detail_level($kode_level_e);
            $nama_l         = $detail_l->row()->nama_level_e; 

            $d['kode_l']    = $kode_level_e;
            $d['class']     = '';
            $d['header']    = 'Level Menu | Level : '.$nama_l;
            $d['content']   = 'level_e/menu_level/index_level_menu';
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
            $kode_level_e   = $this->input->post('kode_level');
            $menu_utama     = $this->input->post('menu1',TRUE);
            foreach($menu_utama as $menu1 => $m1){
                $dt['level']            = $kode_level_e;
                $dt['id_menu_parent']   = $m1;
                $c = $this->db->get_where("mst_menu_parent_e_level",$dt);
                if($c->num_rows() > 0){

                }else{
                    $this->db->insert("mst_menu_parent_e_level",$dt);
                }
            }
            $this->session->set_flashdata('msg', 'Menu Utama berhasil ditambah'); 
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_menu_utama($id_parent_level,$id_menu_parent,$kode_level_e)
    {
        $id['id_parent_level']  = $id_parent_level;
        $this->db->delete("mst_menu_parent_e_level",$id);

        $q1 = $this->db->query("SELECT a.id_menu_level
        FROM mst_menu_e_level a
        JOIN mst_menu_e b ON a.id_menu = b.id_menu
        WHERE b.id_menu_parent = '$id_menu_parent' AND a.level = '$kode_level_e'");
        foreach($q1->result() as $d1){
            $del1['id_menu_level'] = $d1->id_menu_level;
            $this->db->delete("mst_menu_e_level",$del1);
        }
        $this->session->set_flashdata('msg', 'Menu Utama berhasil dihapus'); 
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function simpan_isi_menu()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $kode_level_e   = $this->input->post('kode_level');
            $isi_menu       = $this->input->post('menu2',TRUE);
            foreach ($isi_menu as $isi => $im) {
                $dt['level']    = $kode_level_e;
                $dt['id_menu']  = $im;
                $c = $this->db->get_where("mst_menu_e_level",$dt);
                if($c->num_rows() > 0){
                    
                }else{
                    $this->db->insert("mst_menu_e_level",$dt);
                }
            }
            $this->session->set_flashdata('msg1', 'Isi Menu berhasil disimpan'); 
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_isi_menu($id_menu_level)
    {
        $id['id_menu_level']    = $id_menu_level;
        $this->db->delete("mst_menu_e_level",$id);
        $this->session->set_flashdata('msg1', 'Isi Menu berhasil dihapus'); 
        redirect($_SERVER['HTTP_REFERER']);
    }
}