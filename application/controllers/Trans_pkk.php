<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

class Trans_pkk extends CI_Controller
{
    public function save_set_pkk()
    {
        $masuk = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            // Validasi data input
            $id_p_periode       = $this->input->post('id_p_periode');
            $id_periode         = $this->input->post('id_periode');
            $flag_penilaian     = $this->input->post('flag_penilaian');
            $id_jenis_form      = $this->input->post('id_jenis_form');
            $flag_jenis_form    = $this->input->post('flag_jenis_form');
            $nrp = $this->input->post('nrp');

            if (empty($id_p_periode) || empty($id_periode) || empty($flag_penilaian) || empty($nrp)) {
                $this->session->set_flashdata('msg', 'Data tidak lengkap, gagal menyimpan!');
                redirect($_SERVER['HTTP_REFERER']);
            }

            // Ambil nilai flag_penilaian berdasarkan id_p_periode yang dipilih
            $flag_penilaian_selected = isset($flag_penilaian[$id_p_periode]) ? $flag_penilaian[$id_p_periode] : null;

            if ($flag_penilaian_selected === null) {
                $this->session->set_flashdata('error', 'Flag Penilaian tidak ditemukan!');
                redirect('controller_name/form_page'); // Redirect kembali ke halaman form
            }

            // 🔹 Ambil `flag_jenis_form` berdasarkan ID yang dipilih dari input form
            $flag_jenis_form_selected = isset($flag_jenis_form[$id_jenis_form]) ? $flag_jenis_form[$id_jenis_form] : null;

            if ($flag_jenis_form_selected === null) {
                $this->session->set_flashdata('error', 'Flag Jenis Form tidak ditemukan!');
                redirect('controller_name/form_page');
            }
            $data = [
                'id_p_periode'    => $id_p_periode,
                'id_periode'      => $id_periode,
                'flag_penilaian'  => $flag_penilaian_selected,
                'nrp'             => $nrp,
                'id_jenis_form'   => $id_jenis_form,
                'flag_jenis_form' => $flag_jenis_form_selected,
                'flag_sent'       => 1,
                'insert_date'     => date('Y-m-d H:i:s'),
                'insert_by'       => $this->session->userdata('nrp')
            ];


            // Insert ke tabel trans_pkk
            $this->db->insert("trans_pkk", $data);

            // Redirect dengan pesan sukses
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

    public function simpan_form_a()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $dt = [
                'id_periode'            => $this->input->post('id_periode'),
                'id_p_periode'          => $this->input->post('id_p_periode'),
                'flag_jenis_form'       => $this->input->post('flag_jenis_form'),
                'hasil_nilai_a'         => $this->input->post('hasil_nilai_a'),
                'persen_a'              => $this->input->post('persen_a'),
                'deviasi_nilai_a'       => $this->input->post('deviasi_nilai_a'),
                'hasil_nilai_b'         => $this->input->post('hasil_nilai_b'),
                'persen_b'              => $this->input->post('persen_b'),
                'deviasi_b'             => $this->input->post('deviasi_b'),
                'tugas_tambahan'        => $this->input->post('tugas_tambahan'),
                'hasil_tgs_tambahan'    => $this->input->post('hasil_tgs_tambahan'),
                'persen_tambahan'       => $this->input->post('persen_tambahan'),
                'deviasi_tambahan'      => $this->input->post('deviasi_tambahan'),
                'tahun'                 => date('Y'),
                'nrp'                   => $this->input->post('nrp'),
                'insert_by'             => $this->session->userdata('nrp')
            ];
            $this->db->insert("trans_form_a", $dt);
            // $nrp = $this->session->userdata('nrp');
            // $form_a_data = $this->master_model->get_form_a_data($nrp);

            // if (!empty($form_a_data)) {
            //     $this->session->set_userdata('form_a_data', $form_a_data);
            // } else {
            //     $this->session->unset_userdata('form_a_data');
            // }

            $this->session->set_flashdata('msg', 'Form A Sukses Disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function simpan_form_b()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $dt = [
                'kesimpulan'            => $this->input->post('kesimpulan'),
                'penjelasan'            => $this->input->post('penjelasan'),
                'id_periode'            => $this->input->post('id_periode'),
                'id_p_periode'          => $this->input->post('id_p_periode'),
                'flag_jenis_form'       => $this->input->post('flag_jenis_form'),
                'tahun'                 => date('Y'),
                'nrp'                   => $this->input->post('nrp'),
                'insert_by'             => $this->session->userdata('nrp')
            ];
            $this->db->insert("trans_form_b", $dt);

            $this->session->set_flashdata('msg', 'Form B Sukses Disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function simpan_penilaian_feedback()
    {
        $masuk = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $id_periode        = $this->input->post('id_periode');
            $id_p_periode      = $this->input->post('id_p_periode');
            $flag_jenis_form   = $this->input->post('flag_jenis_form');
            $nrp               = $this->input->post('nrp');
            $komentar_feedback = $this->input->post('komentar_feedback');

            // Cek apakah flag_jenis_form valid
            if (empty($flag_jenis_form)) {
                die('Error: flag_jenis_form tidak ditemukan!');
            }

            // Ambil data penilaian (kinerja & kompetensi)
            $penilaian_data = [
                'kinerja' => $this->input->post('kinerja'),
                'kompetensi' => $this->input->post('kompetensi')
            ];

            foreach ($penilaian_data as $kategori => $data) {
                if (!empty($data)) {
                    foreach ($data as $id_form_penilaian => $nilai) {
                        // Query untuk mengambil nilai dari mst_penilaian_3_7_form_penilaian
                        $query = $this->db->select("nilai_a_flag{$flag_jenis_form} AS nilai_a, 
                                                nilai_b_flag{$flag_jenis_form} AS nilai_b, 
                                                nilai_c_flag{$flag_jenis_form} AS nilai_c, 
                                                nilai_d_flag{$flag_jenis_form} AS nilai_d")
                            ->where('id_form_penilaian', $id_form_penilaian)
                            ->get('mst_penilaian_3_7_form_penilaian');

                        $nilai_form = $query->row(); // Ambil hasil query

                        // Pastikan data ditemukan
                        if (!$nilai_form) {
                            die("Error: Data penilaian tidak ditemukan untuk ID $id_form_penilaian.");
                        }

                        // Menentukan hasil nilai berdasarkan pilihan A, B, C, D
                        switch ($nilai) {
                            case 'A':
                                $hasil_nilai = $nilai_form->nilai_a ?? 0;
                                break;
                            case 'B':
                                $hasil_nilai = $nilai_form->nilai_b ?? 0;
                                break;
                            case 'C':
                                $hasil_nilai = $nilai_form->nilai_c ?? 0;
                                break;
                            case 'D':
                                $hasil_nilai = $nilai_form->nilai_d ?? 0;
                                break;
                            default:
                                $hasil_nilai = 0;
                        }

                        // Menyimpan ke database
                        $dt = [
                            'id_periode'         => $id_periode,
                            'id_p_periode'       => $id_p_periode,
                            'id_form_penilaian'  => $id_form_penilaian,
                            'flag_jenis_form'    => $flag_jenis_form,
                            'isi_form_penilaian' => $nilai, // Pilihan (A, B, C, D)
                            'hasil_nilai'        => $hasil_nilai,
                            'komentar_feedback'  => $komentar_feedback,
                            'tahun'              => date("Y"),
                            'nrp'                => $nrp,
                            'flag_sent'          => 1,
                            'insert_by'          => $this->session->userdata('nrp'),
                            'insert_date'        => date("Y-m-d")
                        ];

                        // Simpan ke database
                        $this->db->insert("trans_kel_3_7", $dt);
                    }
                }
            }

            $this->session->set_flashdata('msg', 'Penilaian berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
