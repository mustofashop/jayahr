<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

class Trans_pkk extends CI_Controller
{
    public function save_set_pkk()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $dt['id_periode']       = $this->input->post('id_periode');
            $dt['id_jenis_form']    = $this->input->post('id_jenis_form');
            $dt['id_p_periode']     = $this->input->post('id_p_periode');
            $dt['flag_jenis_form']  = $this->input->post('flag_jenis_form');
            $dt['nrp']              = $this->input->post('nrp');
            $dt['insert_by']        = $this->session->userdata('nrp');
            $dt['insert_date']      = date("Y-m-d");
            $this->db->insert("trans_pkk", $dt);

            $this->session->set_flashdata('msg', 'Pengaturan Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function simpan_nilai_1_2()
    {
        $masuk = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $id_periode         = $this->input->post('id_periode');
            $flag_jenis_form = $this->input->post('flag_jenis_form');
            $isi_nilai_kel_1_2  = $this->input->post('isi_nilai_kel_1_2');
            $id_nilai_pkk       = $this->input->post('id_nilai_pkk');
            $text_tambahan      = $this->input->post('text_tambahan');
            $flag_sent          = 1;
            $nrp                = $this->input->post('nrp');

            // Loop untuk menyimpan data per kriteria
            foreach ($isi_nilai_kel_1_2 as $id => $nilai) {
                $dt['id_periode'] = $id_periode;
                $dt['id_nilai_pkk'] = $id_nilai_pkk;
                $dt['flag_jenis_form'] = $flag_jenis_form;
                $dt['id_nilai_pkk'] = $id;
                $dt['isi_nilai_kel_1_2'] = $nilai;
                $dt['text_tambahan'] = $text_tambahan;
                $dt['tahun'] = date("Y");
                $dt['nrp'] = $nrp;
                $dt['flag_sent'] = 1;
                $dt['insert_by'] = $this->session->userdata('nrp');
                $dt['insert_date'] = date("Y-m-d");
                $this->db->insert("trans_kel_1_2", $dt);
            }

            $this->session->set_flashdata('msg', 'Nilai Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }



    public function simpan_nilai_3_7()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $dt['id_periode']       = $this->input->post('id_periode');
            $dt['id_jenis_form']    = $this->input->post('id_jenis_form');
            $dt['id_p_periode']     = $this->input->post('id_p_periode');
            $dt['flag_jenis_form']  = $this->input->post('flag_jenis_form');
            $dt['nrp']              = $this->input->post('nrp');
            $dt['insert_by']        = $this->session->userdata('nrp');
            $dt['insert_date']      = date("Y-m-d");
            $this->db->insert("trans_pkk", $dt);

            $this->session->set_flashdata('msg', 'Pengaturan Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
