<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

class Pengaturan_pkk extends CI_Controller
{
    public function index()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $d['class']     = '';
            $d['header']    = 'Data Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/index';
            $this->load->view('master', $d);
        }
    }

    public function list_karyawan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $jenis          = $this->input->get('jenis');
            if ($jenis == '1') {
                // karyawan tetap
                $nama_jenis = 'Karyawan Tetap';
            } elseif ($jenis == '2') {
                $nama_jenis = 'Karyawan Borongan / Magang';
            } else {
                $nama_jenis = 'Kontrak';
            }
            $perusahaan     = 12;
            $detail_pr      = $this->master_model->get_detail_perusahaan($perusahaan);
            if ($detail_pr->num_rows() > 0) {
                $nama_pr    = $detail_pr->row()->nama_perusahaan;
            } else {
                $nama_pr    = '';
            }
            $id_lokasi      = $this->input->get('lokasi');
            if ($id_lokasi == "" || empty($id_lokasi)) {
                $lokasi     = 0;
                $nama_lk    = '';
            } else {
                $detail_lk  = $this->master_model->detail_lokasi($id_lokasi);
                if ($detail_lk->num_rows() > 0) {
                    $nama_lk =  ' | ' . $detail_lk->row()->nama_lokasi;
                } else {
                    $nama_lk = '';
                }
                $lokasi     = $id_lokasi;
            }
            $id_bagian      = $this->input->get('bagian');
            if ($id_bagian == "" || empty($id_bagian)) {
                $bagian     = 0;
                $nama_bg    = '';
            } else {
                $detail_bg  = $this->master_model->detail_bagian($id_bagian);
                if ($detail_bg->num_rows() > 0) {
                    $nama_bg = ' | ' . $detail_bg->row()->nama_bagian;
                } else {
                    $nama_bg = '';
                }
                $bagian     = $id_bagian;
            }
            $d['jenis']     = $jenis;
            $d['perusahaan'] = $perusahaan;
            $d['lokasi']    = $lokasi;
            $d['bagian']    = $bagian;
            $d['class']     = '';
            $d['header']    = 'List Karyawan | ' . $nama_jenis;
            $d['content']   = 'member/karyawan_kontrak/list_karyawan';
            $this->load->view('master', $d);
        }
    }

    public function setting_pkk($id_karyawan, $nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $detail_karyawan = $this->master_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr    = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr    = '';
            }
            $detail_nrp  = $this->master_model->detail_nrp($nrp);
            $d['id_k']      = $id_karyawan;
            $d['idp_nrp']        = $nrp;
            $d['class']     = '';
            $d['header']    = 'Setting PKK | ' . $nama_kr;
            $d['content']   = 'member/karyawan_kontrak/set_pkk';
            $this->load->view('master', $d);
        }
    }

    public function isi_pkk()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $insert_by         = $this->session->userdata('nrp');
            $d['atasan']         = $insert_by;
            $d['class']     = '';
            $d['header']    = 'Setting PKK';
            $d['content']   = 'member/karyawan_kontrak/pengisian_pkk';
            $this->load->view('master', $d);
        }
    }

    public function lap_pkk()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {

            $d['class']     = '';
            $d['header']    = 'Laporan Penilaian Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/lap_pkk';
            $this->load->view('master', $d);
        }
    }

    public function penilaian_pkk()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $d['class']     = '';
            $d['header']    = 'Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/penilaian/index';
            $this->load->view('master', $d);
        }
    }

    public function list_karyawan_pkk()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $jenis          = $this->input->get('jenis');
            if ($jenis == '1') {
                // karyawan tetap
                $nama_jenis = 'Karyawan Tetap';
            } elseif ($jenis == '2') {
                $nama_jenis = 'Karyawan Borongan / Magang';
            } else {
                $nama_jenis = 'Kontrak';
            }
            $perusahaan     = 12;
            $detail_pr      = $this->master_model->get_detail_perusahaan($perusahaan);
            if ($detail_pr->num_rows() > 0) {
                $nama_pr    = $detail_pr->row()->nama_perusahaan;
            } else {
                $nama_pr    = '';
            }
            $id_lokasi      = $this->input->get('lokasi');
            if ($id_lokasi == "" || empty($id_lokasi)) {
                $lokasi     = 0;
                $nama_lk    = '';
            } else {
                $detail_lk  = $this->master_model->detail_lokasi($id_lokasi);
                if ($detail_lk->num_rows() > 0) {
                    $nama_lk =  ' | ' . $detail_lk->row()->nama_lokasi;
                } else {
                    $nama_lk = '';
                }
                $lokasi     = $id_lokasi;
            }
            $id_bagian      = $this->input->get('bagian');
            if ($id_bagian == "" || empty($id_bagian)) {
                $bagian     = 0;
                $nama_bg    = '';
            } else {
                $detail_bg  = $this->master_model->detail_bagian($id_bagian);
                if ($detail_bg->num_rows() > 0) {
                    $nama_bg = ' | ' . $detail_bg->row()->nama_bagian;
                } else {
                    $nama_bg = '';
                }
                $bagian     = $id_bagian;
            }
            $d['jenis']     = $jenis;
            $d['perusahaan'] = $perusahaan;
            $d['lokasi']    = $lokasi;
            $d['bagian']    = $bagian;
            $d['class']     = '';
            $d['header']    = 'List Karyawan | ' . $nama_jenis;
            $d['content']   = 'member/karyawan_kontrak/penilaian/list_karyawan_pkk';
            $this->load->view('master', $d);
        }
    }

    public function form_penilaian_1_2($id_karyawan, $nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $detail_karyawan = $this->master_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr    = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr    = '';
            }
            $detail_nrp  = $this->master_model->detail_nrp($nrp);
            $d['id_k']      = $id_karyawan;
            $d['idp_nrp']        = $nrp;
            $d['class']     = '';
            $d['header']    = 'Isi PKK Kel 1_2 | ' . $nama_kr;
            $d['content']   = 'member/karyawan_kontrak/penilaian/form_penilaian_1_2';
            $this->load->view('master', $d);
        }
    }

    public function form_penilaian_3_7($id_karyawan, $nrp)
    {
        $masuk = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            // Ambil detail karyawan
            $detail_karyawan = $this->master_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr = '';
            }

            // Ambil detail NRP
            $detail_nrp = $this->master_model->detail_nrp($nrp);

            // Ambil data untuk setiap menu
            $d['menu3'] = $this->master_model->get_menu3_data();
            $d['menu4'] = $this->master_model->get_menu4_data();
            $d['menu5'] = $this->master_model->get_menu5_data();
            $d['menu6'] = $this->master_model->get_menu6_data();

            // Data tambahan
            $d['id_k'] = $id_karyawan;
            $d['idp_nrp'] = $nrp;
            $d['class'] = '';
            $d['header'] = 'Isi PKK Kel 3_7 | ' . $nama_kr;
            $d['content'] = 'member/karyawan_kontrak/penilaian/form_penilaian_3_7';

            // Load view
            $this->load->view('master', $d);
        }
    }
}
