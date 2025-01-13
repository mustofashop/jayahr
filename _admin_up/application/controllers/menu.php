<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    public function parent_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['data_p']    = $this->sischool_model->get_parent_menu();
            $d['class']     = 'menu';
            $d['header']    = 'Master Menu | Menu Utama';
            $d['content']   = 'menu/master_menu/index_parent_menu';
            $this->load->view('master',$d);
        }
    }
    public function child_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['data']      = $this->sischool_model->get_menu();
            $d['class']     = 'menu';
            $d['header']    = 'Master Menu | Isi Menu Utama';
            $d['content']   = 'menu/master_menu/index_child_menu';
            $this->load->view('master',$d);
        }
    }
    public function edit_parent(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_parent']                =   $this->input->post('cari');
                
            $q = $this->db->get_where("mst_menu_parent",$id);
            $row = $q->num_rows();
            if($row>0){
                foreach($q->result() as $dt){
                    $d['id_parent']         = $dt->id_parent;
                    $d['nama_parent']       = $dt->nama_parent;
                    $d['link_parent']       = $dt->link_parent;
                    $d['logo']              = $dt->logo;
                    $d['urutan']            = $dt->urutan;
                }
                echo json_encode($d);
            }else{
                    $d['id_parent']         = '';
                    $d['nama_parent']       = '';
                    $d['link_parent']       = '';
                    $d['logo']              = '';
                    $d['urutan']            = '';
                echo json_encode($d);
            }
        }
    }
    public function edit_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_menu']                  =   $this->input->post('cari');
                
            $q = $this->db->get_where("mst_menu",$id);
            $row = $q->num_rows();
            if($row>0){
                foreach($q->result() as $dt){
                    $d['id_menu']           = $dt->id_menu;
                    $d['id_parent']         = $dt->id_parent;
                    $d['nama_menu']         = $dt->nama_menu;
                    $d['link']              = $dt->link;
                    $d['urutan']            = $dt->urutan;
                }
                echo json_encode($d);
            }else{
                    $d['id_menu']           = '';
                    $d['id_parent']         = '';
                    $d['nama_menu']         = '';
                    $d['link']              = '';
                    $d['urutan']            = '';
                echo json_encode($d);
            }
        }
    }
    public function save_kategori(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_parent          = $this->input->post('id_p');
            $nama_parent        = $this->input->post('nama_p');
            $link_parent        = $this->input->post('link_p');
            $logo               = $this->input->post('logo_p');
            $urutan             = $this->input->post('urutan_p');

            $id['id_parent']    = $id_parent;
            $dt['nama_parent']  = $nama_parent;
            $dt['link_parent']  = $link_parent;
            $dt['logo']         = $logo;
            $dt['urutan']       = $urutan;
            
            $q = $this->db->get_where("mst_menu_parent",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_menu_parent",$dt,$id);
                $this->session->set_flashdata('msg_p', 'Kategori Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_menu_parent",$dt);

                $id_parent      = $this->db->insert_id();
                $level          = $this->input->post('level', true);
                $data2          = array();
                foreach($level as $i => $a){
                    $data2[]= array(
                        'level'         => $a,
                        'id_parent'     => $id_parent,
                    );
                }
                $this->db->insert_batch("trans_menu_level",$data2);
                $this->session->set_flashdata('msg_p', 'Kategori Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function save_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_menu            = $this->input->post('id_m');
            $nama_menu          = $this->input->post('name_m');
            $id_parent          = $this->input->post('kategori');
            $link               = $this->input->post('link_m');
            $urutan             = $this->input->post('urutan_m');
            if($id_menu == "" || empty($id_menu)){
                $id_m           = '0';
            }else{
                $id_m           = $id_menu;
            }
            $id['id_menu']      = $id_m;
            $dt['nama_menu']    = $nama_menu;
            $dt['id_parent']    = $id_parent;
            $dt['link']         = $link;
            $dt['urutan']       = $urutan;

            $q = $this->db->get_where("mst_menu",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_menu",$dt,$id);
                $this->session->set_flashdata('msg_m', 'Menu Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_menu",$dt);
                $this->session->set_flashdata('msg_m', 'Menu Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_menu']	    = $this->uri->segment(3);
            $this->db->delete("mst_menu",$id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //add level menu
    public function add_level_menu($id){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $get_nama       = $this->sischool_model->get_nama_menu_parent($id);
            $nama_parent    = $get_nama->row()->nama_parent;
            $id_parent      = $get_nama->row()->id_parent;
            $data           = $this->sischool_model->get_list_level($id);
            $dt['header']   = 'Setting Level Menu '.$nama_parent;
            $dt['id_parent']= $id_parent;
            $dt['list']     = $data->result();
            $dt['class']    = 'menu';
            $dt['content']  = 'menu/master_menu/list_level';
            $this->load->view('master',$dt);
        }
    }
    public function save_level_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_parent      = $this->input->post('id_parent');
            $level          = $this->input->post('level', true);
            $data2          = array();
            foreach($level as $i => $a){
                $data2[]= array(
                    'level'         => $a,
                    'id_parent'     => $id_parent,
                );
            }
            $this->db->insert_batch("trans_menu_level",$data2);
            $this->session->set_flashdata('msg_p', 'Level Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);   
        }
    }
    public function delete_level_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_trans_menu_level']	    = $this->uri->segment(3);
            $this->db->delete("trans_menu_level",$id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //add level isi menu
    public function add_level_isi_menu($id_menu){
        $get_nama       = $this->sischool_model->get_nama_isi_menu($id_menu);
        $nama_parent    = $get_nama->row()->nama_parent;
        $nama_menu      = $get_nama->row()->nama_menu;
        $data           = $this->sischool_model->get_list_level_isi_menu($id_menu);
        $dt['header']   = 'Setting Level Isi Menu : '.$nama_parent.' | '.$nama_menu;
        $dt['id_menu']  = $id_menu;
        $dt['list']     = $data->result();
        $dt['class']    = 'menu';
        $dt['content']  = 'menu/master_menu/list_level_isi_menu';
        $this->load->view('master',$dt);
    }
    public function save_level_isi_menu(){
        $id_menu        = $this->input->post('id_menu');
        $level          = $this->input->post('level', true);
        $data2          = array();
        foreach($level as $i => $a){
            $data2[]= array(
                'level'         => $a,
                'id_menu'       => $id_menu,
            );
        }
        $this->db->insert_batch("trans_menu_isi_level",$data2);
        $this->session->set_flashdata('msg_p', 'Level Sukses disimpan');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function delete_level_isi_menu(){
        $id['id_isi_menu_level']	    = $this->uri->segment(3);
        $this->db->delete("trans_menu_isi_level",$id);
        redirect($_SERVER['HTTP_REFERER']);
    }
    //setting menu
    public function setting_menu()
	{   
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'menu';
            $d['sekolah']   = $this->sischool_model->get_sekolah();
            $d['header']    = 'Setting Menu';       
            $d['content']   = 'menu/setting_menu/index';
            $this->load->view('master',$d);
        }
    }
    public function get_menu_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $sekolah        = $this->input->get('sekolah');
            $nama_sekolah   = $this->sischool_model->get_detail_sekolah($sekolah);
            $nama           = $nama_sekolah->row()->nama_sekolah;
            $data           = $this->sischool_model->get_list_menu($sekolah);
            $dt['header']   = 'Setting Menu '.$nama;
            $dt['class']    = 'menu';       
            $dt['id_s']     = $sekolah;
            $dt['list']     = $data->result();
            $dt['content']  = 'menu/setting_menu/list_menu';
            $this->load->view('master',$dt);
        }
    }
    //sub menu sekolah
    public function add_submenu_sekolah($idmenu,$sekolah){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $nama_sekolah   = $this->sischool_model->get_detail_sekolah($sekolah);
            $nama           = $nama_sekolah->row()->nama_sekolah;
            $dt['class']    = 'menu';       
            $dt['id_parent']= $idmenu;
            $dt['sekolah']  = $sekolah;
            $dt['header']   = 'Tambah Sub Menu '.$nama;
            $dt['data']     = $this->sischool_model->get_submenu_sekolah($idmenu,$sekolah);
            $dt['content']  = 'menu/setting_menu/add_submenu_sekolah';
            $this->load->view('master',$dt);
        }
    }
    public function save_submenu_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_sekolah     = $this->input->post('id_sekolah');
            $parent         = $this->input->post('menu', true);
            $data2          = array();
            foreach($parent as $i => $a){
                $data2[]= array(
                    'id_menu' => $a,
                    'id_sekolah' => $id_sekolah,
                );
            }
            $this->db->insert_batch("trans_menu_sub",$data2);
            $this->session->set_flashdata('msg', 'Submenu Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_submenu_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_trans_menu_sub'] = $this->uri->segment(3);
            $this->db->delete("trans_menu_sub",$id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function tambah_submenu_default($id_parent,$sekolah){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            //cari menu yang gak ada
            $get_data           = $this->sischool_model->get_submenu_sekolah_default($id_parent,$sekolah);
            $get_check          = $get_data->num_rows();
            if($get_check > 0){
                foreach($get_data->result() as $hasil){
                    $id_menu        = $hasil->id_menu;
                    $dt['id_menu']      = $id_menu;
                    $dt['id_sekolah']   = $sekolah;
                    $this->db->insert("trans_menu_sub",$dt);
                }
                $this->session->set_flashdata('msg', 'Submenu Default Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->session->set_flashdata('msg_error', 'Submenu Sudah Ada');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    //
    public function save_category_setting_menu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_sekolah     = $this->input->post('id_sekolah');
            $parent         = $this->input->post('kategori', true);
            $data2          = array();
            foreach($parent as $i => $a){
                $data2[]= array(
                    'id_parent' => $a,
                    'id_sekolah' => $id_sekolah,
                );
            }
            $this->db->insert_batch("trans_menu",$data2);
            $this->session->set_flashdata('msg_p', 'Kategori Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);      
        }
    }
    public function delete_menu_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_trans_menu']= $this->uri->segment(3);
            $this->db->delete("trans_menu",$id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}