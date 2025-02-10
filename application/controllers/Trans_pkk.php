<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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

    public function fb_kr_1_2()
    {
        $masuk = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $id_p_periode       = $this->input->post('id_p_periode');
            $nrp                = $this->input->post('nrp');
            $data = [
                'id_p_periode'    => $id_p_periode,
                'nrp'             => $nrp,
                'isi_fb'    => 'Saya sudah membaca hasil penilaian ini',
                'insert_date'     => date('Y-m-d'),
                'flag_sent'       => 1,
            ];

            // Insert ke tabel trans_pkk
            $this->db->insert("trans_fb_kr_1_2", $data);

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
                    ob_clean();
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
                        $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_tambahan) ? $penilaian->persen_tambahan : '0', 1, 0, 'C');
                        $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_tambahan) ? $penilaian->deviasi_tambahan : 'N/A', 1, 1, 'C');

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
                ob_clean();
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
                    $fb_k = $this->master_model->get_fb_karyawan($nrp, $periode);
                    $fb_a = $this->master_model->get_fb_atasan($nrp, $periode);

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
                    $pdf->Cell($col_widths[2], $height, isset($penilaian->persen_tambahan) ? $penilaian->persen_tambahan : '0', 1, 0, 'C');
                    $pdf->Cell($col_widths[3], $height, isset($penilaian->deviasi_tambahan) ? $penilaian->deviasi_tambahan : 'N/A', 1, 1, 'C');

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
                    $pdf->MultiCell(0, 20, isset($fb_k->isi_feedback) ? $fb_k->isi_feedback : '', 1);

                    // Komentar Atasan Penilai - Sebagai Text Area
                    $pdf->Ln(5);
                    $pdf->SetFont("Arial", 'B', 10);
                    $pdf->Cell(0, 7, isset($row4->nama_value) ? $row4->nama_value : '', 0, 1, 'L');
                    $pdf->SetFont("Arial", '', 10);
                    $pdf->MultiCell(0, 20, isset($fb_a->isi_feedback) ? $fb_a->isi_feedback : '', 1);
                    $pdf->Output('D', 'Laporan_Penilaian_Kel_3_7.pdf');
                } else {
                    $this->session->set_flashdata('msg_error', 'Data Belum Di Nilai');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
    }

    public function download_data_pkk_3_7_excel($nrp, $periode)
    {
        $masuk  = $this->session->userdata('masuk_k');
        $this->load->helper('download');

        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $data = $this->master_model->lap_nilai_3_7_periode($nrp, $periode);

            if ($data->num_rows() > 0) {
                $row = $data->row();
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // **Menentukan Baris Awal**
                $rowIndex = 1;

                // **Judul Laporan**
                $sheet->mergeCells('A' . $rowIndex . ':F' . $rowIndex);
                $sheet->setCellValue('A' . $rowIndex, 'LAPORAN PENILAIAN PRESTASI KERJA');
                $rowIndex++;
                $sheet->mergeCells('A' . $rowIndex . ':F' . $rowIndex);
                $sheet->setCellValue('A' . $rowIndex, 'KARYAWAN KONTRAK KELOMPOK III - VII');
                $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $rowIndex += 2;

                // **Informasi Karyawan**
                $sheet->setCellValue('A' . $rowIndex, 'Nama:');
                $sheet->setCellValue('B' . $rowIndex, isset($row->karyawan_nama) ? $row->karyawan_nama : 'Tidak Ada Data');
                $rowIndex++;
                $sheet->setCellValue('A' . $rowIndex, 'Jabatan:');
                $sheet->setCellValue('B' . $rowIndex, isset($row->job_grade) ? $row->job_grade : 'Tidak Ada Data');
                $rowIndex++;
                $sheet->setCellValue('A' . $rowIndex, 'Tanggal Masuk:');
                $sheet->setCellValue('B' . $rowIndex, isset($row->tgl_hire) ? $row->tgl_hire : 'Tidak Ada Data');
                $rowIndex += 2;

                // **Informasi Penilai**
                $sheet->setCellValue('A' . $rowIndex, 'Atasan Langsung:');
                $sheet->setCellValue('B' . $rowIndex, isset($row->spv1_nama) ? $row->spv1_nama : 'Tidak Ada Data');
                $rowIndex++;
                $sheet->setCellValue('A' . $rowIndex, 'Atasan Tidak Langsung:');
                $sheet->setCellValue('B' . $rowIndex, isset($row->spv2_nama) ? $row->spv2_nama : 'Tidak Ada Data');
                $rowIndex++;
                $sheet->setCellValue('A' . $rowIndex, 'Unit:');
                $sheet->setCellValue('B' . $rowIndex, isset($row->department) ? $row->department : 'Tidak Ada Data');
                $rowIndex++;
                $sheet->setCellValue('A' . $rowIndex, 'Periode Penilaian:');
                $sheet->setCellValue('B' . $rowIndex, isset($row->flag_penilaian) ? $row->flag_penilaian : 'Tidak Ada Data');
                $rowIndex += 2;

                // **Header Tabel Penilaian**
                $headers = ['No', 'Aspek yang Dinilai', 'AL', 'Nilai AL', 'ATL', 'Nilai ATL'];
                $colIndex = 'A';
                foreach ($headers as $header) {
                    $sheet->setCellValue($colIndex . $rowIndex, $header);
                    $sheet->getStyle($colIndex . $rowIndex)->getFont()->setBold(true);
                    $sheet->getStyle($colIndex . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $colIndex++;
                }
                $rowIndex++;

                // **Mengisi Data ke Tabel**
                $no = 1;
                $penilaian = $this->master_model->hasil_nilai_3_7_periode($nrp, $periode);
                foreach ($penilaian->result() as $data_row) {
                    // Konversi dari VARCHAR ke format angka
                    $nilai_atasan_langsung = str_replace(',', '.', trim($data_row->nilai_atasan_langsung));
                    $nilai_atasan_langsung = is_numeric($nilai_atasan_langsung) ? (float) $nilai_atasan_langsung : 0.0;

                    $nilai_atasan_tidak_langsung = str_replace(',', '.', trim($data_row->nilai_atasan_tidak_langsung));
                    $nilai_atasan_tidak_langsung = is_numeric($nilai_atasan_tidak_langsung) ? (float) $nilai_atasan_tidak_langsung : 0.0;

                    $sheet->setCellValue('A' . $rowIndex, $no++);
                    $sheet->setCellValue('B' . $rowIndex, isset($data_row->aspek_dinilai) ? $data_row->aspek_dinilai : '-');
                    $sheet->setCellValue('C' . $rowIndex, isset($data_row->isi_nilai_atasan_langsung) ? $data_row->isi_nilai_atasan_langsung : '-');
                    $sheet->setCellValue('D' . $rowIndex, number_format($nilai_atasan_langsung, 1));
                    $sheet->setCellValue('E' . $rowIndex, isset($data_row->isi_nilai_atasan_tidak_langsung) ? $data_row->isi_nilai_atasan_tidak_langsung : '-');
                    $sheet->setCellValue('F' . $rowIndex, number_format($nilai_atasan_tidak_langsung, 1));
                    $rowIndex++;
                }

                // **Menambahkan Border ke Seluruh Tabel**
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $sheet->getStyle('A12:F' . ($rowIndex - 1))->applyFromArray($styleArray);

                // **Autosize Kolom**
                foreach (range('A', 'F') as $col) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }

                // **Download File Excel**
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Laporan_PKK_3_7.xlsx"');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                ob_start();
                $writer->save('php://output');
            } else {
                $this->session->set_flashdata('msg_error', 'Data tidak ditemukan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // excel
    public function download_set_pkk()
    {
        $masuk  = $this->session->userdata('masuk_k');
        $this->load->helper('download');

        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $data = $this->master_model->list_isi_pkk(); // Ambil data dari model

            if ($data->num_rows() > 0) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // **Header Tabel Sesuai View**
                $headerTable = ['No', 'NRP', 'Nama Karyawan', 'Penilaian Ke', 'Submit', 'SPV 1', 'SPV 2', 'Karyawan'];
                $columnIndex = 'A';

                foreach ($headerTable as $header) {
                    $sheet->setCellValue($columnIndex . '1', $header);
                    $sheet->getStyle($columnIndex . '1')->getFont()->setBold(true);
                    $sheet->getStyle($columnIndex . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $columnIndex++;
                }

                // **Mengisi Data ke Tabel**
                $rowIndex = 2;
                $no = 1;
                foreach ($data->result() as $dt) {
                    // Cek status feedback karyawan
                    $cek_flag_sent = $this->master_model->get_fb_karyawan($dt->nrp, $dt->id_p_periode);

                    // Cek status submit SPV1 dan SPV2 berdasarkan jenis form
                    $spv1_submit = ($dt->flag_jenis_form == 1) ?
                        $this->master_model->get_submit_1_2($dt->nrp, $dt->id_p_periode, $dt->spv1) :
                        $this->master_model->get_submit_3_7($dt->nrp, $dt->id_p_periode, $dt->spv1);

                    $spv2_submit = ($dt->flag_jenis_form == 1) ?
                        $this->master_model->get_submit_1_2($dt->nrp, $dt->id_p_periode, $dt->spv2) :
                        $this->master_model->get_submit_3_7($dt->nrp, $dt->id_p_periode, $dt->spv2);

                    // Mengisi data ke dalam file Excel
                    $sheet->setCellValue('A' . $rowIndex, $no++);
                    $sheet->setCellValue('B' . $rowIndex, isset($dt->nrp) ? $dt->nrp : '-');
                    $sheet->setCellValue('C' . $rowIndex, isset($dt->nama_lengkap) ? $dt->nama_lengkap : '-');

                    // **Kolom Penilaian Ke**
                    $penilaian_ke = '-';
                    if ($dt->flag_penilaian == 1) {
                        $penilaian_ke = 1;
                    } elseif ($dt->flag_penilaian == 2) {
                        $penilaian_ke = 2;
                    } elseif ($dt->flag_penilaian == 3) {
                        $penilaian_ke = 3;
                    }
                    $sheet->setCellValue('D' . $rowIndex, $penilaian_ke);

                    // **Kolom Submit**
                    $submit_status = (isset($dt->flag_sent) && $dt->flag_sent == 1) ? '✔' : '✘';
                    $sheet->setCellValue('E' . $rowIndex, $submit_status);

                    // **Kolom SPV1**
                    $spv1_status = (!empty($spv1_submit) && isset($spv1_submit->flag_sent) && $spv1_submit->flag_sent == 1) ? '✔' : '✘';
                    $sheet->setCellValue('F' . $rowIndex, $spv1_status);

                    // **Kolom SPV2**
                    $spv2_status = (!empty($spv2_submit) && isset($spv2_submit->flag_sent) && $spv2_submit->flag_sent == 1) ? '✔' : '✘';
                    $sheet->setCellValue('G' . $rowIndex, $spv2_status);

                    // **Kolom Karyawan**
                    $karyawan_status = (!empty($cek_flag_sent) && isset($cek_flag_sent->flag_sent) && $cek_flag_sent->flag_sent == 1) ? '✔ Setuju' : '✘';
                    $sheet->setCellValue('H' . $rowIndex, $karyawan_status);

                    $rowIndex++;
                }

                // **Menambahkan Border di Seluruh Tabel**
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $sheet->getStyle('A1:H' . ($rowIndex - 1))->applyFromArray($styleArray);

                // **Autosize Kolom**
                foreach (range('A', 'H') as $col) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }

                // **Download File Excel**
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Laporan Setting PKK.xlsx"');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                ob_start();
                $writer->save('php://output');
            } else {
                $this->session->set_flashdata('msg_error', 'Data tidak ditemukan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function download_data_pkk_pdf($unit)
    {
        $masuk  = $this->session->userdata('masuk_k');
        $this->load->helpers('print_rekap_helper');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $data   = $this->master_model->list_member_rekap_pkk1($unit);
            if ($data->num_rows() > 0) {
                $dt = $data->row();
                $pdf = new reportProduct();
                $pdf->setKriteria("cetak_laporan");
                $pdf->setNama("CETAK DATA KARYAWAN");
                $pdf->AliasNbPages();
                $pdf->AddPage("L", "A4");
                $A4[0] = 210;
                $A4[1] = 297;
                $Q[0] = 216;
                $Q[1] = 279;
                $pdf->SetTitle('LAPORAN PENILAIAN KARYAWAN KONTRAK ' . $dt->department);
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
                $pdf->Cell(290, 4, 'LAPORAN PENILAIAN KARYAWAN KONTRAK ' . $dt->department, 0, 0, 'C');
                $pdf->Cell(10, 4, '', 0, 1);
                $pdf->Ln(5);
                $w = array(10, 35, 30, 65, 20, 35);

                // Tabel Penilaian
                $pdf->SetFont('Arial', 'B', 10);
                $header = ['No', 'Nama', 'NRP', 'Unit', 'Ceklis', 'Nilai (Angka)', 'Kriteria'];
                $colWidths = [10, 70, 22, 80, 28, 28, 28];
                foreach ($header as $i => $col) {
                    $pdf->Cell($colWidths[$i], 10, $col, 1, 0, 'C');
                }
                $pdf->Ln();

                $pdf->SetFont('Arial', '', 10);
                $no = 1;
                $penilaian = $this->master_model->list_member_rekap_pkk1($unit);
                foreach ($penilaian->result() as $row) {
                    $data2 = $this->master_model->real_hasil_nilai($row->nip, $row->id_jenis_form)->row();
                    $data3 = $this->master_model->get_nilai_ceklis_by_nrp($row->nip, $row->id_jenis_form)->row();
                    $nilaiAkhir = (isset($data2->total_nilai_atasan_langsung) && isset($data2->total_nilai_atasan_tidak_langsung))
                        ? ($data2->total_nilai_atasan_langsung * 0.6) + ($data2->total_nilai_atasan_tidak_langsung * 0.4)
                        : 0.0;
                    $jumlah_ceklis = $data3->jumlah_ceklis;

                    if ($nilaiAkhir == 0 && $nilaiAkhir == NULL) {
                        $kriteria = '';
                    } elseif ($nilaiAkhir >= 90 && $nilaiAkhir <= 100) {
                        $kriteria = 'A';
                    } elseif ($nilaiAkhir >= 80 && $nilaiAkhir <= 89) {
                        $kriteria = 'B';
                    } elseif ($nilaiAkhir >= 60 && $nilaiAkhir <= 79) {
                        $kriteria = 'C';
                    } else {
                        $kriteria = 'D';
                    }

                    $pdf->Cell($colWidths[0], 7, $no++, 1, 0, 'C');
                    $pdf->Cell($colWidths[1], 7, $row->nama_lengkap, 1);
                    $pdf->Cell($colWidths[2], 7, $row->nip, 1, 0, 'C');
                    $pdf->Cell($colWidths[3], 7, $row->department, 1, 0, 'C');
                    $pdf->Cell($colWidths[4], 7, $jumlah_ceklis, 1, 0, 'C');
                    $pdf->Cell($colWidths[5], 7, number_format($nilaiAkhir, 1), 1, 0, 'C');
                    $pdf->Cell($colWidths[6], 7, $kriteria, 1, 0, 'C');
                    $pdf->Ln();
                }
                ob_clean();
                $pdf->Output('D', 'Laporan_Penilaian_Karyawan_Kontrak.pdf');
            } else {
                $this->session->set_flashdata('msg_error', 'Data Tidak Ada');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function download_data_pkk_excel($unit)
    {
        $data = $this->master_model->list_member_rekap_pkk1($unit); // Ambil data dari model

        if ($data->num_rows() > 0) {
            $row = $data->row();
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->mergeCells('A1:G1');
            $sheet->setCellValue('A1', 'Laporan Penilaian Karyawan Kontrak ' . $row->department);
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // **Header Tabel Sesuai View**
            $headerTable = ['No', 'Nama', 'NRP', 'Unit', 'Ceklis', 'Nilai (Angka)', 'Kriteria'];
            $columnIndex = 'A';

            foreach ($headerTable as $header) {
                $sheet->setCellValue($columnIndex . '2', $header);
                $sheet->getStyle($columnIndex . '2')->getFont()->setBold(true);
                $sheet->getStyle($columnIndex . '2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $columnIndex++;
            }

            // **Mengisi Data ke Tabel**
            $rowIndex = 3;
            $no = 1;
            foreach ($data->result() as $dt) {
                // Mengisi data nilai & kriteria
                $data2 = $this->master_model->real_hasil_nilai($dt->nip, $dt->id_jenis_form)->row();

                $nilaiAkhir = (isset($data2->total_nilai_atasan_langsung) && isset($data2->total_nilai_atasan_tidak_langsung))
                    ? ($data2->total_nilai_atasan_langsung * 0.6) + ($data2->total_nilai_atasan_tidak_langsung * 0.4)
                    : 0.0;

                if ($nilaiAkhir == 0 && $nilaiAkhir == NULL) {
                    $kriteria = '';
                } elseif ($nilaiAkhir >= 90 && $nilaiAkhir <= 100) {
                    $kriteria = 'A';
                } elseif ($nilaiAkhir >= 80 && $nilaiAkhir <= 89) {
                    $kriteria = 'B';
                } elseif ($nilaiAkhir >= 60 && $nilaiAkhir <= 79) {
                    $kriteria = 'C';
                } else {
                    $kriteria = 'D';
                }

                // Mengisi Data ceklis
                $data3 = $this->master_model->get_nilai_ceklis_by_nrp($dt->nip, $dt->id_jenis_form)->row();
                $jumlah_ceklis = $data3->jumlah_ceklis;

                // Mengisi data ke dalam file Excel
                $sheet->setCellValue('A' . $rowIndex, $no++);
                $sheet->setCellValue('B' . $rowIndex, isset($dt->nama_lengkap) ? $dt->nama_lengkap : '-');
                $sheet->setCellValue('C' . $rowIndex, isset($dt->nip) ? $dt->nip : '-');
                $sheet->setCellValue('D' . $rowIndex, isset($dt->department) ? $dt->department : '-');
                $sheet->setCellValue('E' . $rowIndex, isset($jumlah_ceklis) ? $jumlah_ceklis : '');
                $sheet->setCellValue('F' . $rowIndex, isset($nilaiAkhir) ? number_format($nilaiAkhir, 1) : '');
                $sheet->setCellValue('G' . $rowIndex, isset($kriteria) ? $kriteria : '');

                $sheet->getStyle('C' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G' . $rowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $rowIndex++;
            }

            // **Menambahkan Border di Seluruh Tabel**
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ];
            $sheet->getStyle('A1:G' . ($rowIndex - 1))->applyFromArray($styleArray);

            // **Autosize Kolom**
            foreach (range('A', 'G') as $col) {
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }

            // **Download File Excel**
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_Penilaian_Karyawan_Kontrak_(' . $row->department . ').xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            ob_start();
            $writer->save('php://output');
        } else {
            $this->session->set_flashdata('msg_error', 'Data tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function download_data_pkk_excel_1_2($nrp, $periode)
    {
        $masuk = $this->session->userdata('masuk_k');
        $this->load->helper('print_rekap_helper');

        if (!$masuk) {
            redirect(base_url('login'));
        } else {
            if ($periode == 'all') {
                $trans = $this->master_model->get_trans_pkk($nrp);
                $spreadsheet = new Spreadsheet();
                $index = 0;
                foreach ($trans->result() as $tl) {
                    // Ambil data dari database
                    $query = $this->master_model->lap_nilai_periode($tl->nrp, $tl->id_p_periode);
                    $data = $query->row_array();

                    if (!$data) {
                        show_error('Data tidak ditemukan atau tidak dapat diakses.', 404);
                        return;
                    }

                    if ($index > 0) {
                        $spreadsheet->createSheet();
                    }

                    $spreadsheet->setActiveSheetIndex($index);

                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setTitle("Periode " . $tl->id_p_periode);

                    // *Mengatur Border*
                    $thickBorder = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                'color' => ['rgb' => '000000'],
                            ],
                            'inside' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ];

                    // *Header & Judul*
                    $sheet->mergeCells('A1:F1');
                    $sheet->mergeCells('A2:F2');
                    $sheet->mergeCells('A3:F3');
                    $sheet->setCellValue('A1', 'LAPORAN PENILAIAN PRESTASI KINERJA');
                    $sheet->setCellValue('A2', 'KARYAWAN KONTRAK');
                    $sheet->setCellValue('A3', 'KELOMPOK I - II');
                    $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
                    $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');

                    // *Data Karyawan*
                    $row_karyawan = 5;
                    $sheet->mergeCells("A$row_karyawan:B$row_karyawan");
                    $sheet->setCellValue('A' . $row_karyawan, 'KARYAWAN YANG DINILAI');
                    $sheet->getStyle("A$row_karyawan")->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("A$row_karyawan")->getFont()->setBold(true);
                    $sheet->setCellValue('A' . ($row_karyawan + 1), 'Nama:');
                    $sheet->setCellValue('B' . ($row_karyawan + 1), $data['karyawan_nama']);
                    $sheet->setCellValue('A' . ($row_karyawan + 2), 'Jabatan:');
                    $sheet->setCellValue('B' . ($row_karyawan + 2), $data['job_grade']);
                    $sheet->setCellValue('A' . ($row_karyawan + 3), 'Tanggal Masuk:');
                    $sheet->setCellValue('B' . ($row_karyawan + 3), $data['tgl_hire']);
                    $sheet->getStyle("A$row_karyawan:B" . ($row_karyawan + 3))->applyFromArray($thickBorder);

                    // *Data Penilai*
                    $row_penilai = $row_karyawan + 5;
                    $sheet->mergeCells("A$row_penilai:B$row_penilai");
                    $sheet->setCellValue('A' . $row_penilai, 'NAMA PENILAI');
                    $sheet->getStyle("A$row_penilai")->getFont()->setBold(true);
                    $sheet->getStyle("A$row_penilai")->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('A' . ($row_penilai + 1), 'Atasan Langsung:');
                    $sheet->setCellValue('B' . ($row_penilai + 1), $data['spv1_nama']);
                    $sheet->setCellValue('A' . ($row_penilai + 2), 'Atasan Tidak Langsung:');
                    $sheet->setCellValue('B' . ($row_penilai + 2), $data['spv2_nama']);
                    $sheet->setCellValue('A' . ($row_penilai + 3), 'Unit:');
                    $sheet->setCellValue('B' . ($row_penilai + 3), $data['department']);
                    $sheet->setCellValue('A' . ($row_penilai + 4), 'Periode Penilaian:');
                    $sheet->setCellValue('B' . ($row_penilai + 4), $data['id_p_periode']);
                    $sheet->getStyle("A$row_penilai:B" . ($row_penilai + 4))->applyFromArray($thickBorder);
                    $sheet->getStyle('B' . ($row_penilai + 4))->getAlignment()->setHorizontal('left');

                    // *Header Tabel Penilaian*
                    $row_penilaian = $row_penilai + 6;
                    $sheet->setCellValue('A' . $row_penilaian, 'No')
                        ->setCellValue('B' . $row_penilaian, 'Aspek Yang Dinilai')
                        ->setCellValue('C' . $row_penilaian, 'Atasan Langsung')
                        ->setCellValue('D' . $row_penilaian, 'Nilai Atasan Langsung')
                        ->setCellValue('E' . $row_penilaian, 'Atasan Tidak Langsung')
                        ->setCellValue('F' . $row_penilaian, 'Nilai Atasan Tidak Langsung');
                    $sheet->getStyle("A$row_penilaian:F$row_penilaian")->getFont()->setBold(true);
                    $sheet->getStyle("B$row_penilaian")->getAlignment()->setHorizontal('center');

                    // *Mengisi Data Penilaian*
                    $penilaian2 = $this->master_model->hasil_nilai_periode($tl->nrp, $tl->id_p_periode);
                    $text = $penilaian2->row();
                    $total_nilai_atasan_langsung = 0;
                    $total_nilai_atasan_tidak_langsung = 0;
                    $row = $row_penilaian + 1;
                    $no = 1;

                    foreach ($penilaian2->result_array() as $p) {
                        $sheet->setCellValue('A' . $row, $no);
                        $sheet->setCellValue('B' . $row, $p['aspek_dinilai']);
                        $sheet->setCellValue('C' . $row, $p['isi_nilai_atasan_langsung']);
                        $sheet->setCellValue('D' . $row, number_format($p['nilai_atasan_langsung'], 1, '.', ''));
                        $sheet->setCellValue('E' . $row, $p['isi_nilai_atasan_tidak_langsung']);
                        $sheet->setCellValue('F' . $row, number_format($p['nilai_atasan_tidak_langsung'], 1, '.', ''));

                        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('0.0');
                        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('0.0');
                        $row++;
                        $no++;
                    }

                    // Hitung total
                    $total_nilai_atasan_langsung += (float) $p['total_nilai_atasan_langsung'];
                    $total_nilai_atasan_tidak_langsung += (float) $p['total_nilai_atasan_tidak_langsung'];

                    $row++;
                    $no++;

                    // **Menambahkan Total**
                    $sheet->setCellValue("B$row", 'Total');
                    $sheet->setCellValue("C$row", number_format($total_nilai_atasan_langsung, 1, '.', ''));
                    $sheet->setCellValue("E$row", number_format($total_nilai_atasan_tidak_langsung, 1, '.', ''));
                    $sheet->mergeCells("C$row:D$row"); // Perbaikan merge agar sesuai dengan nomor baris
                    $sheet->mergeCells("E$row:F$row");
                    $sheet->getStyle("C$row:D$row")->getNumberFormat()->setFormatCode('0.0');
                    $sheet->getStyle("E$row:F$row")->getNumberFormat()->setFormatCode('0.0');
                    $sheet->getStyle("B$row:F$row")->getFont()->setBold(true);
                    $sheet->getStyle("B$row:F$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    // **Menghitung Hasil Akhir**
                    $row_hasil_akhir = $row + 1;
                    $hasil_akhir = ($total_nilai_atasan_langsung * 0.6) + ($total_nilai_atasan_tidak_langsung * 0.4);

                    $sheet->setCellValue("B$row_hasil_akhir", 'Hasil Akhir');
                    $sheet->setCellValue("C$row_hasil_akhir", $hasil_akhir);
                    $sheet->mergeCells("C$row_hasil_akhir:F$row_hasil_akhir");
                    $sheet->getStyle("C$row_hasil_akhir:F$row_hasil_akhir")->getNumberFormat()->setFormatCode('0.0');
                    $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getFont()->setBold(true);
                    $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    // **Menambahkan Border**
                    $sheet->getStyle("A$row_penilaian:F$row_hasil_akhir")->applyFromArray($thickBorder);
                    // *Merapikan Alignment*
                    $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setHorizontal('left'); // Rata tengah horizontal untuk No
                    $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setVertical('left'); // Rata tengah vertikal untuk No
                    $sheet->getStyle("C$row_penilaian:F" . ($row - 1))->getAlignment()->setHorizontal('center'); // Rata tengah untuk kolom lain

                    // *Menyesuaikan Lebar Kolom secara Dinamis*
                    foreach (range('A', 'F') as $columnID) {
                        $sheet->getColumnDimension($columnID)->setAutoSize(true);
                    }

                    // *Tabel Kriteria*
                    $row_kriteria = $row_hasil_akhir + 2; // Sesuaikan posisi awal tabel kriteria
                    $sheet->setCellValue('A' . $row_kriteria, 'Kriteria');
                    $sheet->setCellValue('B' . $row_kriteria, 'Nilai');
                    $sheet->setCellValue('C' . $row_kriteria, 'Keterangan');
                    $sheet->getStyle("A$row_kriteria:C$row_kriteria")->getFont()->setBold(true);

                    $start_kriteria = $row_kriteria + 1;
                    $kriteria = [
                        ['A', '90 s.d. 100', 'Istimewa'],
                        ['B', '80 s.d. 89', 'Baik'],
                        ['C', '60 s.d. 79', 'Cukup'],
                        ['D', '40 s.d. 59', 'Kurang']
                    ];
                    foreach ($kriteria as $k) {
                        $sheet->setCellValue('A' . $start_kriteria, $k[0]);
                        $sheet->setCellValue('B' . $start_kriteria, $k[1]);
                        $sheet->setCellValue('C' . $start_kriteria, $k[2]);
                        $start_kriteria++;
                    }

                    // *Menambahkan Border Tebal pada Tabel Kriteria*
                    $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->applyFromArray($thickBorder);

                    // *Membuat Alignment ke Tengah*
                    $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setVertical('center');

                    // **Judul Aspek Tambahan**
                    $row_aspek = $start_kriteria + 1; // Beri jarak 1 baris kosong setelah tabel kriteria
                    $sheet->setCellValue('A' . $row_aspek, 'Aspek-aspek Tambahan (mohon diuraikan bila ada) :');
                    $sheet->mergeCells("A$row_aspek:C$row_aspek");
                    $sheet->getStyle("A$row_aspek")->getFont()->setBold(true);

                    // **Atasan Langsung**
                    $row_atasan_langsung = $row_aspek + 1;
                    $sheet->setCellValue('A' . $row_atasan_langsung, 'Atasan Langsung:');
                    $sheet->mergeCells("A$row_atasan_langsung:C$row_atasan_langsung");
                    $sheet->getStyle("A$row_atasan_langsung")->getFont()->setBold(true);

                    // **Isi Atasan Langsung**
                    $row_text_atasan_langsung = $row_atasan_langsung + 1;
                    $sheet->setCellValue('A' . $row_text_atasan_langsung, !empty($text->text_tambahan_atasan_langsung) ? $text->text_tambahan_atasan_langsung : '');
                    $sheet->mergeCells("A$row_text_atasan_langsung:C$row_text_atasan_langsung");

                    // **Garis Kosong**
                    $row_garis_atasan = $row_text_atasan_langsung + 1;
                    $sheet->mergeCells("A$row_garis_atasan:C$row_garis_atasan");

                    // **Atasan Tidak Langsung**
                    $row_atasan_tidak_langsung = $row_garis_atasan + 1;
                    $sheet->setCellValue('A' . $row_atasan_tidak_langsung, 'Atasan Tidak Langsung:');
                    $sheet->mergeCells("A$row_atasan_tidak_langsung:C$row_atasan_tidak_langsung");
                    $sheet->getStyle("A$row_atasan_tidak_langsung")->getFont()->setBold(true);

                    // **Isi Atasan Tidak Langsung**
                    $row_text_atasan_tidak_langsung = $row_atasan_tidak_langsung + 1;
                    $sheet->setCellValue('A' . $row_text_atasan_tidak_langsung, !empty($text->text_tambahan_atasan_tidak_langsung) ? $text->text_tambahan_atasan_tidak_langsung : '');
                    $sheet->mergeCells("A$row_text_atasan_tidak_langsung:C$row_text_atasan_tidak_langsung");

                    // **Garis Kosong**
                    $row_garis_tidak_langsung = $row_text_atasan_tidak_langsung + 1;
                    $sheet->mergeCells("A$row_garis_tidak_langsung:C$row_garis_tidak_langsung");

                    // **Atur Border untuk Tabel Aspek Tambahan**
                    $styleArray = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ];

                    // Terapkan border ke area aspek tambahan
                    $sheet->getStyle("A$row_aspek:C$row_garis_tidak_langsung")->applyFromArray($styleArray);

                    // **Set Lebar Kolom**
                    $sheet->getColumnDimension('A')->setWidth(50);
                    $sheet->getColumnDimension('B')->setWidth(50);
                    $sheet->getColumnDimension('C')->setWidth(50);

                    $index++;
                }

                // Set Sheet Aktif ke yang pertama
                $spreadsheet->setActiveSheetIndex(0);

                // Set nama file
                $filename = "Laporan_Penilaian_$nrp.xlsx";

                if (ob_get_contents()) {
                    ob_end_clean();
                }
                // Simpan dan download file
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit;
            } else {
                // Ambil data dari database
                $query = $this->master_model->lap_nilai_periode($nrp, $periode);
                $data = $query->row_array();

                if (!$data) {
                    show_error('Data tidak ditemukan atau tidak dapat diakses.', 404);
                    return;
                }

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle("Periode " . $periode);

                // *Mengatur Border*
                $thickBorder = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];

                // *Header & Judul*
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A1', 'LAPORAN PENILAIAN PRESTASI KINERJA');
                $sheet->setCellValue('A2', 'KARYAWAN KONTRAK');
                $sheet->setCellValue('A3', 'KELOMPOK I - II');
                $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');

                // *Data Karyawan*
                $row_karyawan = 5;
                $sheet->mergeCells("A$row_karyawan:B$row_karyawan");
                $sheet->setCellValue('A' . $row_karyawan, 'KARYAWAN YANG DINILAI');
                $sheet->getStyle("A$row_karyawan")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A$row_karyawan")->getFont()->setBold(true);
                $sheet->setCellValue('A' . ($row_karyawan + 1), 'Nama:');
                $sheet->setCellValue('B' . ($row_karyawan + 1), $data['karyawan_nama']);
                $sheet->setCellValue('A' . ($row_karyawan + 2), 'Jabatan:');
                $sheet->setCellValue('B' . ($row_karyawan + 2), $data['job_grade']);
                $sheet->setCellValue('A' . ($row_karyawan + 3), 'Tanggal Masuk:');
                $sheet->setCellValue('B' . ($row_karyawan + 3), $data['tgl_hire']);
                $sheet->getStyle("A$row_karyawan:B" . ($row_karyawan + 3))->applyFromArray($thickBorder);

                // *Data Penilai*
                $row_penilai = $row_karyawan + 5;
                $sheet->mergeCells("A$row_penilai:B$row_penilai");
                $sheet->setCellValue('A' . $row_penilai, 'NAMA PENILAI');
                $sheet->getStyle("A$row_penilai")->getFont()->setBold(true);
                $sheet->getStyle("A$row_penilai")->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('A' . ($row_penilai + 1), 'Atasan Langsung:');
                $sheet->setCellValue('B' . ($row_penilai + 1), $data['spv1_nama']);
                $sheet->setCellValue('A' . ($row_penilai + 2), 'Atasan Tidak Langsung:');
                $sheet->setCellValue('B' . ($row_penilai + 2), $data['spv2_nama']);
                $sheet->setCellValue('A' . ($row_penilai + 3), 'Unit:');
                $sheet->setCellValue('B' . ($row_penilai + 3), $data['department']);
                $sheet->setCellValue('A' . ($row_penilai + 4), 'Periode Penilaian:');
                $sheet->setCellValue('B' . ($row_penilai + 4), $data['id_p_periode']);
                $sheet->getStyle("A$row_penilai:B" . ($row_penilai + 4))->applyFromArray($thickBorder);
                $sheet->getStyle('B' . ($row_penilai + 4))->getAlignment()->setHorizontal('left');

                // *Header Tabel Penilaian*
                $row_penilaian = $row_penilai + 6;
                $sheet->setCellValue('A' . $row_penilaian, 'No')
                    ->setCellValue('B' . $row_penilaian, 'Aspek Yang Dinilai')
                    ->setCellValue('C' . $row_penilaian, 'Atasan Langsung')
                    ->setCellValue('D' . $row_penilaian, 'Nilai Atasan Langsung')
                    ->setCellValue('E' . $row_penilaian, 'Atasan Tidak Langsung')
                    ->setCellValue('F' . $row_penilaian, 'Nilai Atasan Tidak Langsung');
                $sheet->getStyle("A$row_penilaian:F$row_penilaian")->getFont()->setBold(true);
                $sheet->getStyle("B$row_penilaian")->getAlignment()->setHorizontal('center');

                // *Mengisi Data Penilaian*
                $penilaian2 = $this->master_model->hasil_nilai_periode($nrp, $periode);
                $text = $penilaian2->row();
                $total_nilai_atasan_langsung = 0;
                $total_nilai_atasan_tidak_langsung = 0;
                $row = $row_penilaian + 1;
                $no = 1;

                foreach ($penilaian2->result_array() as $p) {
                    $sheet->setCellValue('A' . $row, $no);
                    $sheet->setCellValue('B' . $row, $p['aspek_dinilai']);
                    $sheet->setCellValue('C' . $row, $p['isi_nilai_atasan_langsung']);
                    $sheet->setCellValue('D' . $row, number_format($p['nilai_atasan_langsung'], 1));
                    $sheet->setCellValue('E' . $row, $p['isi_nilai_atasan_tidak_langsung']);
                    $sheet->setCellValue('F' . $row, number_format($p['nilai_atasan_tidak_langsung'], 1));

                    $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('0.0');
                    $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('0.0');
                    $row++;
                    $no++;
                }

                // Hitung total
                $total_nilai_atasan_langsung += (float) $p['total_nilai_atasan_langsung'];
                $total_nilai_atasan_tidak_langsung += (float) $p['total_nilai_atasan_tidak_langsung'];

                $row++;
                $no++;

                // **Menambahkan Total**
                $sheet->setCellValue("B$row", 'Total');
                $sheet->setCellValue("C$row", $total_nilai_atasan_langsung);
                $sheet->setCellValue("E$row", $total_nilai_atasan_tidak_langsung);
                $sheet->mergeCells("C$row:D$row"); // Perbaikan merge agar sesuai dengan nomor baris
                $sheet->mergeCells("E$row:F$row");
                $sheet->getStyle("B$row:F$row")->getFont()->setBold(true);
                $sheet->getStyle("B$row:F$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C$row")->getNumberFormat()->setFormatCode('0.0');
                $sheet->getStyle("E$row")->getNumberFormat()->setFormatCode('0.0');

                // **Menghitung Hasil Akhir**
                $row_hasil_akhir = $row + 1;
                $hasil_akhir = ($total_nilai_atasan_langsung * 0.6) + ($total_nilai_atasan_tidak_langsung * 0.4);

                $sheet->setCellValue("B$row_hasil_akhir", 'Hasil Akhir');
                $sheet->setCellValue("C$row_hasil_akhir", $hasil_akhir);
                $sheet->mergeCells("C$row_hasil_akhir:F$row_hasil_akhir");
                $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getFont()->setBold(true);
                $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C$row_hasil_akhir:F$row_hasil_akhir")->getNumberFormat()->setFormatCode('0.0');

                // **Menambahkan Border**
                $sheet->getStyle("A$row_penilaian:F$row_hasil_akhir")->applyFromArray($thickBorder);
                // *Merapikan Alignment*
                $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setHorizontal('left'); // Rata tengah horizontal untuk No
                $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setVertical('left'); // Rata tengah vertikal untuk No
                $sheet->getStyle("C$row_penilaian:F" . ($row - 1))->getAlignment()->setHorizontal('center'); // Rata tengah untuk kolom lain

                // *Menyesuaikan Lebar Kolom secara Dinamis*
                foreach (range('A', 'F') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // *Tabel Kriteria*
                $row_kriteria = $row_hasil_akhir + 2; // Sesuaikan posisi awal tabel kriteria
                $sheet->setCellValue('A' . $row_kriteria, 'Kriteria');
                $sheet->setCellValue('B' . $row_kriteria, 'Nilai');
                $sheet->setCellValue('C' . $row_kriteria, 'Keterangan');
                $sheet->getStyle("A$row_kriteria:C$row_kriteria")->getFont()->setBold(true);

                $start_kriteria = $row_kriteria + 1;
                $kriteria = [
                    ['A', '90 s.d. 100', 'Istimewa'],
                    ['B', '80 s.d. 89', 'Baik'],
                    ['C', '60 s.d. 79', 'Cukup'],
                    ['D', '40 s.d. 59', 'Kurang']
                ];
                foreach ($kriteria as $k) {
                    $sheet->setCellValue('A' . $start_kriteria, $k[0]);
                    $sheet->setCellValue('B' . $start_kriteria, $k[1]);
                    $sheet->setCellValue('C' . $start_kriteria, $k[2]);
                    $start_kriteria++;
                }

                // *Menambahkan Border Tebal pada Tabel Kriteria*
                $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->applyFromArray($thickBorder);

                // *Membuat Alignment ke Tengah*
                $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setVertical('center');

                // **Judul Aspek Tambahan**
                $row_aspek = $start_kriteria + 1; // Beri jarak 1 baris kosong setelah tabel kriteria
                $sheet->setCellValue('A' . $row_aspek, 'Aspek-aspek Tambahan (mohon diuraikan bila ada) :');
                $sheet->mergeCells("A$row_aspek:C$row_aspek");
                $sheet->getStyle("A$row_aspek")->getFont()->setBold(true);

                // **Atasan Langsung**
                $row_atasan_langsung = $row_aspek + 1;
                $sheet->setCellValue('A' . $row_atasan_langsung, 'Atasan Langsung:');
                $sheet->mergeCells("A$row_atasan_langsung:C$row_atasan_langsung");
                $sheet->getStyle("A$row_atasan_langsung")->getFont()->setBold(true);

                // **Isi Atasan Langsung**
                $row_text_atasan_langsung = $row_atasan_langsung + 1;
                $sheet->setCellValue('A' . $row_text_atasan_langsung, !empty($text->text_tambahan_atasan_langsung) ? $text->text_tambahan_atasan_langsung : '');
                $sheet->mergeCells("A$row_text_atasan_langsung:C$row_text_atasan_langsung");

                // **Garis Kosong**
                $row_garis_atasan = $row_text_atasan_langsung + 1;
                $sheet->mergeCells("A$row_garis_atasan:C$row_garis_atasan");

                // **Atasan Tidak Langsung**
                $row_atasan_tidak_langsung = $row_garis_atasan + 1;
                $sheet->setCellValue('A' . $row_atasan_tidak_langsung, 'Atasan Tidak Langsung:');
                $sheet->mergeCells("A$row_atasan_tidak_langsung:C$row_atasan_tidak_langsung");
                $sheet->getStyle("A$row_atasan_tidak_langsung")->getFont()->setBold(true);

                // **Isi Atasan Tidak Langsung**
                $row_text_atasan_tidak_langsung = $row_atasan_tidak_langsung + 1;
                $sheet->setCellValue('A' . $row_text_atasan_tidak_langsung, !empty($text->text_tambahan_atasan_tidak_langsung) ? $text->text_tambahan_atasan_tidak_langsung : '');
                $sheet->mergeCells("A$row_text_atasan_tidak_langsung:C$row_text_atasan_tidak_langsung");

                // **Garis Kosong**
                $row_garis_tidak_langsung = $row_text_atasan_tidak_langsung + 1;
                $sheet->mergeCells("A$row_garis_tidak_langsung:C$row_garis_tidak_langsung");

                // **Atur Border untuk Tabel Aspek Tambahan**
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ];

                // Terapkan border ke area aspek tambahan
                $sheet->getStyle("A$row_aspek:C$row_garis_tidak_langsung")->applyFromArray($styleArray);

                // **Set Lebar Kolom**
                $sheet->getColumnDimension('A')->setWidth(50);
                $sheet->getColumnDimension('B')->setWidth(50);
                $sheet->getColumnDimension('C')->setWidth(50);

                // Set nama file
                $filename = "Laporan_Penilaian_$nrp.xlsx";

                if (ob_get_contents()) {
                    ob_end_clean();
                }
                // Simpan dan download file
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit;
            }
        }
    }

    public function download_data_pkk_excel_3_7($nrp, $periode)
    {
        $masuk = $this->session->userdata('masuk_k');
        $this->load->helper('print_rekap_helper');

        if (!$masuk) {
            redirect(base_url('login'));
        } else {
            // Ambil data dari database
            if ($periode == 'all') {
                $trans = $this->master_model->get_trans_pkk($nrp);
                $spreadsheet = new Spreadsheet();
                $index = 0;
                foreach ($trans->result() as $dm) {
                    $query = $this->master_model->lap_nilai_3_7_periode($dm->nrp, $dm->id_p_periode);
                    $data = $query->row_array();

                    if (!$data) {
                        show_error('Data tidak ditemukan atau tidak dapat diakses.', 404);
                        return;
                    }

                    if ($index > 0) {
                        $spreadsheet->createSheet();
                    }

                    $spreadsheet->setActiveSheetIndex($index);

                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setTitle("Periode " . $dm->id_p_periode);

                    // *Mengatur Border*
                    $thickBorder = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                'color' => ['rgb' => '000000'],
                            ],
                            'inside' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ];

                    // *Header & Judul*
                    $sheet->mergeCells('A1:F1');
                    $sheet->mergeCells('A2:F2');
                    $sheet->mergeCells('A3:F3');
                    $sheet->setCellValue('A1', 'LAPORAN PENILAIAN PRESTASI KINERJA');
                    $sheet->setCellValue('A2', 'KARYAWAN KONTRAK');
                    $sheet->setCellValue('A3', 'KELOMPOK III - VII');
                    $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
                    $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');


                    // // *Mengatur Lebar Kolom*
                    // $column_widths = ['A' => 3, 'B' => 50, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 15];
                    // foreach ($column_widths as $column => $width) {
                    //     $sheet->getColumnDimension($column)->setWidth($width);
                    // }

                    // *Data Karyawan*
                    $row_karyawan = 5;
                    $sheet->mergeCells("A$row_karyawan:B$row_karyawan");
                    $sheet->setCellValue('A' . $row_karyawan, 'KARYAWAN YANG DINILAI');
                    $sheet->getStyle("A$row_karyawan")->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("A$row_karyawan")->getFont()->setBold(true);
                    $sheet->setCellValue('A' . ($row_karyawan + 1), 'Nama:');
                    $sheet->setCellValue('B' . ($row_karyawan + 1), $data['karyawan_nama']);
                    $sheet->setCellValue('A' . ($row_karyawan + 2), 'Jabatan:');
                    $sheet->setCellValue('B' . ($row_karyawan + 2), $data['job_grade']);
                    $sheet->setCellValue('A' . ($row_karyawan + 3), 'Tanggal Masuk:');
                    $sheet->setCellValue('B' . ($row_karyawan + 3), $data['tgl_hire']);
                    $sheet->getStyle("A$row_karyawan:B" . ($row_karyawan + 3))->applyFromArray($thickBorder);

                    // *Data Penilai*
                    $row_penilai = $row_karyawan + 5;
                    $sheet->mergeCells("A$row_penilai:B$row_penilai");
                    $sheet->setCellValue('A' . $row_penilai, 'NAMA PENILAI');
                    $sheet->getStyle("A$row_penilai")->getFont()->setBold(true);
                    $sheet->getStyle("A$row_penilai")->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('A' . ($row_penilai + 1), 'Atasan Langsung:');
                    $sheet->setCellValue('B' . ($row_penilai + 1), $data['spv1_nama']);
                    $sheet->setCellValue('A' . ($row_penilai + 2), 'Atasan Tidak Langsung:');
                    $sheet->setCellValue('B' . ($row_penilai + 2), $data['spv2_nama']);
                    $sheet->setCellValue('A' . ($row_penilai + 3), 'Unit:');
                    $sheet->setCellValue('B' . ($row_penilai + 3), $data['department']);
                    $sheet->setCellValue('A' . ($row_penilai + 4), 'Periode Penilaian:');
                    $sheet->setCellValue('B' . ($row_penilai + 4), $data['id_p_periode']);
                    $sheet->getStyle("A$row_penilai:B" . ($row_penilai + 4))->applyFromArray($thickBorder);
                    $sheet->getStyle('B' . ($row_penilai + 4))->getAlignment()->setHorizontal('left');

                    // *Header Tabel Penilaian*
                    $row_penilaian = $row_penilai + 6;
                    $sheet->setCellValue('A' . $row_penilaian, 'No')
                        ->setCellValue('B' . $row_penilaian, 'Aspek Yang Dinilai')
                        ->setCellValue('C' . $row_penilaian, 'Atasan Langsung')
                        ->setCellValue('D' . $row_penilaian, 'Nilai Atasan Langsung')
                        ->setCellValue('E' . $row_penilaian, 'Atasan Tidak Langsung')
                        ->setCellValue('F' . $row_penilaian, 'Nilai Atasan Tidak Langsung');
                    $sheet->getStyle("A$row_penilaian:F$row_penilaian")->getFont()->setBold(true);
                    $sheet->getStyle("B$row_penilaian")->getAlignment()->setHorizontal('center');

                    // *Mengisi Data Penilaian*
                    $penilaian2 = $this->master_model->hasil_nilai_3_7_periode($dm->nrp, $dm->id_p_periode);
                    $row = $row_penilaian + 1;
                    $total_nilai_atasan_langsung = 0;
                    $total_nilai_atasan_tidak_langsung = 0;
                    $no = 1;

                    foreach ($penilaian2->result_array() as $p) {
                        $sheet->setCellValue('A' . $row, $no);
                        $sheet->setCellValue('B' . $row, $p['aspek_dinilai']);
                        $sheet->setCellValue('C' . $row, $p['isi_nilai_atasan_langsung']);
                        $sheet->setCellValue('D' . $row, $p['nilai_atasan_langsung']);
                        $sheet->setCellValue('E' . $row, $p['isi_nilai_atasan_tidak_langsung']);
                        $sheet->setCellValue('F' . $row, $p['nilai_atasan_tidak_langsung']);
                        $row++;
                        $no++;
                    }

                    // Hitung total
                    $total_nilai_atasan_langsung += (float) $p['total_nilai_atasan_langsung'];
                    $total_nilai_atasan_tidak_langsung += (float) $p['total_nilai_atasan_tidak_langsung'];

                    $row++;
                    $no++;

                    // **Menambahkan Total**
                    $sheet->setCellValue("B$row", 'Total');
                    $sheet->setCellValue("C$row", $total_nilai_atasan_langsung);
                    $sheet->setCellValue("E$row", $total_nilai_atasan_tidak_langsung);
                    $sheet->mergeCells("C$row:D$row"); // Perbaikan merge agar sesuai dengan nomor baris
                    $sheet->mergeCells("E$row:F$row");
                    $sheet->getStyle("B$row:F$row")->getFont()->setBold(true);
                    $sheet->getStyle("B$row:F$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    // **Menghitung Hasil Akhir**
                    $row_hasil_akhir = $row + 1;
                    $hasil_akhir = ($total_nilai_atasan_langsung + $total_nilai_atasan_tidak_langsung) / 2;

                    $sheet->setCellValue("B$row_hasil_akhir", 'Hasil Akhir');
                    $sheet->setCellValue("C$row_hasil_akhir", $hasil_akhir);
                    $sheet->mergeCells("C$row_hasil_akhir:F$row_hasil_akhir");
                    $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getFont()->setBold(true);
                    $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    $sheet->getStyle("A$row_penilaian:F$row_hasil_akhir")->applyFromArray($thickBorder);

                    // *Merapikan Alignment*
                    $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setHorizontal('left'); // Rata tengah horizontal untuk No
                    $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setVertical('left'); // Rata tengah vertikal untuk No
                    $sheet->getStyle("C$row_penilaian:F" . ($row - 1))->getAlignment()->setHorizontal('center'); // Rata tengah untuk kolom lain

                    // *Menyesuaikan Lebar Kolom secara Dinamis*
                    foreach (range('A', 'F') as $columnID) {
                        $sheet->getColumnDimension($columnID)->setAutoSize(true);
                    }

                    //  // *Mengatur Lebar Kolom*
                    //  $column_widths = ['A' => 3, 'B' => 50, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 15];
                    //  foreach ($column_widths as $column => $width) {
                    //      $sheet->getColumnDimension($column)->setWidth($width);
                    //  }

                    // *Tabel Kriteria*
                    $row_kriteria = $row_hasil_akhir + 2; // Sesuaikan posisi awal tabel kriteria
                    $sheet->setCellValue('A' . $row_kriteria, 'Kriteria');
                    $sheet->setCellValue('B' . $row_kriteria, 'Nilai');
                    $sheet->setCellValue('C' . $row_kriteria, 'Keterangan');
                    $sheet->getStyle("A$row_kriteria:C$row_kriteria")->getFont()->setBold(true);

                    $start_kriteria = $row_kriteria + 1;
                    $kriteria = [
                        ['A', '90 s.d. 100', 'Istimewa'],
                        ['B', '80 s.d. 89', 'Baik'],
                        ['C', '60 s.d. 79', 'Cukup'],
                        ['D', '40 s.d. 59', 'Kurang']
                    ];
                    foreach ($kriteria as $k) {
                        $sheet->setCellValue('A' . $start_kriteria, $k[0]);
                        $sheet->setCellValue('B' . $start_kriteria, $k[1]);
                        $sheet->setCellValue('C' . $start_kriteria, $k[2]);
                        $start_kriteria++;
                    }

                    // *Menambahkan Border Tebal pada Tabel Kriteria*
                    $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->applyFromArray($thickBorder);

                    // *Membuat Alignment ke Tengah*
                    $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setVertical('center');

                    // // Tambahkan bagian Kesimpulan
                    // $row_kriteria += 6;
                    // $sheet->setCellValue('A' . $row, 'KESIMPULAN ATAS HASIL SELURUH PENILAIAN');
                    // $sheet->mergeCells('A' . $row . ':F' . $row);
                    // $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                    // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // $row++;
                    // $sheet->setCellValue('A' . $row, 'Tuliskan hal-hal positif, kelemahan yang harus diperbaiki, serta perbaikan yang telah dilakukan karyawan dibanding penilaian sebelumnya.');
                    // $sheet->mergeCells('A' . $row . ':F' . ($row + 2));

                    // // Tambahkan bagian komentar
                    // $row += 4;
                    // $sheet->setCellValue('A' . $row, 'PENDAPAT / KOMENTAR');
                    // $sheet->mergeCells('A' . $row . ':F' . $row);
                    // $sheet->getStyle('A' . $row)->getFont()->setBold(true);

                    // Ambil data dari model
                    $menu3 = $this->master_model->get_menu3_data()->result();
                    $menu4 = $this->master_model->get_menu4_data()->result();
                    $menu6 = $this->master_model->get_menu6_data()->result();
                    $form_a = $this->master_model->get_form_A($dm->nrp, $dm->id_p_periode, $penilaian2->atasan);
                    $form_b = $this->master_model->get_form_B($dm->nrp, $dm->id_p_periode, $penilaian2->atasan);
                    $feedback_karyawan       = $this->master_model->get_fb_karyawan($dm->nrp, $dm->id_p_periode);
                    $feedback_atasan       = $this->master_model->get_fb_atasan($dm->nrp, $dm->id_p_periode);

                    // Set awal row
                    $row = $start_kriteria + 1;

                    // *Header Tabel*
                    $headers = ['RENCANA KERJA', 'KESIMPULAN HASIL', '%', 'KESIMPULAN DEVIASI'];
                    $sheet->fromArray($headers, null, "A$row");
                    $sheet->getStyle("A$row:D$row")->applyFromArray($thickBorder);
                    $sheet->getStyle("A$row:D$row")->getFont()->setBold(true);
                    $row++;

                    // *Bagian Kinerja*
                    $sheet->setCellValue("A$row", 'A. KINERJA (Didasarkan Sasaran Pekerjaan)');
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    // *Tugas Pokok*
                    if (!empty($menu3)) {
                        $sheet->setCellValue("A$row", "1. {$menu3[0]->nama_value}");
                        $sheet->getStyle("A$row")->getFont()->setBold(true);
                        $row++;

                        $sheet->setCellValue("A$row", "a. {$menu3[1]->description}");
                        $sheet->setCellValue("B$row", $form_a->hasil_nilai_a ?? 'Nilai Belum Di Isi !');
                        $sheet->setCellValue("C$row", $form_a->persen_a ?? '0');
                        $sheet->setCellValue("D$row", $form_a->deviasi_nilai_a ?? 'Nilai Belum Di Isi !');
                        $row++;

                        $sheet->setCellValue("A$row", 'b. Sasaran Pekerjaan Secara Kuantitatif');
                        $sheet->setCellValue("B$row", $form_a->hasil_nilai_b ?? 'Nilai Belum Di Isi !');
                        $sheet->setCellValue("C$row", $form_a->persen_b ?? '0');
                        $sheet->setCellValue("D$row", $form_a->deviasi_b ?? 'Nilai Belum Di Isi !');
                        $row++;

                        // *Menambahkan Border ke Tugas Pokok*
                        $sheet->getStyle("A" . ($row - 3) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                    }

                    // *Tugas Tambahan*
                    if (!empty($menu3)) {
                        $sheet->setCellValue("A$row", "2. {$menu3[1]->nama_value}");
                        $sheet->mergeCells("A$row:D$row");
                        $sheet->getStyle("A$row")->getFont()->setBold(true);
                        $row++;

                        $sheet->setCellValue("A$row", $form_a->tugas_tambahan ?? 'Nilai Belum Di Isi !');
                        $sheet->setCellValue("B$row", $form_a->hasil_tgs_tambahan ?? 'Nilai Belum Di Isi !');
                        $sheet->setCellValue("C$row", $form_a->persen_tambahan ?? '0');
                        $sheet->setCellValue("D$row", $form_a->deviasi_tambahan ?? 'Nilai Belum Di Isi !');
                        $row++;

                        // *Menambahkan Border ke Tugas Tambahan*
                        $sheet->getStyle("A" . ($row - 2) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                    }


                    // Kesimpulan
                    if (!empty($menu4) && isset($menu4[1]->description)) {
                        $row += 1;
                        $sheet->setCellValue("A$row", $menu4[1]->nama_value);
                        $sheet->mergeCells("A$row:D$row");
                        $sheet->getStyle("A$row")->getFont()->setBold(true);
                        $row++;

                        $descriptionText = $menu4[1]->description ?? ''; // Pastikan variabel selalu ada
                        $sheet->setCellValue("A$row", $descriptionText);
                        $sheet->mergeCells("A$row:D$row");
                        $sheet->getStyle("A$row")->getAlignment()->setWrapText(true);

                        // Hitung tinggi baris berdasarkan jumlah karakter
                        $textLength = strlen($descriptionText);
                        $estimatedHeight = ceil($textLength / 50) * 6; // Estimasi tinggi berdasarkan panjang teks
                        $sheet->getRowDimension($row)->setRowHeight($estimatedHeight);

                        $row++;

                        $sheet->setCellValue("A$row", $form_b->kesimpulan ?? 'Nilai Belum Di Isi !');
                        $sheet->mergeCells("A$row:D" . ($row + 1));
                        $sheet->getStyle("A$row")->getAlignment()->setWrapText(true);

                        // Hitung tinggi baris berdasarkan jumlah karakter
                        $textLength = strlen($descriptionText);
                        $estimatedHeight = ceil($textLength / 50) * 6; // Estimasi tinggi berdasarkan panjang teks
                        $sheet->getRowDimension($row)->setRowHeight($estimatedHeight);
                        $row += 2;

                        // Menambahkan Border ke Kesimpulan
                        $sheet->getStyle("A" . ($row - 4) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                    }

                    // penjelasan
                    if (!empty($menu4)) {
                        $row += 1;
                        $sheet->setCellValue("A$row", $menu4[0]->nama_value);
                        $sheet->mergeCells("A$row:D$row");
                        $sheet->getStyle("A$row")->getFont()->setBold(true);
                        $row++;

                        $sheet->setCellValue("A$row", $menu4[0]->description);
                        $sheet->mergeCells("A$row:D$row");
                        $row++;

                        $sheet->setCellValue("A$row", $form_b->penjelasan ?? 'Nilai Belum Di Isi !');
                        $sheet->mergeCells("A$row:D" . ($row + 1));
                        $sheet->getStyle("A$row")->getAlignment()->setWrapText(true);

                        // Hitung tinggi baris berdasarkan jumlah karakter
                        $textLength = strlen($descriptionText);
                        $estimatedHeight = ceil($textLength / 50) * 6; // Estimasi tinggi berdasarkan panjang teks
                        $sheet->getRowDimension($row)->setRowHeight($estimatedHeight);
                        $row += 2;

                        // *Menambahkan Border ke Kesimpulan*
                        $sheet->getStyle("A" . ($row - 4) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                    }


                    // *Pendapat / Komentar*
                    $row += 1;
                    $sheet->setCellValue("A$row", 'PENDAPAT / KOMENTAR');
                    $sheet->mergeCells("A$row:D$row");
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    if (!empty($menu6)) {
                        $sheet->setCellValue("A$row", "1. {$menu6[0]->nama_value}");
                        $sheet->mergeCells("A$row:D$row");
                        $sheet->getStyle("A$row")->getFont()->setBold(true);
                        $row++;

                        $sheet->setCellValue("A$row", 'Mintakan pendapat/komentar karyawan yang dinilai atas seluruh hasil penilaian tersebut di atas.');
                        $sheet->mergeCells("A$row:D" . ($row + 1));
                        $row += 2;

                        $sheet->setCellValue("A$row", $feedback_karyawan->isi_feedback ?? 'Nilai Belum Di Isi !');
                        $sheet->mergeCells("A$row:D" . ($row + 1));
                        $row += 2;

                        $sheet->setCellValue("A$row", "2. {$menu6[1]->nama_value}");
                        $sheet->mergeCells("A$row:D$row");
                        $sheet->getStyle("A$row")->getFont()->setBold(true);
                        $row++;

                        $sheet->setCellValue("A$row", $feedback_atasan->isi_feedback ?? 'Nilai Belum Di Isi !');
                        $sheet->mergeCells("A$row:D" . ($row + 1));
                        $row += 1;

                        // *Menambahkan Border ke Pendapat*
                        $sheet->getStyle("A" . ($row - 8) . ":D$row")->applyFromArray($thickBorder);
                    }
                    $index++;
                }
                // Set Sheet Aktif ke yang pertama
                $spreadsheet->setActiveSheetIndex(0);
                // Set nama file
                $filename = "Laporan_Penilaian_$nrp.xlsx";

                if (ob_get_contents()) {
                    ob_end_clean();
                }

                // Simpan dan download file
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit;
            } else {
                $query = $this->master_model->lap_nilai_3_7_periode($nrp, $periode);
                $data = $query->row_array();

                if (!$data) {
                    show_error('Data tidak ditemukan atau tidak dapat diakses.', 404);
                    return;
                }

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle("Periode " . $periode);

                // *Mengatur Border*
                $thickBorder = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];

                // *Header & Judul*
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A1', 'LAPORAN PENILAIAN PRESTASI KINERJA');
                $sheet->setCellValue('A2', 'KARYAWAN KONTRAK');
                $sheet->setCellValue('A3', 'KELOMPOK III - VII');
                $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');


                // // *Mengatur Lebar Kolom*
                // $column_widths = ['A' => 3, 'B' => 50, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 15];
                // foreach ($column_widths as $column => $width) {
                //     $sheet->getColumnDimension($column)->setWidth($width);
                // }

                // *Data Karyawan*
                $row_karyawan = 5;
                $sheet->mergeCells("A$row_karyawan:B$row_karyawan");
                $sheet->setCellValue('A' . $row_karyawan, 'KARYAWAN YANG DINILAI');
                $sheet->getStyle("A$row_karyawan")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A$row_karyawan")->getFont()->setBold(true);
                $sheet->setCellValue('A' . ($row_karyawan + 1), 'Nama:');
                $sheet->setCellValue('B' . ($row_karyawan + 1), $data['karyawan_nama']);
                $sheet->setCellValue('A' . ($row_karyawan + 2), 'Jabatan:');
                $sheet->setCellValue('B' . ($row_karyawan + 2), $data['job_grade']);
                $sheet->setCellValue('A' . ($row_karyawan + 3), 'Tanggal Masuk:');
                $sheet->setCellValue('B' . ($row_karyawan + 3), $data['tgl_hire']);
                $sheet->getStyle("A$row_karyawan:B" . ($row_karyawan + 3))->applyFromArray($thickBorder);

                // *Data Penilai*
                $row_penilai = $row_karyawan + 5;
                $sheet->mergeCells("A$row_penilai:B$row_penilai");
                $sheet->setCellValue('A' . $row_penilai, 'NAMA PENILAI');
                $sheet->getStyle("A$row_penilai")->getFont()->setBold(true);
                $sheet->getStyle("A$row_penilai")->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('A' . ($row_penilai + 1), 'Atasan Langsung:');
                $sheet->setCellValue('B' . ($row_penilai + 1), $data['spv1_nama']);
                $sheet->setCellValue('A' . ($row_penilai + 2), 'Atasan Tidak Langsung:');
                $sheet->setCellValue('B' . ($row_penilai + 2), $data['spv2_nama']);
                $sheet->setCellValue('A' . ($row_penilai + 3), 'Unit:');
                $sheet->setCellValue('B' . ($row_penilai + 3), $data['department']);
                $sheet->setCellValue('A' . ($row_penilai + 4), 'Periode Penilaian:');
                $sheet->setCellValue('B' . ($row_penilai + 4), '1');
                $sheet->getStyle("A$row_penilai:B" . ($row_penilai + 4))->applyFromArray($thickBorder);
                $sheet->getStyle('B' . ($row_penilai + 4))->getAlignment()->setHorizontal('left');

                // *Header Tabel Penilaian*
                $row_penilaian = $row_penilai + 6;
                $sheet->setCellValue('A' . $row_penilaian, 'No')
                    ->setCellValue('B' . $row_penilaian, 'Aspek Yang Dinilai')
                    ->setCellValue('C' . $row_penilaian, 'Atasan Langsung')
                    ->setCellValue('D' . $row_penilaian, 'Nilai Atasan Langsung')
                    ->setCellValue('E' . $row_penilaian, 'Atasan Tidak Langsung')
                    ->setCellValue('F' . $row_penilaian, 'Nilai Atasan Tidak Langsung');
                $sheet->getStyle("A$row_penilaian:F$row_penilaian")->getFont()->setBold(true);
                $sheet->getStyle("B$row_penilaian")->getAlignment()->setHorizontal('center');

                // *Mengisi Data Penilaian*
                $penilaian2 = $this->master_model->hasil_nilai_3_7_periode($nrp, $periode);
                $row = $row_penilaian + 1;
                $total_nilai_atasan_langsung = 0;
                $total_nilai_atasan_tidak_langsung = 0;
                $no = 1;

                foreach ($penilaian2->result_array() as $p) {
                    $sheet->setCellValue('A' . $row, $no);
                    $sheet->setCellValue('B' . $row, $p['aspek_dinilai']);
                    $sheet->setCellValue('C' . $row, $p['isi_nilai_atasan_langsung']);
                    $sheet->setCellValue('D' . $row, $p['nilai_atasan_langsung']);
                    $sheet->setCellValue('E' . $row, $p['isi_nilai_atasan_tidak_langsung']);
                    $sheet->setCellValue('F' . $row, $p['nilai_atasan_tidak_langsung']);
                    $row++;
                    $no++;
                }

                // Hitung total
                $total_nilai_atasan_langsung += (float) $p['total_nilai_atasan_langsung'];
                $total_nilai_atasan_tidak_langsung += (float) $p['total_nilai_atasan_tidak_langsung'];

                $row++;
                $no++;

                // **Menambahkan Total**
                $sheet->setCellValue("B$row", 'Total');
                $sheet->setCellValue("C$row", $total_nilai_atasan_langsung);
                $sheet->setCellValue("E$row", $total_nilai_atasan_tidak_langsung);
                $sheet->mergeCells("C$row:D$row"); // Perbaikan merge agar sesuai dengan nomor baris
                $sheet->mergeCells("E$row:F$row");
                $sheet->getStyle("B$row:F$row")->getFont()->setBold(true);
                $sheet->getStyle("B$row:F$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // **Menghitung Hasil Akhir**
                $row_hasil_akhir = $row + 1;
                $hasil_akhir = ($total_nilai_atasan_langsung + $total_nilai_atasan_tidak_langsung) / 2;

                $sheet->setCellValue("B$row_hasil_akhir", 'Hasil Akhir');
                $sheet->setCellValue("C$row_hasil_akhir", $hasil_akhir);
                $sheet->mergeCells("C$row_hasil_akhir:F$row_hasil_akhir");
                $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getFont()->setBold(true);
                $sheet->getStyle("B$row_hasil_akhir:F$row_hasil_akhir")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("A$row_penilaian:F$row_hasil_akhir")->applyFromArray($thickBorder);

                // *Merapikan Alignment*
                $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setHorizontal('left'); // Rata tengah horizontal untuk No
                $sheet->getStyle("A$row_penilaian:A" . ($row - 1))->getAlignment()->setVertical('left'); // Rata tengah vertikal untuk No
                $sheet->getStyle("C$row_penilaian:F" . ($row - 1))->getAlignment()->setHorizontal('center'); // Rata tengah untuk kolom lain

                // *Menyesuaikan Lebar Kolom secara Dinamis*
                foreach (range('A', 'F') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                //  // *Mengatur Lebar Kolom*
                //  $column_widths = ['A' => 3, 'B' => 50, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 15];
                //  foreach ($column_widths as $column => $width) {
                //      $sheet->getColumnDimension($column)->setWidth($width);
                //  }

                // *Tabel Kriteria*
                $row_kriteria = $row_hasil_akhir + 2; // Sesuaikan posisi awal tabel kriteria
                $sheet->setCellValue('A' . $row_kriteria, 'Kriteria');
                $sheet->setCellValue('B' . $row_kriteria, 'Nilai');
                $sheet->setCellValue('C' . $row_kriteria, 'Keterangan');
                $sheet->getStyle("A$row_kriteria:C$row_kriteria")->getFont()->setBold(true);

                $start_kriteria = $row_kriteria + 1;
                $kriteria = [
                    ['A', '90 s.d. 100', 'Istimewa'],
                    ['B', '80 s.d. 89', 'Baik'],
                    ['C', '60 s.d. 79', 'Cukup'],
                    ['D', '40 s.d. 59', 'Kurang']
                ];
                foreach ($kriteria as $k) {
                    $sheet->setCellValue('A' . $start_kriteria, $k[0]);
                    $sheet->setCellValue('B' . $start_kriteria, $k[1]);
                    $sheet->setCellValue('C' . $start_kriteria, $k[2]);
                    $start_kriteria++;
                }

                // *Menambahkan Border Tebal pada Tabel Kriteria*
                $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->applyFromArray($thickBorder);

                // *Membuat Alignment ke Tengah*
                $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A$row_kriteria:C" . ($start_kriteria - 1))->getAlignment()->setVertical('center');

                // // Tambahkan bagian Kesimpulan
                // $row_kriteria += 6;
                // $sheet->setCellValue('A' . $row, 'KESIMPULAN ATAS HASIL SELURUH PENILAIAN');
                // $sheet->mergeCells('A' . $row . ':F' . $row);
                // $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // $row++;
                // $sheet->setCellValue('A' . $row, 'Tuliskan hal-hal positif, kelemahan yang harus diperbaiki, serta perbaikan yang telah dilakukan karyawan dibanding penilaian sebelumnya.');
                // $sheet->mergeCells('A' . $row . ':F' . ($row + 2));

                // // Tambahkan bagian komentar
                // $row += 4;
                // $sheet->setCellValue('A' . $row, 'PENDAPAT / KOMENTAR');
                // $sheet->mergeCells('A' . $row . ':F' . $row);
                // $sheet->getStyle('A' . $row)->getFont()->setBold(true);

                // Ambil data dari model
                $menu3 = $this->master_model->get_menu3_data()->result();
                $menu4 = $this->master_model->get_menu4_data()->result();
                $menu6 = $this->master_model->get_menu6_data()->result();
                $form_a = $this->master_model->get_form_A($nrp, $periode, $penilaian2->atasan);
                $form_b = $this->master_model->get_form_B($nrp, $periode, $penilaian2->atasan);
                $feedback_karyawan = $this->master_model->get_fb_karyawan($nrp, $periode, $penilaian2->atasan);
                $feedback_atasan   = $this->master_model->get_fb_atasan($nrp, $periode, $penilaian2->atasan);

                // Set awal row
                $row = $start_kriteria + 1;

                // *Header Tabel*
                $headers = ['RENCANA KERJA', 'KESIMPULAN HASIL', '%', 'KESIMPULAN DEVIASI'];
                $sheet->fromArray($headers, null, "A$row");
                $sheet->getStyle("A$row:D$row")->applyFromArray($thickBorder);
                $sheet->getStyle("A$row:D$row")->getFont()->setBold(true);
                $row++;

                // *Bagian Kinerja*
                $sheet->setCellValue("A$row", 'A. KINERJA (Didasarkan Sasaran Pekerjaan)');
                $sheet->getStyle("A$row")->getFont()->setBold(true);
                $row++;

                // *Tugas Pokok*
                if (!empty($menu3)) {
                    $sheet->setCellValue("A$row", "1. {$menu3[0]->nama_value}");
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    $sheet->setCellValue("A$row", "a. {$menu3[1]->description}");
                    $sheet->setCellValue("B$row", $form_a->hasil_nilai_a ?? 'Nilai Belum Di Isi !');
                    $sheet->setCellValue("C$row", $form_a->persen_a ?? '0');
                    $sheet->setCellValue("D$row", $form_a->deviasi_nilai_a ?? 'Nilai Belum Di Isi !');
                    $row++;

                    $sheet->setCellValue("A$row", 'b. Sasaran Pekerjaan Secara Kuantitatif');
                    $sheet->setCellValue("B$row", $form_a->hasil_nilai_b ?? 'Nilai Belum Di Isi !');
                    $sheet->setCellValue("C$row", $form_a->persen_b ?? '0');
                    $sheet->setCellValue("D$row", $form_a->deviasi_b ?? 'Nilai Belum Di Isi !');
                    $row++;

                    // *Menambahkan Border ke Tugas Pokok*
                    $sheet->getStyle("A" . ($row - 3) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                }

                // *Tugas Tambahan*
                if (!empty($menu3)) {
                    $sheet->setCellValue("A$row", "2. {$menu3[1]->nama_value}");
                    $sheet->mergeCells("A$row:D$row");
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    $sheet->setCellValue("A$row", $form_a->tugas_tambahan ?? 'Nilai Belum Di Isi !');
                    $sheet->setCellValue("B$row", $form_a->hasil_tgs_tambahan ?? 'Nilai Belum Di Isi !');
                    $sheet->setCellValue("C$row", $form_a->persen_tambahan ?? '0');
                    $sheet->setCellValue("D$row", $form_a->deviasi_tambahan ?? 'Nilai Belum Di Isi !');
                    $row++;

                    // *Menambahkan Border ke Tugas Tambahan*
                    $sheet->getStyle("A" . ($row - 2) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                }


                // Kesimpulan
                if (!empty($menu4) && isset($menu4[1]->description)) {
                    $row += 1;
                    $sheet->setCellValue("A$row", $menu4[1]->nama_value);
                    $sheet->mergeCells("A$row:D$row");
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    $descriptionText = $menu4[1]->description ?? ''; // Pastikan variabel selalu ada
                    $sheet->setCellValue("A$row", $descriptionText);
                    $sheet->mergeCells("A$row:D$row");
                    $sheet->getStyle("A$row")->getAlignment()->setWrapText(true);

                    // Hitung tinggi baris berdasarkan jumlah karakter
                    $textLength = strlen($descriptionText);
                    $estimatedHeight = ceil($textLength / 50) * 6; // Estimasi tinggi berdasarkan panjang teks
                    $sheet->getRowDimension($row)->setRowHeight($estimatedHeight);

                    $row++;

                    $sheet->setCellValue("A$row", $form_b->kesimpulan ?? 'Nilai Belum Di Isi !');
                    $sheet->mergeCells("A$row:D" . ($row + 1));
                    $sheet->getStyle("A$row")->getAlignment()->setWrapText(true);

                    // Hitung tinggi baris berdasarkan jumlah karakter
                    $textLength = strlen($descriptionText);
                    $estimatedHeight = ceil($textLength / 50) * 6; // Estimasi tinggi berdasarkan panjang teks
                    $sheet->getRowDimension($row)->setRowHeight($estimatedHeight);
                    $row += 2;

                    // Menambahkan Border ke Kesimpulan
                    $sheet->getStyle("A" . ($row - 4) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                }

                // penjelasan
                if (!empty($menu4)) {
                    $row += 1;
                    $sheet->setCellValue("A$row", $menu4[0]->nama_value);
                    $sheet->mergeCells("A$row:D$row");
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    $sheet->setCellValue("A$row", $menu4[0]->description);
                    $sheet->mergeCells("A$row:D$row");
                    $row++;

                    $sheet->setCellValue("A$row", $form_b->penjelasan ?? 'Nilai Belum Di Isi !');
                    $sheet->mergeCells("A$row:D" . ($row + 1));
                    $sheet->getStyle("A$row")->getAlignment()->setWrapText(true);

                    // Hitung tinggi baris berdasarkan jumlah karakter
                    $textLength = strlen($descriptionText);
                    $estimatedHeight = ceil($textLength / 50) * 6; // Estimasi tinggi berdasarkan panjang teks
                    $sheet->getRowDimension($row)->setRowHeight($estimatedHeight);
                    $row += 2;

                    // *Menambahkan Border ke Kesimpulan*
                    $sheet->getStyle("A" . ($row - 4) . ":D" . ($row - 1))->applyFromArray($thickBorder);
                }


                // *Pendapat / Komentar*
                $row += 1;
                $sheet->setCellValue("A$row", 'PENDAPAT / KOMENTAR');
                $sheet->mergeCells("A$row:D$row");
                $sheet->getStyle("A$row")->getFont()->setBold(true);
                $row++;

                if (!empty($menu6)) {
                    $sheet->setCellValue("A$row", "1. {$menu6[0]->nama_value}");
                    $sheet->mergeCells("A$row:D$row");
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    $sheet->setCellValue("A$row", 'Mintakan pendapat/komentar karyawan yang dinilai atas seluruh hasil penilaian tersebut di atas.');
                    $sheet->mergeCells("A$row:D" . ($row + 1));
                    $row += 2;

                    $sheet->setCellValue("A$row", $feedback_karyawan->isi_feedback ?? 'Nilai Belum Di Isi !');
                    $sheet->mergeCells("A$row:D" . ($row + 1));
                    $row += 2;

                    $sheet->setCellValue("A$row", "2. {$menu6[1]->nama_value}");
                    $sheet->mergeCells("A$row:D$row");
                    $sheet->getStyle("A$row")->getFont()->setBold(true);
                    $row++;

                    $sheet->setCellValue("A$row", $feedback_atasan->isi_feedback ?? 'Nilai Belum Di Isi !');
                    $sheet->mergeCells("A$row:D" . ($row + 1));
                    $row += 1;

                    // *Menambahkan Border ke Pendapat*
                    $sheet->getStyle("A" . ($row - 8) . ":D$row")->applyFromArray($thickBorder);
                }

                // Set nama file
                $filename = "Laporan_Penilaian_$nrp.xlsx";

                if (ob_get_contents()) {
                    ob_end_clean();
                }

                // Simpan dan download file
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit;
            }
        }
    }
}
