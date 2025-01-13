<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_education extends CI_Controller {
    public function index()
	{   
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $d['header']    = 'Data Karyawan';
            $d['content']   = 'master/education/index_karyawan';
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
            $d['header']    = 'List Karyawan | '.$nama_k.' | Education';
            $d['content']   = 'master/education/list_karyawan';
            $this->load->view('master',$d);
        }
    }
    
    public function lihat_education($id_karyawan,$kategori)
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
            $d['header']    = 'Lihat Education | '.$nama_k;
            $d['content']   = 'master/education/lihat_education';
            $this->load->view('master',$d);
        }
    }
    public function simpan_education($nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
                    $dt['nrp'] = $nrp;
                    $dt['level'] = $this->input->post('level');
					$dt['name'] = $this->input->post('name');
					$dt['major'] = $this->input->post('major');
					$dt['period'] = $this->input->post('period');
					$dt['city'] = $this->input->post('city');
					$dt['gpa'] = $this->input->post('gpa');
                    $this->db->insert("trans_education",$dt);
            }
            $this->session->set_flashdata('msg', 'Education Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_education()
    {
        $id['id_trans_education']   = $this->input->post('id');
        $c  = $this->db->get_where("trans_education",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_trans_education']    = $dt->id_trans_education;
                $d['level']    = $dt->level;
                $d['name']  = $dt->name;
                $d['major']  = $dt->major;
                $d['period']  = $dt->period;
                $d['city']  = $dt->city;
                $d['gpa']  = $dt->gpa;
            }
            echo json_encode($d);
        }else{
            $d['level']    = '';
            $d['name']    = '';
            $d['major']    = '';
            $d['period']    = '';
            $d['city']  = '';
            $d['gpa']  = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_education()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trans_education']   = $this->input->post('id_trans_education');
            $dt['level'] = $this->input->post('level');
            $dt['name'] = $this->input->post('name');
            $dt['major'] = $this->input->post('major');
            $dt['period'] = $this->input->post('period');
            $dt['city'] = $this->input->post('city');
            $dt['gpa'] = $this->input->post('gpa');
            $this->db->update("trans_education",$dt,$id);
            $this->session->set_flashdata('msg', 'Education Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_education($id_trans_education)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trans_education']   = $id_trans_education;
            $this->db->delete("trans_education",$id);
            $this->session->set_flashdata('msg_error', 'Education Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}