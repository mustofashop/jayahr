<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_career extends CI_Controller {
    public function index()
	{   
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $d['header']    = 'Data Karyawan';
            $d['content']   = 'master/career/index_karyawan';
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
            $d['header']    = 'List Karyawan | '.$nama_k.' | Career';
            $d['content']   = 'master/career/list_karyawan';
            $this->load->view('master',$d);
        }
    }
    
    public function lihat_career($id_karyawan,$kategori)
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
            $d['header']    = 'Lihat Career | '.$nama_k;
            $d['content']   = 'master/career/lihat_career';
            $this->load->view('master',$d);
        }
    }
    public function simpan_career($nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
			
				$job_title = $this->input->post('job_title');
				$organization_unit = $this->input->post('organization_unit');
				$job_grade = $this->input->post('job_grade');
				
                    $dt['nrp'] = $nrp;
                    $dt['effective_date'] = $this->input->post('effective_date');
					$dt['range_year'] = $this->input->post('range_year');
					$dt['job_title'] = $this->input->post('job_title');
					$dt['organization_unit'] = $this->input->post('organization_unit');
					$dt['job_grade'] = $this->input->post('job_grade');
					$dt['employee_status'] = $this->input->post('employee_status');
                    $this->db->insert("trans_career",$dt);
					
					$id['nip']            = $nrp;
					$dt2['job_title']          = $this->input->post('job_title');
					$dt2['department']          = $this->input->post('organization_unit');
					$dt2['job_grade']          = $this->input->post('job_grade');
					$dt2['status_jaya']          = $this->input->post('employee_status');
					$this->db->update("mst_karyawan",$dt2,$id);
            }
			
            $this->session->set_flashdata('msg', 'Career Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_career()
    {
        $id['id_trans_career']   = $this->input->post('id');
        $c  = $this->db->get_where("trans_career",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_trans_career']    = $dt->id_trans_career;
                $d['effective_date']    = $dt->effective_date;
                $d['range_year']  = $dt->range_year;
                $d['job_title']  = $dt->job_title;
                $d['organization_unit']  = $dt->organization_unit;
                $d['job_grade']  = $dt->job_grade;
                $d['employee_status']  = $dt->employee_status;
            }
            echo json_encode($d);
        }else{
            $d['effective_date']    = '';
            $d['range_year']    = '';
            $d['job_title']    = '';
            $d['organization_unit']    = '';
            $d['job_grade']  = '';
            $d['employee_status']  = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_career()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trans_career']   = $this->input->post('id_trans_career');
            $dt['effective_date'] = $this->input->post('effective_date');
            $dt['range_year'] = $this->input->post('range_year');
            $dt['job_title'] = $this->input->post('job_title');
            $dt['organization_unit'] = $this->input->post('organization_unit');
            $dt['job_grade'] = $this->input->post('job_grade');
            $dt['employee_status'] = $this->input->post('employee_status');
            $this->db->update("trans_career",$dt,$id);
            $this->session->set_flashdata('msg', 'Career Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_career($id_trans_career)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trans_career']   = $id_trans_career;
            $this->db->delete("trans_career",$id);
            $this->session->set_flashdata('msg_error', 'Career Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}