<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_e extends CI_Controller {
    public function index()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = '';
            $d['header']    = 'Master Menu Enterprise';
            $d['content']   = 'menu_e/master_menu/index_master_menu';
            $this->load->view('master',$d);
        }
    }
    public function edit_menu_utama()
    {
        $id['id_menu_parent']   = $this->input->post('id');
        
        $q      = $this->db->get_where("mst_menu_parent_e",$id);
        $row    = $q->num_rows();
        if($row>0){
            foreach ($q->result() as $dt) {
                $d['id_menu_parent']    = $dt->id_menu_parent;
                $d['nama_parent']       = $dt->nama_parent;
                $d['link_parent']       = $dt->link_parent;
                $d['logo']              = $dt->logo;
                $d['urutan']            = $dt->urutan;
            }
            echo json_encode($d);
        }else{
                $d['id_menu_parent']    = '';
                $d['nama_parent']       = '';
                $d['link_parent']       = '';
                $d['logo']              = '';
                $d['urutan']            = '';
            echo json_encode($d);
        }
    }
    public function simpan_menu_utama()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_menu_p              = $this->input->post('id_menu_parent');
            if(empty($id_menu_p)){
                $id_menu_parent     = '0';
            }else{
                $id_menu_parent     = $id_menu_p;
            }
            $id['id_menu_parent']   = $id_menu_parent;

            $dt['nama_parent']      = $this->input->post('nama_parent');
            $dt['link_parent']      = $this->input->post('link_parent');
            $dt['logo']             = $this->input->post('logo');
            $dt['urutan']           = $this->input->post('urutan_parent');
            $c = $this->db->get_where("mst_menu_parent_e",$id);
            if($c->num_rows() > 0){
                $this->db->update("mst_menu_parent_e",$dt,$id);
                $this->session->set_flashdata('msg', 'Menu berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_menu_parent_e",$dt);
                $this->session->set_flashdata('msg', 'Menu berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function level_menu_utama($id_menu_parent)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_menu    = $this->menu_e_model->detail_menu_utama($id_menu_parent);
            $nama_menu      = $detail_menu->row()->nama_parent;
            $d['id_m_p']    = $id_menu_parent;
            $d['class']     = '';
            $d['header']    = 'Level Menu Utama | '.$nama_menu;
            $d['content']   = 'menu_e/master_menu/level_master_menu';
            $this->load->view('master',$d);
        }
    }
    public function simpan_level_menu_utama()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_menu_parent = $this->input->post('id_menu_parent');
            $level          = $this->input->post('level',TRUE);
            foreach ($level as $i => $a) {
                $dt['id_menu_parent'] = $id_menu_parent;
                $dt['level']          = $a;
                $this->db->insert('mst_menu_parent_e_level',$dt);
            }
            $this->session->set_flashdata('msg', 'Level Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_level_parent($id_parent_level)
    {
        $id['id_parent_level'] = $id_parent_level;
        $this->db->delete("mst_menu_parent_e_level",$id);
        $this->session->set_flashdata('msg', 'Level Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    // isi menu
    public function isi_menu_e($id_menu_parent)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_menu    = $this->menu_e_model->detail_menu_utama($id_menu_parent);
            $nama_menu      = $detail_menu->row()->nama_parent;
            $d['id_m_p']    = $id_menu_parent;
            $d['class']     = '';
            $d['header']    = 'Isi Menu Utama | '.$nama_menu;
            $d['content']   = 'menu_e/master_menu/isi_menu';
            $this->load->view('master',$d);
        }
    }
    public function edit_isi_menu()
    {
        $id['id_menu']   = $this->input->post('id');
        
        $q      = $this->db->get_where("mst_menu_e",$id);
        $row    = $q->num_rows();
        if($row>0){
            foreach ($q->result() as $dt) {
                $d['id_menu']           = $dt->id_menu;
                $d['nama_menu']         = $dt->nama_menu;
                $d['link']              = $dt->link;
                $d['urutan']            = $dt->urutan;
            }
            echo json_encode($d);
        }else{
                $d['id_menu']           = '';
                $d['nama_menu']         = '';
                $d['link']              = '';
                $d['urutan']            = '';
            echo json_encode($d);
        }
    }
    public function simpan_isi()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_menu        = $this->input->post('id_menu');
            if(empty($id_menu)){
                $id['id_menu']  = '0';
            }else{
                $id['id_menu']  = $id_menu;
            }
            $dt['id_menu_parent']   = $this->input->post('id_menu_parent');
            $dt['nama_menu']        = $this->input->post('nama_menu');
            $dt['link']             = $this->input->post('link');
            $dt['urutan']           = $this->input->post('urutan');
            $c  = $this->db->get_where("mst_menu_e",$id);
            if($c->num_rows() > 0){
                $this->db->update("mst_menu_e",$dt,$id);
                $this->session->set_flashdata('msg', 'Isi Menu berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_menu_e",$dt);
                $this->session->set_flashdata('msg', 'Isi Menu berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function level_isi_menu($id_menu)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_menu    = $this->menu_e_model->detail_isi_menu($id_menu);
            $nama_menu      = $detail_menu->row()->nama_menu;
            $d['id_menu']   = $id_menu;
            $d['class']     = '';
            $d['header']    = 'Level Isi Menu | '.$nama_menu;
            $d['content']   = 'menu_e/master_menu/level_isi_menu';
            $this->load->view('master',$d);
        }
    }
    public function simpan_level_isi_menu()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_menu        = $this->input->post('id_menu');
            $level          = $this->input->post('level',TRUE);
            foreach ($level as $i => $a) {
                $dt['id_menu']  = $id_menu;
                $dt['level']    = $a;
                $this->db->insert('mst_menu_e_level',$dt);
            }
            $this->session->set_flashdata('msg', 'Level Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_level_isi($id_menu_level)
    {
        $id['id_menu_level'] = $id_menu_level;
        $this->db->delete("mst_menu_e_level",$id);
        $this->session->set_flashdata('msg', 'Level Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
}