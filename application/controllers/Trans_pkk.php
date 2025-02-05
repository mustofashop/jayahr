<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            $nrp                = $this->input->post('nrp');

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
            redirect(base_url('Pengaturan_pkk/list_karyawan'));
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
            redirect(base_url('Pengaturan_pkk/list_karyawan_pkk'));
        }
    }

    public function simpan_nilai_3_7()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $id_periode      = $this->input->post('id_periode');
            $flag_jenis_form = $this->input->post('flag_jenis_form');
            $id_p_periode    = $this->input->post('id_p_periode');
            $nrp             = $this->input->post('nrp');
            $insert_by       = $this->session->userdata('nrp');

            // 1️⃣ **Simpan Form A jika ada input**
            if ($this->input->post('hasil_nilai_a')) {
                $dt_a = [
                    'id_periode'            => $id_periode,
                    'id_p_periode'          => $id_p_periode,
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
                    'insert_date'           => date("Y-m-d"),
                    'nrp'                   => $nrp,
                    'flag_jenis_form'       => $flag_jenis_form,
                    'insert_by'             => $insert_by
                ];
                $this->db->insert("trans_form_a", $dt_a);
                $this->session->set_flashdata('msg', 'Form A Sukses Disimpan');
            }

            // 2️⃣ **Simpan Form B jika ada input**
            if ($this->input->post('kesimpulan')) {
                $dt_b = [
                    'kesimpulan'            => $this->input->post('kesimpulan'),
                    'penjelasan'            => $this->input->post('penjelasan'),
                    'id_periode'            => $id_periode,
                    'id_p_periode'          => $id_p_periode,
                    'tahun'                 => date('Y'),
                    'insert_date'           => date("Y-m-d"),
                    'nrp'                   => $nrp,
                    'flag_jenis_form'       => $flag_jenis_form,
                    'insert_by'             => $insert_by
                ];
                $this->db->insert("trans_form_b", $dt_b);
                $this->session->set_flashdata('msg', 'Form B Sukses Disimpan');
            }

            // 3️⃣ **Simpan Penilaian Feedback jika ada flag_jenis_form**
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
                        // Query untuk mengambil nilai dari mst_penilaian_3_7_form_penilaian berdasarkan flag
                        $query = $this->db->select("nilai_a, nilai_b, nilai_c, nilai_d")
                            ->where('id_form_penilaian', $id_form_penilaian)
                            ->where('flag', $flag_jenis_form) // Sesuaikan dengan flag_jenis_form
                            ->get('mst_flag');

                        $nilai_form = $query->row(); // Ambil hasil query

                        // Pastikan data ditemukan
                        if (!$nilai_form) {
                            die("Error: Data penilaian tidak ditemukan untuk ID $id_form_penilaian dan flag $flag_jenis_form.");
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

                $this->session->set_flashdata('msg', 'Penilaian berhasil disimpan');
            }
            redirect(base_url('Pengaturan_pkk/list_karyawan_pkk'));
        }
    }

    public function fb_karyawan()
    {
        $masuk = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $id_p_periode       = $this->input->post('id_p_periode');
            $nrp                = $this->input->post('nrp');
            $isi_feedback       = $this->input->post('isi_feedback');

            $data = [
                'id_p_periode'    => $id_p_periode,
                'nrp'             => $nrp,
                'isi_feedback'    => $isi_feedback,
                'insert_date'     => date('Y-m-d'),
                'flag_sent'       => 1,
            ];

            // Insert ke tabel trans_pkk
            $this->db->insert("trans_fb_karyawan", $data);

            // Redirect dengan pesan sukses
            $this->session->set_flashdata('msg', 'Feedback Sukses dikirim');
            redirect(base_url('Pengaturan_pkk/nilai_pkk'));
        }
    }

    public function fb_atasan()
    {
        if ($this->session->userdata('masuk_k') != TRUE) {
            echo json_encode(["status" => "error", "message" => "Session expired, silakan login kembali"]);
            return;
        }

        $id_p_periode = $this->input->post('id_p_periode');
        $nrp = $this->input->post('nrp');
        $isi_feedback = $this->input->post('isi_feedback'); // Ambil feedback dari AJAX

        if (empty($id_p_periode) || empty($nrp) || empty($isi_feedback)) {
            echo json_encode(["status" => "error", "message" => "Semua data harus diisi!"]);
            return;
        }

        $data = [
            'id_p_periode' => $id_p_periode,
            'nrp'          => $nrp,
            'isi_feedback' => $isi_feedback,
            'insert_date'  => date('Y-m-d'),
            'flag_sent'    => 1,
            'insert_by'    => $this->session->userdata('nrp'),
        ];

        if ($this->db->insert("trans_fb_atasan", $data)) {
            echo json_encode(["status" => "success", "message" => "Feedback berhasil disimpan!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menyimpan feedback"]);
        }
    }

    function download_data_pkk($nrp, $periode)
    {
        $masuk  = $this->session->userdata('masuk_k');
        $this->load->helpers('print_rekap_helper');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            if ($periode == 'all') {
                $data1   = $this->master_model->get_trans_pkk($nrp);
                $pdf = new reportProduct();
                $pdf->setKriteria("cetak_laporan");
                foreach ($data1->result() as $dt) {
                    $data   = $this->master_model->lap_nilai_periode($dt->nrp, $dt->id_p_periode);
                    if ($data->num_rows() > 0) {
                        $row = $data->row();
                        $pdf->setNama("CETAK DATA KARYAWAN");
                        $pdf->AliasNbPages();
                        $pdf->AddPage("P", "A4");
                        $A4[0] = 210;
                        $A4[1] = 297;
                        $Q[0] = 216;
                        $Q[1] = 279;
                        $pdf->SetTitle('LAPORAN PENILAIAN PRESTASI KERJA');
                        $pdf->SetCreator('Jaya HR');
                        $h = 7;
                        $pdf->SetFont('Times', 'B', 14);
                        $pdf->SetX(6);
                        $pdf->SetX(6);
                        $pdf->SetFont('Times', '', 10);
                        $pdf->Ln(5);

                        //Column widths
                        $pdf->SetFont('Arial', 'B', 14);
                        $pdf->SetX(6);
                        $pdf->Cell(200, 4, 'LAPORAN PENILAIAN PRESTASI KERJA', 0, 0, 'C');
                        $pdf->Cell(10, 4, '', 0, 1);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(190, 5, 'KARYAWAN KONTRAK KELOMPOK I - II', 0, 1, 'C');
                        $pdf->Ln(5);
                        $w = array(10, 35, 30, 65, 20, 35);

                        // Lebar Kolom
                        $colWidths = [10, 70, 30, 20, 30, 20];

                        // Informasi Karyawan
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Nama', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->karyawan_nama) ? $row->karyawan_nama : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Jabatan', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->job_grade) ? $row->job_grade : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Tanggal Masuk', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->tgl_hire) ? $row->tgl_hire : 'Tidak Ada Data', 1, 1);

                        $pdf->Ln(5);

                        // Informasi Penilai
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Atasan Langsung', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->spv1_nama) ? $row->spv1_nama : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Atasan Tidak Langsung', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->spv2_nama) ? $row->spv2_nama : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Unit', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->department) ? $row->department : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Periode Penilaian', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->flag_penilaian) ? $row->flag_penilaian : 'Tidak Ada Data', 1, 1);
                        $pdf->Ln(5);


                        // Tabel Penilaian
                        $pdf->SetFont('Arial', 'B', 10);
                        $header = ['No', 'Aspek yang Dinilai', 'AL', 'Nilai AL', 'ATL', 'Nilai ATL'];
                        $colWidths = [10, 100, 20, 20, 20, 20];
                        foreach ($header as $i => $col) {
                            $pdf->Cell($colWidths[$i], 10, $col, 1, 0, 'C');
                        }
                        $pdf->Ln();

                        $pdf->SetFont('Arial', '', 10);
                        $no = 1;
                        $penilaian = $this->master_model->hasil_nilai_periode($dt->nrp, $dt->id_p_periode);
                        foreach ($penilaian->result() as $row) {
                            $pdf->Cell($colWidths[0], 7, $no++, 1, 0, 'C');
                            $pdf->Cell($colWidths[1], 7, utf8_decode($row->aspek_dinilai), 1);
                            $pdf->Cell($colWidths[2], 7, $row->isi_nilai_atasan_langsung, 1, 0, 'C');
                            $pdf->Cell($colWidths[3], 7, number_format($row->nilai_atasan_langsung, 1), 1, 0, 'C');
                            $pdf->Cell($colWidths[4], 7, $row->isi_nilai_atasan_tidak_langsung, 1, 0, 'C');
                            $pdf->Cell($colWidths[5], 7, number_format($row->nilai_atasan_tidak_langsung, 1), 1, 0, 'C');
                            $pdf->Ln();
                        }
                        // Total dan Hasil Akhir
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Total', 1);
                        $pdf->Cell($colWidths[2] + $colWidths[3], 7, number_format($row->total_nilai_atasan_langsung, 1), 1, 0, 'C');
                        $pdf->Cell($colWidths[4] + $colWidths[5], 7, number_format($row->total_nilai_atasan_tidak_langsung, 1), 1, 0, 'C');
                        $pdf->Ln();

                        $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Hasil Akhir', 1);
                        $pdf->Cell($colWidths[2] + $colWidths[3] + $colWidths[4] + $colWidths[5], 7, number_format(($row->total_nilai_atasan_langsung * 0.6) + ($row->total_nilai_atasan_tidak_langsung * 0.4), 1), 1, 0, 'C');
                        $pdf->Ln(12);

                        // Tabel Kriteria Penilaian
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(35, 7, 'Kriteria', 1, 0, 'C');
                        $pdf->Cell(35, 7, 'Nilai', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Keterangan', 1, 1, 'C');

                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(35, 7, 'A', 1, 0, 'C');
                        $pdf->Cell(35, 7, '90 s.d. 100', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Istimewa', 1, 1, 'C');
                        $pdf->Cell(35, 7, 'B', 1, 0, 'C');
                        $pdf->Cell(35, 7, '80 s.d. 89', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Baik', 1, 1, 'C');
                        $pdf->Cell(35, 7, 'C', 1, 0, 'C');
                        $pdf->Cell(35, 7, '40 s.d. 79', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Cukup', 1, 1, 'C');
                        $pdf->Cell(35, 7, 'D', 1, 0, 'C');
                        $pdf->Cell(35, 7, '40 s.d. 59', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Kurang', 1, 1, 'C');
                        $pdf->Ln(5);

                        // Aspek Tambahan
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(190, 7, 'Aspek-aspek Tambahan (mohon diuraikan bila ada):', 1, 1, 'L');
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->MultiCell(190, 7, 'Atasan Langsung:' . (isset($row->text_tambahan_atasan_langsung) ? $row->text_tambahan_atasan_langsung : 'Tidak Ada Data'), 1);
                        $pdf->MultiCell(190, 7, 'Atasan Tidak Langsung:' . (isset($row->text_tambahan_atasan_tidak_langsung) ? $row->text_tambahan_atasan_tidak_langsung : 'Tidak Ada Data'), 1);
                    } else {
                        $this->session->set_flashdata('msg_error', 'Data Belum Di Nilai');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                ob_clean();
                $pdf->Output('D', 'Laporan_Penilaian_Kel_1_2.pdf');
            } else {
                $data   = $this->master_model->lap_nilai_periode($nrp, $periode);
                if ($data->num_rows() > 0) {
                    $row = $data->row();
                    $pdf = new reportProduct();
                    $pdf->setKriteria("cetak_laporan");
                    $pdf->setNama("CETAK DATA KARYAWAN");
                    $pdf->AliasNbPages();
                    $pdf->AddPage("P", "A4");
                    $A4[0] = 210;
                    $A4[1] = 297;
                    $Q[0] = 216;
                    $Q[1] = 279;
                    $pdf->SetTitle('LAPORAN PENILAIAN PRESTASI KERJA');
                    $pdf->SetCreator('Jaya HR');

                    $h = 7;
                    $pdf->SetFont('Times', 'B', 14);
                    $pdf->SetX(6);
                    $pdf->SetX(6);
                    $pdf->SetFont('Times', '', 10);
                    $pdf->Ln(5);

                    //Column widths
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->SetX(6);
                    $pdf->Cell(200, 4, 'LAPORAN PENILAIAN PRESTASI KERJA', 0, 0, 'C');
                    $pdf->Cell(10, 4, '', 0, 1);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, 'KARYAWAN KONTRAK KELOMPOK I - II', 0, 1, 'C');
                    $pdf->Ln(5);
                    $w = array(10, 35, 30, 65, 20, 35);

                    // Lebar Kolom
                    $colWidths = [10, 70, 30, 20, 30, 20];

                    // Informasi Karyawan
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Nama', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->karyawan_nama) ? $row->karyawan_nama : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Jabatan', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->job_grade) ? $row->job_grade : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Tanggal Masuk', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->tgl_hire) ? $row->tgl_hire : 'Tidak Ada Data', 1, 1);

                    $pdf->Ln(5);

                    // Informasi Penilai
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Atasan Langsung', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->spv1_nama) ? $row->spv1_nama : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Atasan Tidak Langsung', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->spv2_nama) ? $row->spv2_nama : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Unit', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->department) ? $row->department : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Periode Penilaian', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->flag_penilaian) ? $row->flag_penilaian : 'Tidak Ada Data', 1, 1);
                    $pdf->Ln(5);

                    // Tabel Penilaian
                    $pdf->SetFont('Arial', 'B', 10);
                    $header = ['No', 'Aspek yang Dinilai', 'AL', 'Nilai AL', 'ATL', 'Nilai ATL'];
                    $colWidths = [10, 100, 20, 20, 20, 20];
                    foreach ($header as $i => $col) {
                        $pdf->Cell($colWidths[$i], 10, $col, 1, 0, 'C');
                    }
                    $pdf->Ln();

                    $pdf->SetFont('Arial', '', 10);
                    $no = 1;
                    $penilaian = $this->master_model->hasil_nilai_periode($nrp, $periode);
                    foreach ($penilaian->result() as $row) {
                        $pdf->Cell($colWidths[0], 7, $no++, 1, 0, 'C');
                        $pdf->Cell($colWidths[1], 7, utf8_decode($row->aspek_dinilai), 1);
                        $pdf->Cell($colWidths[2], 7, $row->isi_nilai_atasan_langsung, 1, 0, 'C');
                        $pdf->Cell($colWidths[3], 7, number_format($row->nilai_atasan_langsung, 1), 1, 0, 'C');
                        $pdf->Cell($colWidths[4], 7, $row->isi_nilai_atasan_tidak_langsung, 1, 0, 'C');
                        $pdf->Cell($colWidths[5], 7, number_format($row->nilai_atasan_tidak_langsung, 1), 1, 0, 'C');
                        $pdf->Ln();
                    }
                    // Total dan Hasil Akhir
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Total', 1);
                    $pdf->Cell($colWidths[2] + $colWidths[3], 7, number_format($row->total_nilai_atasan_langsung, 1), 1, 0, 'C');
                    $pdf->Cell($colWidths[4] + $colWidths[5], 7, number_format($row->total_nilai_atasan_tidak_langsung, 1), 1, 0, 'C');
                    $pdf->Ln();

                    $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Hasil Akhir', 1);
                    $pdf->Cell($colWidths[2] + $colWidths[3] + $colWidths[4] + $colWidths[5], 7, number_format(($row->total_nilai_atasan_langsung * 0.6) + ($row->total_nilai_atasan_tidak_langsung * 0.4), 1), 1, 0, 'C');
                    $pdf->Ln(12);

                    // Tabel Kriteria Penilaian
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(35, 7, 'Kriteria', 1, 0, 'C');
                    $pdf->Cell(35, 7, 'Nilai', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Keterangan', 1, 1, 'C');

                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(35, 7, 'A', 1, 0, 'C');
                    $pdf->Cell(35, 7, '90 s.d. 100', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Istimewa', 1, 1, 'C');
                    $pdf->Cell(35, 7, 'B', 1, 0, 'C');
                    $pdf->Cell(35, 7, '80 s.d. 89', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Baik', 1, 1, 'C');
                    $pdf->Cell(35, 7, 'C', 1, 0, 'C');
                    $pdf->Cell(35, 7, '40 s.d. 79', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Cukup', 1, 1, 'C');
                    $pdf->Cell(35, 7, 'D', 1, 0, 'C');
                    $pdf->Cell(35, 7, '40 s.d. 59', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Kurang', 1, 1, 'C');
                    $pdf->Ln(5);

                    // Aspek Tambahan
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 7, 'Aspek-aspek Tambahan (mohon diuraikan bila ada):', 1, 1, 'L');
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->MultiCell(190, 7, 'Atasan Langsung:' . (isset($row->text_tambahan_atasan_langsung) ? $row->text_tambahan_atasan_langsung : 'Tidak Ada Data'), 1);
                    $pdf->MultiCell(190, 7, 'Atasan Tidak Langsung:' . (isset($row->text_tambahan_atasan_tidak_langsung) ? $row->text_tambahan_atasan_tidak_langsung : 'Tidak Ada Data'), 1);
                    $pdf->Output('D', 'Laporan_Penilaian_Kel_1_2.pdf');
                } else {
                    $this->session->set_flashdata('msg_error', 'Data Belum Di Nilai');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
    }

    function download_data_pkk_3_7($nrp, $periode)
    {
        $masuk  = $this->session->userdata('masuk_k');
        $this->load->helpers('print_rekap_helper');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            if ($periode == 'all') {
                $data1   = $this->master_model->get_trans_pkk($nrp);
                $pdf = new reportProduct();
                $pdf->setKriteria("cetak_laporan");
                foreach ($data1->result() as $dt) {
                    $data   = $this->master_model->lap_nilai_3_7_periode($dt->nrp, $dt->id_p_periode);
                    if ($data->num_rows() > 0) {
                        $row = $data->row();
                        $pdf->setNama("CETAK DATA KARYAWAN");
                        $pdf->AliasNbPages();
                        $pdf->AddPage("P", "A4");
                        $A4[0] = 210;
                        $A4[1] = 297;
                        $Q[0] = 216;
                        $Q[1] = 279;
                        $pdf->SetTitle('LAPORAN PENILAIAN PRESTASI KERJA');
                        $pdf->SetCreator('Jaya HR');

                        $h = 7;
                        $pdf->SetFont('Times', 'B', 14);
                        $pdf->SetX(6);
                        $pdf->SetX(6);
                        $pdf->SetFont('Times', '', 10);
                        $pdf->Ln(5);

                        //Column widths
                        $pdf->SetFont('Arial', 'B', 14);
                        $pdf->SetX(6);
                        $pdf->Cell(200, 4, 'LAPORAN PENILAIAN PRESTASI KERJA', 0, 0, 'C');
                        $pdf->Cell(10, 4, '', 0, 1);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(190, 5, 'KARYAWAN KONTRAK KELOMPOK III - VII', 0, 1, 'C');
                        $pdf->Ln(5);
                        $w = array(10, 35, 30, 65, 20, 35);

                        // Lebar Kolom
                        $colWidths = [10, 70, 30, 20, 30, 20];

                        // Informasi Karyawan
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Nama', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->karyawan_nama) ? $row->karyawan_nama : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Jabatan', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->job_grade) ? $row->job_grade : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Tanggal Masuk', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->tgl_hire) ? $row->tgl_hire : 'Tidak Ada Data', 1, 1);

                        $pdf->Ln(5);

                        // Informasi Penilai
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Atasan Langsung', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->spv1_nama) ? $row->spv1_nama : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Atasan Tidak Langsung', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->spv2_nama) ? $row->spv2_nama : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Unit', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->department) ? $row->department : 'Tidak Ada Data', 1, 1);

                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(50, 7, 'Periode Penilaian', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(60, 7, isset($row->flag_penilaian) ? $row->flag_penilaian : 'Tidak Ada Data', 1, 1);
                        $pdf->Ln(5);

                        // Tabel Penilaian
                        $pdf->SetFont('Arial', 'B', 10);
                        $header = ['No', 'Aspek yang Dinilai', 'AL', 'Nilai AL', 'ATL', 'Nilai ATL'];
                        $colWidths = [10, 100, 20, 20, 20, 20];
                        foreach ($header as $i => $col) {
                            $pdf->Cell($colWidths[$i], 10, $col, 1, 0, 'C');
                        }
                        $pdf->Ln();

                        $pdf->SetFont('Arial', '', 10);
                        $no = 1;
                        $penilaian = $this->master_model->hasil_nilai_3_7_periode($dt->nrp, $dt->id_p_periode);
                        foreach ($penilaian->result() as $row) {
                            $pdf->Cell($colWidths[0], 7, $no++, 1, 0, 'C');
                            $pdf->Cell($colWidths[1], 7, utf8_decode($row->aspek_dinilai), 1);
                            $pdf->Cell($colWidths[2], 7, $row->isi_nilai_atasan_langsung, 1, 0, 'C');
                            $pdf->Cell($colWidths[3], 7, is_numeric($row->nilai_atasan_langsung) ? number_format($row->nilai_atasan_langsung, 1) : '0.0', 1, 0, 'C');
                            $pdf->Cell($colWidths[4], 7, $row->isi_nilai_atasan_tidak_langsung, 1, 0, 'C');
                            $pdf->Cell($colWidths[5], 7, is_numeric($row->nilai_atasan_langsung) ? number_format($row->nilai_atasan_tidak_langsung, 1) : '0.0', 1, 0, 'C');
                            $pdf->Ln();
                        }
                        // Total dan Hasil Akhir
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Total', 1);
                        $pdf->Cell($colWidths[2] + $colWidths[3], 7, is_numeric($row->total_nilai_atasan_langsung) ? number_format($row->total_nilai_atasan_langsung, 1) : '0.0', 1, 0, 'C');
                        $pdf->Cell($colWidths[4] + $colWidths[5], 7, is_numeric($row->total_nilai_atasan_langsung) ? number_format($row->total_nilai_atasan_tidak_langsung, 1) : '0.0', 1, 0, 'C');
                        $pdf->Ln();

                        $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Hasil Akhir', 1);
                        // Pastikan nilai numerik sebelum perhitungan
                        $total_nilai_atasan_langsung = is_numeric($row->total_nilai_atasan_langsung) ? str_replace(',', '.', $row->total_nilai_atasan_langsung) : 0;
                        $total_nilai_atasan_tidak_langsung = is_numeric($row->total_nilai_atasan_tidak_langsung) ? str_replace(',', '.', $row->total_nilai_atasan_tidak_langsung) : 0;

                        // Hitung hasil akhir
                        $hasil_akhir = ($total_nilai_atasan_langsung * 0.6) + ($total_nilai_atasan_tidak_langsung * 0.4);

                        // Cetak ke PDF dengan number_format
                        $pdf->Cell($colWidths[2] + $colWidths[3] + $colWidths[4] + $colWidths[5], 7, number_format(floatval($hasil_akhir), 1), 1, 0, 'C');

                        $pdf->Ln(12);

                        // Tabel Kriteria Penilaian
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(35, 7, 'Kriteria', 1, 0, 'C');
                        $pdf->Cell(35, 7, 'Nilai', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Keterangan', 1, 1, 'C');

                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(35, 7, 'A', 1, 0, 'C');
                        $pdf->Cell(35, 7, '90 s.d. 100', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Istimewa', 1, 1, 'C');
                        $pdf->Cell(35, 7, 'B', 1, 0, 'C');
                        $pdf->Cell(35, 7, '80 s.d. 89', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Baik', 1, 1, 'C');
                        $pdf->Cell(35, 7, 'C', 1, 0, 'C');
                        $pdf->Cell(35, 7, '40 s.d. 79', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Cukup', 1, 1, 'C');
                        $pdf->Cell(35, 7, 'D', 1, 0, 'C');
                        $pdf->Cell(35, 7, '40 s.d. 59', 1, 0, 'C');
                        $pdf->Cell(40, 7, 'Kurang', 1, 1, 'C');
                        $pdf->Ln(5);

                        $pdf->AddPage();
                        $pdf->SetFont("Arial", 'B', 12);

                        // Judul
                        $pdf->Cell(0, 7, 'Penilaian Kinerja Karyawan', 0, 1, 'L');
                        $pdf->Ln(3);

                        // Header Tabel
                        $pdf->SetFont("Arial", 'B', 10);
                        $header = ["RENCANA KERJA", "KESIMPULAN HASIL", "%", "KESIMPULAN DEVIASI"];
                        $col_widths = [90, 40, 20, 40]; // Menyesuaikan lebar kolom agar Kesimpulan Deviasi tidak terpotong

                        foreach ($header as $i => $col) {
                            $pdf->Cell($col_widths[$i], 10, $col, 1, 0, 'C');
                        }
                        $pdf->Ln();

                        $pdf->SetFont("Arial", '', 10);
                        $pdf->Cell(array_sum($col_widths), 8, "A. KINERJA", 1, 1, 'L');
                        $pdf->Cell(array_sum($col_widths), 8, "(Didasarkan Sasaran Pekerjaan)", 1, 1, 'L');
                        $pdf->Cell(array_sum($col_widths), 8, "1. Tugas Pokok", 1, 1, 'L');

                        $penilaian = $this->master_model->nilai_form_a($dt->nrp, $dt->id_p_periode)->row();
                        $penilaian2 = $this->master_model->nilai_form_b($dt->nrp, $dt->id_p_periode)->row();
                        $row1 = $this->master_model->get_menu4_data()->row(0); // Mengambil baris pertama
                        $row2 = $this->master_model->get_menu4_data()->row(1); // Mengambil baris kedua
                        $row3 = $this->master_model->get_menu6_data()->row(0); // Mengambil baris pertama
                        $row4 = $this->master_model->get_menu6_data()->row(1); // Mengambil baris kedua
                        $height = 8;

                        // Row 1: "a. Sesuai tugas karyawan"
                        $pdf->Cell($col_widths[0], $height, "a. Sesuai tugas karyawan", 1, 0, 'L');
                        $pdf->Cell($col_widths[1], $height, isset($penilaian->hasil_nilai_a) ? $penilaian->hasil_nilai_a : 'N/A', 1, 0, 'C');
                        $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_a) ? $penilaian->persen_a : '0', 1, 0, 'C');
                        $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_nilai_a) ? $penilaian->deviasi_nilai_a : 'N/A', 1, 1, 'C');

                        // Row 2: "b. Sasaran Pekerjaan Secara Kuantitatif"
                        $pdf->Cell($col_widths[0], $height, "b. Sasaran Pekerjaan Secara Kuantitatif", 1, 0, 'L');
                        $pdf->Cell($col_widths[1], $height, isset($penilaian->hasil_nilai_b) ? $penilaian->hasil_nilai_b : 'N/A', 1, 0, 'C');
                        $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_b) ? $penilaian->persen_b : '0', 1, 0, 'C');
                        $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_b) ? $penilaian->deviasi_b : 'N/A', 1, 1, 'C');

                        $pdf->Cell(array_sum($col_widths), 8, "2. Tugas Tambahan", 1, 1, 'L');

                        // Row 3: Menyesuaikan agar kolom sejajar dengan header
                        $pdf->Cell($col_widths[0], $height, isset($penilaian->tugas_tambahan) ? $penilaian->tugas_tambahan : 'N/A', 1, 0, 'C');
                        $pdf->Cell($col_widths[1], $height, isset($penilaian->hasil_tgs_tambahan) ? $penilaian->hasil_tgs_tambahan : 'N/A', 1, 0, 'C');
                        $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_tambahan) ? $penilaian->persen_tambahan : 'N/A', 1, 0, 'C');
                        $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_tambahan) ? $penilaian->deviasi_tambahan : '0', 1, 1, 'C');

                        // Kesimpulan Atas Hasil Seluruh Penilaian - Sebagai Text Area
                        // Kesimpulan Atas Hasil Seluruh Penilaian - Mengambil data dari database dan menambahkan deskripsi
                        $pdf->Ln(5);
                        $pdf->SetFont("Arial", 'B', 10);
                        $pdf->Cell(0, 7, isset($row2->nama_value) ? $row2->nama_value : '', 0, 1, 'L');
                        $pdf->SetFont("Arial", 'I', 9);
                        $pdf->MultiCell(0, 10, isset($row2->description) ? $row2->description : '', 0);
                        $pdf->SetFont("Arial", '', 10);
                        $pdf->MultiCell(0, 20, isset($penilaian2->kesimpulan) ? $penilaian2->kesimpulan : '', 1);
                        $pdf->Ln(2);

                        // Penjelasan Hasil Kinerja Karyawan - Mengambil data dari database dan menambahkan deskripsi
                        $pdf->Ln(5);
                        $pdf->SetFont("Arial", 'B', 10);
                        $pdf->Cell(0, 7, isset($row1->nama_value) ? $row1->nama_value : '', 0, 1, 'L');
                        $pdf->SetFont("Arial", 'I', 9);
                        $pdf->MultiCell(0, 10, isset($row1->description) ? $row1->description : '', 0);
                        $pdf->SetFont("Arial", '', 10);
                        $pdf->MultiCell(0, 20, isset($penilaian2->penjelasan) ? $penilaian2->penjelasan : '', 1);
                        $pdf->Ln(2);

                        // Pendapat / Komentar - Sebagai Text Area
                        $pdf->Ln(5);
                        $pdf->SetFont("Arial", 'B', 10);
                        $pdf->Cell(0, 7, isset($row3->nama_value) ? $row3->nama_value : '', 0, 1, 'L');
                        $pdf->SetFont("Arial", 'I', 9);
                        $pdf->MultiCell(0, 10, isset($row3->description) ? $row3->description : '', 0);
                        $pdf->SetFont("Arial", '', 10);
                        $pdf->MultiCell(0, 20, isset($penilaian2->pendapat) ? $penilaian2->pendapat : '', 1);

                        // Komentar Atasan Penilai - Sebagai Text Area
                        $pdf->Ln(5);
                        $pdf->SetFont("Arial", 'B', 10);
                        $pdf->Cell(0, 7, isset($row4->nama_value) ? $row4->nama_value : '', 0, 1, 'L');
                        $pdf->SetFont("Arial", '', 10);
                        $pdf->MultiCell(0, 20, isset($penilaian2->komentar_atasan) ? $penilaian2->komentar_atasan : '', 1);
                    } else {
                        $this->session->set_flashdata('msg_error', 'Data Belum Di Nilai');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                $pdf->Output('D', 'Laporan_Penilaian_Kel_3_7.pdf');
            } else {
                $data   = $this->master_model->lap_nilai_3_7_periode($nrp, $periode);
                if ($data->num_rows() > 0) {
                    $row = $data->row();
                    $pdf = new reportProduct();
                    $pdf->setKriteria("cetak_laporan");
                    $pdf->setNama("CETAK DATA KARYAWAN");
                    $pdf->AliasNbPages();
                    $pdf->AddPage("P", "A4");
                    $A4[0] = 210;
                    $A4[1] = 297;
                    $Q[0] = 216;
                    $Q[1] = 279;
                    $pdf->SetTitle('LAPORAN PENILAIAN PRESTASI KERJA');
                    $pdf->SetCreator('Jaya HR');

                    $h = 7;
                    $pdf->SetFont('Times', 'B', 14);
                    $pdf->SetX(6);
                    $pdf->SetX(6);
                    $pdf->SetFont('Times', '', 10);
                    $pdf->Ln(5);

                    //Column widths
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->SetX(6);
                    $pdf->Cell(200, 4, 'LAPORAN PENILAIAN PRESTASI KERJA', 0, 0, 'C');
                    $pdf->Cell(10, 4, '', 0, 1);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, 'KARYAWAN KONTRAK KELOMPOK III - VII', 0, 1, 'C');
                    $pdf->Ln(5);
                    $w = array(10, 35, 30, 65, 20, 35);

                    // Lebar Kolom
                    $colWidths = [10, 70, 30, 20, 30, 20];

                    // Informasi Karyawan
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Nama', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->karyawan_nama) ? $row->karyawan_nama : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Jabatan', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->job_grade) ? $row->job_grade : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Tanggal Masuk', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->tgl_hire) ? $row->tgl_hire : 'Tidak Ada Data', 1, 1);

                    $pdf->Ln(5);

                    // Informasi Penilai
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Atasan Langsung', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->spv1_nama) ? $row->spv1_nama : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Atasan Tidak Langsung', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->spv2_nama) ? $row->spv2_nama : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Unit', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->department) ? $row->department : 'Tidak Ada Data', 1, 1);

                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(50, 7, 'Periode Penilaian', 1);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(60, 7, isset($row->flag_penilaian) ? $row->flag_penilaian : 'Tidak Ada Data', 1, 1);
                    $pdf->Ln(5);

                    // Tabel Penilaian
                    $pdf->SetFont('Arial', 'B', 10);
                    $header = ['No', 'Aspek yang Dinilai', 'AL', 'Nilai AL', 'ATL', 'Nilai ATL'];
                    $colWidths = [10, 100, 20, 20, 20, 20];
                    foreach ($header as $i => $col) {
                        $pdf->Cell($colWidths[$i], 10, $col, 1, 0, 'C');
                    }
                    $pdf->Ln();

                    $pdf->SetFont('Arial', '', 10);
                    $no = 1;
                    $penilaian = $this->master_model->hasil_nilai_3_7_periode($nrp, $periode);
                    foreach ($penilaian->result() as $row) {
                        $nilai_langsung = $row->nilai_atasan_langsung ? str_replace(',', '.', $row->nilai_atasan_langsung) : '0.0';
                        $nilai_tak_langsung = $row->nilai_atasan_tidak_langsung ? str_replace(',', '.', $row->nilai_atasan_tidak_langsung) : '0.0';

                        $pdf->Cell($colWidths[0], 7, $no++, 1, 0, 'C');
                        $pdf->Cell($colWidths[1], 7, utf8_decode($row->aspek_dinilai), 1);
                        $pdf->Cell($colWidths[2], 7, $row->isi_nilai_atasan_langsung, 1, 0, 'C');
                        $pdf->Cell($colWidths[3], 7, number_format($nilai_langsung, 1), 1, 0, 'C');
                        $pdf->Cell($colWidths[4], 7, $row->isi_nilai_atasan_tidak_langsung, 1, 0, 'C');
                        $pdf->Cell($colWidths[5], 7, number_format($nilai_tak_langsung, 1), 1, 0, 'C');
                        $pdf->Ln();
                    }
                    // Total dan Hasil Akhir
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Total', 1);
                    $pdf->Cell($colWidths[2] + $colWidths[3], 7, is_numeric($row->total_nilai_atasan_langsung) ? number_format($row->total_nilai_atasan_langsung, 1) : '0.0', 1, 0, 'C');
                    $pdf->Cell($colWidths[4] + $colWidths[5], 7, is_numeric($row->total_nilai_atasan_langsung) ? number_format($row->total_nilai_atasan_tidak_langsung, 1) : '0.0', 1, 0, 'C');
                    $pdf->Ln();

                    $pdf->Cell($colWidths[0] + $colWidths[1], 7, 'Hasil Akhir', 1);
                    // Pastikan nilai numerik sebelum perhitungan
                    $total_nilai_atasan_langsung = is_numeric($row->total_nilai_atasan_langsung) ? str_replace(',', '.', $row->total_nilai_atasan_langsung) : 0;
                    $total_nilai_atasan_tidak_langsung = is_numeric($row->total_nilai_atasan_tidak_langsung) ? str_replace(',', '.', $row->total_nilai_atasan_tidak_langsung) : 0;

                    // Hitung hasil akhir
                    $hasil_akhir = ($total_nilai_atasan_langsung * 0.6) + ($total_nilai_atasan_tidak_langsung * 0.4);

                    // Cetak ke PDF dengan number_format
                    $pdf->Cell($colWidths[2] + $colWidths[3] + $colWidths[4] + $colWidths[5], 7, number_format(floatval($hasil_akhir), 1), 1, 0, 'C');

                    $pdf->Ln(12);

                    // Tabel Kriteria Penilaian
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(35, 7, 'Kriteria', 1, 0, 'C');
                    $pdf->Cell(35, 7, 'Nilai', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Keterangan', 1, 1, 'C');

                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(35, 7, 'A', 1, 0, 'C');
                    $pdf->Cell(35, 7, '90 s.d. 100', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Istimewa', 1, 1, 'C');
                    $pdf->Cell(35, 7, 'B', 1, 0, 'C');
                    $pdf->Cell(35, 7, '80 s.d. 89', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Baik', 1, 1, 'C');
                    $pdf->Cell(35, 7, 'C', 1, 0, 'C');
                    $pdf->Cell(35, 7, '40 s.d. 79', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Cukup', 1, 1, 'C');
                    $pdf->Cell(35, 7, 'D', 1, 0, 'C');
                    $pdf->Cell(35, 7, '40 s.d. 59', 1, 0, 'C');
                    $pdf->Cell(40, 7, 'Kurang', 1, 1, 'C');
                    $pdf->Ln(5);

                    $pdf->AddPage();
                    $pdf->SetFont("Arial", 'B', 12);

                    // Judul
                    $pdf->Cell(0, 7, 'Penilaian Kinerja Karyawan', 0, 1, 'L');
                    $pdf->Ln(3);

                    // Header Tabel
                    $pdf->SetFont("Arial", 'B', 10);
                    $header = ["RENCANA KERJA", "KESIMPULAN HASIL", "%", "KESIMPULAN DEVIASI"];
                    $col_widths = [90, 40, 20, 40]; // Menyesuaikan lebar kolom agar Kesimpulan Deviasi tidak terpotong

                    foreach ($header as $i => $col) {
                        $pdf->Cell($col_widths[$i], 10, $col, 1, 0, 'C');
                    }
                    $pdf->Ln();

                    $pdf->SetFont("Arial", '', 10);
                    $pdf->Cell(array_sum($col_widths), 8, "A. KINERJA", 1, 1, 'L');
                    $pdf->Cell(array_sum($col_widths), 8, "(Didasarkan Sasaran Pekerjaan)", 1, 1, 'L');
                    $pdf->Cell(array_sum($col_widths), 8, "1. Tugas Pokok", 1, 1, 'L');

                    $penilaian = $this->master_model->nilai_form_a($nrp, $periode)->row();
                    $penilaian2 = $this->master_model->nilai_form_b($nrp, $periode)->row();
                    $row1 = $this->master_model->get_menu4_data()->row(0); // Mengambil baris pertama
                    $row2 = $this->master_model->get_menu4_data()->row(1); // Mengambil baris kedua
                    $row3 = $this->master_model->get_menu6_data()->row(0); // Mengambil baris pertama
                    $row4 = $this->master_model->get_menu6_data()->row(1); // Mengambil baris kedua
                    $height = 8;

                    // Row 1: "a. Sesuai tugas karyawan"
                    $pdf->Cell($col_widths[0], $height, "a. Sesuai tugas karyawan", 1, 0, 'L');
                    $pdf->Cell($col_widths[1], $height, isset($penilaian->hasil_nilai_a) ? $penilaian->hasil_nilai_a : 'N/A', 1, 0, 'C');
                    $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_a) ? $penilaian->persen_a : '0', 1, 0, 'C');
                    $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_nilai_a) ? $penilaian->deviasi_nilai_a : 'N/A', 1, 1, 'C');

                    // Row 2: "b. Sasaran Pekerjaan Secara Kuantitatif"
                    $pdf->Cell($col_widths[0], $height, "b. Sasaran Pekerjaan Secara Kuantitatif", 1, 0, 'L');
                    $pdf->Cell($col_widths[1], $height, isset($penilaian->hasil_nilai_b) ? $penilaian->hasil_nilai_b : 'N/A', 1, 0, 'C');
                    $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_b) ? $penilaian->persen_b : '0', 1, 0, 'C');
                    $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_b) ? $penilaian->deviasi_b : 'N/A', 1, 1, 'C');

                    $pdf->Cell(array_sum($col_widths), 8, "2. Tugas Tambahan", 1, 1, 'L');

                    // Row 3: Menyesuaikan agar kolom sejajar dengan header
                    $pdf->Cell($col_widths[0], $height, isset($penilaian->tugas_tambahan) ? $penilaian->tugas_tambahan : 'N/A', 1, 0, 'C');
                    $pdf->Cell($col_widths[1], $height, isset($penilaian->hasil_tgs_tambahan) ? $penilaian->hasil_tgs_tambahan : 'N/A', 1, 0, 'C');
                    $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_tambahan) ? $penilaian->persen_tambahan : 'N/A', 1, 0, 'C');
                    $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_tambahan) ? $penilaian->deviasi_tambahan : '0', 1, 1, 'C');

                    // Kesimpulan Atas Hasil Seluruh Penilaian - Sebagai Text Area
                    // Kesimpulan Atas Hasil Seluruh Penilaian - Mengambil data dari database dan menambahkan deskripsi
                    $pdf->Ln(5);
                    $pdf->SetFont("Arial", 'B', 10);
                    $pdf->Cell(0, 7, isset($row2->nama_value) ? $row2->nama_value : '', 0, 1, 'L');
                    $pdf->SetFont("Arial", 'I', 9);
                    $pdf->MultiCell(0, 10, isset($row2->description) ? $row2->description : '', 0);
                    $pdf->SetFont("Arial", '', 10);
                    $pdf->MultiCell(0, 20, isset($penilaian2->kesimpulan) ? $penilaian2->kesimpulan : '', 1);
                    $pdf->Ln(2);

                    // Penjelasan Hasil Kinerja Karyawan - Mengambil data dari database dan menambahkan deskripsi
                    $pdf->Ln(5);
                    $pdf->SetFont("Arial", 'B', 10);
                    $pdf->Cell(0, 7, isset($row1->nama_value) ? $row1->nama_value : '', 0, 1, 'L');
                    $pdf->SetFont("Arial", 'I', 9);
                    $pdf->MultiCell(0, 10, isset($row1->description) ? $row1->description : '', 0);
                    $pdf->SetFont("Arial", '', 10);
                    $pdf->MultiCell(0, 20, isset($penilaian2->penjelasan) ? $penilaian2->penjelasan : '', 1);
                    $pdf->Ln(2);

                    // Pendapat / Komentar - Sebagai Text Area
                    $pdf->Ln(5);
                    $pdf->SetFont("Arial", 'B', 10);
                    $pdf->Cell(0, 7, isset($row3->nama_value) ? $row3->nama_value : '', 0, 1, 'L');
                    $pdf->SetFont("Arial", 'I', 9);
                    $pdf->MultiCell(0, 10, isset($row3->description) ? $row3->description : '', 0);
                    $pdf->SetFont("Arial", '', 10);
                    $pdf->MultiCell(0, 20, isset($penilaian2->pendapat) ? $penilaian2->pendapat : '', 1);

                    // Komentar Atasan Penilai - Sebagai Text Area
                    $pdf->Ln(5);
                    $pdf->SetFont("Arial", 'B', 10);
                    $pdf->Cell(0, 7, isset($row4->nama_value) ? $row4->nama_value : '', 0, 1, 'L');
                    $pdf->SetFont("Arial", '', 10);
                    $pdf->MultiCell(0, 20, isset($penilaian2->komentar_atasan) ? $penilaian2->komentar_atasan : '', 1);
                    $pdf->Output('D', 'Laporan_Penilaian_Kel_3_7.pdf');
                } else {
                    $this->session->set_flashdata('msg_error', 'Data Belum Di Nilai');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
    }

    // excel
    function download_data_pkk_excel($nrp)
    {
        $masuk  = $this->session->userdata('masuk_k');
        $this->load->helpers('print_rekap_helper');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $data   = $this->master_model->lap_nilai($nrp);
            if ($data->num_rows() > 0) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // *Judul Laporan*
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'LAPORAN PENILAIAN PRESTASI KERJA KARYAWAN KONTRAK KELOMPOK I - II');
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // *Header Data Karyawan*
                $headers = ['Nama', 'Jabatan', 'Tanggal Masuk', 'Atasan Langsung', 'Atasan Tidak Langsung', 'Unit', 'Periode Penilaian'];
                $values  = [
                    isset($data->row()->nama) ? $data->row()->nama : 'Tidak Ada Data',
                    isset($data->row()->jabatan) ? $data->row()->jabatan : 'Tidak Ada Data',
                    isset($data->row()->tgl_masuk) ? $data->row()->tgl_masuk : 'Tidak Ada Data',
                    isset($data->row()->atasan_langsung) ? $data->row()->atasan_langsung : 'Tidak Ada Data',
                    isset($data->row()->atasan_tidak_langsung) ? $data->row()->atasan_tidak_langsung : 'Tidak Ada Data',
                    isset($data->row()->unit) ? $data->row()->unit : 'Tidak Ada Data',
                    isset($data->row()->periode_penilaian) ? $data->row()->periode_penilaian : 'Tidak Ada Data'
                ];

                for ($i = 0; $i < count($headers); $i++) {
                    $sheet->setCellValue('A' . ($i + 3), $headers[$i]);
                    $sheet->setCellValue('B' . ($i + 3), $values[$i]);
                }

                // *Header Tabel Penilaian*
                $headerPenilaian = ['No', 'Aspek yang Dinilai', 'Atasan Langsung', 'Nilai AL', 'Atasan Tidak Langsung', 'Nilai ATL'];
                $colIndex = 'A';
                foreach ($headerPenilaian as $header) {
                    $sheet->setCellValue($colIndex . '11', $header);
                    $sheet->getStyle($colIndex . '11')->getFont()->setBold(true);
                    $colIndex++;
                }

                // *Isi Data Penilaian*
                $rowIndex = 12;
                $no = 1;
                foreach ($data->result() as $dt) {
                    $sheet->setCellValue('A' . $rowIndex, $no++);
                    $sheet->setCellValue('B' . $rowIndex, isset($dt->aspek_dinilai) ? $dt->aspek_dinilai : 'Tidak Ada Data');
                    $sheet->setCellValue('C' . $rowIndex, isset($dt->nilai_atasan_langsung) ? $dt->nilai_atasan_langsung : '0');
                    $sheet->setCellValue('D' . $rowIndex, isset($dt->skor_atasan_langsung) ? $dt->skor_atasan_langsung : '0');
                    $sheet->setCellValue('E' . $rowIndex, isset($dt->nilai_atasan_tidak_langsung) ? $dt->nilai_atasan_tidak_langsung : '0');
                    $sheet->setCellValue('F' . $rowIndex, isset($dt->skor_atasan_tidak_langsung) ? $dt->skor_atasan_tidak_langsung : '0');
                    $rowIndex++;
                }

                // *Total Nilai*
                $sheet->setCellValue('B' . $rowIndex, 'TOTAL');
                $sheet->setCellValue('D' . $rowIndex, '=SUM(D12:D' . ($rowIndex - 1) . ')');
                $sheet->setCellValue('F' . $rowIndex, '=SUM(F12:F' . ($rowIndex - 1) . ')');

                $rowIndex++;
                $sheet->setCellValue('B' . $rowIndex, 'Hasil Akhir');
                $sheet->setCellValue('D' . $rowIndex, '=D' . ($rowIndex - 1) . '/12');
                $sheet->setCellValue('F' . $rowIndex, '=F' . ($rowIndex - 1) . '/12');

                //autosize
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                // redirect output to client browser    
                $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
                // header('Content-Type: application/vnd.ms-excel');
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Rekap_IDP.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');
                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0
                // $writer = new Xlsx($spreadsheet);
                ob_end_clean();
                ob_start();
                $writer->save('php://output');
            } else {
                $this->session->set_flashdata('msg_error', 'Data karyawan tidak ada');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
