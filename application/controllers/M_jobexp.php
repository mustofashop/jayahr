<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jobexp extends CI_Controller {
    public function index()
	{   
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $d['header']    = 'Data Karyawan';
            $d['content']   = 'master/job/index_karyawan';
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
            $d['header']    = 'List Karyawan | '.$nama_k.' | Appraisal';
            $d['content']   = 'master/job/list_karyawan';
            $this->load->view('master',$d);
        }
    }
    
    public function lihat_job($id_karyawan,$kategori)
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
            $d['header']    = 'Lihat Job Experience | '.$nama_k;
            $d['content']   = 'master/job/lihat_job';
            $this->load->view('master',$d);
        }
    }
    public function simpan_job($nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
                    $dt['nrp'] = $nrp;
                    $dt['company_name'] = $this->input->post('company_name');
					$dt['company_location'] = $this->input->post('company_location');
					$dt['position'] = $this->input->post('position');
					$dt['employment_period'] = $this->input->post('employment_period');
                    $this->db->insert("trans_job_experience",$dt);
            }
            $this->session->set_flashdata('msg', 'Job Experience Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_job()
    {
        $id['id_job_experience']   = $this->input->post('id');
        $c  = $this->db->get_where("trans_job_experience",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_job_experience']    = $dt->id_job_experience;
                $d['company_name']    = $dt->company_name;
                $d['company_location']  = $dt->company_location;
                $d['position']  = $dt->position;
                $d['employment_period']  = $dt->employment_period;
            }
            echo json_encode($d);
        }else{
            $d['company_name']    = '';
            $d['company_location']    = '';
            $d['position']    = '';
            $d['employment_period']    = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_job()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_job_experience']   = $this->input->post('id_job_experience');
            $dt['company_name'] = $this->input->post('company_name');
            $dt['company_location'] = $this->input->post('company_location');
            $dt['position'] = $this->input->post('position');
            $dt['employment_period'] = $this->input->post('employment_period');
            $this->db->update("trans_job_experience",$dt,$id);
            $this->session->set_flashdata('msg', 'Job Experience Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_job($id_job_experience)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_job_experience']   = $id_job_experience;
            $this->db->delete("trans_job_experience",$id);
            $this->session->set_flashdata('msg_error', 'Job Experience Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}