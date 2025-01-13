<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Libur extends CI_Controller {
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

            $d['header']    = 'Libur';
            $d['content']   = 'master/libur/index_libur';
            $this->load->view('master',$d);
        }
    }
    public function simpan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_perusahaan  = $this->session->userdata('id_perusahaan');
            $tanggal        = $this->input->post('tanggal',TRUE);
            $keterangan     = $this->input->post('keterangan',TRUE);
            foreach ($tanggal as $tgl => $t) {
                if(!empty($t)){
                    $dt['tanggal']      = $t;
                    $dt['id_perusahaan']= $id_perusahaan;
                    $c = $this->db->get_where("mst_libur_perusahaan",$dt);
                    if($c->num_rows() > 0){

                    }else{
                        $dt['keterangan']   = $keterangan[$tgl];
                        $this->db->insert("mst_libur_perusahaan",$dt);
                    }
                }
            }
            $this->session->set_flashdata('msg', 'Libur Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit()
    {
        $id['id_libur_perusahaan']  = $this->input->post('id');
        $c = $this->db->get_where("mst_libur_perusahaan",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_libur_perusahaan']   = $dt->id_libur_perusahaan;
                $d['keterangan']            = $dt->keterangan;
                $d['tanggal']               = $dt->tanggal;
            }
            echo json_encode($d);
        }else{
                $d['id_libur_perusahaan']   = '';
                $d['keterangan']            = '';
                $d['tanggal']               = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_libur_perusahaan']      = $this->input->post('id_libur_perusahaan');
            $dt['keterangan']               = $this->input->post('keterangan');
            $dt['tanggal']                  = $this->input->post('tanggal');
            $this->db->update("mst_libur_perusahaan",$dt,$id);
            $this->session->set_flashdata('msg', 'Libur Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus($id_libur_perusahaan)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_libur_perusahaan']  = $id_libur_perusahaan;
            $this->db->delete("mst_libur_perusahaan",$id);
            $this->session->set_flashdata('msg_error', 'Libur Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}