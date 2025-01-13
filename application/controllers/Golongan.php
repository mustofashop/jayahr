<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan extends CI_Controller {
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
            $d['header']    = 'Golongan';
            $d['content']   = 'master/golongan/index_golongan';
            $this->load->view('master',$d);
        }
    }
    public function simpan_golongan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_p   = $this->session->userdata('id_perusahaan');
            $nama_j = $this->input->post('nama_golongan',TRUE);
            foreach ($nama_j as $nama => $j) {
                if(empty($j)){

                }else{
                    $dt['nama_golongan'] = $j;
                    $dt['id_perusahaan']= $id_p;
                    $this->db->insert("mst_golongan",$dt);
                }
            }
            $this->session->set_flashdata('msg', 'Golongan Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_golongan()
    {
        $id['id_golongan']   = $this->input->post('id');
        $c  = $this->db->get_where("mst_golongan",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_golongan']    = $dt->id_golongan;
                $d['nama_golongan']  = $dt->nama_golongan;
            }
            echo json_encode($d);
        }else{
            $d['id_golongan']    = '';
            $d['nama_golongan']  = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_golongan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_golongan']   = $this->input->post('id_golongan');
            $dt['nama_golongan'] = $this->input->post('nama_golongan');
            $this->db->update("mst_golongan",$dt,$id);
            $this->session->set_flashdata('msg', 'Golongan Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_golongan($id_golongan)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_golongan']   = $id_golongan;
            $dt['flag_hapus']   = '1';
            $this->db->update("mst_golongan",$dt,$id);
            $this->session->set_flashdata('msg_error', 'Golongan Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}