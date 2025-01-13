<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_training extends CI_Controller {
    public function index()
	{   
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $d['header']    = 'Data Karyawan';
            $d['content']   = 'master/training/index_karyawan';
            $this->load->view('master',$d);
        }
    }
    public function list_karyawan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $kategori   = $this->input->get('kategori');
            if($kategori == '1'){
                $nama_k = 'Karyawan Tetap';
            }else{
                $nama_k = 'Karyawan Kontrak';
            }
            
            $d['kategori']  = $kategori;
            $d['header']    = 'List Karyawan | '.$nama_k.' | Training';
            $d['content']   = 'master/training/list_karyawan';
            $this->load->view('master',$d);
        }
    }
    
    public function lihat_training($id_karyawan,$kategori)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $detail_k       = $this->master_model->detail_karyawan($id_karyawan);
            $nama_k         = $detail_k->row()->nama_lengkap;
            $nrp         	= $detail_k->row()->nip;
            $d['id_k']      = $id_karyawan;
            $d['nrp']      = $nrp;
            $d['kategori']  = $kategori;
            //$d['lokasi']    = $lokasi;
            $d['header']    = 'Lihat Training | '.$nama_k;
            $d['content']   = 'master/training/lihat_training';
            $this->load->view('master',$d);
        }
    }
    public function simpan_training($nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
                    $dt['nrp'] = $nrp;
                    $dt['training_course'] = $this->input->post('training_course');
					$dt['training_topic'] = $this->input->post('training_topic');
					$dt['start_date'] = $this->input->post('start_date');
					$dt['end_date'] = $this->input->post('end_date');
                    $this->db->insert("trans_training_history",$dt);
            }
            $this->session->set_flashdata('msg', 'Training Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_training()
    {
        $id['id_trn_training']   = $this->input->post('id');
        $c  = $this->db->get_where("trans_training_history",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_trn_training']    = $dt->id_trn_training;
                $d['training_course']    = $dt->training_course;
                $d['training_topic']  = $dt->training_topic;
                $d['start_date']  = $dt->start_date;
                $d['end_date']  = $dt->end_date;
            }
            echo json_encode($d);
        }else{
            $d['training_course']    = '';
            $d['training_topic']    = '';
            $d['start_date']    = '';
            $d['end_date']    = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_training()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trn_training']   = $this->input->post('id_trn_training');
            $dt['training_course'] = $this->input->post('training_course');
            $dt['training_topic'] = $this->input->post('training_topic');
            $dt['start_date'] = $this->input->post('start_date');
            $dt['end_date'] = $this->input->post('end_date');
            $this->db->update("trans_training_history",$dt,$id);
            $this->session->set_flashdata('msg', 'Training Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_training($id_trn_training)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trn_training']   = $id_trn_training;
            $this->db->delete("trans_training_history",$id);
            $this->session->set_flashdata('msg_error', 'Training Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}