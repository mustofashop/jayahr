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
            $dt['flag_penilaian']   = $this->input->post('flag_penilaian');
            $dt['flag_sent']        = 1;
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
            $id_p_periode       = $this->input->post('id_p_periode');
            $flag_jenis_form    = $this->input->post('flag_jenis_form');
            $isi_nilai_kel_1_2  = $this->input->post('isi_nilai_kel_1_2'); // Pilihan nilai (A, B, C, D)
            $id_nilai_pkk       = $this->input->post('id_nilai_pkk');
            $text_tambahan      = $this->input->post('text_tambahan');
            $nrp                = $this->input->post('nrp');
            $bobot              = $this->input->post('bobot'); // Bobot sesuai kriteria
            $nilai_a            = $this->input->post('isi_nilai_a');
            $nilai_b            = $this->input->post('isi_nilai_b');
            $nilai_c            = $this->input->post('isi_nilai_c');
            $nilai_d            = $this->input->post('isi_nilai_d');

            // Loop untuk menyimpan data per kriteria
            foreach ($isi_nilai_kel_1_2 as $id => $nilai) {
                $dt['id_periode']           = $id_periode;
                $dt['id_p_periode']         = $id_p_periode;
                $dt['id_nilai_pkk']         = $id;
                $dt['flag_jenis_form']      = $flag_jenis_form;
                $dt['isi_nilai_kel_1_2']    = $nilai; // Pilihan (A, B, C, D)
                $dt['text_tambahan']        = $text_tambahan;
                $dt['tahun']                = date("Y");
                $dt['nrp']                  = $nrp;
                $dt['bobot']                = isset($bobot[$id]) ? $bobot[$id] : 0;
                $dt['flag_sent']            = 1;
                $dt['insert_by']            = $this->session->userdata('nrp');
                $dt['insert_date']          = date("Y-m-d");

                // Kondisi untuk mengambil nilai berdasarkan pilihan (A, B, C, D)
                if ($nilai == 'A') {
                    $dt['nilai_akhir'] = isset($nilai_a[$id]) ? $nilai_a[$id] : 0;
                } elseif ($nilai == 'B') {
                    $dt['nilai_akhir'] = isset($nilai_b[$id]) ? $nilai_b[$id] : 0;
                } elseif ($nilai == 'C') {
                    $dt['nilai_akhir'] = isset($nilai_c[$id]) ? $nilai_c[$id] : 0;
                } elseif ($nilai == 'D') {
                    $dt['nilai_akhir'] = isset($nilai_d[$id]) ? $nilai_d[$id] : 0;
                } else {
                    $dt['nilai_akhir'] = 0; // Default jika pilihan tidak valid
                }

                // Simpan data ke database
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
