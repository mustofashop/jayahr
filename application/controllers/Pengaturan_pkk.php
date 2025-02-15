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
            $detail_nrp     = $this->master_model->detail_nrp($nrp);
            $d['id_k']      = $id_karyawan;
            $d['filled_ids'] = $this->master_model->get_filled_p_periode_ids($nrp); // Ambil ID yang sudah diisi
            $d['idp_nrp']   = $nrp;
            $d['trans_pkk'] = $this->master_model->get_trans_pkk($nrp);
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
            $insert_by      = $this->session->userdata('nrp');
            $d['atasan']    = $insert_by;
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
            // $bagian         = $this->session->userdata('department');
            // $id_karyawan    = $this->session->userdata('id_karyawan');
            $level          = $this->session->userdata('level');
            $unit           = $this->master_model->list_unit($level);
            $d['unit']      = $unit;
            $d['class']     = '';
            $d['header']    = 'Laporan Penilaian Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/lap_pkk';
            $this->load->view('master', $d);
        }
    }

    public function laporan_penilaian_kontrak()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            // $unit           = $this->input->get('unit');
            // $dtl_bagian     = $this->master_model->detail_bagian($unit);
            // $nrp            = $this->session->userdata('nrp');
            // $penilaian      = $this->master_model->hasil_nilai($nrp);
            // $d['penilaian'] = $penilaian;
            // $d['unit']      = $unit;
            // $d['nrp']       = $nrp;            //AKSI
            $d['class']     = '';
            $d['header']    = 'Laporan Penilaian Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/laporan_penilaian_kontrak';
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
            $set_pkk                  = $this->master_model->list_isi_pkk();
            $d['jenis']               = $jenis;
            $d['set_pkk']             = $set_pkk;
            $d['class']               = '';
            $d['header']              = 'List Karyawan | ' . $nama_jenis;
            $d['content']             = 'member/karyawan_kontrak/penilaian/list_karyawan_pkk';
            $this->load->view('master', $d);
        }
    }

    public function form_penilaian_1_2($id_karyawan, $nrp, $id_periode, $flag_jenis_form, $id_p_periode, $atasan)
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
            $detail_nrp                 = $this->master_model->detail_nrp($nrp);
            $detail_periode             = $this->master_model->detail_periode($id_periode);
            $jenis_form                 = $this->master_model->detail_jenis_form($flag_jenis_form);
            $detail_periode_penilaian   = $this->master_model->detail_periode_penilaian($id_p_periode);
            $insert_by                  = $this->session->userdata('nrp');
            $nilai_data                 = $this->master_model->get_nilai_1_2_terisi($nrp, $id_p_periode, $atasan);
            $d['id_k']                  = $id_karyawan;
            $d['idp_nrp']               = $nrp;
            $d['id_periode']            = $id_periode;
            $d['flag_jenis_form']       = $flag_jenis_form;
            $d['id_p_periode']          = $id_p_periode;
            $d['nilai_terisi']          = $nilai_data['nilai']; // Nilai per kriteria
            $d['text_tambahan']         = $nilai_data['text_tambahan']; // Text tambahan
            $d['atasan']                = $insert_by;
            $d['class']                 = '';
            $d['header']                = 'Isi PKK Kel 1_2 | ' . $nama_kr;
            $d['content']               = 'member/karyawan_kontrak/penilaian/form_penilaian_1_2';
            $this->load->view('master', $d);
        }
    }

    public function form_penilaian_3_7($id_karyawan, $nrp, $id_periode, $flag_jenis_form, $id_p_periode, $atasan)
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
            $detail_nrp                 = $this->master_model->detail_nrp($nrp);
            $detail_periode             = $this->master_model->detail_periode($id_periode);
            $jenis_form                 = $this->master_model->detail_jenis_form($flag_jenis_form);
            $detail_periode_penilaian   = $this->master_model->detail_periode_penilaian($id_p_periode);
            $insert_by                  = $this->session->userdata('nrp');
            // Ambil data nilai yang sudah diisi
            $d['nilai_terisi']      = $this->master_model->get_nilai_3_7_terisi($nrp, $id_p_periode, $atasan);
            $d['form_a']            = $this->master_model->get_form_A($nrp, $id_p_periode, $atasan);
            $d['form_b']            = $this->master_model->get_form_B($nrp, $id_p_periode, $atasan);
            $d['fb_k']              = $this->master_model->get_fb_karyawan($nrp, $id_p_periode);
            $d['fb_a']              = $this->master_model->get_fb_atasan($nrp, $id_p_periode);
            // Data tambahan
            $d['id_k']              = $id_karyawan;
            $d['idp_nrp']           = $nrp;
            $d['id_periode']        = $id_periode;
            $d['flag_jenis_form']   = $flag_jenis_form;
            $d['id_p_periode']      = $id_p_periode;
            $d['atasan']            = $insert_by;
            // Ambil data untuk setiap menu
            $d['menu3']             = $this->master_model->get_menu3_data();
            $d['menu4']             = $this->master_model->get_menu4_data();
            $d['menu5']             = $this->master_model->get_menu5_data();
            $d['menu6']             = $this->master_model->get_menu6_data();
            $d['menu5_data']        = $this->master_model->get_menu5_data();
            $d['class'] = '';
            $d['header'] = 'Isi PKK Kel 3_7 | ' . $nama_kr;
            $d['content'] = 'member/karyawan_kontrak/penilaian/form_penilaian_3_7';

            // Load view
            $this->load->view('master', $d);
        }
    }

    //nilai pkk

    // Menampilkan form penilaian
    public function nilai_pkk()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $nrp            = $this->session->userdata('nrp');
            $id_karyawan    = $this->session->userdata('id_karyawan');
            $data           = $this->master_model->lap_nilai($nrp);
            $penilaian      = $this->master_model->hasil_nilai($nrp);
            $data2          = $this->master_model->lap_nilai_3_7($nrp);
            $penilaian2     = $this->master_model->hasil_nilai_3_7($nrp);
            $form_a         = $this->master_model->nilai_form_a1($nrp);
            $form_b         = $this->master_model->nilai_form_b1($nrp);
            $data_pkk       = $this->master_model->detail_karyawan_full($id_karyawan);

            // Ambil flag_jenis_form dari hasil query
            $row = $data->row(); // Ambil satu baris data dari query
            $flag_jenis_form = isset($row->flag_jenis_form) ? $row->flag_jenis_form : 0;

            // Masukkan flag ke dalam data yang dikirim ke view
            $d['periode']   = 1; // Set default ke 1
            $d['menu3']     = $this->master_model->get_menu3_data();
            $d['menu4']     = $this->master_model->get_menu4_data();
            $d['menu5']     = $this->master_model->get_menu5_data();
            $d['menu6']     = $this->master_model->get_menu6_data();
            $d['fb_k']      = $this->master_model->get_fb_karyawan1($nrp);
            $d['fb_kr_1_2'] = $this->master_model->get_fb_kr1_2($nrp);
            $d['fb_a']      = $this->master_model->get_fb_atasan1($nrp);
            $d['data']      = $data;
            $d['penilaian'] = $penilaian;
            $d['data2']     = $data2;
            $d['penilaian2'] = $penilaian2;
            $d['form_a']    = $form_a;
            $d['form_b']    = $form_b;
            $d['nrp']       = $nrp;
            $d['data_pkk']  = $data_pkk;
            $d['flag_jenis_form'] = $flag_jenis_form; // Simpan flag_jenis_form dalam array data
            $d['class']     = '';
            $d['header']    = 'Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/penilaian/nilai';
            $d['flag_sent'] = isset($d['fb_k']->flag_sent) ? $d['fb_k']->flag_sent : 0;
            $d['flag_sent2']  = isset($d['fb_kr_1_2']->flag_sent) ? $d['fb_kr_1_2']->flag_sent : 0;

            $this->load->view('master', $d);
        }
    }

    public function nilai_pkk_periode($nrp, $jenis_form, $periode)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            if ($jenis_form == '1') {
                $data           = $this->master_model->lap_nilai_periode($nrp, $periode);
                $penilaian      = $this->master_model->hasil_nilai_periode($nrp, $periode);
                $d['data']      = $data;
                $d['penilaian'] = $penilaian;
                $d['periode']    = $periode;
                $d['flag_sent2']  = isset($d['fb_kr_1_2']->flag_sent) ? $d['fb_kr_1_2']->flag_sent : 0;
            } else {
                $data2           = $this->master_model->lap_nilai_3_7_periode($nrp, $periode);
                $penilaian2      = $this->master_model->hasil_nilai_3_7_periode($nrp, $periode);
                $form_a          = $this->master_model->nilai_form_a($nrp, $periode);
                $form_b          = $this->master_model->nilai_form_b($nrp, $periode);
                $d['data2']      = $data2;
                $d['penilaian2'] = $penilaian2;
                $d['form_a']     = $form_a;
                $d['form_b']     = $form_b;
                $d['fb_k']       = $this->master_model->get_fb_karyawan($nrp, $periode);
                $d['fb_a']       = $this->master_model->get_fb_atasan($nrp, $periode);
                $d['periode']    = $periode;
                $d['flag_sent']  = isset($d['fb_k']->flag_sent) ? $d['fb_k']->flag_sent : 0;
            }
            $data_pkk       = $this->master_model->detail_karyawan1($nrp);
            // Masukkan flag ke dalam data yang dikirim ke view
            $d['menu3']     = $this->master_model->get_menu3_data();
            $d['menu4']     = $this->master_model->get_menu4_data();
            $d['menu5']     = $this->master_model->get_menu5_data();
            $d['menu6']     = $this->master_model->get_menu6_data();
            $d['nrp']       = $nrp;
            $d['data_pkk']  = $data_pkk;
            $d['flag_jenis_form'] = $jenis_form; // Simpan flag_jenis_form dalam array data
            $d['class']     = '';
            $d['header']    = 'Laporan Penilaian Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/penilaian/nilai';
            $this->load->view('master', $d);
        }
    }

    public function view_nilai_pkk_periode($nrp, $jenis_form, $periode)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            if ($periode == 'all') {
                if ($jenis_form == 'form_penilaian_1_2') {
                    $rowData        = $this->master_model->get_trans_nilai_1_2($nrp);
                    $d['rowData']   = $rowData;
                    $d['periode']   = $periode;
                } else {
                    $rowData        = $this->master_model->get_trans_nilai_3_7($nrp);
                    $d['rowData']   = $rowData;
                    $d['periode']   = $periode;
                }
            } else {
                if ($jenis_form == 'form_penilaian_1_2') {
                    $data           = $this->master_model->lap_nilai_periode($nrp, $periode);
                    $penilaian      = $this->master_model->hasil_nilai_periode($nrp, $periode);
                    $d['periode']   = $periode;
                    $d['data']      = $data;
                    $d['penilaian'] = $penilaian;
                } else {
                    $data2          = $this->master_model->lap_nilai_3_7_periode($nrp, $periode);
                    $penilaian2     = $this->master_model->hasil_nilai_3_7_periode($nrp, $periode);
                    $form_a         = $this->master_model->nilai_form_a($nrp, $periode);
                    $form_b         = $this->master_model->nilai_form_b($nrp, $periode);
                    $d['periode']   = $periode;
                    $d['data']      = $data2;
                    $d['penilaian2'] = $penilaian2;
                    $d['form_a']    = $form_a;
                    $d['form_b']    = $form_b;
                    $d['fb_k']       = $this->master_model->get_fb_karyawan($nrp, $periode);
                    $d['fb_a']       = $this->master_model->get_fb_atasan($nrp, $periode);
                }
            }
            $data_pkk       = $this->master_model->detail_karyawan1($nrp);
            // Masukkan flag ke dalam data yang dikirim ke view
            $d['menu3']     = $this->master_model->get_menu3_data();
            $d['menu4']     = $this->master_model->get_menu4_data();
            $d['menu5']     = $this->master_model->get_menu5_data();
            $d['menu6']     = $this->master_model->get_menu6_data();
            $d['nrp']       = $nrp;
            $d['data_pkk']  = $data_pkk;
            $d['flag_jenis_form'] = $jenis_form; // Simpan flag_jenis_form dalam array data
            $d['class']     = '';
            $d['header']    = 'Laporan Penilaian Karyawan Kontrak';
            $d['content']   = 'member/karyawan_kontrak/penilaian/view_penilaian';
            $this->load->view('master', $d);
        }
    }
}
