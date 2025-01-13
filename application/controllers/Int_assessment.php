<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Int_assessment extends CI_Controller
{
	public function index()
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$d['header']    = 'Internal Assessment';
			$d['content']   = 'master/inass/index_inass';
			$this->load->view('master', $d);
		}
	}
	public function list_inass()
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$this->load->library('session');
			$no = 1;
			$id_iassx = 1;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {
				$this->session->unset_userdata('selected_inass11' . $no);
				$no++;
			}

			$no = 1;
			$id_iassx = 2;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {
				$this->session->unset_userdata('selected_inass10' . $no);
				$no++;
			}

			$no = 1;
			$id_iassx = 3;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {
				$this->session->unset_userdata('selected_inass9' . $no);
				$no++;
			}

			$no = 1;
			$id_iassx = 4;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {
				$this->session->unset_userdata('selected_inass8' . $no);
				$no++;
			}

			$no = 1;
			$id_iassx = 5;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {
				$this->session->unset_userdata('selected_inass7' . $no);
				$no++;
			}

			$no = 1;
			$id_iassx = 2;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {
				$this->session->unset_userdata('selected_inass6' . $no);
				$no++;
			}
			//Inass 2, ke-3
			$no = 1;
			$id_iassx = 3;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {
				$this->session->unset_userdata('selected_inass5' . $no);
				$no++;
			}
			//Inass 2, ke-4
			$no = 1;
			$id_iassx = 4;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {
				$this->session->unset_userdata('selected_inass4' . $no);
				$no++;
			}
			//Inass 2, ke-5
			$no = 1;
			$id_iassx = 5;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {
				$this->session->unset_userdata('selected_inass3' . $no);
				$no++;
			}
			//Inass 2, ke-6
			$no = 1;
			$id_iassx = 6;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {
				$this->session->unset_userdata('selected_inass2' . $no);
				$no++;
			}
			$this->session->unset_userdata('selected_inass1');
			$this->session->unset_userdata('selected_inass');
			$tahun   = $this->input->get('tahun');
			$d['tahun']     = $tahun;
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

			$d['header']    = 'List Sub Ordinate | Internal Assessment | ' . $tahun;
			$d['content']   = 'master/inass/list_inass';
			$this->load->view('master', $d);
		}
	}
	public function sent_inass($tahun, $nrp, $nrp2)
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$id2['tahun']            = $tahun;
			$id2['nrp']            = $nrp;
			$id2['insert_by']          = $nrp2;
			$dt2['flag_sent']          = 1;
			$dt2['sent_date']          = date("Y-m-d");
			$this->db->update("trans_inass", $dt2, $id2);
			$this->session->set_flashdata('msg', 'Penilaian Sukses Dikirim');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function tambah_inass($nrp, $tahun)
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$detail_k       = $this->master_model->detail_karyawan2($nrp);
			$row 			= $this->master_model->list_tanya_inass3(1)->result();
			$nama_k         = $detail_k->row()->nama_lengkap;
			$d['data']  	= $row;
			$d['nrp']  		= $nrp;
			$d['tahun']    = $tahun;
			//$d['header']    = 'Internal Assessment';
			$d['header']    = 'Isi Internal Assessment | ' . $nama_k;
			$d['content']   = 'master/inass/tambah_inass';
			$this->load->view('master', $d);
		}
	}
	public function list_bagian()
	{
		$id_lokasi  = $this->input->post('id');
		$bagian     = $this->master_model->list_bagian_lokasi($id_lokasi)->result();
		echo (json_encode($bagian));
	}

	public function lihat_inass($nrp, $tahun)
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$d['nrp']      	= $nrp;
			$d['tahun']  	= $tahun;
			$d['header']    = 'Lihat Internal Assessment | ' . $nrp;
			$d['content']   = 'master/inass/lihat_inass';
			$this->load->view('master', $d);
		}
	}
	public function lihat_inass2($nrp, $tahun)
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$insert_by 		= $this->session->userdata('nrp');
			$d['nrp']      	= $nrp;
			$d['tahun']  	= $tahun;
			$d['atasan']  	= $insert_by;
			$d['header']    = 'Lihat Internal Assessment | ' . $nrp;
			$d['content']   = 'master/inass/lihat_inass2';
			$this->load->view('master', $d);
		}
	}
	public function simpan_inass_old()
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$tahun    = $this->input->post('tahun');
			$nrp    = $this->input->post('nrp');
			$id['tahun']  = $tahun;
			$id['nrp']  = $nrp;

			//Inass 3, ke-1
			$id_iassx = 1;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {

				$id_inass3 = $da->id_iass_3;
				$isi_inass3 = 'iass3_' . $da->id_iass_3;

				$dt['tahun']  = $tahun;
				$dt['nrp']  = $nrp;
				$dt['id_inass3']   = $id_inass3;
				$dt['isi_inass3']  = $this->input->post($isi_inass3);
				$dt['insert_by']          = $this->session->userdata('nrp');
				$dt['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass3", $dt);
			}
			//Inass 3, ke-2
			$id_iassx = 2;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {

				$id_inass3 = $da->id_iass_3;
				$isi_inass3 = 'iass3_' . $da->id_iass_3;

				$dt['tahun']  = $tahun;
				$dt['nrp']  = $nrp;
				$dt['id_inass3']   = $id_inass3;
				$dt['isi_inass3']  = $this->input->post($isi_inass3);
				$dt['insert_by']          = $this->session->userdata('nrp');
				$dt['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass3", $dt);
			}
			//Inass 3, ke-3
			$id_iassx = 3;
			$data   = $this->master_model->list_inass_sudah();
			foreach ($data->result() as $da) {

				$id_inass3 = $da->id_iass_3;
				$isi_inass3 = 'iass3_' . $da->id_iass_3;

				$dt['tahun']  = $tahun;
				$dt['nrp']  = $nrp;
				$dt['id_inass3']   = $id_inass3;
				$dt['isi_inass3']  = $this->input->post($isi_inass3);
				$dt['insert_by']          = $this->session->userdata('nrp');
				$dt['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass3", $dt);
			}
			//Inass 3, ke-4
			$id_iassx = 4;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {

				$id_inass3 = $da->id_iass_3;
				$isi_inass3 = 'iass3_' . $da->id_iass_3;

				$dt['tahun']  = $tahun;
				$dt['nrp']  = $nrp;
				$dt['id_inass3']   = $id_inass3;
				$dt['isi_inass3']  = $this->input->post($isi_inass3);
				$dt['insert_by']          = $this->session->userdata('nrp');
				$dt['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass3", $dt);
			}
			//Inass 3, ke-5
			$id_iassx = 5;
			$data   = $this->master_model->list_tanya_inass3($id_iassx);
			foreach ($data->result() as $da) {

				$id_inass3 = $da->id_iass_3;
				$isi_inass3 = 'iass3_' . $da->id_iass_3;

				$dt['tahun']  = $tahun;
				$dt['nrp']  = $nrp;
				$dt['id_inass3']   = $id_inass3;
				$dt['isi_inass3']  = $this->input->post($isi_inass3);
				$dt['insert_by']          = $this->session->userdata('nrp');
				$dt['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass3", $dt);
			}
			//Inass 2, ke-2
			$id_iassx = 2;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {

				$id_inass2 = $da2->id_iass_2;
				$isi_inass2 = 'iass2_' . $da2->id_iass_2;

				$dt2['tahun']  = $tahun;
				$dt2['nrp']  = $nrp;
				$dt2['id_inass2']   = $id_inass2;
				$dt2['isi_inass2']  = $this->input->post($isi_inass2);
				$dt2['insert_by']          = $this->session->userdata('nrp');
				$dt2['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass2", $dt2);
			}
			//Inass 2, ke-3
			$id_iassx = 3;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {

				$id_inass2 = $da2->id_iass_2;
				$isi_inass2 = 'iass2_' . $da2->id_iass_2;

				$dt2['tahun']  = $tahun;
				$dt2['nrp']  = $nrp;
				$dt2['id_inass2']   = $id_inass2;
				$dt2['isi_inass2']  = $this->input->post($isi_inass2);
				$dt2['insert_by']          = $this->session->userdata('nrp');
				$dt2['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass2", $dt2);
			}
			//Inass 2, ke-4
			$id_iassx = 4;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {

				$id_inass2 = $da2->id_iass_2;
				$isi_inass2 = 'iass2_' . $da2->id_iass_2;

				$dt2['tahun']  = $tahun;
				$dt2['nrp']  = $nrp;
				$dt2['id_inass2']   = $id_inass2;
				$dt2['isi_inass2']  = $this->input->post($isi_inass2);
				$dt2['insert_by']          = $this->session->userdata('nrp');
				$dt2['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass2", $dt2);
			}
			//Inass 2, ke-5
			$id_iassx = 5;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {

				$id_inass2 = $da2->id_iass_2;
				$isi_inass2 = 'iass2_' . $da2->id_iass_2;

				$dt2['tahun']  = $tahun;
				$dt2['nrp']  = $nrp;
				$dt2['id_inass2']   = $id_inass2;
				$dt2['isi_inass2']  = $this->input->post($isi_inass2);
				$dt2['insert_by']          = $this->session->userdata('nrp');
				$dt2['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass2", $dt2);
			}
			//Inass 2, ke-6
			$id_iassx = 6;
			$data   = $this->master_model->list_tanya_inass2($id_iassx);
			foreach ($data->result() as $da2) {

				$id_inass2 = $da2->id_iass_2;
				$isi_inass2 = 'iass2_' . $da2->id_iass_2;

				$dt2['tahun']  = $tahun;
				$dt2['nrp']  = $nrp;
				$dt2['id_inass2']   = $id_inass2;
				$dt2['isi_inass2']  = $this->input->post($isi_inass2);
				$dt2['insert_by']          = $this->session->userdata('nrp');
				$dt2['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass2", $dt2);
			}

			//Inass 1, ke-7
			$id_iassx = 7;
			$data   = $this->master_model->list_tanya_inass1($id_iassx);
			foreach ($data->result() as $da3) {

				$id_inass1 = $da3->id_iass;
				$isi_inass1 = 'iass1_' . $da3->id_iass;

				$dt3['tahun']  = $tahun;
				$dt3['nrp']  = $nrp;
				$dt3['id_inass']   = $id_inass1;
				$dt3['isi_inass']  = $this->input->post($isi_inass1);
				$dt3['insert_by']          = $this->session->userdata('nrp');
				$dt3['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass", $dt3);
			}
			//Inass 1, ke-8
			$id_iassx = 8;
			$data   = $this->master_model->list_tanya_inass1($id_iassx);
			foreach ($data->result() as $da3) {

				$id_inass1 = $da3->id_iass;
				$isi_inass1 = 'iass1_' . $da3->id_iass;

				$dt3['tahun']  = $tahun;
				$dt3['nrp']  = $nrp;
				$dt3['id_inass']   = $id_inass1;
				$dt3['isi_inass']  = $this->input->post($isi_inass1);
				$dt3['insert_by']          = $this->session->userdata('nrp');
				$dt3['insert_date']          = date("Y-m-d");

				$this->db->insert("trans_inass", $dt3);
			}

			$this->session->set_flashdata('msg', 'Internal Assessment Berhasil disimpan');
			redirect('int_assessment/list_inass?tahun=' . $tahun);
			/*
            $c  = $this->db->get_where("mst_karyawan1",$id);
            if($c->num_rows() > 0){
                $dt['status']   = $this->input->post('status');
                $this->db->update("mst_karyawan1",$dt,$id);
                $this->session->set_flashdata('msg', 'Internal Assessment Berhasil diubah');
                redirect($_SERVER['HTTP_REFERER']);
            }else{ 
                $dt['password']         = md5('1234');
                $dt['id_perusahaan']    = $this->session->userdata('id_perusahaan');
                $dt['jenis_karyawan']   = $this->input->post('kategori');
                $this->db->insert("mst_karyawan1",$dt);
                $this->session->set_flashdata('msg', 'Internal Assessment Berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }*/
		}
	}

	public function edit_inass($tahun, $nrp)
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$detail_k       = $this->master_model->detail_karyawan2($nrp);
			$nama_k         = $detail_k->row()->nama_lengkap;
			$insert_by 		= $this->session->userdata('nrp');
			$d['nrp']       = $nrp;
			$d['tahun']     = $tahun;
			$d['atasan']	= $insert_by;
			//$d['kategori']  = $kategori;
			$d['header']    = 'Edit Internal Assessment | ' . $nama_k;
			$d['content']   = 'master/inass/edit_inass';
			$this->load->view('master', $d);
		}
	}

	public function simpan_inass()
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$insert_by = $this->session->userdata('nrp');
			$tahun    = $this->input->post('tahun');
			$nrp    = $this->input->post('nrp');
			$id['nrp']  = $nrp;
			$id['tahun']  = $tahun;
			// Load database
			$this->load->database();

			$condition = [
				'nrp' => $nrp,
				'insert_by' => $insert_by
			];

			// Menggunakan query builder
			// $this->db->where('nrp', $id);
			$c  = $this->db->get_where("trans_inass", $condition);

			if ($c->num_rows() > 0) {
				$tahun    = $this->input->post('tahun');
				$nrp    = $this->input->post('nrp');

				$id['tahun']  = $tahun;
				$id['nrp']  = $nrp;

				//Inass 3, ke-1
				$id_iassx = 1;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {

					$id_inass3 = $da->id_iass_3;
					$isi_inass3 = 'iass3_' . $da->id_iass_3;

					$id['tahun']  = $tahun;
					$id['nrp']  = $nrp;
					$id['id_inass3']   = $id_inass3;
					$id['insert_by']          = $this->session->userdata('nrp');
					$dt['isi_inass3']  = $this->input->post($isi_inass3);

					$this->db->update("trans_inass3", $dt, $id);
				}
				//Inass 3, ke-2
				$id_iassx = 2;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {

					$id_inass3 = $da->id_iass_3;
					$isi_inass3 = 'iass3_' . $da->id_iass_3;

					$id['tahun']  = $tahun;
					$id['nrp']  = $nrp;
					$id['id_inass3']   = $id_inass3;
					$id['insert_by']          = $this->session->userdata('nrp');
					$dt['isi_inass3']  = $this->input->post($isi_inass3);

					$this->db->update("trans_inass3", $dt, $id);
				}
				//Inass 3, ke-3
				$id_iassx = 3;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {

					$id_inass3 = $da->id_iass_3;
					$isi_inass3 = 'iass3_' . $da->id_iass_3;

					$id['tahun']  = $tahun;
					$id['nrp']  = $nrp;
					$id['id_inass3']   = $id_inass3;
					$id['insert_by']          = $this->session->userdata('nrp');
					$dt['isi_inass3']  = $this->input->post($isi_inass3);

					$this->db->update("trans_inass3", $dt, $id);
				}
				//Inass 3, ke-4
				$id_iassx = 4;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {

					$id_inass3 = $da->id_iass_3;
					$isi_inass3 = 'iass3_' . $da->id_iass_3;

					$id['tahun']  = $tahun;
					$id['nrp']  = $nrp;
					$id['id_inass3']   = $id_inass3;
					$id['insert_by']          = $this->session->userdata('nrp');
					$dt['isi_inass3']  = $this->input->post($isi_inass3);

					$this->db->update("trans_inass3", $dt, $id);
				}
				//Inass 3, ke-5
				$id_iassx = 5;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {

					$id_inass3 = $da->id_iass_3;
					$isi_inass3 = 'iass3_' . $da->id_iass_3;

					$id['tahun']  = $tahun;
					$id['nrp']  = $nrp;
					$id['id_inass3']   = $id_inass3;
					$id['insert_by']          = $this->session->userdata('nrp');
					$dt['isi_inass3']  = $this->input->post($isi_inass3);

					$this->db->update("trans_inass3", $dt, $id);
				}
				//Inass 2, ke-2
				$id_iassx = 2;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {

					$id_inass2 = $da2->id_iass_2;
					$isi_inass2 = 'iass2_' . $da2->id_iass_2;

					$id2['tahun']  = $tahun;
					$id2['nrp']  = $nrp;
					$id2['id_inass2']   = $id_inass2;
					$id2['insert_by']          = $this->session->userdata('nrp');
					$dt2['isi_inass2']  = $this->input->post($isi_inass2);

					$this->db->update("trans_inass2", $dt2, $id2);
				}
				//Inass 2, ke-3
				$id_iassx = 3;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {

					$id_inass2 = $da2->id_iass_2;
					$isi_inass2 = 'iass2_' . $da2->id_iass_2;

					$id2['tahun']  = $tahun;
					$id2['nrp']  = $nrp;
					$id2['id_inass2']   = $id_inass2;
					$id2['insert_by']          = $this->session->userdata('nrp');
					$dt2['isi_inass2']  = $this->input->post($isi_inass2);

					$this->db->update("trans_inass2", $dt2, $id2);
				}
				//Inass 2, ke-4
				$id_iassx = 4;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {

					$id_inass2 = $da2->id_iass_2;
					$isi_inass2 = 'iass2_' . $da2->id_iass_2;

					$id2['tahun']  = $tahun;
					$id2['nrp']  = $nrp;
					$id2['id_inass2']   = $id_inass2;
					$id2['insert_by']          = $this->session->userdata('nrp');
					$dt2['isi_inass2']  = $this->input->post($isi_inass2);

					$this->db->update("trans_inass2", $dt2, $id2);
				}
				//Inass 2, ke-5
				$id_iassx = 5;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {

					$id_inass2 = $da2->id_iass_2;
					$isi_inass2 = 'iass2_' . $da2->id_iass_2;

					$id2['tahun']  = $tahun;
					$id2['nrp']  = $nrp;
					$id2['id_inass2']   = $id_inass2;
					$id2['insert_by']          = $this->session->userdata('nrp');
					$dt2['isi_inass2']  = $this->input->post($isi_inass2);

					$this->db->update("trans_inass2", $dt2, $id2);
				}
				//Inass 2, ke-6
				$id_iassx = 6;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {

					$id_inass2 = $da2->id_iass_2;
					$isi_inass2 = 'iass2_' . $da2->id_iass_2;

					$id2['tahun']  = $tahun;
					$id2['nrp']  = $nrp;
					$id2['id_inass2']   = $id_inass2;
					$id2['insert_by']          = $this->session->userdata('nrp');
					$dt2['isi_inass2']  = $this->input->post($isi_inass2);

					$this->db->update("trans_inass2", $dt2, $id2);
				}

				//Inass 1, ke-7
				$id_iassx = 7;
				$data   = $this->master_model->list_tanya_inass1($id_iassx);
				foreach ($data->result() as $da3) {

					$id_inass1 = $da3->id_iass;
					$isi_inass1 = 'iass1_' . $da3->id_iass;

					$id3['tahun']  = $tahun;
					$id3['nrp']  = $nrp;
					$id3['id_inass']   = $id_inass1;
					$id3['insert_by']          = $this->session->userdata('nrp');
					$dt3['isi_inass']  = $this->input->post($isi_inass1);

					$this->db->update("trans_inass", $dt3, $id3);
				}
				//Inass 1, ke-8
				$id_iassx = 8;
				$data   = $this->master_model->list_tanya_inass1($id_iassx);
				foreach ($data->result() as $da3) {

					$id_inass1 = $da3->id_iass;
					$isi_inass1 = 'iass1_' . $da3->id_iass;

					$id3['tahun']  = $tahun;
					$id3['nrp']  = $nrp;
					$id3['id_inass']   = $id_inass1;
					$id3['insert_by']          = $this->session->userdata('nrp');
					$dt3['isi_inass']  = $this->input->post($isi_inass1);

					$this->db->update("trans_inass", $dt3, $id3);
				}

				$this->session->set_flashdata('msg', 'Internal Assessment Berhasil diubah.');
				redirect('int_assessment/list_inass?tahun=' . $tahun);
			}
			//-------------------------------------------------------------------------------------
			else {
				$this->load->library('session');
				$this->load->library('form_validation');

				// set rules pada form validation

				$id_iassx = 1;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);

				foreach ($data->result() as $da) {
					$this->form_validation->set_rules('iass3_' . $da->id_iass_3, 'iass3_' . $da->id_iass_3, 'required');
				}

				$id_iassx = 2;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {
					$this->form_validation->set_rules('iass3_' . $da->id_iass_3, 'iass3_' . $da->id_iass_3, 'required');
				}

				$id_iassx = 3;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {
					$this->form_validation->set_rules('iass3_' . $da->id_iass_3, 'iass3_' . $da->id_iass_3, 'required');
				}

				$id_iassx = 4;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {
					$this->form_validation->set_rules('iass3_' . $da->id_iass_3, 'iass3_' . $da->id_iass_3, 'required');
				}

				$id_iassx = 5;
				$data   = $this->master_model->list_tanya_inass3($id_iassx);
				foreach ($data->result() as $da) {
					$this->form_validation->set_rules('iass3_' . $da->id_iass_3, 'iass3_' . $da->id_iass_3, 'required');
				}

				$id_iassx = 2;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {
					$this->form_validation->set_rules('iass2_' . $da2->id_iass_2, 'iass2_' . $da2->id_iass_2, 'required');
				}
				//Inass 2, ke-3
				$id_iassx = 3;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {
					$this->form_validation->set_rules('iass2_' . $da2->id_iass_2, 'iass2_' . $da2->id_iass_2, 'required');
				}
				//Inass 2, ke-4
				$id_iassx = 4;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {
					$this->form_validation->set_rules('iass2_' . $da2->id_iass_2, 'iass2_' . $da2->id_iass_2, 'required');
				}
				//Inass 2, ke-5
				$id_iassx = 5;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {
					$this->form_validation->set_rules('iass2_' . $da2->id_iass_2, 'iass2_' . $da2->id_iass_2, 'required');
				}
				//Inass 2, ke-6
				$id_iassx = 6;
				$data   = $this->master_model->list_tanya_inass2($id_iassx);
				foreach ($data->result() as $da2) {
					$this->form_validation->set_rules('iass2_' . $da2->id_iass_2, 'iass2_' . $da2->id_iass_2, 'required');
				}

				//Inass 1, ke-7
				$id_iassx = 7;
				$data   = $this->master_model->list_tanya_inass1($id_iassx);
				foreach ($data->result() as $da7) {
					$this->form_validation->set_rules('iass1_' . $da7->id_iass, 'iass1_' . $da7->id_iass, 'required');
				}
				//Inass 1, ke-8
				$id_iassx = 8;
				$data   = $this->master_model->list_tanya_inass1($id_iassx);
				foreach ($data->result() as $da8) {
					$this->form_validation->set_rules('iass1_' . $da8->id_iass, 'iass1_' . $da8->id_iass, 'required');
				}

				// set session untuk menapilkan hasil yang sudah diinput

				if ($this->form_validation->run() == false) {
					$no = 1;
					$id_iassx = 1;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->set_userdata('selected_inass11' . $no, $this->input->post('iass3_' . $da->id_iass_3));
						$no++;
					}

					$no = 1;
					$id_iassx = 2;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->set_userdata('selected_inass10' . $no, $this->input->post('iass3_' . $da->id_iass_3));
						$no++;
					}

					$no = 1;
					$id_iassx = 3;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->set_userdata('selected_inass9' . $no, $this->input->post('iass3_' . $da->id_iass_3));
						$no++;
					}

					$no = 1;
					$id_iassx = 4;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->set_userdata('selected_inass8' . $no, $this->input->post('iass3_' . $da->id_iass_3));
						$no++;
					}

					$no = 1;
					$id_iassx = 5;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->set_userdata('selected_inass7' . $no, $this->input->post('iass3_' . $da->id_iass_3));
						$no++;
					}

					$no = 1;
					$id_iassx = 2;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->set_userdata('selected_inass6' . $no, $this->input->post('iass2_' . $da2->id_iass_2));
						$no++;
					}
					//Inass 2, ke-3
					$no = 1;
					$id_iassx = 3;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->set_userdata('selected_inass5' . $no, $this->input->post('iass2_' . $da2->id_iass_2));
						$no++;
					}
					//Inass 2, ke-4
					$no = 1;
					$id_iassx = 4;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->set_userdata('selected_inass4' . $no, $this->input->post('iass2_' . $da2->id_iass_2));
						$no++;
					}
					//Inass 2, ke-5
					$no = 1;
					$id_iassx = 5;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->set_userdata('selected_inass3' . $no, $this->input->post('iass2_' . $da2->id_iass_2));
						$no++;
					}
					//Inass 2, ke-6
					$no = 1;
					$id_iassx = 6;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->set_userdata('selected_inass2' . $no, $this->input->post('iass2_' . $da2->id_iass_2));
						$no++;
					}

					//Inass 1, ke-7
					$id_iassx = 7;
					$data   = $this->master_model->list_tanya_inass1($id_iassx);
					foreach ($data->result() as $da7) {
						$this->session->set_userdata('selected_inass1', $this->input->post('iass1_' . $da7->id_iass));
					}

					$id_iassx = 8;
					$data   = $this->master_model->list_tanya_inass1($id_iassx);
					foreach ($data->result() as $da8) {
						$this->session->set_userdata('selected_inass', $this->input->post('iass1_' . $da8->id_iass));
					}
					$this->session->set_flashdata('msg_error', 'Data belum lengkap');
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					$tahun    = $this->input->post('tahun');
					$nrp    = $this->input->post('nrp');
					$id['tahun']  = $tahun;
					$id['nrp']  = $nrp;

					//Inass 3, ke-1
					$id_iassx = 1;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);

					foreach ($data->result() as $da) {

						$id_inass3 = $da->id_iass_3;
						$isi_inass3 = 'iass3_' . $da->id_iass_3;

						$dt['tahun']  = $tahun;
						$dt['nrp']  = $nrp;
						$dt['id_inass3']   = $id_inass3;
						$dt['isi_inass3']  = $this->input->post($isi_inass3);
						$dt['insert_by']          = $this->session->userdata('nrp');
						$dt['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass3", $dt);
					}
					//Inass 3, ke-2
					$id_iassx = 2;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {

						$id_inass3 = $da->id_iass_3;
						$isi_inass3 = 'iass3_' . $da->id_iass_3;

						$dt['tahun']  = $tahun;
						$dt['nrp']  = $nrp;
						$dt['id_inass3']   = $id_inass3;
						$dt['isi_inass3']  = $this->input->post($isi_inass3);
						$dt['insert_by']          = $this->session->userdata('nrp');
						$dt['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass3", $dt);
					}
					//Inass 3, ke-3
					$id_iassx = 3;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {

						$id_inass3 = $da->id_iass_3;
						$isi_inass3 = 'iass3_' . $da->id_iass_3;

						$dt['tahun']  = $tahun;
						$dt['nrp']  = $nrp;
						$dt['id_inass3']   = $id_inass3;
						$dt['isi_inass3']  = $this->input->post($isi_inass3);
						$dt['insert_by']          = $this->session->userdata('nrp');
						$dt['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass3", $dt);
					}
					//Inass 3, ke-4
					$id_iassx = 4;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {

						$id_inass3 = $da->id_iass_3;
						$isi_inass3 = 'iass3_' . $da->id_iass_3;

						$dt['tahun']  = $tahun;
						$dt['nrp']  = $nrp;
						$dt['id_inass3']   = $id_inass3;
						$dt['isi_inass3']  = $this->input->post($isi_inass3);
						$dt['insert_by']          = $this->session->userdata('nrp');
						$dt['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass3", $dt);
					}
					//Inass 3, ke-5
					$id_iassx = 5;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {

						$id_inass3 = $da->id_iass_3;
						$isi_inass3 = 'iass3_' . $da->id_iass_3;

						$dt['tahun']  = $tahun;
						$dt['nrp']  = $nrp;
						$dt['id_inass3']   = $id_inass3;
						$dt['isi_inass3']  = $this->input->post($isi_inass3);
						$dt['insert_by']          = $this->session->userdata('nrp');
						$dt['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass3", $dt);
					}
					//Inass 2, ke-2
					$id_iassx = 2;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {

						$id_inass2 = $da2->id_iass_2;
						$isi_inass2 = 'iass2_' . $da2->id_iass_2;

						$dt2['tahun']  = $tahun;
						$dt2['nrp']  = $nrp;
						$dt2['id_inass2']   = $id_inass2;
						$dt2['isi_inass2']  = $this->input->post($isi_inass2);
						$dt2['insert_by']          = $this->session->userdata('nrp');
						$dt2['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass2", $dt2);
					}
					//Inass 2, ke-3
					$id_iassx = 3;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {

						$id_inass2 = $da2->id_iass_2;
						$isi_inass2 = 'iass2_' . $da2->id_iass_2;

						$dt2['tahun']  = $tahun;
						$dt2['nrp']  = $nrp;
						$dt2['id_inass2']   = $id_inass2;
						$dt2['isi_inass2']  = $this->input->post($isi_inass2);
						$dt2['insert_by']          = $this->session->userdata('nrp');
						$dt2['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass2", $dt2);
					}
					//Inass 2, ke-4
					$id_iassx = 4;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {

						$id_inass2 = $da2->id_iass_2;
						$isi_inass2 = 'iass2_' . $da2->id_iass_2;

						$dt2['tahun']  = $tahun;
						$dt2['nrp']  = $nrp;
						$dt2['id_inass2']   = $id_inass2;
						$dt2['isi_inass2']  = $this->input->post($isi_inass2);
						$dt2['insert_by']          = $this->session->userdata('nrp');
						$dt2['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass2", $dt2);
					}
					//Inass 2, ke-5
					$id_iassx = 5;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {

						$id_inass2 = $da2->id_iass_2;
						$isi_inass2 = 'iass2_' . $da2->id_iass_2;

						$dt2['tahun']  = $tahun;
						$dt2['nrp']  = $nrp;
						$dt2['id_inass2']   = $id_inass2;
						$dt2['isi_inass2']  = $this->input->post($isi_inass2);
						$dt2['insert_by']          = $this->session->userdata('nrp');
						$dt2['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass2", $dt2);
					}
					//Inass 2, ke-6
					$id_iassx = 6;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {

						$id_inass2 = $da2->id_iass_2;
						$isi_inass2 = 'iass2_' . $da2->id_iass_2;

						$dt2['tahun']  = $tahun;
						$dt2['nrp']  = $nrp;
						$dt2['id_inass2']   = $id_inass2;
						$dt2['isi_inass2']  = $this->input->post($isi_inass2);
						$dt2['insert_by']          = $this->session->userdata('nrp');
						$dt2['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass2", $dt2);
					}

					//Inass 1, ke-7
					$id_iassx = 7;
					$data   = $this->master_model->list_tanya_inass1($id_iassx);
					foreach ($data->result() as $da7) {

						$id_inass1 = $da7->id_iass;
						$isi_inass1 = 'iass1_' . $da7->id_iass;

						$dt7['tahun']  = $tahun;
						$dt7['nrp']  = $nrp;
						$dt7['id_inass']   = $id_inass1;
						$dt7['isi_inass']  = $this->input->post($isi_inass1);
						$dt7['insert_by']          = $this->session->userdata('nrp');
						$dt7['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass", $dt7);
					}
					//Inass 1, ke-8
					$id_iassx = 8;
					$data   = $this->master_model->list_tanya_inass1($id_iassx);
					foreach ($data->result() as $da8) {

						$id_inass1 = $da8->id_iass;
						$isi_inass1 = 'iass1_' . $da8->id_iass;

						$dt8['tahun']  = $tahun;
						$dt8['nrp']  = $nrp;
						$dt8['id_inass']   = $id_inass1;
						$dt8['isi_inass']  = $this->input->post($isi_inass1);
						$dt8['insert_by']          = $this->session->userdata('nrp');
						$dt8['insert_date']          = date("Y-m-d");

						$this->db->insert("trans_inass", $dt8);
					}
					$no = 1;
					$id_iassx = 1;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->unset_userdata('selected_inass11' . $no);
						$no++;
					}

					$no = 1;
					$id_iassx = 2;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->unset_userdata('selected_inass10' . $no);
						$no++;
					}

					$no = 1;
					$id_iassx = 3;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->unset_userdata('selected_inass9' . $no);
						$no++;
					}

					$no = 1;
					$id_iassx = 4;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->unset_userdata('selected_inass8' . $no);
						$no++;
					}

					$no = 1;
					$id_iassx = 5;
					$data   = $this->master_model->list_tanya_inass3($id_iassx);
					foreach ($data->result() as $da) {
						$this->session->unset_userdata('selected_inass7' . $no);
						$no++;
					}

					$no = 1;
					$id_iassx = 2;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->unset_userdata('selected_inass6' . $no);
						$no++;
					}
					//Inass 2, ke-3
					$no = 1;
					$id_iassx = 3;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->unset_userdata('selected_inass5' . $no);
						$no++;
					}
					//Inass 2, ke-4
					$no = 1;
					$id_iassx = 4;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->unset_userdata('selected_inass4' . $no);
						$no++;
					}
					//Inass 2, ke-5
					$no = 1;
					$id_iassx = 5;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->unset_userdata('selected_inass3' . $no);
						$no++;
					}
					//Inass 2, ke-6
					$no = 1;
					$id_iassx = 6;
					$data   = $this->master_model->list_tanya_inass2($id_iassx);
					foreach ($data->result() as $da2) {
						$this->session->unset_userdata('selected_inass2' . $no);
						$no++;
					}
					$this->session->unset_userdata('selected_inass1');
					$this->session->unset_userdata('selected_inass');
				}

				$this->session->set_flashdata('msg', 'Internal Assessment Berhasil disimpan');
				redirect('int_assessment/list_inass?tahun=' . $tahun);

				/*
            {
                $dt['status']   = $this->input->post('status');
                $this->db->update("mst_karyawan1",$dt,$id);
                $this->session->set_flashdata('msg', 'Internal Assessment Berhasil diubah');
                redirect($_SERVER['HTTP_REFERER']);
            }{ 
                $dt['password']         = md5('1234');
                $dt['id_perusahaan']    = $this->session->userdata('id_perusahaan');
                $dt['jenis_karyawan']   = $this->input->post('kategori');
                $this->db->insert("mst_karyawan1",$dt);
                $this->session->set_flashdata('msg', 'Internal Assessment Berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }*/
			}
		}
	}

	public function rekap_ia()
	{
		$masuk  = $this->session->userdata('masuk_k');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {
			$tahun          = $this->input->get('tahun');
			$unit          = $this->input->get('unit');
			$nrp          = $this->session->userdata('nrp');
			$d['tahun']     = $tahun;
			$d['unit']     = $unit;
			$d['nrp']     = $nrp;
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

			$d['header']    = 'Rekap Internal Assessment  | ' . $tahun . ' | ' . $unit;
			$d['content']   = 'member/member/list_rekap_ia';
			$this->load->view('member', $d);
		}
	}

	function download_rekap_ia($tahun, $nrp)
	{
		$masuk  = $this->session->userdata('masuk_k');
		$this->load->helpers('print_rekap_helper');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {

			//$data   = $this->enterprise_model->download_data_karyawan($id_perusahaan,$lokasi,$bagian,$jenis);
			$id_karyawan    = $this->session->userdata('id_karyawan');
			$aksi           = $this->master_model->list_aksi($id_karyawan);
			$tahun = '2024';
			$data   = $this->master_model->list_inass_rekap($tahun, $nrp);
			if ($data->num_rows() > 0) {
				$pdf = new reportProduct();
				$pdf->setKriteria("cetak_laporan");
				$pdf->setNama("CETAK REKAP IA");
				$pdf->AliasNbPages();
				$pdf->AddPage("P", "A4");
				$A4[0] = 210;
				$A4[1] = 297;
				$Q[0] = 216;
				$Q[1] = 279;
				$pdf->SetTitle('LAPORAN REKAP IA');
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
				$pdf->Cell(200, 4, 'LAPORAN REKAP IA', 0, 0, 'C');
				$pdf->Cell(10, 4, '', 0, 1);
				$pdf->Ln(5);
				$w = array(10, 35, 30, 65, 20, 35);

				//Header
				$pdf->SetFont('Arial', 'B', 6);
				$pdf->Cell($w[0], $h, 'No', 1, 0, 'C');
				$pdf->Cell($w[4], $h, 'NRP / NIP', 1, 0, 'C');
				$pdf->Cell($w[3], $h, 'Nama Karyawan', 1, 0, 'C');
				$pdf->Cell($w[4], $h, 'Assessment Year', 1, 0, 'C');
				$pdf->Cell($w[3], $h, 'Assessor', 1, 0, 'C');
				$pdf->Cell($w[0], $h, 'Score', 1, 0, 'C');

				$pdf->Ln();

				$pdf->SetFont('Arial', '', 6);
				$pdf->SetFillColor(204, 204, 204);
				$pdf->SetTextColor(0);
				$fill = false;
				$no = 1;

				$kolom  = 2;

				foreach ($data->result() as $dt) {
					$row = ($dt->inas3_1 + $dt->inas3_2 + $dt->inas3_3 + $dt->inas3_4 + $dt->inas3_5) / 5;
					$row1 = ($row + $dt->inas2_2 + $dt->inas2_3 + $dt->inas2_4 + $dt->inas2_5 + $dt->inas2_6 + $dt->isi_inass1 + $dt->isi_inass11) / 8;
					$pdf->Cell($w[0], $h, $no, 'LR', 0, 'C', $fill);
					$pdf->Cell($w[4], $h, $dt->nrp, 'LR', 0, 'C', $fill);
					$pdf->Cell($w[3], $h, $dt->nama_lengkap, 'LR', 0, 'C', $fill);
					$pdf->Cell($w[4], $h, $dt->tahun, 'LR', 0, 'C', $fill);
					$pdf->Cell($w[3], $h, $dt->insertby, 'LR', 0, 'C', $fill);
					$pdf->Cell($w[0], $h, "" . number_format($row1, 2, ',', '.'), 'LR', 0, 'C', $fill);
					$pdf->Ln();
					$fill = !$fill;
					$no++;
				}

				$pdf->Cell(array_sum($w), 0, '');
				$pdf->Ln(10);
				$pdf->SetX(130);
				$pdf->Cell(100, $h, $this->master_model->tgl_indo(date('Y-m-d')), 'C');
				$pdf->Ln(20);
				$pdf->SetX(130);
				$pdf->Cell(100, $h, '___________________', 'C');
				$pdf->Output('Rekap_IA_' . $this->master_model->tgl_indo(date('Y-m-d')) . '.pdf', 'D');
			} else {
				$this->session->set_flashdata('msg_error', 'Data tidak ada');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	function download_rekap_ia_old($tahun, $nrp)
	{
		$masuk  = $this->session->userdata('masuk_k');
		$this->load->helpers('print_rekap_helper');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {

			//$data   = $this->enterprise_model->download_data_karyawan($id_perusahaan,$lokasi,$bagian,$jenis);
			$id_karyawan    = $this->session->userdata('id_karyawan');
			$aksi           = $this->master_model->list_aksi($id_karyawan);
			$tahun 			= '2024';
			$no 			= 1;
			$data   		= $this->master_model->list_inass_rekap($tahun, $nrp);
			if ($data->num_rows() > 0) {
				$spreadsheet        = new Spreadsheet();
				$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A1', "No")
					->setCellValue('B1', "NRP / NIP")
					->setCellValue('C1', "Nama Karyawan")
					->setCellValue('D1', "Assessment Year")
					->setCellValue('E1', "Assesor")
					->setCellValue('F1', "Score");

				$kolom  = 2;
				$no = 1;
				foreach ($data->result() as $dt) {
					$row = ($dt->inas3_1 + $dt->inas3_2 + $dt->inas3_3 + $dt->inas3_4 + $dt->inas3_5) / 5;
					$row1 = ($row + $dt->inas2_2 + $dt->inas2_3 + $dt->inas2_4 + $dt->inas2_5 + $dt->inas2_6 + $dt->isi_inass1 + $dt->isi_inass11) / 8;
					$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A' . $kolom, "" . number_format($no))
						->setCellValue('B' . $kolom, $dt->nrp)
						->setCellValue('C' . $kolom, $dt->nama_lengkap)
						->setCellValue('D' . $kolom, $dt->tahun)
						->setCellValue('E' . $kolom, $dt->insertby)
						->setCellValue('F' . $kolom, "" . number_format($row1, 2, ',', '.'));

					$kolom++;
					$no++;
					$spreadsheet->getActiveSheet()->getStyle('A:AM')->getAlignment()->setHorizontal('center');
					$spreadsheet->getActiveSheet()->getStyle('A2:AM2')->getAlignment()->setHorizontal('center');
				}
				//autosize
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				// redirect output to client browser    
				$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
				// header('Content-Type: application/vnd.ms-excel');
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="Rekap_IA.xlsx"');
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

	function download_rekap_ia_admin($unit, $nrp)
	{
		$masuk  = $this->session->userdata('masuk_k');
		$this->load->helpers('print_rekap_helper');
		if ($masuk != TRUE) {
			redirect(base_url('login'));
		} else {

			//$data   = $this->enterprise_model->download_data_karyawan($id_perusahaan,$lokasi,$bagian,$jenis);
			$id_karyawan    = $this->session->userdata('id_karyawan');
			$aksi           = $this->master_model->list_aksi($id_karyawan);
			$tahun 			= '2024';
			$no 			= 1;
			$data   		= $this->master_model->list_inass_rekap_admin($unit, $nrp);
			if ($data->num_rows() > 0) {
				$spreadsheet        = new Spreadsheet();
				$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A1', "No")
					->setCellValue('B1', "NRP / NIP")
					->setCellValue('C1', "Nama Karyawan")
					->setCellValue('D1', "Assessment Year")
					->setCellValue('E1', "Assesor")
					->setCellValue('F1', "Score");

				$kolom  = 2;
				$no = 1;
				foreach ($data->result() as $dt) {
					$row = ($dt->inas3_1 + $dt->inas3_2 + $dt->inas3_3 + $dt->inas3_4 + $dt->inas3_5) / 5;
					$row1 = ($row + $dt->inas2_2 + $dt->inas2_3 + $dt->inas2_4 + $dt->inas2_5 + $dt->inas2_6 + $dt->isi_inass1 + $dt->isi_inass11) / 8;
					$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A' . $kolom, "" . number_format($no))
						->setCellValue('B' . $kolom, $dt->nrp)
						->setCellValue('C' . $kolom, $dt->nama_lengkap)
						->setCellValue('D' . $kolom, $dt->tahun)
						->setCellValue('E' . $kolom, $dt->insertby)
						->setCellValue('F' . $kolom, "" . number_format($row1, 2, ',', '.'));

					$kolom++;
					$no++;
					$spreadsheet->getActiveSheet()->getStyle('A:AM')->getAlignment()->setHorizontal('center');
					$spreadsheet->getActiveSheet()->getStyle('A2:AM2')->getAlignment()->setHorizontal('center');
				}
				//autosize
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				// redirect output to client browser    
				$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
				// header('Content-Type: application/vnd.ms-excel');
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="Rekap_IA.xlsx"');
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
}
