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
            $data = [
                'id_p_periode'    => $id_p_periode,
                'id_periode'      => $id_periode,
                'flag_penilaian'  => $flag_penilaian_selected,
                'nrp'             => $nrp,
                'id_jenis_form'   => $id_jenis_form,
                'flag_jenis_form' => $flag_jenis_form,
                'flag_Sent'       => 1,
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

    function download_data_pkk($nrp)
    {
        $logged_in          = $this->session->userdata('logged_in');
        $this->load->helpers('print_rekap_helper');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {

            $data   = $this->master_model->lap_nilai($nrp);
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
                $penilaian = $this->master_model->hasil_nilai($nrp);
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
                $pdf->MultiCell(190, 7, 'Atasan Langsung:
' . (isset($row->text_tambahan_atasan_langsung) ? $row->text_tambahan_atasan_langsung : 'Tidak Ada Data'), 1);
                $pdf->MultiCell(190, 7, 'Atasan Tidak Langsung:
' . (isset($row->text_tambahan_atasan_tidak_langsung) ? $row->text_tambahan_atasan_tidak_langsung : 'Tidak Ada Data'), 1);

                $pdf->Output('D', 'Laporan_Penilaian_Kel_1_2.pdf');
            } else {
                $this->session->set_flashdata('msg_error', 'Data karyawan tidak ada');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
