<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Karyawan extends CI_Controller
{
    private $db2;
    public function __construct()
    {
        parent::__construct();
        // $this->load->library(array('PHPExcel','PHPExcel/IOFactory', 'fpdf'));		
        // $this->db2 = $this->load->database('enterprise', TRUE);
    }

    public function master_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = '';
            $d['data']      = $this->enterprise_model->get_perusahaan();
            $d['header']    = 'Karyawan';
            $d['content']   = 'enterprise/karyawan/master_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function list_lokasi()
    {
        $id_perusahaan  = $this->input->post('id');
        $data           = $this->enterprise_model->list_lokasi($id_perusahaan)->result();
        echo (json_encode($data));
    }
    public function list_bagian()
    {
        $id_lokasi      = $this->input->post('id');
        $data           = $this->enterprise_model->list_bagian($id_lokasi)->result();
        echo (json_encode($data));
    }
    public function list_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
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
            $detail_pr      = $this->enterprise_model->get_detail_perusahaan($perusahaan);
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
                $detail_lk  = $this->enterprise_model->detail_lokasi($id_lokasi);
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
                $detail_bg  = $this->enterprise_model->detail_bagian($id_bagian);
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
            $d['content']   = 'enterprise/karyawan/list_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function view_karyawan($id_karyawan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_karyawan = $this->enterprise_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr    = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr    = '';
            }
            $d['id_k']      = $id_karyawan;
            $d['class']     = '';
            $d['header']    = 'View Karyawan | ' . $nama_kr;
            $d['content']   = 'enterprise/karyawan/view_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function edit_karyawan()
    {
        $id['id_karyawan']  = $this->input->post('id');
        $q      = $this->db->get_where("mst_karyawan", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_karyawan']       = $dt->id_karyawan;
                $d['nip']               = $dt->nip;
                $d['nama_lengkap']      = $dt->nama_lengkap;
                $d['badgenumber']       = $dt->badgenumber;
                $d['userid']            = $dt->userid;
                $d['no_telepon']        = $dt->no_telepon;
                $d['status']            = $dt->status;
            }
            echo json_encode($d);
        } else {
            $d['id_karyawan']       = '';
            $d['nip']               = '';
            $d['nama_lengkap']      = '';
            $d['badgenumber']       = '';
            $d['userid']            = '';
            $d['no_telepon']        = '';
            $d['status']            = '';
            echo json_encode($d);
        }
    }
    public function simpan_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_karyawan    = $this->input->post('id_karyawan');
            $detail_karyawan = $this->enterprise_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr    = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr    = '';
            }
            if ($id_karyawan == "" || empty($id_karyawan)) {
                $karyawan   = '0';
            } else {
                $karyawan   = $id_karyawan;
            }
            $id['id_karyawan']  = $karyawan;
            $dt['nama_lengkap'] = $this->input->post('nama_lengkap');
            $dt['nip']          = $this->input->post('nip');
            $dt['userid']       = $this->input->post('userid');
            $dt['badgenumber']  = $this->input->post('badgenumber');
            $dt['no_telepon']   = $this->input->post('no_telepon');
            $dt['status']       = $this->input->post('status');
            $dt['jenis_kelamin']       = $this->input->post('jenis_kelamin');

            $q = $this->db->get_where("mst_karyawan", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_karyawan", $dt, $id);
                $this->session->set_flashdata('msg', 'Karyawan ' . $nama_kr . ' Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_karyawan", $dt);
                $this->session->set_flashdata('msg', 'Karyawan ' . $nama_kr . ' Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function simpan_detail_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_karyawan']      = $this->input->post('id_karyawan');

            //profil
            //foto
            $lebar_gambar   = 640;
            $tinggi_gambar  = 480;
            $config['upload_path']          = './assets/karyawan/foto';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['encrypt_name']         = TRUE;
            //custom upload
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $gbr                            = $this->upload->data();
                if ($_FILES['image']['size'] >  100000) {
                    //convert
                    $config['image_library']    = 'gd2';
                    $config['source_image']     = './assets/karyawan/foto/' . $gbr['file_name'];
                    $config['create_thumb']     = FALSE;
                    $config['maintain_ratio']   = TRUE;
                    $config['quality']          = '100%';
                    $config['width']            = $lebar_gambar;
                    $config['height']           = $tinggi_gambar;
                    $config['new_image']        = './assets/karyawan/foto/' . $gbr['file_name'];
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $file_logo                  = './assets/karyawan/foto/' . $gbr['file_name'];
                    $dt['foto_file']            = $gbr['file_name'];
                } else {
                    $file_logo                  = './assets/karyawan/foto/' . $gbr['file_name'];
                    $dt['foto_file']            = $gbr['file_name'];
                }
                // encode
                $file_base64                    = base64_encode(file_get_contents($file_logo));
                $dt['foto_64']                  = $file_base64;
            }
            //
            $dt['status']       = $this->input->post('status');
            $dt['nip']          = $this->input->post('nip');

            $dt['nama_lengkap'] = $this->input->post('nama_lengkap');

            $dt['tempat_lahir'] = $this->input->post('tempat_lahir');
            $dt['tgl_lahir']    = $this->input->post('tanggal_lahir');
            $dt['jenis_kelamin'] = $this->input->post('jenis_kelamin');

            $dt['nama_ayah']    = $this->input->post('nama_ayah');
            $dt['nama_ibu']     = $this->input->post('nama_ibu');
            $dt['nama_pasangan'] = $this->input->post('nama_pasangan');
            $dt['nama_anak1']   = $this->input->post('nama_anak_1');
            $dt['nama_anak2']   = $this->input->post('nama_anak_2');
            $dt['nama_anak3']   = $this->input->post('nama_anak_3');
            $dt['hp_keluarga']  = $this->input->post('hp_keluarga');
            $dt['alamat_anak']  = $this->input->post('alamat_anak');
            $dt['alamat_pasangan']  = $this->input->post('alamat_pasangan');
            $dt['uk_baju']          = $this->input->post('uk_baju');
            $dt['uk_celana']        = $this->input->post('uk_celana');
            $dt['spv1']        = $this->input->post('spv1');
            $dt['spv2']        = $this->input->post('spv2');
            $dt['spv3']      = $this->input->post('spv3');
            $c = $this->db->get_where("mst_karyawan", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_karyawan", $dt, $id);
                $this->session->set_flashdata('msg', 'Karyawan ' . $this->input->post('nama_lengkap') . ' Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_karyawan", $dt);
                $this->session->set_flashdata('msg', 'Karyawan ' . $this->input->post('nama_lengkap') . ' Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function reset_password($id_karyawan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_karyawan    = $this->enterprise_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr        = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr        = '';
            }
            $id['id_karyawan']  = $id_karyawan;
            $dt['password']     = md5('1234');
            $this->db->update("mst_karyawan", $dt, $id);
            $this->session->set_flashdata('msg', 'Password Karyawan ' . $nama_kr . ' Sukses diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_karyawan($id_karyawan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_karyawan    = $this->enterprise_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr        = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr        = '';
            }
            $id['id_karyawan']  = $id_karyawan;
            $dt['flag_hapus']   = '1';
            $this->db->update("mst_karyawan", $dt, $id);
            $this->session->set_flashdata('msg', 'Karyawan ' . $nama_kr . ' dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function restore_karyawan($id_karyawan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_karyawan    = $this->enterprise_model->detail_karyawan($id_karyawan);
            if ($detail_karyawan->num_rows() > 0) {
                $nama_kr        = $detail_karyawan->row()->nama_lengkap;
            } else {
                $nama_kr        = '';
            }
            $id['id_karyawan']  = $id_karyawan;
            $dt['flag_hapus']   = '0';
            $this->db->update("mst_karyawan", $dt, $id);
            $this->session->set_flashdata('msg', 'Karyawan ' . $nama_kr . ' direstore');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function upload_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $jenis          = $this->input->post('jenis');
            $id_perusahaan  = $this->input->post('perusahaan');

            date_default_timezone_set('Asia/Jakarta');
            $config['upload_path']      = 'assets/';
            $config['allowed_types']    = '*';
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
                    "nip"               => $rowData[0][0],
                    "foto"               => $rowData[0][1],
                    "nama_lengkap"      => $rowData[0][2],
                    "jenis_kelamin"     => $rowData[0][3],
                    "tgl_lahir"         => $rowData[0][4],
                    "tgl_hire"          => $rowData[0][5],
                    "tgl_permanen"         => $rowData[0][6],
                    "status_jaya"        => $rowData[0][7],
                    "job_title"          => $rowData[0][8],
                    "department"         => $rowData[0][9],
                    "job_grade"         => $rowData[0][10],
                    "company"              => $rowData[0][11],
                    "spv1"                => $rowData[0][12],
                    "spv2"                => $rowData[0][13],
                    "spv3"              => $rowData[0][14],
                    "id_perusahaan"     => $id_perusahaan,
                    "jenis_karyawan"    => $jenis,
                    "password"          => md5($rowData[0][0]) //password = NRP
                );
                $nip           = $data['nip'];
                $id['nip']     = "$nip";
                $q = $this->db->get_where('mst_karyawan', $id);
                if ($q->num_rows() > 0) {
                    $this->db->update('mst_karyawan', $data, $id);
                } else {
                    $this->db->insert('mst_karyawan', $data);
                }
            }
            //hapus file
            unlink($inputFileName);
            $this->session->set_flashdata('msg', 'Upload Karyawan Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    function download_data_karyawan($id_perusahaan, $id_lokasi, $id_bagian, $jenis)
    {
        $logged_in          = $this->session->userdata('logged_in');
        $this->load->helpers('print_rekap_helper');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            if ($id_lokasi == '0') {
                $lokasi     = "";
            } else {
                $lokasi     = "AND a.id_lokasi = '$id_lokasi'";
            }

            if ($id_bagian == '0') {
                $bagian     = "";
            } else {
                $bagian     = "AND a.id_bagian = '$id_bagian'";
            }

            $data   = $this->enterprise_model->download_data_karyawan($id_perusahaan, $lokasi, $bagian, $jenis);
            if ($data->num_rows() > 0) {
                $pdf = new reportProduct();
                $pdf->setKriteria("cetak_laporan");
                $pdf->setNama("CETAK DATA KARYAWAN");
                $pdf->AliasNbPages();
                $pdf->AddPage("L", "A4");
                $A4[0] = 210;
                $A4[1] = 297;
                $Q[0] = 216;
                $Q[1] = 279;
                $pdf->SetTitle('LAPORAN DATA KARYAWAN');
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
                $pdf->Cell(300, 4, 'LAPORAN DATA KARYAWAN', 0, 0, 'C');
                $pdf->Cell(10, 4, '', 0, 1);
                $pdf->Ln(5);
                $w = array(10, 35, 30, 65, 20, 35);

                //Header
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell($w[0], $h, 'No', 1, 0, 'C');
                $pdf->Cell($w[4], $h, 'NRP / NIP', 1, 0, 'C');
                $pdf->Cell($w[5], $h, 'Nama Lengkap', 1, 0, 'C');
                $pdf->Cell($w[0], $h, 'Gender', 1, 0, 'C');
                $pdf->Cell($w[4], $h, 'Date of Birth', 1, 0, 'C');
                $pdf->Cell($w[4], $h, 'Date of Hire', 1, 0, 'C');
                if ($jenis == '1') {
                    // karyawan tetap
                    $pdf->Cell($w[5], $h, 'Date of Permanent', 1, 0, 'C');
                } elseif ($jenis == '2') {
                    $nama_jenis = 'Karyawan Borongan / Magang';
                } else {
                    $nama_jenis = 'Kontrak';
                }
                $pdf->Cell($w[4], $h, 'Status', 1, 0, 'C');

                if ($jenis == '1') {
                    // karyawan tetap
                    $pdf->Cell($w[5], $h, 'Job Grade', 1, 0, 'C');
                } elseif ($jenis == '2') {
                    $nama_jenis = 'Karyawan Borongan / Magang';
                } else {
                    $nama_jenis = 'Kontrak';
                    $pdf->Cell($w[3], $h, 'Job Grade', 1, 0, 'C');
                }
                $pdf->Cell($w[4], $h, 'Company', 1, 0, 'C');
                $pdf->Cell($w[4], $h, 'SPV1', 1, 0, 'C');
                $pdf->Cell($w[4], $h, 'SPV2', 1, 0, 'C');
                if ($jenis == '3') {

                    $pdf->Cell($w[4], $h, 'SPV3', 1, 0, 'C');
                } elseif ($jenis == '2') {
                    $nama_jenis = 'Karyawan Borongan / Magang';
                } else {
                    // $nama_jenis = 'Kontrak';
                }
                $pdf->Ln();

                $pdf->SetFont('Arial', '', 8);
                $pdf->SetFillColor(204, 204, 204);
                $pdf->SetTextColor(0);
                $fill = false;
                $no = 1;

                $kolom  = 2;
                foreach ($data->result() as $dt) {
                    $pdf->Cell($w[0], $h, $no, 'LR', 0, 'C', $fill);
                    $pdf->Cell($w[4], $h, $dt->nip, 'LR', 0, 'C', $fill);
                    $pdf->Cell($w[5], $h, $dt->nama_lengkap, 'LR', 0, 'C', $fill);
                    $pdf->Cell($w[0], $h, $dt->jenis_kelamin, 'LR', 0, 'C', $fill);
                    $pdf->Cell($w[4], $h, $dt->tgl_lahir, 'LR', 0, 'C', $fill);
                    $pdf->Cell($w[4], $h, $dt->tgl_hire, 'LR', 0, 'C', $fill);
                    if ($jenis == '1') {

                        $pdf->Cell($w[5], $h, $dt->tgl_permanen, 'LR', 0, 'C', $fill);
                    } elseif ($jenis == '2') {
                        $nama_jenis = 'Karyawan Borongan / Magang';
                    } else {
                        $nama_jenis = 'Kontrak';
                    }
                    $pdf->Cell($w[4], $h, $dt->status_jaya, 'LR', 0, 'C', $fill);

                    if ($jenis == '1') {
                        // karyawan tetap
                        $pdf->Cell($w[5], $h, $dt->job_grade, 'LR', 0, 'C', $fill);
                    } elseif ($jenis == '2') {
                        $nama_jenis = 'Karyawan Borongan / Magang';
                    } else {
                        $nama_jenis = 'Kontrak';
                        $pdf->Cell($w[3], $h, $dt->job_grade, 'LR', 0, 'C', $fill);
                    }
                    $pdf->Cell($w[4], $h, $dt->company, 'LR', 0, 'C', $fill);
                    $pdf->Cell($w[4], $h, $dt->spv1, 'LR', 0, 'C', $fill);
                    $pdf->Cell($w[4], $h, $dt->spv2, 'LR', 0, 'C', $fill);
                    if ($jenis == '3') {

                        $pdf->Cell($w[4], $h, $dt->spv3, 'LR', 0, 'C', $fill);
                    } elseif ($jenis == '2') {
                        $nama_jenis = 'Karyawan Borongan / Magang';
                    } else {
                        // $nama_jenis = 'Kontrak';
                    }
                    $pdf->Ln();
                    $fill = !$fill;
                    $no++;
                }
                $detail_pr      = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
                $nama_pr        = $detail_pr->row()->nama_perusahaan;
                if ($id_lokasi == '0') {
                    $detail_lk  = '';
                    $nama_lk    = '';
                } else {
                    $detail_lk  = $this->enterprise_model->detail_lokasi($id_lokasi);
                    $nama_lk    = $detail_lk->row()->nama_lokasi;
                }
                if ($id_bagian == '0') {
                    $detail_bg  = '';
                    $nama_bg    = '';
                } else {
                    $detail_bg  = $this->enterprise_model->detail_bagian($id_bagian);
                    $nama_bg    = $detail_bg->row()->nama_bagian;
                }

                if ($jenis == '1') {
                    $nama_jenis = 'Karyawan_Tetap';
                } else {
                    $nama_jenis = 'Karyawan_Kontrak';
                }
                $pdf->Cell(array_sum($w), 0, '', 'T');
                $pdf->Ln(10);
                $pdf->SetX(130);
                $pdf->Cell(100, $h, $this->master_model->tgl_indo(date('Y-m-d')), 'C');
                $pdf->Ln(20);
                $pdf->SetX(130);
                // $pdf->Cell(100,$h,'___________________','C');
                $pdf->Output('Karyawan_Data_' . $this->master_model->tgl_indo(date('Y-m-d')) . '.pdf', 'D');
            } else {
                $this->session->set_flashdata('msg_error', 'Data karyawan tidak ada');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    function download_data_karyawan_pdf($id_perusahaan, $id_lokasi, $id_bagian, $jenis)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            if ($id_lokasi == '0') {
                $lokasi     = "";
            } else {
                $lokasi     = "AND a.id_lokasi = '$id_lokasi'";
            }

            if ($id_bagian == '0') {
                $bagian     = "";
            } else {
                $bagian     = "AND a.id_bagian = '$id_bagian'";
            }

            $data   = $this->enterprise_model->download_data_karyawan($id_perusahaan, $lokasi, $bagian, $jenis);
            if ($data->num_rows() > 0) {
                $spreadsheet        = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', "NRP / NIP")
                    ->setCellValue('B1', "Foto")
                    ->setCellValue('C1', "Nama Lengkap")
                    ->setCellValue('D1', "Gender")
                    ->setCellValue('E1', "Date of Birth")
                    ->setCellValue('F1', "Date of Hire")
                    ->setCellValue('G1', "Date of Permanent")
                    ->setCellValue('H1', "Status")
                    ->setCellValue('I1', "Job Title")
                    ->setCellValue('J1', "Department")
                    ->setCellValue('K1', "Job Grade")
                    ->setCellValue('L1', "Company")
                    ->setCellValue('M1', "SPV1")
                    ->setCellValue('N1', "SPV2")
                    ->setCellValue('O1', "SPV3");
                // $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:AM1')->getFont()->setBold( true );
                // $spreadsheet->getActiveSheet()->getColumnDimension('A1:AM1')->setAutoSize(true);

                $kolom  = 2;
                foreach ($data->result() as $dt) {
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $dt->nip)
                        ->setCellValue('B' . $kolom, $dt->foto)
                        ->setCellValue('C' . $kolom, $dt->nama_lengkap)
                        ->setCellValue('D' . $kolom, $dt->jenis_kelamin)
                        ->setCellValue('E' . $kolom, $dt->tgl_lahir)
                        ->setCellValue('F' . $kolom, $dt->tgl_hire)
                        ->setCellValue('G' . $kolom, $dt->tgl_permanen)
                        ->setCellValue('H' . $kolom, $dt->status_jaya)
                        ->setCellValue('I' . $kolom, $dt->job_title)
                        ->setCellValue('J' . $kolom, $dt->department)
                        ->setCellValue('K' . $kolom, $dt->job_grade)
                        ->setCellValue('L' . $kolom, $dt->company)
                        ->setCellValue('M' . $kolom, $dt->spv1)
                        ->setCellValue('N' . $kolom, $dt->spv2)
                        ->setCellValue('O' . $kolom, $dt->spv3);

                    $kolom++;
                    $spreadsheet->getActiveSheet()->getStyle('A:AM')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()->getStyle('A2:AM2')->getAlignment()->setHorizontal('center');
                }
                $detail_pr      = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
                $nama_pr        = $detail_pr->row()->nama_perusahaan;
                if ($id_lokasi == '0') {
                    $detail_lk  = '';
                    $nama_lk    = '';
                } else {
                    $detail_lk  = $this->enterprise_model->detail_lokasi($id_lokasi);
                    $nama_lk    = $detail_lk->row()->nama_lokasi;
                }
                if ($id_bagian == '0') {
                    $detail_bg  = '';
                    $nama_bg    = '';
                } else {
                    $detail_bg  = $this->enterprise_model->detail_bagian($id_bagian);
                    $nama_bg    = $detail_bg->row()->nama_bagian;
                }

                if ($jenis == '1') {
                    $nama_jenis = 'Karyawan_Tetap';
                } else {
                    $nama_jenis = 'Karyawan_Kontrak';
                }
                //autosize
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                // redirect output to client browser    
                $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
                // header('Content-Type: application/vnd.ms-excel');
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Data Karyawan ' . $nama_jenis . '_' . $nama_pr . '.xlsx"');
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
    public function userid_karyawan($badgenumber)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['badgenumber'] = $badgenumber;
            $c = $this->db->get_where("userinfo_karyawan", $id);
            if ($c->num_rows() > 0) {
                $dt['userid']  = $c->row()->userid;
                $this->db->update("mst_karyawan", $dt, $id);

                $n = $this->db->get_where("mst_karyawan", $dt);
                $nm = $n->row()->nama_lengkap;
                $this->session->set_flashdata('msg', 'Userid ' . $nm . ' berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('msg_error', 'Userid di userinfo tidak ada');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function userid_karyawan_all($perusahaan, $lokasi, $bagian, $jenis)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            // jenis 1 = karyawan tetap, 2 = borongan
            if ($lokasi == '0') {
                $id_lokasi = "";
            } else {
                $id_lokasi = "AND id_lokasi = '$lokasi'";
            }

            if ($bagian == '0') {
                $id_bagian = "";
            } else {
                $id_bagian = "AND id_bagian = '$bagian'";
            }

            $data = $this->enterprise_model->list_badgenumber_karyawan($perusahaan, $id_lokasi, $id_bagian, $jenis);
            foreach ($data->result() as $dtk) {
                $id1['badgenumber'] = $dtk->badgenumber;
                $c = $this->db->get_where("userinfo_karyawan", $id1);
                if ($c->num_rows() > 0) {
                    $dt['userid']  = $c->row()->userid;
                    $this->db->update("mst_karyawan", $dt, $id1);
                } else {
                    $dt['userid']  = 0;
                    $this->db->update("mst_karyawan", $dt, $id1);
                }
            }
            $this->session->set_flashdata('msg', 'Userid berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function sample_kartap()
    {
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'assets/upload_kartap/sample_kartap.xlsx');
        $name = "upload_kartap.xlsx";

        force_download($name, $data);
    }

    public function sample_kontrak()
    {
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'assets/upload_kontrak/sample_kontrak.xlsx');
        $name = "upload_kontrak.xlsx";

        force_download($name, $data);
    }
}
