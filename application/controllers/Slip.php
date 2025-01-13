<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Slip extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load library FPDF
        $this->load->library('fpdf');
    }

    public function index()
    {
        //$logged_in          = $this->session->userdata('logged_in');
        //if($logged_in != TRUE || empty($logged_in))
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $d['class']     = '';
            $d['header']    = 'Slip';
            $d['content']   = 'slip/index.php';
            $this->load->view('master', $d);
        }
    }

    public function entry()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $bulan          = $this->input->get('bulan');
            $d['bulan']     = $bulan;
            $d['data']      = $this->master_model->list_slip_gaji($bulan);
            $d['header']    = 'Data Slip Gaji | ' . $bulan;
            $d['content']   = 'slip/entry';
            $this->load->view('member', $d);
        }
    }

    public function upload_gaji()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $bulan          = $this->input->post('bulan');
            date_default_timezone_set('Asia/Jakarta');
            $config['upload_path'] = 'assets/';
            $config['allowed_types'] = '*';
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_excel')) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('errornya' => $this->upload->display_errors());
                print_r($error);
            } else {
                // jika berhasil upload ambil data dan masukkan ke database
                $upload_data = $this->upload->data();
            }
            $inputFileName = 'assets/' . $upload_data['file_name'];
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE
                );
                $data = array(
                    "nig"                   => $rowData[0][0],
                    "nama_guru"             => $rowData[0][1],
                    "gapok"                 => $rowData[0][2],
                    "tpt"                   => $rowData[0][3],
                    "jabatan"               => $rowData[0][4],
                    "jht"                   => $rowData[0][5],
                    "bpjs"                  => $rowData[0][6],
                    "transport"             => $rowData[0][7],
                    "tahsin"                => $rowData[0][8],
                    "ko_bhs"                => $rowData[0][9],
                    "k_jilid"               => $rowData[0][10],
                    "sat"                   => $rowData[0][11],
                    "piket"                 => $rowData[0][12],
                    "pengganti_pelajaran"   => $rowData[0][13],
                    "jht_2"                 => $rowData[0][14],
                    "bpjs_2"                => $rowData[0][15],
                    "eskul"                 => $rowData[0][16],
                    "pinj_yayasan"          => $rowData[0][17],
                    "koperasi"              => $rowData[0][18],
                    "pinj_koperasi"         => $rowData[0][19],
                    "pembinaan_tahfidz"     => $rowData[0][20],
                    "pph"                   => $rowData[0][21],
                    "qurban"                => $rowData[0][22],
                    "dll"                   => $rowData[0][23],
                    "bulan"                 => $bulan,
                );
                $nig = $data['nig'];
                $id['nig'] = "$nig";
                $q = $this->db->get_where('trans_slip', $id);
                if ($q->num_rows() > 0) {
                    $this->db->update('trans_slip', $data, $id);
                } else {
                    $this->db->insert('trans_slip', $data);
                }
            }
            // hapus file
            unlink($inputFileName);
            $this->session->set_flashdata('msg', 'Upload Slip Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function sample_upload()
    {
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'assets/upload_gaji/sample_gaji2.xlsx');
        $name = "sample_upload_gaji_guru.xlsx";

        force_download($name, $data);
    }

    public function detail_slip($id_slip)
    {
        $masuk = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $detail_k = $this->master_model->gaji($id_slip);

            if ($detail_k && $detail_k->num_rows() > 0) {
                $detail = $detail_k->row_array();
                echo json_encode($detail);
            } else {
                echo json_encode(['error' => 'Data tidak ditemukan']);
            }
        }
    }

    public function edit_gaji()
    {
        $id['id_slip']   = $this->input->post('cari');

        $q      = $this->db->get_where("trans_slip", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_slip']               = $dt->id_slip;
                $d['nama_guru']             = $dt->nama_guru;
                $d['jabatan']               = $dt->jabatan;
                $d['nig']                   = $dt->nig;
                $d['gapok']                 = $dt->gapok;
                $d['tpt']                   = $dt->tpt;
                $d['jht']                   = $dt->jht;
                $d['bpjs']                  = $dt->bpjs;
                $d['transport']             = $dt->transport;
                $d['tahsin']                = $dt->tahsin;
                $d['ko_bhs']                = $dt->ko_bhs;
                $d['k_jilid']               = $dt->k_jilid;
                $d['sat']                   = $dt->sat;
                $d['piket']                 = $dt->piket;
                $d['pengganti_pelajaran']   = $dt->pengganti_pelajaran;
                $d['eskul']                 = $dt->eskul;
                $d['pembinaan_tahfidz']     = $dt->pembinaan_tahfidz;
                $d['jht_2']                 = $dt->jht_2;
                $d['bpjs_2']                = $dt->bpjs_2;
                $d['pinj_yayasan']          = $dt->pinj_yayasan;
                $d['koperasi']              = $dt->koperasi;
                $d['pinj_koperasi']         = $dt->pinj_koperasi;
                $d['pph']                   = $dt->pph;
                $d['qurban']                = $dt->qurban;
                $d['dll']                   = $dt->dll;
            }
            echo json_encode($d);
        } else {
            $d['id_slip']               = '';
            $d['nama_guru']             = '';
            $d['jabatan']               = '';
            $d['nig']                   = '';
            $d['gapok']                 = '';
            $d['tpt']                   = '';
            $d['jht']                   = '';
            $d['bpjs']                  = '';
            $d['transport']             = '';
            $d['tahsin']                = '';
            $d['ko_bhs']                = '';
            $d['k_jilid']               = '';
            $d['sat']                   = '';
            $d['piket']                 = '';
            $d['pengganti_pelajaran']   = '';
            $d['eskul']                 = '';
            $d['pembinaan_tahfidz']     = '';
            $d['jht_2']                 = '';
            $d['bpjs_2']                = '';
            $d['pinj_yayasan']          = '';
            $d['koperasi']              = '';
            $d['pinj_koperasi']         = '';
            $d['pph']                   = '';
            $d['qurban']                = '';
            $d['dll']                   = '';
            echo json_encode($d);
        }
    }

    public function simpan_edit_slip()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $id['id_slip']               = $this->input->post('id_slip');
            $dt['nama_guru']             = $this->input->post('nama_guru');
            $dt['jabatan']               = $this->input->post('jabatan');
            $dt['nig']                   = $this->input->post('nig');
            $dt['gapok']                 = $this->input->post('gapok');
            $dt['tpt']                   = $this->input->post('tpt');
            $dt['jht']                   = $this->input->post('jht');
            $dt['bpjs']                  = $this->input->post('bpjs');
            $dt['transport']             = $this->input->post('transport');
            $dt['tahsin']                = $this->input->post('tahsin');
            $dt['ko_bhs']                = $this->input->post('ko_bhs');
            $dt['k_jilid']               = $this->input->post('k_jilid');
            $dt['sat']                   = $this->input->post('sat');
            $dt['piket']                 = $this->input->post('piket');
            $dt['pengganti_pelajaran']   = $this->input->post('pengganti_pelajaran');
            $dt['eskul']                 = $this->input->post('eskul');
            $dt['pembinaan_tahfidz']     = $this->input->post('pembinaan_tahfidz');
            $dt['jht_2']                 = $this->input->post('jht_2');
            $dt['bpjs_2']                = $this->input->post('bpjs_2');
            $dt['pinj_yayasan']          = $this->input->post('pinj_yayasan');
            $dt['koperasi']              = $this->input->post('koperasi');
            $dt['pinj_koperasi']         = $this->input->post('pinj_koperasi');
            $dt['pph']                   = $this->input->post('pph');
            $dt['qurban']                = $this->input->post('qurban');
            $dt['dll']                   = $this->input->post('dll');
            $this->db->update("trans_slip", $dt, $id);
            $this->session->set_flashdata('msg', 'Slip Berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function download_data_slip($bulan)
    {
        $pdf = new FPDF('p', 'mm', 'A4');
        $this->db->order_by('nama_guru', 'ASC');
        $data = $this->db->from('trans_slip')
            ->where('bulan', $bulan)
            ->get()
            ->result();
        foreach ($data as $row) {
            $total_induksi = $row->gapok + $row->tpt + $row->jht + $row->bpjs + $row->transport + $row->tahsin + $row->ko_bhs + $row->k_jilid + $row->sat + $row->piket + $row->pengganti_pelajaran + $row->eskul + $row->pembinaan_tahfidz;

            $total_deduksi = $row->jht_2 + $row->bpjs_2 + $row->pinj_yayasan + $row->koperasi  + $row->pinj_koperasi + $row->pph + $row->qurban + $row->dll;

            $total_diterima = $total_induksi + $total_deduksi;

            $pdf->AddPage();
            $pdf->image('assets/img/NURUL-FAJRI.png', 20, 5, 18, 18);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 7, 'SLIP GAJI GURU', 0, 1, 'C');
            $pdf->Cell(0, 7, 'SEKOLAH ISLAM TERPADU NURUL FAZRI', 0, 1, 'C');
            $pdf->Line(200, 25, 10, 25);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Cell(0, 5, 'TANDA TERIMA PERNGHASILAN : Bulan' .  $bulan, 0, 1);
            $pdf->Ln(5);

            $pdf->Cell(20, 5, 'Nama Guru', 0, 0);
            $pdf->SetFont('Arial', '', 12);

            // Menyimpan posisi X saat ini
            $current_x = $pdf->GetX();
            $current_y = $pdf->GetY();

            // Menentukan lebar untuk kolom nama
            $nama_width = 42;

            // Mengatur cell untuk nama
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->MultiCell($nama_width, 5, ': ' . $row->nama_guru, 0, 'L');

            // Mengatur posisi kembali ke kanan
            $pdf->SetXY($current_x + $nama_width + 30, $current_y); // Menambahkan jarak antara nama dan NIG

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Cell(20, 5, 'Nig', 0, 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(20, 5, ': ' . $row->nig, 0, 1); // Gunakan 1 untuk line break

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'b', 12);

            $pdf->Cell(60, 5, 'INDUKSI :', 0, 1);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Gaji Pokok ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->gapok), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tunjangan Jabatan ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->jabatan), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tunjangan Pegawai Tetap', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->tpt), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, '(JHT)/(JP) ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->jht), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'BPJS Kes/Jkm/JKK ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->bpjs), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Transport ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->transport), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tahsin', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->tahsin), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Koordinator Bahasa ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->ko_bhs), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Kenaikan Jilid ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->k_jilid), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Sumatif Akhir Tahun (SAT) ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->sat), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Piket', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->piket), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pengganti Pelajaran ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->pengganti_pelajaran), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Eskul', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->eskul), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pembinaan Tahfidz', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->pembinaan_tahfidz), 0, 1);

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Ln(3);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Total Induksi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($total_induksi), 0, 1);

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Ln(3);
            $pdf->Cell(60, 5, 'DEDUKSI :', 0, 1);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, '(JHT)/(JP)', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->jht_2) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'BPJS Kes/Jkm/JKK', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->bpjs_2) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pinjaman Yayasan', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->pinj_yayasan) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Koperasi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->koperasi) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pinjaman Koperasi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->pinj_koperasi) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'PPH-21', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->pph) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tabungan Qurban', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->qurban) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Dan Lain-Lain', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->dll) . '', 0, 1);

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Ln(3);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Total Deduksi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($total_deduksi), 0, 1);


            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'TOTAL DITERIMA', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($total_diterima) . '', 0, 1);
            $pdf->Cell(135, 5, '_________________________________________________________________________________', 0, 0);
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(135, 5, 'Bekasi, ' . $this->master_model->tgl_indo(date('Y-m-d')) . '', 0, 0);
            $pdf->Cell(60, 5, 'Mengetahui,', 0, 1);
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(135, 5, '(_________________)', 0, 0);
            $pdf->Cell(60, 5, 'Bendahara Yayasan', 0, 1);
        }
        $pdf->Output('Gaji_Guru' . $this->master_model->tgl_indo(date('Y-m')) . '.pdf', 'D');
    }

    public function download_data_slip_dtl($id_slip)
    {
        $pdf = new FPDF('p', 'mm', 'A4');

        $this->db->from('trans_slip');
        $this->db->where('id_slip', $id_slip);
        $this->db->order_by('nama_guru', 'ASC');
        $query = $this->db->get();
        $data = $query->result();

        $date = date('M-Y');
        $date1 = date('d-M-Y');
        foreach ($data as $row) {
            $total_induksi = $row->gapok + $row->tpt + $row->jht + $row->bpjs + $row->transport + $row->tahsin + $row->ko_bhs + $row->k_jilid + $row->sat + $row->piket + $row->pengganti_pelajaran + $row->eskul + $row->pembinaan_tahfidz;

            $total_deduksi = $row->jht_2 + $row->bpjs_2 + $row->pinj_yayasan + $row->koperasi  + $row->pinj_koperasi + $row->pph + $row->qurban + $row->dll;

            $total_diterima = $total_induksi + $total_deduksi;

            $pdf->AddPage();
            $pdf->image('assets/img/NURUL-FAJRI.png', 20, 5, 18, 18);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 7, 'SLIP GAJI GURU', 0, 1, 'C');
            $pdf->Cell(0, 7, 'SEKOLAH ISLAM TERPADU NURUL FAZRI', 0, 1, 'C');
            $pdf->Line(200, 25, 10, 25);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Cell(0, 5, 'TANDA TERIMA PENGHASILAN : Bulan' . $this->master_model->tgl_indo(date('Y-m')), 0, 1);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'b', 12);

            $pdf->Cell(20, 5, 'Nama Guru', 0, 0);
            $pdf->SetFont('Arial', '', 12);

            // Menyimpan posisi X saat ini
            $current_x = $pdf->GetX();
            $current_y = $pdf->GetY();

            // Menentukan lebar untuk kolom nama
            $nama_width = 42;

            // Mengatur cell untuk nama
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->MultiCell($nama_width, 5, ': ' . $row->nama_guru, 0, 'L');

            // Mengatur posisi kembali ke kanan
            $pdf->SetXY($current_x + $nama_width + 30, $current_y); // Menambahkan jarak antara nama dan NIG

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Cell(20, 5, 'Nig', 0, 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(20, 5, ': ' . $row->nig, 0, 1); // Gunakan 1 untuk line break

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'b', 12);

            $pdf->Cell(60, 5, 'INDUKSI :', 0, 1);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Gaji Pokok ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->gapok), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tunjangan Jabatan ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->jabatan), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tunjangan Pegawai Tetap', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->tpt), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, '(JHT)/(JP) ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->jht), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'BPJS Kes/Jkm/JKK ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->bpjs), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Transport ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->transport), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tahsin', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->tahsin), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Koordinator Bahasa ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->ko_bhs), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Kenaikan Jilid ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->k_jilid), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Sumatif Akhir Tahun (SAT) ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->sat), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Piket', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->piket), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pengganti Pelajaran ', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->pengganti_pelajaran), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Eskul', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->eskul), 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pembinaan Tahfidz', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($row->pembinaan_tahfidz), 0, 1);

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Ln(3);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Total Induksi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($total_induksi), 0, 1);

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Ln(3);
            $pdf->Cell(60, 5, 'DEDUKSI :', 0, 1);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, '(JHT)/(JP)', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->jht_2) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'BPJS Kes/Jkm/JKK', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->bpjs_2) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pinjaman Yayasan', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->pinj_yayasan) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Koperasi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->koperasi) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Pinjaman Koperasi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->pinj_koperasi) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'PPH-21', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->pph) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Tabungan Qurban', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->qurban) . '', 0, 1);

            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Dan Lain-Lain', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($row->dll) . '', 0, 1);

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Ln(3);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'Total Deduksi', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(50, 5, ': Rp.' . number_format($total_deduksi), 0, 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'b', 12);
            $pdf->Cell(20, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, 'TOTAL DITERIMA', 0, 0);
            $pdf->Cell(10, 5, '', 0, 0); // Menambahkan Cell kosong untuk memberi jarak
            $pdf->Cell(60, 5, ': Rp.' . number_format($total_diterima) . '', 0, 1);
            $pdf->Cell(135, 5, '_________________________________________________________________________________', 0, 0);
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(135, 5, 'Bekasi, ' . $this->master_model->tgl_indo(date('Y-m-d')) . '', 0, 0);
            $pdf->Cell(60, 5, 'Mengetahui,', 0, 1);
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(135, 5, '(_________________)', 0, 0);
            $pdf->Cell(60, 5, 'Bendahara Yayasan', 0, 1);
        }
        $pdf->Output('Gaji_Guru - ' . ($row->nama_guru . ' -' . $this->master_model->tgl_indo(date('Y-m'))), 0, 1, '.pdf', 'D');
    }

    public function download_data_slip_dtl_json($id_slip)
    {
        // Mengambil data dari database
        $this->db->from('trans_slip');
        $this->db->where('id_slip', $id_slip);
        $this->db->order_by('nama_guru', 'ASC');
        $query = $this->db->get();
        $data = $query->result();

        // Memformat data ke dalam array yang sesuai
        $output = [];
        foreach ($data as $row) {
            $total_induksi = $row->gapok + $row->tpt + $row->jht + $row->bpjs + $row->transport + $row->tahsin + $row->ko_bhs + $row->k_jilid + $row->sat + $row->piket + $row->pengganti_pelajaran + $row->eskul + $row->pembinaan_tahfidz;
            $total_deduksi = $row->jht_2 + $row->bpjs_2 + $row->pinj_yayasan + $row->koperasi + $row->pinj_koperasi + $row->pph + $row->qurban + $row->dll;
            $total_diterima = $total_induksi + $total_deduksi;

            $output[] = [
                'nama_guru' => $row->nama_guru,
                'nig' => $row->nig,
                'induksi' => [
                    'gapok' => $row->gapok,
                    'jabatan' => $row->jabatan,
                    'tpt' => $row->tpt,
                    'jht' => $row->jht,
                    'bpjs' => $row->bpjs,
                    'transport' => $row->transport,
                    'tahsin' => $row->tahsin,
                    'ko_bhs' => $row->ko_bhs,
                    'k_jilid' => $row->k_jilid,
                    'sat' => $row->sat,
                    'piket' => $row->piket,
                    'pengganti_pelajaran' => $row->pengganti_pelajaran,
                    'eskul' => $row->eskul,
                    'pembinaan_tahfidz' => $row->pembinaan_tahfidz,
                    'total_induksi' => $total_induksi
                ],
                'deduksi' => [
                    'jht_2' => $row->jht_2,
                    'bpjs_2' => $row->bpjs_2,
                    'pinj_yayasan' => $row->pinj_yayasan,
                    'koperasi' => $row->koperasi,
                    'pinj_koperasi' => $row->pinj_koperasi,
                    'pph' => $row->pph,
                    'qurban' => $row->qurban,
                    'dll' => $row->dll,
                    'total_deduksi' => $total_deduksi
                ],
                'total_diterima' => $total_diterima,
                'tanggal' => $this->master_model->tgl_indo(date('Y-m-d'))
            ];
        }

        // Mengatur header untuk output JSON
        header('Content-Type: application/json');
        echo json_encode($output);
    }
}
