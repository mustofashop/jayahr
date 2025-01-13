<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Lap_inass extends CI_Controller
{
    public function index()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $d['header']    = 'Data Karyawan';
            $d['content']   = 'master/karyawan/index_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function list_ia()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {

            //AKSI
            $d['aksi1']     = '';
            $d['aksi2']     = '';
            $d['aksi3']     = '';
            $d['aksi4']     = '';
            $id_karyawan    = $this->session->userdata('id_karyawan');
            $aksi           = $this->master_model->list_aksi($id_karyawan);
            if ($aksi->num_rows() > 0) {
                foreach ($aksi->result() as $a) {
                    $d['aksi' . $a->aksi]  = $a->aksi;
                }
            }

            $d['header']    = 'Laporan Pengisian Internal Assessment';
            $d['content']   = 'laporan/inass/list_member';
            $this->load->view('member', $d);
        }
    }
    public function tambah_karyawan($kategori, $lokasi)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $d['kategori']  = $kategori;
            $d['lokasi']    = $lokasi;
            $d['header']    = 'Tambah Karyawan';
            $d['content']   = 'master/karyawan/tambah_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function list_bagian()
    {
        $id_lokasi  = $this->input->post('id');
        $bagian     = $this->master_model->list_bagian_lokasi($id_lokasi)->result();
        echo (json_encode($bagian));
    }
    public function edit_karyawan($id_karyawan, $kategori, $lokasi)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $detail_k       = $this->master_model->detail_karyawan($id_karyawan);
            $nama_k         = $detail_k->row()->nama_lengkap;
            $d['id_k']      = $id_karyawan;
            $d['kategori']  = $kategori;
            $d['lokasi']    = $lokasi;
            $d['header']    = 'Edit Karyawan | ' . $nama_k;
            $d['content']   = 'master/karyawan/edit_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function lihat_karyawan($id_karyawan, $kategori, $lokasi)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $detail_k       = $this->master_model->detail_karyawan($id_karyawan);
            $nama_k         = $detail_k->row()->nama_lengkap;
            $d['id_k']      = $id_karyawan;
            $d['kategori']  = $kategori;
            $d['lokasi']    = $lokasi;
            $d['header']    = 'Lihat Karyawan | ' . $nama_k;
            $d['content']   = 'master/karyawan/lihat_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function simpan_karyawan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $id_karyawan    = $this->input->post('id_karyawan');
            if (empty($id_karyawan)) {
                $id['id_karyawan']  = '0';
            } else {
                $id['id_karyawan']  = $id_karyawan;
            }

            //foto
            $lebar_gambar       = 640;
            $tinggi_gambar      = 480;

            $config['upload_path']          = './assets/foto_karyawan/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['encrypt_name']         = TRUE;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $gbr                            = $this->upload->data();
                if ($_FILES['image']['size'] >  100000) {
                    $config['image_library']    = 'gd2';
                    $config['source_image']     = './assets/foto_karyawan/' . $gbr['file_name'];
                    $config['create_thumb']     = FALSE;
                    $config['maintain_ratio']   = TRUE;
                    $config['quality']          = '100%';
                    $config['width']            = $lebar_gambar;
                    $config['height']           = $tinggi_gambar;
                    $config['new_image']        = './assets/foto_karyawan/' . $gbr['file_name'];
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $foto_profil                = './assets/foto_karyawan/' . $gbr['file_name'];
                    $dt['foto_file']            = $gbr['file_name'];
                } else {
                    $foto_profil                = './assets/foto_karyawan/' . $gbr['file_name'];
                    $dt['foto_file']            = $gbr['file_name'];
                }
                // encode
                $file_base64                    = base64_encode(file_get_contents($foto_profil));
                $dt['foto_64']                  = $file_base64;
                // unlink($foto_profil);
            }
            //end foto
            $dt['nip']          = $this->input->post('nip');
            $dt['badgenumber']  = $this->input->post('badgenumber');
            $dt['nama_lengkap'] = $this->input->post('nama_lengkap');
            $dt['id_lokasi']    = $this->input->post('lokasi');
            $dt['id_bagian']    = $this->input->post('bagian');
            $dt['tempat_lahir'] = $this->input->post('tempat_lahir');
            if (empty($this->input->post('tanggal_lahir'))) {
                $dt['tgl_lahir'] = '1990-01-01';
            } else {
                $dt['tgl_lahir'] = $this->input->post('tanggal_lahir');
            }
            $dt['jenis_kelamin'] = $this->input->post('jenis_kelamin');
            $dt['status_nikah'] = $this->input->post('status_nikah');
            $dt['pendidikan']   = $this->input->post('pendidikan');
            $dt['alamat']       = $this->input->post('alamat');
            $dt['domisili']     = $this->input->post('domisili');
            $dt['kode_pos']     = $this->input->post('kode_pos');
            $dt['kelurahan']    = $this->input->post('kelurahan');
            $dt['kecamatan']    = $this->input->post('kecamatan');
            $dt['kota']         = $this->input->post('kota');
            $dt['provinsi']     = $this->input->post('provinsi');
            $dt['no_telepon']   = $this->input->post('telepon');
            $dt['no_wa']        = $this->input->post('wa');
            $dt['email']        = $this->input->post('email');
            $dt['gol_darah']    = $this->input->post('gol_darah');
            $dt['npwp']         = $this->input->post('npwp');
            $dt['ktp']          = $this->input->post('ktp');
            $dt['bpjskes']      = $this->input->post('bpjsk');
            $dt['bpjstk']       = $this->input->post('bpjstk');
            $dt['nama_ayah']    = $this->input->post('nama_ayah');
            $dt['nama_ibu']     = $this->input->post('nama_ibu');
            $dt['nama_pasangan'] = $this->input->post('nama_pasangan');
            $dt['nama_anak1']   = $this->input->post('nama_anak1');
            $dt['nama_anak2']   = $this->input->post('nama_anak2');
            $dt['nama_anak3']   = $this->input->post('nama_anak3');
            $dt['hp_keluarga']  = $this->input->post('no_keluarga');
            $dt['alamat_anak']  = $this->input->post('alamat_anak');
            $dt['alamat_pasangan']  = $this->input->post('alamat_pasangan');
            $dt['uk_baju']      = $this->input->post('ukuran_baju');
            $dt['uk_celana']    = $this->input->post('ukuran_celana');
            $dt['uk_sepatu']    = $this->input->post('ukuran_sepatu');
            $dt['nama_bank']    = $this->input->post('nama_bank');
            $dt['no_rekening']  = $this->input->post('no_rekening');
            $c  = $this->db->get_where("mst_karyawan", $id);
            if ($c->num_rows() > 0) {
                $dt['status']   = $this->input->post('status');
                $this->db->update("mst_karyawan", $dt, $id);
                $this->session->set_flashdata('msg', 'Karyawan Berhasil diubah');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $dt['password']         = md5('1234');
                $dt['id_perusahaan']    = $this->session->userdata('id_perusahaan');
                $dt['jenis_karyawan']   = $this->input->post('kategori');
                $this->db->insert("mst_karyawan", $dt);
                $this->session->set_flashdata('msg', 'Karyawan Berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function hapus_karyawan($id_karyawan)
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $detail_k           = $this->master_model->detail_karyawan($id_karyawan);
            $nama_k             = $detail_k->row()->nama_lengkap;
            $id['id_karyawan']  = $id_karyawan;
            $dt['flag_hapus']   = '1';
            $this->db->update("mst_karyawan", $dt, $id);
            $this->session->set_flashdata('msg_error', 'Karyawan ' . $nama_k . ' Berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function download_inass_belum()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {

            //$data   = $this->enterprise_model->download_data_karyawan($id_perusahaan,$lokasi,$bagian,$jenis);
            $thn = '2023';
            $data   = $this->master_model->list_idp_belum($thn);
            if ($data->num_rows() > 0) {
                $spreadsheet        = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', "NRP")
                    ->setCellValue('B1', "Nama Karyawan")
                    ->setCellValue('C1', "Status")
                    ->setCellValue('D1', "Job Grade")
                    ->setCellValue('E1', "Unit Kerja")
                    ->setCellValue('F1', "Tanggal Hire")
                    ->setCellValue('G1', "SPV 1")
                    ->setCellValue('H1', "SPV 2")
                    ->setCellValue('I1', "SPV 3");
                // $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:AM1')->getFont()->setBold( true );
                // $spreadsheet->getActiveSheet()->getColumnDimension('A1:AM1')->setAutoSize(true);

                $kolom  = 2;
                foreach ($data->result() as $dt) {
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $dt->nip)
                        ->setCellValue('B' . $kolom, $dt->nama_lengkap)
                        ->setCellValue('C' . $kolom, $dt->status_jaya)
                        ->setCellValue('D' . $kolom, $dt->job_grade)
                        ->setCellValue('E' . $kolom, $dt->department)
                        ->setCellValue('F' . $kolom, $dt->tgl_hire)
                        ->setCellValue('G' . $kolom, $dt->spv1)
                        ->setCellValue('H' . $kolom, $dt->spv2)
                        ->setCellValue('I' . $kolom, $dt->spv3);

                    $kolom++;
                    $spreadsheet->getActiveSheet()->getStyle('A:AM')->getAlignment()->setHorizontal('center');
                    $spreadsheet->getActiveSheet()->getStyle('A2:AM2')->getAlignment()->setHorizontal('center');
                }
                //autosize
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                // redirect output to client browser    
                $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
                // header('Content-Type: application/vnd.ms-excel');
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Belum_Isi_IDP.xlsx"');
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
                $this->session->set_flashdata('msg_error', 'Data tidak ada');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function rekap_ia()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if ($masuk != TRUE) {
            redirect(base_url('login'));
        } else {
            $bagian         = $this->session->userdata('department');
            $id_karyawan    = $this->session->userdata('id_karyawan');
            $level          = $this->session->userdata('level');
            $unit           = $this->master_model->list_unit($level);
            $unit2          = $this->master_model->list_unit2($bagian, $id_karyawan, $level);
            $d['unit']      = $unit;
            $d['unit2']     = $unit2;
            $d['class']     = '';
            $d['header']    = 'Rekap Internal Assessment (Pilih Tahun & Unit)';
            $d['content']   = 'laporan/inass/frekap_ia';
            $this->load->view('master', $d);
        }
    }
}
