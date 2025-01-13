<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_assessment extends CI_Controller {
    public function index()
	{   
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $d['header']    = 'Data Karyawan';
            $d['content']   = 'master/assessment/index_karyawan';
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
            $d['header']    = 'List Karyawan | '.$nama_k.' | Assessment';
            $d['content']   = 'master/assessment/list_karyawan';
            $this->load->view('master',$d);
        }
    }
    
    public function lihat_assessment($id_karyawan,$kategori)
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
            $d['header']    = 'Lihat Assessment | '.$nama_k;
            $d['content']   = 'master/assessment/lihat_assessment';
            $this->load->view('master',$d);
        }
    }
    public function simpan_assessment($nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
                    $dt['nrp'] = $nrp;
                    $dt['subject'] = $this->input->post('subject');
					$dt['testing_date'] = $this->input->post('testing_date');
					$dt['institution'] = $this->input->post('institution');
					$dt['institution_score'] = $this->input->post('institution_score');
					$dt['result_description'] = $this->input->post('result_description');
                    $this->db->insert("trans_assessment",$dt);
            }
            $this->session->set_flashdata('msg', 'Assessment Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_assessment()
    {
        $id['id_job_assessment']   = $this->input->post('id');
        $c  = $this->db->get_where("trans_assessment",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_job_assessment']    = $dt->id_job_assessment;
                $d['subject']    = $dt->subject;
                $d['testing_date']  = $dt->testing_date;
                $d['institution']  = $dt->institution;
                $d['institution_score']  = $dt->institution_score;
                $d['result_description']  = $dt->result_description;
            }
            echo json_encode($d);
        }else{
            $d['subject']    = '';
            $d['subject']    = '';
            $d['testing_date']    = '';
            $d['institution']    = '';
            $d['institution_score']    = '';
            $d['result_description']  = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_assessment()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_job_assessment']   = $this->input->post('id_job_assessment');
            $dt['subject'] = $this->input->post('subject');
            $dt['testing_date'] = $this->input->post('testing_date');
            $dt['institution'] = $this->input->post('institution');
            $dt['institution_score'] = $this->input->post('institution_score');
            $dt['result_description'] = $this->input->post('result_description');
            $this->db->update("trans_assessment",$dt,$id);
            $this->session->set_flashdata('msg', 'Assessment Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_assessment($id_job_assessment)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_job_assessment']   = $id_job_assessment;
            $this->db->delete("trans_assessment",$id);
            $this->session->set_flashdata('msg_error', 'Assessment Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}