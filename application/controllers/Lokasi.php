<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lokasi extends CI_Controller {
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

            $d['header']    = 'Lokasi';
            $d['content']   = 'master/lokasi/index_lokasi';
            $this->load->view('master',$d);
        }
    }
    public function simpan_lokasi()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_lokasi  = $this->input->post('id_lokasi');
            if(empty($id_lokasi)){
                $id['id_lokasi']    = '0';
            }else{
                $id['id_lokasi']    = $id_lokasi;
            }
            $dt['nama_lokasi']      = $this->input->post('nama_lokasi');
            $dt['id_perusahaan']    = $this->session->userdata('id_perusahaan');
            $c  = $this->db->get_where('mst_lokasi',$id);
            if($c->num_rows() > 0){
                $this->db->update('mst_lokasi',$dt,$id);
                $this->session->set_flashdata('msg', 'Lokasi Berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert('mst_lokasi',$dt);
                $this->session->set_flashdata('msg', 'Lokasi Berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_lokasi()
    {
        $id['id_lokasi']  = $this->input->post('id');
        $c  = $this->db->get_where('mst_lokasi',$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_lokasi']     = $dt->id_lokasi;
                $d['nama_lokasi']   = $dt->nama_lokasi;
            }
            echo json_encode($d);
        }else{
                $d['id_lokasi']     = '';
                $d['nama_lokasi']   = '';
            echo json_encode($d);
        }
    }
    public function sub_lokasi($id_lokasi)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $detail_lokasi  = $this->master_model->detail_lokasi($id_lokasi);
            $nama_lokasi    = $detail_lokasi->row()->nama_lokasi;

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

            $d['id_lokasi'] = $id_lokasi;
            $d['header']    = 'Sub Lokasi | '.$nama_lokasi;
            $d['content']   = 'master/lokasi/sub_lokasi';
            $this->load->view('master',$d);
        }
    }
    public function edit_sub_lokasi()
    {
        $id['id_sub_lokasi']    = $this->input->post('id');
        $c  = $this->db->get_where('mst_lokasi_sub',$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_sub_lokasi']     = $dt->id_sub_lokasi;
                $d['nama_sub_lokasi']   = $dt->nama_sub_lokasi;
                $d['latitude_sub']      = $dt->latitude_sub;
                $d['longitude_sub']     = $dt->longitude_sub;
                $d['jarak_sub']         = $dt->jarak_sub;
                $d['sn']                = $dt->sn;
            }   
            echo json_encode($d);
        }else{
                $d['id_sub_lokasi']     = '';
                $d['nama_sub_lokasi']   = '';
                $d['latitude_sub']      = '';
                $d['longitude_sub']     = '';
                $d['jarak_sub']         = '';
                $d['sn']                = '';
            echo json_encode($d);
        }
    }
    public function simpan_sub_lokasi()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_sub_lokasi    = $this->input->post('id_sub_lokasi');
            if(empty($id_sub_lokasi)){
                $id['id_sub_lokasi']    = '0';
            }else{
                $id['id_sub_lokasi']    = $id_sub_lokasi;
            }
            $dt['id_lokasi']            = $this->input->post('id_lokasi');
            $dt['nama_sub_lokasi']      = $this->input->post('nama_sub_lokasi');
            $dt['latitude_sub']         = $this->input->post('latitude');
            $dt['longitude_sub']        = $this->input->post('longitude');
            $dt['jarak_sub']            = $this->input->post('jarak');
            $dt['sn']                   = $this->input->post('sn');
            $c  = $this->db->get_where('mst_lokasi_sub',$id);
            if($c->num_rows() > 0){
                $this->db->update('mst_lokasi_sub',$dt,$id);
                $this->session->set_flashdata('msg', 'Sub Lokasi Berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert('mst_lokasi_sub',$dt);
                $this->session->set_flashdata('msg', 'Sub Lokasi Berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}