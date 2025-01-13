<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bagian extends CI_Controller {
    public function index()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            //AKSI
            $d['aksi1']     = '';
            $d['aksi2']     = '';
            $d['aksi3']     = '';
            $d['aksi4']     = '';
            $id_karyawan    = $this->session->userdata('id_karyawan');
            $aksi           = $this->master_model->list_aksi($id_karyawan);
            if($aksi->num_rows() > 0){
                foreach ($aksi->result() as $a) {
                    $d['aksi'.$a->aksi]  = $a->aksi;
                }
            }

            $d['header']    = 'Bagian / Unit Kerja';
            $d['content']   = 'master/bagian/index_bagian';
            $this->load->view('master',$d);
        }
    }
    public function simpan_bagian()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $bagian             = $this->input->post('bagian');
            $id_perusahaan      = $this->session->userdata('id_perusahaan');
            $absen              = $this->input->post('absen_o');
            $dt1['nama_bagian']         = $bagian;
            $dt1['id_perusahaan']       = $id_perusahaan;
            $dt1['flag_absen_online']   = $absen;
            $dt1['id_karyawan']         = $this->input->post('leader');
            $this->db->insert("mst_bagian",$dt1);
            $id_bagian          = $this->db->insert_id();
            $lokasi             = $this->input->post('lokasi',TRUE);
            $data2              = array();
            foreach($lokasi as $i => $a){
                $data2[]= array(
                    'id_lokasi'     => $a,
                    'id_bagian'     => $id_bagian,
                );
            }
            $this->db->insert_batch("mst_bagian_detail",$data2);
            $this->session->set_flashdata('msg', 'Bagian / Unit Kerja Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_bagian()
    {
        $id['id_bagian']   = $this->input->post('cari');
        
        $q      = $this->db->get_where("mst_bagian",$id);
        $row    = $q->num_rows();
        if($row>0){
            foreach($q->result() as $dt){
                $d['id_bagian']         = $dt->id_bagian;
                $d['nama_bagian']       = $dt->nama_bagian;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        }else{
                $d['id_bagian']         = '';
                $d['nama_bagian']       = '';
                $d['flag_absen_online'] = '';
                $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_bagian()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_bagian']            = $this->input->post('id_bagian');
            $dt['nama_bagian']          = $this->input->post('nama_bagian');
            $dt['flag_absen_online']    = $this->input->post('absen_o');
            $dt['id_karyawan']          = $this->input->post('leader');
            $this->db->update("mst_bagian",$dt,$id);
            $this->session->set_flashdata('msg', 'Bagian / Unit Kerja Sukses diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_lokasi($id_bagian)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $detail_bagian1 = $this->master_model->detail_bagian1($id_bagian);
            $nama_bagian1   = $detail_bagian1->row()->nama_bagian;

            $d['id_bagian'] = $id_bagian;
            $d['header']    = 'Edit Lokasi | '.$nama_bagian1;
            $d['content']   = 'master/bagian/edit_lokasi';
            $this->load->view('master',$d);
        }
    }
    public function simpan_lokasi()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_bagian          = $this->input->post('id_bagian');
            $lokasi             = $this->input->post('lokasi',TRUE);
            $data2              = array();
            foreach($lokasi as $i => $a){
                $data2[]= array(
                    'id_lokasi'     => $a,
                    'id_bagian'     => $id_bagian,
                );
            }
            $this->db->insert_batch("mst_bagian_detail",$data2);
            $this->session->set_flashdata('msg', 'Lokasi Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_lokasi($id_bagian_detail)
    {
        $id['id_bagian_detail'] = $id_bagian_detail;
        $this->db->delete("mst_bagian_detail",$id);
        $this->session->set_flashdata('msg', 'Lokasi Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //bagian level 2
    public function bagian_2($id_bagian)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $detail_bagian1 = $this->master_model->detail_bagian1($id_bagian);
            $nama_bagian1   = $detail_bagian1->row()->nama_bagian;

            //AKSI
            $d['aksi1']     = '';
            $d['aksi2']     = '';
            $d['aksi3']     = '';
            $d['aksi4']     = '';
            $id_karyawan    = $this->session->userdata('id_karyawan');
            $aksi           = $this->master_model->list_aksi($id_karyawan);
            if($aksi->num_rows() > 0){
                foreach ($aksi->result() as $a) {
                    $d['aksi'.$a->aksi]  = $a->aksi;
                }
            }

            $d['id_bagian'] = $id_bagian;
            $d['header']    = 'Bagian Level 2 | '.$nama_bagian1;
            $d['content']   = 'master/bagian/bagian_2/index_bagian2';
            $this->load->view('master',$d);
        }
    }
    public function simpan_bagian2()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_bagian_2        = $this->input->post('id_bagian_2');
            if(empty($id_bagian_2)){
                $id['id_bagian_2']  = '0';
            }else{
                $id['id_bagian_2']  = $id_bagian_2;
            }
            $dt['id_bagian']        = $this->input->post('id_bagian');
            $dt['nama_bagian_2']    = $this->input->post('nama');
            $dt['flag_absen_online']= $this->input->post('absen');
            $dt['id_karyawan']      = $this->input->post('leader');
            $c = $this->db->get_where("mst_bagian_2",$id);
            if($c->num_rows() > 0){
                $this->db->update("mst_bagian_2",$dt,$id);
                $this->session->set_flashdata('msg', 'Bagian Level 2 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_bagian_2",$dt);
                $this->session->set_flashdata('msg', 'Bagian Level 2 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_bagian_2()
    {
        $id['id_bagian_2']   = $this->input->post('cari');
        
        $q      = $this->db->get_where("mst_bagian_2",$id);
        $row    = $q->num_rows();
        if($row>0){
            foreach($q->result() as $dt){
                $d['id_bagian_2']       = $dt->id_bagian_2;
                $d['nama_bagian']       = $dt->nama_bagian_2;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        }else{
                $d['id_bagian_2']       = '';
                $d['nama_bagian']       = '';
                $d['flag_absen_online'] = '';
                $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    //bagian 3
    public function bagian_3($id_bagian_2,$id_bagian)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $detail_bagian1 = $this->master_model->detail_bagian1($id_bagian);
            $nama_bagian1   = $detail_bagian1->row()->nama_bagian;

            $detail_bagian2 = $this->master_model->detail_bagian_2($id_bagian_2);
            $nama_bagian2   = $detail_bagian2->row()->nama_bagian_2;
            //AKSI
            $d['aksi1']     = '';
            $d['aksi2']     = '';
            $d['aksi3']     = '';
            $d['aksi4']     = '';
            $id_karyawan    = $this->session->userdata('id_karyawan');
            $aksi           = $this->master_model->list_aksi($id_karyawan);
            if($aksi->num_rows() > 0){
                foreach ($aksi->result() as $a) {
                    $d['aksi'.$a->aksi]  = $a->aksi;
                }
            }

            $d['id_bagian'] = $id_bagian;
            $d['id_bagian2']= $id_bagian_2;
            $d['header']    = 'Bagian Level 3 | '.$nama_bagian1.' | '.$nama_bagian2;
            $d['content']   = 'master/bagian/bagian_3/index_bagian3';
            $this->load->view('master',$d);
        }
    }
    public function simpan_bagian3()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_bagian_3        = $this->input->post('id_bagian_3');
            if(empty($id_bagian_3)){
                $id['id_bagian_3']  = '0';
            }else{
                $id['id_bagian_3']  = $id_bagian_3;
            }
            $dt['id_bagian_2']      = $this->input->post('id_bagian_2');
            $dt['nama_bagian_3']    = $this->input->post('nama');
            $dt['flag_absen_online']= $this->input->post('absen');
            $dt['id_karyawan']      = $this->input->post('leader');
            $c = $this->db->get_where("mst_bagian_3",$id);
            if($c->num_rows() > 0){
                $this->db->update("mst_bagian_3",$dt,$id);
                $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_bagian_3",$dt);
                $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_bagian_3()
    {
        $id['id_bagian_3']   = $this->input->post('cari');
        
        $q      = $this->db->get_where("mst_bagian_3",$id);
        $row    = $q->num_rows();
        if($row>0){
            foreach($q->result() as $dt){
                $d['id_bagian_3']       = $dt->id_bagian_3;
                $d['nama_bagian']       = $dt->nama_bagian_3;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        }else{
                $d['id_bagian_3']       = '';
                $d['nama_bagian']       = '';
                $d['flag_absen_online'] = '';
                $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    //bagian 4
    public function bagian_4($id_bagian_3,$id_bagian_2,$id_bagian)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $detail_bagian1 = $this->master_model->detail_bagian1($id_bagian);
            $nama_bagian1   = $detail_bagian1->row()->nama_bagian;

            $detail_bagian2 = $this->master_model->detail_bagian_2($id_bagian_2);
            $nama_bagian2   = $detail_bagian2->row()->nama_bagian_2;

            $detail_bagian3 = $this->master_model->detail_bagian_3($id_bagian_3);
            $nama_bagian3   = $detail_bagian3->row()->nama_bagian_3;
            //AKSI
            $d['aksi1']     = '';
            $d['aksi2']     = '';
            $d['aksi3']     = '';
            $d['aksi4']     = '';
            $id_karyawan    = $this->session->userdata('id_karyawan');
            $aksi           = $this->master_model->list_aksi($id_karyawan);
            if($aksi->num_rows() > 0){
                foreach ($aksi->result() as $a) {
                    $d['aksi'.$a->aksi]  = $a->aksi;
                }
            }

            $d['id_bagian'] = $id_bagian;
            $d['id_bagian2']= $id_bagian_2;
            $d['id_bagian3']= $id_bagian_3;
            $d['header']    = 'Bagian Level 4 | '.$nama_bagian1.' | '.$nama_bagian2.' | '.$nama_bagian3;
            $d['content']   = 'master/bagian/bagian_4/index_bagian4';
            $this->load->view('master',$d);
        }
    }
    public function simpan_bagian4()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_bagian_4        = $this->input->post('id_bagian_4');
            if(empty($id_bagian_4)){
                $id['id_bagian_4']  = '0';
            }else{
                $id['id_bagian_4']  = $id_bagian_4;
            }
            $dt['id_bagian_3']      = $this->input->post('id_bagian_3');
            $dt['nama_bagian_4']    = $this->input->post('nama');
            $dt['flag_absen_online']= $this->input->post('absen');
            $dt['id_karyawan']      = $this->input->post('leader');
            $c = $this->db->get_where("mst_bagian_4",$id);
            if($c->num_rows() > 0){
                $this->db->update("mst_bagian_4",$dt,$id);
                $this->session->set_flashdata('msg', 'Bagian Level 4 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_bagian_4",$dt);
                $this->session->set_flashdata('msg', 'Bagian Level 4 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_bagian_4()
    {
        $id['id_bagian_4']   = $this->input->post('cari');
        
        $q      = $this->db->get_where("mst_bagian_4",$id);
        $row    = $q->num_rows();
        if($row>0){
            foreach($q->result() as $dt){
                $d['id_bagian_4']       = $dt->id_bagian_4;
                $d['nama_bagian']       = $dt->nama_bagian_4;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        }else{
                $d['id_bagian_4']       = '';
                $d['nama_bagian']       = '';
                $d['flag_absen_online'] = '';
                $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
}