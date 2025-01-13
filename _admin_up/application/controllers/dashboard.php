<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function index()
	{   
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
			$d['class']     = 'dashboard';
			$d['header']    = 'Dashboard';
			$d['content']   = 'dashboard';
			$this->load->view('master',$d);
		}
    }
    public function edit_aplikasi()
    {
        $id['id_aplikasi_mobile']   = $this->input->post('cari');
        
        $q      = $this->db->get_where("mst_aplikasi_mobile2",$id);
        $row    = $q->num_rows();
        if($row>0){
            foreach ($q->result() as $dt) {
                $d['id_aplikasi_mobile']= $dt->id_aplikasi_mobile;
                $d['nama_aplikasi']     = $dt->nama_aplikasi;
                $d['nama_package']      = $dt->nama_package;
                $d['link_aplikasi']     = $dt->link_aplikasi;
                $d['kode_aplikasi']     = $dt->kode_aplikasi;
            }
            echo json_encode($d);
        }else{
                $d['id_aplikasi_mobile']= '';
                $d['nama_aplikasi']     = '';
                $d['nama_package']      = '';
                $d['link_aplikasi']     = '';
                $d['kode_aplikasi']     = '';
            echo json_encode($d);
        }
    }
    public function simpan_aplikasi()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_aplikasi_mobile = $this->input->post('id_aplikasi_mobile');
            if($id_aplikasi_mobile == "" || empty($id_aplikasi_mobile)){
                $id['id_aplikasi_mobile'] = '0';
            }else{
                $id['id_aplikasi_mobile'] = $id_aplikasi_mobile;
            }
            $dt['kode_aplikasi']    = $this->input->post('kode_aplikasi');
            $dt['nama_aplikasi']    = $this->input->post('nama_aplikasi');
            $dt['link_aplikasi']    = $this->input->post('link_aplikasi');
            $dt['nama_package']     = $this->input->post('nama_package');
            
            $c = $this->db->get_where("mst_aplikasi_mobile2",$id);
            if($c->num_rows() > 0){
                $this->db->update("mst_aplikasi_mobile2",$dt,$id);
                $this->session->set_flashdata('msg2', 'Aplikasi berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_aplikasi_mobile2",$dt);
                $this->session->set_flashdata('msg2', 'Aplikasi berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_aplikasi($id_aplikasi_mobile)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_aplikasi_mobile'] = $id_aplikasi_mobile;
            $this->db->delete("mst_aplikasi_mobile2",$id);
            $this->db->delete("mst_aplikasi_mobile2_trans",$id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_trans_aplikasi()
    {
        $id['id_trans_aplikasi_mobile'] = $this->input->post('cari');
        
        $q      = $this->db->get_where("mst_aplikasi_mobile2_trans",$id);
        if($q->num_rows() > 0){
            foreach ($q->result() as $dt) {
                $d['id_trans_aplikasi_mobile'] = $dt->id_trans_aplikasi_mobile;
                $d['version']           = $dt->version;
                $d['release_date']      = $dt->release_date;
                $d['id_aplikasi_mobile']= $dt->id_aplikasi_mobile;
            }
            echo json_encode($d);
        }else{
                $d['id_trans_aplikasi_mobile'] = '';
                $d['version']           = '';
                $d['release_date']      = '';
                $d['id_aplikasi_mobile']= '';
            echo json_encode($d);
        }
    }
    public function simpan_transaksi_aplikasi()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_trans_aplikasi  = $this->input->post('id_trans');
            if($id_trans_aplikasi == "" || empty($id_trans_aplikasi)){
                $id['id_trans_aplikasi_mobile'] = '0';
            }else{
                $id['id_trans_aplikasi_mobile'] = $id_trans_aplikasi;
            }
            $dt['id_aplikasi_mobile']   = $this->input->post('nama_aplikasi');
            $dt['version']              = $this->input->post('version');
            $dt['release_date']         = $this->input->post('tanggal');
            date_default_timezone_set("Asia/Jakarta");
            $dt['last_update']          = date('Y-m-d H:i:s');
            $c = $this->db->get_where("mst_aplikasi_mobile2_trans",$id);
            if($c->num_rows() > 0){
                $this->db->update("mst_aplikasi_mobile2_trans",$dt,$id);
                $this->session->set_flashdata('msg3', 'Transaksi Aplikasi berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_aplikasi_mobile2_trans",$dt);
                $this->session->set_flashdata('msg3', 'Transaksi Aplikasi berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_trans_aplikasi($id_trans_aplikasi)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_trans_aplikasi_mobile'] = $id_trans_aplikasi;
            $this->db->delete("mst_aplikasi_mobile2_trans",$id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}