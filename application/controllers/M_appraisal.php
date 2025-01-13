<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_appraisal extends CI_Controller {
    public function index()
	{   
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $d['header']    = 'Data Karyawan';
            $d['content']   = 'master/appraisal/index_karyawan';
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
            $d['content']   = 'master/appraisal/list_karyawan';
            $this->load->view('master',$d);
        }
    }
    
    public function lihat_appraisal($id_karyawan,$kategori)
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
            $d['header']    = 'Lihat Appraisal | '.$nama_k;
            $d['content']   = 'master/appraisal/lihat_appraisal';
            $this->load->view('master',$d);
        }
    }
    public function simpan_appraisal($nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
                    $dt['nrp'] = $nrp;
                    $dt['tahun'] = $this->input->post('tahun');
					$dt['kpi_pa'] = $this->input->post('kpi_pa');
					$dt['kbi'] = $this->input->post('kbi');
					$dt['catatan'] = $this->input->post('catatan');
                    $this->db->insert("trans_appraisal",$dt);
            }
            $this->session->set_flashdata('msg', 'Appraisal Berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_appraisal()
    {
        $id['id_trn_appraisal']   = $this->input->post('id');
        $c  = $this->db->get_where("trans_appraisal",$id);
        if($c->num_rows() > 0){
            foreach ($c->result() as $dt) {
                $d['id_trn_appraisal']    = $dt->id_trn_appraisal;
                $d['tahun']    = $dt->tahun;
                $d['kpi_pa']  = $dt->kpi_pa;
                $d['kbi']  = $dt->kbi;
                $d['catatan']  = $dt->catatan;
            }
            echo json_encode($d);
        }else{
            $d['tahun']    = '';
            $d['kpi_pa']    = '';
            $d['kbi']    = '';
            $d['catatan']    = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_appraisal()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trn_appraisal']   = $this->input->post('id_trn_appraisal');
            $dt['tahun'] = $this->input->post('tahun');
            $dt['kpi_pa'] = $this->input->post('kpi_pa');
            $dt['kbi'] = $this->input->post('kbi');
            $dt['catatan'] = $this->input->post('catatan');
            $this->db->update("trans_appraisal",$dt,$id);
            $this->session->set_flashdata('msg', 'Appraisal Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_appraisal($id_trn_appraisal)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_trn_appraisal']   = $id_trn_appraisal;
            $this->db->delete("trans_appraisal",$id);
            $this->session->set_flashdata('msg_error', 'Appraisal Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}