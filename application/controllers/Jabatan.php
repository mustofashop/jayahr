<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {
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

            $d['header']    = 'Jabatan';
            $d['content']   = 'master/jabatan/index_jabatan';
            $this->load->view('master',$d);
        }
    }
    public function simpan_jabatan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id_p   = $this->session->userdata('id_perusahaan');
            $nama_j = $this->input->post('nama_jabatan',TRUE);
            foreach ($nama_j as $nama => $j) {
                if(empty($j)){

                }else{
                    $dt['nama_jabatan'] = $j;
                    $dt['id_perusahaan']= $id_p;
                    $this->db->insert("mst_jabatan",$dt);
                }
            }
            $this->session->set_flashdata('msg', 'Jabatan Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_jabatan()
    {
        $id['id_jabatan']   = $this->input->post('id');
        $c  = $this->db->get_where("mst_jabatan",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_jabatan']    = $dt->id_jabatan;
                $d['nama_jabatan']  = $dt->nama_jabatan;
            }
            echo json_encode($d);
        }else{
            $d['id_jabatan']    = '';
            $d['nama_jabatan']  = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_jabatan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_jabatan']   = $this->input->post('id_jabatan');
            $dt['nama_jabatan'] = $this->input->post('nama_jabatan');
            $this->db->update("mst_jabatan",$dt,$id);
            $this->session->set_flashdata('msg', 'Jabatan Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_jabatan($id_jabatan)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_jabatan']   = $id_jabatan;
            $dt['flag_hapus']   = '1';
            $this->db->update("mst_jabatan",$dt,$id);
            $this->session->set_flashdata('msg_error', 'Jabatan Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}