<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan extends CI_Controller
{
    private $db2;
    //private $db3;
    public function __construct()
    {
        parent::__construct();
        $this->db2 = $this->load->database('enterprise', TRUE);
        //$this->db3 = $this->load->database('enterprise_plb', TRUE);
    }
    //settings 1
    public function setting($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail             = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan    = $detail->row()->nama_perusahaan;
            $d['id_p']          = $id_perusahaan;
            $d['class']         = 'perusahaan';
            $d['header']        = 'Setting | ' . $nama_perusahaan;
            $d['content']       = 'perusahaan/setting/index_setting';
            $this->load->view('master', $d);
        }
    }
    public function save_setting_omit()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_karyawan    = $this->input->post('karyawan', TRUE);
            foreach ($id_karyawan as $karyawan => $k) {
                $d['id_karyawan'] = $k;
                $c  = $this->db->get_where("trans_om_it", $d);
                if ($c->num_rows() > 0) {
                } else {
                    $this->db->insert("trans_om_it", $d);
                }
            }
            $id_perusahaan          = $this->input->post('id_perusahaan');
            $d2['id_perusahaan']    = $id_perusahaan;
            $dt2['flag_omit']       = '1';
            $this->db->update("mst_perusahaan", $dt2, $d2);
            $this->session->set_flashdata('msg1', 'Settings OM/IT Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function hapus_omit($id_om_it, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_om_it'] = $id_om_it;
            $this->db->delete("trans_om_it", $id);
            //cek jumlah omit
            $c1 = $this->enterprise_model->list_om_it($id_perusahaan);
            if ($c1->num_rows() > 0) {
                //nothing
            } else {
                $id2['id_perusahaan']   = $id_perusahaan;
                $dt2['flag_omit']       = '0';
                $this->db->update("mst_perusahaan", $dt2, $id2);
            }
            $this->session->set_flashdata('msg1', 'Settings OM/IT Sukses dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //settings 2 
    public function save_settings()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_perusahaan']        = $this->input->post('perusahaan');
            $d['id_sekolah']            = $this->input->post('sekolah');
            $d['use_wa']                = $this->input->post('wa');
            $d['selfie_allowed']        = $this->input->post('selfie');
            $d['sppd_allowed']          = $this->input->post('sppd');
            // $d['selisih_jam']           = $this->input->post('selisih');
            // $d['format_laporan_detail'] = $this->input->post('laporan');
            $this->db->update("mst_perusahaan", $d, $id);
            $this->session->set_flashdata('msg_settings', 'Settings Sukses diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //master perusahaan
    public function master_perusahaan()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_perusahaan();
            $d['header']    = 'Perusahaan';
            $d['content']   = 'perusahaan/master_perusahaan/index_perusahaan';
            $this->load->view('master', $d);
        }
    }
    public function get_data_perusahaan()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $perusahaan         = $this->input->get('perusahaan');
            $settings           = $this->enterprise_model->get_settings_perusahaan($perusahaan);
            $d['class']         = 'perusahaan';
            $d['data']          = $this->enterprise_model->get_detail_perusahaan($perusahaan);
            $d['id_perusahaan'] = $perusahaan;
            $d['data_set']      = $settings;
            $d['header']        = 'Perusahaan';
            $d['content']       = 'perusahaan/master_perusahaan/detail_perusahaan';
            $this->load->view('master', $d);
        }
    }
    public function edit_perusahaan()
    {
        $id['id_perusahaan']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_perusahaan", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_perusahaan']     = $dt->id_perusahaan;
                $d['nama_perusahaan']   = $dt->nama_perusahaan;
                $d['ip_perusahaan']     = $dt->ip_perusahaan;
            }
            echo json_encode($d);
        } else {
            $d['id_perusahaan']     = '';
            $d['nama_perusahaan']   = '';
            $d['ip_perusahaan']     = '';
            echo json_encode($d);
        }
    }
    public function save_perusahaan()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_perusahaan          = $this->input->post('id');
            $nama_perusahaan        = $this->input->post('nama');
            $ip_perusahaan          = $this->input->post('ip');
            if ($id_perusahaan == "" || empty($id_perusahaan)) {
                $id['id_perusahaan'] = '0';
            } else {
                $id['id_perusahaan'] = $id_perusahaan;
            }
            $dt['nama_perusahaan']  = $nama_perusahaan;
            $dt['ip_perusahaan']    = $ip_perusahaan;
            //logo 
            $lebar_gambar   = 640;
            $tinggi_gambar  = 480;
            $config['upload_path']          = './assets/perusahaan/logo';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['encrypt_name']         = TRUE;
            //custom upload
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $gbr                            = $this->upload->data();
                if ($_FILES['image']['size'] >  100000) {
                    //convert
                    $config['image_library']    = 'gd2';
                    $config['source_image']     = './assets/perusahaan/logo/' . $gbr['file_name'];
                    $config['create_thumb']     = FALSE;
                    $config['maintain_ratio']   = TRUE;
                    $config['quality']          = '100%';
                    $config['width']            = $lebar_gambar;
                    $config['height']           = $tinggi_gambar;
                    $config['new_image']        = './assets/perusahaan/logo/' . $gbr['file_name'];
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $file_logo                  = './assets/perusahaan/logo/' . $gbr['file_name'];
                    $dt['logo_link']            = $gbr['file_name'];
                } else {
                    $file_logo                  = './assets/perusahaan/logo/' . $gbr['file_name'];
                    $dt['logo_link']            = $gbr['file_name'];
                }
                // encode
                $file_base64                    = base64_encode(file_get_contents($file_logo));
                $dt['logo']                     = $file_base64;
                $dt['flag_logo']                = '1';
            }
            $q = $this->db2->get_where("mst_perusahaan", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db2->update("mst_perusahaan", $dt, $id);
                $this->session->set_flashdata('msg', 'Perusahaan Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db2->insert("mst_perusahaan", $dt);
                $this->session->set_flashdata('msg', 'Perusahaan Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_perusahaan($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_perusahaan'] = $id_perusahaan;
            $this->db2->delete("mst_perusahaan", $id);
            $this->session->set_flashdata('msg', 'Perusahaan dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //bagian
    public function master_bagian($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail             = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan    = $detail->row()->nama_perusahaan;
            $d['nama']          = $nama_perusahaan;
            $d['class']         = 'perusahaan';
            $d['id_p']          = $id_perusahaan;
            $d['header']        = 'Bagian / Unit Kerja';
            $d['content']       = 'perusahaan/master_bagian/index_bagian';
            $this->load->view('master', $d);
        }
    }

    public function save_bagian()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $bagian                     = $this->input->post('bagian');
            $id_perusahaan              = $this->input->post('id_perusahaan');
            $absen                      = $this->input->post('absen_o');
            $dt1['nama_bagian']         = $bagian;
            $dt1['id_perusahaan']       = $id_perusahaan;
            $dt1['flag_absen_online']   = $absen;
            $dt1['id_karyawan']         = $this->input->post('leader');
            $this->db->insert("mst_bagian", $dt1);
            $id_bagian                  = $this->db->insert_id();
            $lokasi                     = $this->input->post('lokasi', TRUE);
            $data2                      = array();
            foreach ($lokasi as $i => $a) {
                $data2[] = array(
                    'id_lokasi'     => $a,
                    'id_bagian'     => $id_bagian,
                );
            }
            $this->db->insert_batch("mst_bagian_detail", $data2);
            $this->session->set_flashdata('msg', 'Bagian / Unit Kerja Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_bagian($id_bagian)
    {
        $id['id_bagian'] = $id_bagian;
        $this->db->delete("mst_bagian", $id);
        $this->db->delete("mst_bagian_detail", $id);
        $this->session->set_flashdata('msg', 'Bagian / Unit Kerja Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_bagian()
    {
        $id['id_bagian'] = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_bagian", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_bagian']         = $dt->id_bagian;
                $d['nama_bagian']       = $dt->nama_bagian;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        } else {
            $d['id_bagian']         = '';
            $d['nama_bagian']       = '';
            $d['flag_absen_online'] = '';
            $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    public function save_edit_bagian()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_bagian']            = $this->input->post('id_bagian');
            $dt['nama_bagian']          = $this->input->post('nama_bagian');
            $dt['flag_absen_online']    = $this->input->post('absen_o');
            $dt['id_karyawan']          = $this->input->post('leader');
            $this->db->update("mst_bagian", $dt, $id);
            $this->session->set_flashdata('msg', 'Bagian / Unit Kerja Sukses diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_lokasi_bagian($id_bagian, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail         = $this->enterprise_model->detail_bagian($id_bagian);
            $nama_bagian    = $detail->row()->nama_bagian;
            $d['id_bagian'] = $id_bagian;
            $d['id_p']      = $id_perusahaan;
            $d['class']     = 'perusahaan';
            $d['header']    = 'Edit Lokasi ' . $nama_bagian;
            $d['content']   = 'perusahaan/master_bagian/edit_lokasi';
            $this->load->view('master', $d);
        }
    }
    public function delete_lokasi_bagian($id_bagian_detail)
    {
        $id['id_bagian_detail'] = $id_bagian_detail;
        $this->db->delete("mst_bagian_detail", $id);
        $this->session->set_flashdata('msg', 'Lokasi Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function save_lokasi_bagian()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_bagian          = $this->input->post('id_bagian');
            $lokasi             = $this->input->post('lokasi', TRUE);
            $data2              = array();
            foreach ($lokasi as $i => $a) {
                $data2[] = array(
                    'id_lokasi'     => $a,
                    'id_bagian'     => $id_bagian,
                );
            }
            $this->db->insert_batch("mst_bagian_detail", $data2);
            $this->session->set_flashdata('msg', 'Lokasi Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //bagian level 2
    public function master_bagian_2($id_bagian, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_bagian  = $this->enterprise_model->detail_bagian($id_bagian);
            $nama_bagian    = $detail_bagian->row()->nama_bagian;

            $detail             = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan    = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['id_b']      = $id_bagian;
            $d['header']    = 'Bagian Level 2 | ' . $nama_perusahaan . ' | ' . $nama_bagian;
            $d['content']   = 'perusahaan/master_bagian/bagian2/index_bagian2';
            $this->load->view('master', $d);
        }
    }
    public function save_bagian_2()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_bagian_2    = $this->input->post('id_bagian_2');
            if (empty($id_bagian_2)) {
                $id['id_bagian_2']  = '0';
            } else {
                $id['id_bagian_2']  = $id_bagian_2;
            }
            $dt['id_bagian']            = $this->input->post('id_bagian');
            $dt['nama_bagian_2']        = $this->input->post('nama');
            $dt['flag_absen_online']    = $this->input->post('absen');
            $dt['id_karyawan']          = $this->input->post('leader');
            $c = $this->db->get_where("mst_bagian_2", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_bagian_2", $dt, $id);
                $this->session->set_flashdata('msg', 'Bagian Level 2 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_bagian_2", $dt);
                $this->session->set_flashdata('msg', 'Bagian Level 2 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_bagian_2()
    {
        $id['id_bagian_2']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_bagian_2", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_bagian_2']       = $dt->id_bagian_2;
                $d['nama_bagian']       = $dt->nama_bagian_2;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        } else {
            $d['id_bagian_2']       = '';
            $d['nama_bagian']       = '';
            $d['flag_absen_online'] = '';
            $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    public function delete_bagian_2($id_bagian_2)
    {
        $id['id_bagian_2']    = $id_bagian_2;
        $this->db->delete("mst_bagian_2", $id);
        $this->session->set_flashdata('msg', 'Bagian Level 2 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //bagian level 3
    public function master_bagian_3($id_bagian_2, $id_bagian, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_bagian2 = $this->enterprise_model->detail_bagian_2($id_bagian_2);
            $nama_bagian_2  = $detail_bagian2->row()->nama_bagian_2;

            $detail_bagian  = $this->enterprise_model->detail_bagian($id_bagian);
            $nama_bagian    = $detail_bagian->row()->nama_bagian;

            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['id_b']      = $id_bagian;
            $d['id_b2']     = $id_bagian_2;
            $d['header']    = 'Bagian Level 3 | ' . $nama_perusahaan . ' | ' . $nama_bagian . ' | ' . $nama_bagian_2;
            $d['content']   = 'perusahaan/master_bagian/bagian3/index_bagian3';
            $this->load->view('master', $d);
        }
    }
    public function save_bagian_3()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_bagian_3        = $this->input->post('id_bagian_3');
            if (empty($id_bagian_3)) {
                $id['id_bagian_3']  = '0';
            } else {
                $id['id_bagian_3']  = $id_bagian_3;
            }
            $dt['id_bagian_2']       = $this->input->post('id_bagian_2');
            $dt['nama_bagian_3']     = $this->input->post('nama');
            $dt['flag_absen_online'] = $this->input->post('absen');
            $dt['id_karyawan']       = $this->input->post('leader');
            $c = $this->db->get_where("mst_bagian_3", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_bagian_3", $dt, $id);
                $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_bagian_3", $dt);
                $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_bagian_3()
    {
        $id['id_bagian_3']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_bagian_3", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_bagian_3']       = $dt->id_bagian_3;
                $d['nama_bagian']       = $dt->nama_bagian_3;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        } else {
            $d['id_bagian_3']       = '';
            $d['nama_bagian']       = '';
            $d['flag_absen_online'] = '';
            $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    public function delete_bagian_3($id_bagian_3)
    {
        $id['id_bagian_3']    = $id_bagian_3;
        $this->db->delete("mst_bagian_3", $id);
        $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //MASTER BAGIAN 4
    public function master_bagian_4($id_bagian_3, $id_bagian_2, $id_bagian, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_bagian3 = $this->enterprise_model->detail_bagian_3($id_bagian_3);
            $nama_bagian_3  = $detail_bagian3->row()->nama_bagian_3;

            $detail_bagian2 = $this->enterprise_model->detail_bagian_2($id_bagian_2);
            $nama_bagian_2  = $detail_bagian2->row()->nama_bagian_2;

            $detail_bagian  = $this->enterprise_model->detail_bagian($id_bagian);
            $nama_bagian    = $detail_bagian->row()->nama_bagian;

            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['id_b']      = $id_bagian;
            $d['id_b2']     = $id_bagian_2;
            $d['id_b3']     = $id_bagian_3;
            $d['header']    = 'Bagian Level 4 | ' . $nama_perusahaan . ' | ' . $nama_bagian . ' | ' . $nama_bagian_2 . ' | ' . $nama_bagian_3;
            $d['content']   = 'perusahaan/master_bagian/bagian4/index_bagian4';
            $this->load->view('master', $d);
        }
    }
    public function save_bagian_4()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_bagian_4        = $this->input->post('id_bagian_4');
            if (empty($id_bagian_4)) {
                $id['id_bagian_4']  = '0';
            } else {
                $id['id_bagian_4']  = $id_bagian_4;
            }
            $dt['id_bagian_3']       = $this->input->post('id_bagian_3');
            $dt['nama_bagian_4']     = $this->input->post('nama');
            $dt['flag_absen_online'] = $this->input->post('absen');
            $dt['id_karyawan']       = $this->input->post('leader');
            $c = $this->db->get_where("mst_bagian_4", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_bagian_4", $dt, $id);
                $this->session->set_flashdata('msg', 'Bagian Level 4 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_bagian_4", $dt);
                $this->session->set_flashdata('msg', 'Bagian Level 4 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_bagian_4()
    {
        $id['id_bagian_4']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_bagian_4", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_bagian_4']       = $dt->id_bagian_4;
                $d['nama_bagian']       = $dt->nama_bagian_4;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        } else {
            $d['id_bagian_4']       = '';
            $d['nama_bagian']       = '';
            $d['flag_absen_online'] = '';
            $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    public function delete_bagian_4($id_bagian_4)
    {
        $id['id_bagian_4']    = $id_bagian_4;
        $this->db->delete("mst_bagian_4", $id);
        $this->session->set_flashdata('msg', 'Bagian Level 4 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    //IDP
    //inass 1
    public function master_idp($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;
            $d['nama']       = $nama_perusahaan;
            $d['class']      = 'perusahaan';
            $d['id_p']       = $id_perusahaan;
            $d['header']     = 'Pertanyaan Employee Analitic';
            $d['content']    = 'perusahaan/master_idp/index_idp';
            $this->load->view('master', $d);
        }
    }

    //internal assesment
    //inass 1
    public function master_inass($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;
            $d['nama']       = $nama_perusahaan;
            $d['class']      = 'perusahaan';
            $d['id_p']       = $id_perusahaan;
            $d['header']     = 'Pertanyaan Internal Assesment';
            $d['content']    = 'perusahaan/master_inass/index_inass';
            $this->load->view('master', $d);
        }
    }

    public function save_inass()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $dt1['nama_value']  = $this->input->post('nama_value');
            $dt1['desc']        = $this->input->post('desc');
            $dt1['urutan']      = $this->input->post('urutan');
            $dt1['flag_diisi']  = $this->input->post('flag_diisi');
            $this->db->insert("mst_inass", $dt1);

            $this->session->set_flashdata('msg', 'Pertanyaan Level 1 Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_inass($id_iass)
    {
        $id['id_iass']    = $id_iass;
        $this->db->delete("mst_inass", $id);
        $this->session->set_flashdata('msg', 'Pertanyaan Level 1 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_inass()
    {
        $id['id_iass']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_inass", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_iass']    = $dt->id_iass;
                $d['nama_value'] = $dt->nama_value;
                $d['flag_diisi'] = $dt->flag_diisi;
                $d['desc']       = $dt->desc;
                $d['urutan']     = $dt->urutan;
            }
            echo json_encode($d);
        } else {
            $d['id_iass']    = '';
            $d['nama_value'] = '';
            $d['flag_diisi'] = '';
            $d['desc']       = '';
            $d['urutan']     = '';
            echo json_encode($d);
        }
    }
    public function save_edit_inass()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_iass']      = $this->input->post('id_iass');
            $dt['nama_value']   = $this->input->post('nama_value');
            $dt['desc']         = $this->input->post('desc');
            $dt['flag_diisi']   = $this->input->post('flag_diisi');
            $dt['urutan']       = $this->input->post('urutan');
            $this->db->update("mst_inass", $dt, $id);
            $this->session->set_flashdata('msg', 'Bagian / Unit Kerja Sukses diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete_lokasi_inass($id_bagian_detail)
    {
        $id['id_iass'] = $id_bagian_detail;
        $this->db->delete("mst_inass", $id);
        $this->session->set_flashdata('msg', 'Pertanyaan Level 1 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    //inass level 2
    public function master_inass_2($id_iass, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_inass  = $this->enterprise_model->detail_inass($id_iass);
            $nama_inass    = $detail_inass->row()->nama_value;

            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['id_iass']   = $id_iass;
            $d['header']    = 'Pertanyaan level 2 | ' . $nama_inass;
            $d['content']   = 'perusahaan/master_inass/inass2/index_inass2';
            $this->load->view('master', $d);
        }
    }
    public function save_inass_2()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_iass_2        = $this->input->post('id_iass_2');
            if (empty($id_iass_2)) {
                $id['id_iass_2']  = '0';
            } else {
                $id['id_iass_2']  = $id_iass_2;
            }

            $dt['id_iass']    = $this->input->post('id_iass');
            $dt['nama_value'] = $this->input->post('nama_value');
            $dt['flag_diisi'] = $this->input->post('flag_diisi');
            $dt['urutan']     = $this->input->post('urutan');
            $dt['desc']       = $this->input->post('desc');
            $c = $this->db->get_where("mst_inass_2", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_inass_2", $dt, $id);
                $this->session->set_flashdata('msg', 'Pertanyaan Level 2 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_inass_2", $dt);
                $this->session->set_flashdata('msg', 'Pertanyaan Level 2 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_inass_2()
    {
        $id['id_iass_2']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_inass_2", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_iass_2']  = $dt->id_iass_2;
                $d['id_iass']    = $dt->id_iass;
                $d['nama_value'] = $dt->nama_value;
                $d['flag_diisi'] = $dt->flag_diisi;
                $d['desc']       = $dt->desc;
                $d['urutan']     = $dt->urutan;
            }
            echo json_encode($d);
        } else {
            $d['id_iass_2']  = '';
            $d['id_iass']    = '';
            $d['nama_value'] = '';
            $d['flag_diisi'] = '';
            $d['desc']       = '';
            $d['urutan']     = '';
            echo json_encode($d);
        }
    }
    public function delete_inass_2($id_iass_2)
    {
        $id['id_iass_2']    = $id_iass_2;
        $this->db->delete("mst_inass_2", $id);
        $this->session->set_flashdata('msg', 'Pertanyaan Level 2 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //inass level 3
    public function master_inass_3($id_iass_2, $id_iass, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_inass2 = $this->enterprise_model->detail_inass_2($id_iass_2);
            $nama_inass_2  = $detail_inass2->row()->nama_value;

            $detail_inass  = $this->enterprise_model->detail_inass($id_iass);
            $nama_inass    = $detail_inass->row()->nama_value;

            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['id_b']      = $id_iass;
            $d['id_b2']     = $id_iass_2;
            $d['header']    = 'Pertanyaan Level 3 | ' . $nama_inass . ' | ' . $nama_inass_2;
            $d['content']   = 'perusahaan/master_inass/inass3/index_inass3';
            $this->load->view('master', $d);
        }
    }
    public function save_inass_3()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_bagian_3    = $this->input->post('id_bagian_3');
            if (empty($id_bagian_3)) {
                $id['id_bagian_3']  = '0';
            } else {
                $id['id_bagian_3']  = $id_bagian_3;
            }
            $dt['id_bagian_2']          = $this->input->post('id_bagian_2');
            $dt['nama_bagian_3']        = $this->input->post('nama');
            $dt['flag_absen_online']    = $this->input->post('absen');
            $dt['id_karyawan']          = $this->input->post('leader');
            $c = $this->db->get_where("mst_bagian_3", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_bagian_3", $dt, $id);
                $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_bagian_3", $dt);
                $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_inass_3()
    {
        $id['id_bagian_3']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_bagian_3", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_bagian_3']       = $dt->id_bagian_3;
                $d['nama_bagian']       = $dt->nama_bagian_3;
                $d['flag_absen_online'] = $dt->flag_absen_online;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        } else {
            $d['id_bagian_3']       = '';
            $d['nama_bagian']       = '';
            $d['flag_absen_online'] = '';
            $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    public function delete_inass_3($id_bagian_3)
    {
        $id['id_bagian_3']    = $id_bagian_3;
        $this->db->delete("mst_bagian_3", $id);
        $this->session->set_flashdata('msg', 'Bagian Level 3 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }


    //lokasi
    public function master_lokasi($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;
            $d['nama']       = $nama_perusahaan;
            $d['class']      = 'perusahaan';
            $d['data']       = $this->enterprise_model->get_lokasi($id_perusahaan);
            $d['id_p']       = $id_perusahaan;
            $d['header']     = 'Lokasi';
            $d['content']    = 'perusahaan/master_lokasi/index_lokasi';
            $this->load->view('master', $d);
        }
    }
    public function save_lokasi()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $nama_lokasi    = $this->input->post('nama', TRUE);
            $kode_lokasi    = $this->input->post('kode', TRUE);
            //$id_karyawan    = $this->input->post('karyawan',TRUE);
            $id_perusahaan  = $this->input->post('id_perusahaan');
            foreach ($nama_lokasi as $nama => $value1) {
                if ($value1 != '' || !empty($value1)) {
                    $dt5['nama_lokasi']     = $value1;
                    $dt5['kode_lokasi']     = $kode_lokasi[$nama];
                    //$dt5['id_karyawan']     = $id_karyawan[$nama];
                    $dt5['id_perusahaan']   = $id_perusahaan;
                    $this->db2->insert("mst_lokasi", $dt5);
                } else {
                }
            }
            $this->session->set_flashdata('msg', 'Lokasi Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_lokasi()
    {
        $id['id_lokasi']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_lokasi", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_lokasi']         = $dt->id_lokasi;
                $d['nama_lokasi']       = $dt->nama_lokasi;
                $d['kode_lokasi']       = $dt->kode_lokasi;
                $d['id_karyawan']       = $dt->id_karyawan;
            }
            echo json_encode($d);
        } else {
            $d['id_lokasi']         = '';
            $d['nama_lokasi']       = '';
            $d['kode_lokasi']       = '';
            $d['id_karyawan']       = '';
            echo json_encode($d);
        }
    }
    public function delete_lokasi($id_lokasi)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_lokasi'] = $id_lokasi;
            $this->db2->delete("mst_lokasi", $id);
            $this->session->set_flashdata('msg', 'Lokasi dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function save_edit_lokasi()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_lokasi']    = $this->input->post('id_lokasi');
            $dt['nama_lokasi']  = $this->input->post('nama_lokasi');
            $dt['kode_lokasi']  = $this->input->post('kode_lokasi');
            //$dt['id_karyawan']  = $this->input->post('karyawan');
            $this->db->update("mst_lokasi", $dt, $id);
            $this->session->set_flashdata('msg', 'Lokasi diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //SUB LOKASI
    public function sub_lokasi($id_lokasi)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_lokasi  = $this->enterprise_model->detail_lokasi($id_lokasi);
            if ($detail_lokasi->num_rows() > 0) {
                $nama_lokasi = $detail_lokasi->row()->nama_lokasi;
            } else {
                $nama_lokasi = '';
            }
            $d['id_lokasi'] = $id_lokasi;
            $d['class']     = 'perusahaan';
            $d['header']    = 'Sub Lokasi | ' . $nama_lokasi;
            $d['content']   = 'perusahaan/master_lokasi/sub_lokasi';
            $this->load->view('master', $d);
        }
    }
    public function edit_sub_lokasi()
    {
        $id['id_sub_lokasi'] = $this->input->post('id');

        $q      = $this->db->get_where("mst_lokasi_sub", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_sub_lokasi']     = $dt->id_sub_lokasi;
                $d['nama_sub_lokasi']   = $dt->nama_sub_lokasi;
                $d['latitude_sub']      = $dt->latitude_sub;
                $d['longitude_sub']     = $dt->longitude_sub;
                $d['jarak_sub']         = $dt->jarak_sub;
                $d['sn']                = $dt->sn;
            }
            echo json_encode($d);
        } else {
            $d['id_sub_lokasi']     = '';
            $d['nama_sub_lokasi']   = '';
            $d['latitude_sub']      = '';
            $d['longitude_sub']     = '';
            $d['jarak_sub']         = '';
            $d['sn']                = '';
            echo json_encode($d);
        }
    }
    public function save_sub_lokasi()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_sub_lokasi          = $this->input->post('id_sub_lokasi');
            if ($id_sub_lokasi == "" || empty($id_sub_lokasi)) {
                $ids_lokasi         = '0';
            } else {
                $ids_lokasi         = $id_sub_lokasi;
            }
            $id['id_sub_lokasi']    = $ids_lokasi;

            $dt['id_lokasi']        = $this->input->post('id_lokasi');
            $dt['nama_sub_lokasi']  = $this->input->post('nama_sub');
            $dt['latitude_sub']     = $this->input->post('latitude_sub');
            $dt['longitude_sub']    = $this->input->post('longitude_sub');
            $dt['jarak_sub']        = $this->input->post('jarak_sub');
            $dt['sn']               = $this->input->post('sn');

            $q      = $this->db->get_where("mst_lokasi_sub", $id);
            $row    = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_lokasi_sub", $dt, $id);
                $this->session->set_flashdata('msg', 'Sub Lokasi Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_lokasi_sub", $dt);
                $this->session->set_flashdata('msg', 'Sub Lokasi Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_sub_lokasi($id_sub_lokasi)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_sub_lokasi'] = $id_sub_lokasi;
            $this->db->delete("mst_lokasi_sub", $id);
            $this->session->set_flashdata('msg', 'Sub Lokasi dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //shift
    public function master_shift($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;
            $d['class']      = 'perusahaan';
            $d['id_p']       = $id_perusahaan;
            $d['header']     = 'Shift / Non Shift ' . $nama_perusahaan;
            $d['content']    = 'perusahaan/master_shift/index_shift';
            $this->load->view('master', $d);
        }
    }
    public function tambah_shift($id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;
            $d['class']      = 'perusahaan';
            $d['id_p']       = $id_perusahaan;
            $d['header']     = 'Tambah Shift / Non Shift ' . $nama_perusahaan;
            $d['content']    = 'perusahaan/master_shift/tambah_shift';
            $this->load->view('master', $d);
        }
    }
    public function save_shift()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $jenis_shift            = $this->input->post('jenis');
            $d['id_perusahaan']     = $this->input->post('id_perusahaan');
            $d['jenis_shift']       = $jenis_shift;
            $d['nama_shift']        = $this->input->post('nama_shift');
            if ($jenis_shift == '1') {
                //non shift
                $d['jam_masuk']         = $this->input->post('masuk');
                $d['jam_keluar']        = $this->input->post('keluar');
                $d['jam_telat']         = $this->input->post('telat');
                $d['jam_setengah_hari'] = $this->input->post('setengah_hari');
            } else {
                //shift
                $d['jam_masuk']         = '00:00';
                $d['jam_keluar']        = '00:00';
                $d['jam_telat']         = '00:00';
                $d['jam_setengah_hari'] = '00:00';
            }
            $kategori               = $this->input->post('kategori');
            $d['kategori']          = $kategori;
            $this->db->insert("mst_shift", $d);
            $id_shift               = $this->db->insert_id();
            $hari                   = $this->input->post('hari', TRUE);
            //hari
            foreach ($hari as $h => $value1) {
                if ($value1 != '' || !empty($value1)) {
                    $d2['hari']            = $value1;
                    $d2['id_shift']        = $id_shift;
                    $this->db->insert("mst_shift_hari", $d2);
                } else {
                }
            }
            if ($kategori == '1') {
                //lokasi
                $id_lokasi  = $this->input->post('lokasi', TRUE);
                foreach ($id_lokasi as $l => $value2) {
                    if ($value2 != '' || !empty($value2)) {
                        $d3['id_lokasi']    = $value2;
                        $d3['id_shift']     = $id_shift;
                        $d3['id_lokasi_sub'] = '0';
                        $this->db->insert("mst_shift_lokasi", $d3);
                    } else {
                    }
                }
            } elseif ($kategori == '2') {
                //sub lokasi
                $id_lokasi_sub  = $this->input->post('sublokasi', TRUE);
                foreach ($id_lokasi_sub as $ls => $value3) {
                    if ($value3 != '' || !empty($value3)) {
                        $d4['id_lokasi']    = '0';
                        $d4['id_shift']     = $id_shift;
                        $d4['id_lokasi_sub'] = $value3;
                        $this->db->insert("mst_shift_lokasi", $d4);
                    } else {
                    }
                }
            } elseif ($kategori == '3') {
                //bagian
                $id_bagian      = $this->input->post('bagian', TRUE);
                foreach ($id_bagian as $b => $value4) {
                    if ($value4 != '' || !empty($value4)) {
                        $d5['id_shift']     = $id_shift;
                        $d5['id_bagian']    = $value4;
                        $this->db->insert("mst_shift_bagian", $d5);
                    } else {
                    }
                }
            }
            $this->session->set_flashdata('msg', 'Shift berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_shift($id_shift, $kategori)
    {
        $id['id_shift'] = $id_shift;
        if ($kategori == '1') {
            //lokasi
            $this->db->delete("mst_shift_lokasi", $id);
        } elseif ($kategori == '2') {
            //sub lokasi
            $this->db->delete("mst_shift_lokasi", $id);
        } elseif ($kategori == '3') {
            //bagian
            $this->db->delete("mst_shift_bagian", $id);
        }
        $this->db->delete("mst_shift", $id);
        $this->db->delete("mst_shift_hari", $id);
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_shift()
    {
        $id['id_shift']                 = $this->input->post('cari');

        $q      = $this->db->get_where("mst_shift", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_shift']          = $dt->id_shift;
                $d['nama_shift']        = $dt->nama_shift;
                $d['jam_masuk']         = $dt->jam_masuk;
                $d['jam_keluar']        = $dt->jam_keluar;
                $d['jam_telat']         = $dt->jam_telat;
                $d['jam_setengah_hari'] = $dt->jam_setengah_hari;
            }
            echo json_encode($d);
        } else {
            $d['id_shift']          = '';
            $d['nama_shift']        = '';
            $d['jam_masuk']         = '';
            $d['jam_keluar']        = '';
            $d['jam_telat']         = '';
            $d['jam_setengah_hari'] = '';
            echo json_encode($d);
        }
    }
    public function simpan_edit_shift()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_shift']     = $this->input->post('id_shift');

            $dt['nama_shift']   = $this->input->post('nama_shift');
            $dt['jam_masuk']    = $this->input->post('jam_masuk');
            $dt['jam_keluar']   = $this->input->post('jam_keluar');
            $dt['jam_telat']    = $this->input->post('jam_telat');
            $dt['jam_setengah_hari']    = $this->input->post('jam_setengah_hari');

            $this->db->update('mst_shift', $dt, $id);
            $this->session->set_flashdata('msg', 'Shift berhasil diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_shift_hari($id_shift, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_shift   = $this->enterprise_model->detail_shift($id_shift);
            $nama_shift     = $detail_shift->row()->nama_shift;
            $d['class']     = 'perusahaan';
            $d['id_shift']  = $id_shift;
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Edit Hari ' . $nama_shift;
            $d['content']   = 'perusahaan/master_shift/edit_hari';
            $this->load->view('master', $d);
        }
    }
    public function delete_hari_shift($id_shift, $hari)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_shift'] = $id_shift;
            $id['hari']     = $hari;
            $this->db->delete("mst_shift_hari", $id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function simpan_hari_shift()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_shift       = $this->input->post('id_shift');
            $hari           = $this->input->post('hari', TRUE);
            foreach ($hari as $h => $value1) {
                if ($value1 != '' || !empty($value1)) {
                    $d2['hari']            = $value1;
                    $d2['id_shift']        = $id_shift;
                    $c = $this->db->get_where("mst_shift_hari", $d2);
                    if ($c->num_rows() > 0) {
                    } else {
                        $this->db->insert("mst_shift_hari", $d2);
                    }
                } else {
                }
            }
            $this->session->set_flashdata('msg', 'Shift Hari berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_shift_lokasi($id_shift, $id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_shift   = $this->enterprise_model->detail_shift($id_shift);
            $nama_shift     = $detail_shift->row()->nama_shift;
            $d['class']     = 'perusahaan';
            $d['id_shift']  = $id_shift;
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Edit Lokasi ' . $nama_shift;
            $d['content']   = 'perusahaan/master_shift/edit_lokasi';
            $this->load->view('master', $d);
        }
    }
    public function delete_lokasi_shift($id_shift, $id_lokasi)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_shift'] = $id_shift;
            $id['id_lokasi'] = $id_lokasi;
            $this->db->delete("mst_shift_lokasi", $id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function simpan_lokasi_shift()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_shift       = $this->input->post('id_shift');
            $lokasi         = $this->input->post('lokasi', TRUE);
            foreach ($lokasi as $l => $value1) {
                if ($value1 != '' || !empty($value1)) {
                    $d2['id_lokasi']       = $value1;
                    $d2['id_shift']        = $id_shift;
                    $c = $this->db->get_where("mst_shift_lokasi", $d2);
                    if ($c->num_rows() > 0) {
                    } else {
                        $d['id_lokasi_sub'] = '0';
                        $this->db->insert("mst_shift_lokasi", $d2);
                    }
                } else {
                }
            }
            $this->session->set_flashdata('msg', 'Shift Lokasi berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_shift_sublokasi($id_shift, $id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $logged_in          = $this->session->userdata('logged_in');
            if ($logged_in != TRUE || empty($logged_in)) {
                redirect(base_url('login'));
            } else {
                $detail_shift   = $this->enterprise_model->detail_shift($id_shift);
                $nama_shift     = $detail_shift->row()->nama_shift;
                $d['class']     = 'perusahaan';
                $d['id_shift']  = $id_shift;
                $d['id_p']      = $id_perusahaan;
                $d['header']    = 'Edit Sub Lokasi ' . $nama_shift;
                $d['content']   = 'perusahaan/master_shift/edit_sublokasi';
                $this->load->view('master', $d);
            }
        }
    }
    public function delete_sublokasi_shift($id_shift, $id_sub_lokasi)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_shift']         = $id_shift;
            $id['id_lokasi_sub']    = $id_sub_lokasi;
            $this->db->delete("mst_shift_lokasi", $id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function simpan_sublokasi_shift()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_shift       = $this->input->post('id_shift');
            $sublokasi      = $this->input->post('sublokasi', TRUE);
            foreach ($sublokasi as $sl => $value1) {
                if ($value1 != '' || !empty($value1)) {
                    $d2['id_lokasi_sub']   = $value1;
                    $d2['id_shift']        = $id_shift;
                    $c = $this->db->get_where("mst_shift_lokasi", $d2);
                    if ($c->num_rows() > 0) {
                    } else {
                        $d['id_lokasi'] = '0';
                        $this->db->insert("mst_shift_lokasi", $d2);
                    }
                } else {
                }
            }
            $this->session->set_flashdata('msg', 'Shift Sub Lokasi berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_shift_bagian($id_shift, $id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $logged_in          = $this->session->userdata('logged_in');
            if ($logged_in != TRUE || empty($logged_in)) {
                redirect(base_url('login'));
            } else {
                $detail_shift   = $this->enterprise_model->detail_shift($id_shift);
                $nama_shift     = $detail_shift->row()->nama_shift;
                $d['class']     = 'perusahaan';
                $d['id_shift']  = $id_shift;
                $d['id_p']      = $id_perusahaan;
                $d['header']    = 'Edit Bagian ' . $nama_shift;
                $d['content']   = 'perusahaan/master_shift/edit_bagian';
                $this->load->view('master', $d);
            }
        }
    }
    public function delete_bagian_shift($id_shift_bagian)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_shift_bagian']  = $id_shift_bagian;
            $this->db->delete("mst_shift_bagian", $id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function simpan_bagian_shift()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_shift       = $this->input->post('id_shift');
            $bagian         = $this->input->post('bagian', TRUE);
            foreach ($bagian as $b => $value1) {
                if ($value1 != '' || !empty($value1)) {
                    $d2['id_bagian']        = $value1;
                    $d2['id_shift']         = $id_shift;
                    $c = $this->db->get_where("mst_shift_bagian", $d2);
                    if ($c->num_rows() > 0) {
                    } else {
                        $this->db->insert("mst_shift_bagian", $d2);
                    }
                } else {
                }
            }
            $this->session->set_flashdata('msg', 'Shift Bagian berhasil disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //detail shift
    public function detail_shift($id_shift, $id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_shift   = $this->enterprise_model->detail_shift($id_shift);
            $nama_shift     = $detail_shift->row()->nama_shift;
            $d['class']     = 'perusahaan';
            $d['id_shift']  = $id_shift;
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Detail Shift ' . $nama_shift;
            $d['content']   = 'perusahaan/master_shift/detail_shift';
            $this->load->view('master', $d);
        }
    }
    public function edit_detail_shift()
    {
        $id['id_shift_detail']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_shift_detail", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_shift_detail']   = $dt->id_shift_detail;
                $d['kode_shift']        = $dt->kode_shift;
                $d['shift_ke']          = $dt->shift_ke;
                $d['jam_masuk']         = $dt->jam_masuk;
                $d['jam_keluar']        = $dt->jam_keluar;
                $d['jam_telat']         = $dt->jam_telat;
                $d['setengah_hari']     = $dt->jam_setengah_hari;
            }
            echo json_encode($d);
        } else {
            $d['id_shift_detail']   = '';
            $d['kode_shift']        = '';
            $d['shift_ke']          = '';
            $d['jam_masuk']         = '';
            $d['jam_keluar']        = '';
            $d['jam_telat']         = '';
            $d['setengah_hari']     = '';
            echo json_encode($d);
        }
    }
    public function simpan_detail_shift()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_shift_detail    = $this->input->post('id_shift_detail');
            if (empty($id_shift_detail)) {
                $id['id_shift_detail']  = '0';
            } else {
                $id['id_shift_detail']  = $id_shift_detail;
            }
            $dt['id_shift']         = $this->input->post('id_shift');
            $dt['kode_shift']       = $this->input->post('kode_shift');
            $dt['shift_ke']         = $this->input->post('shift_ke');
            $dt['jam_masuk']        = $this->input->post('masuk');
            $dt['jam_keluar']       = $this->input->post('keluar');
            $dt['jam_telat']        = $this->input->post('telat');
            $dt['jam_setengah_hari'] = $this->input->post('setengah_hari');
            $c  = $this->db->get_where("mst_shift_detail", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_shift_detail", $dt, $id);
                $this->session->set_flashdata('msg', 'Shift berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_shift_detail", $dt);
                $this->session->set_flashdata('msg', 'Shift berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_detail_shift($id_shift_detail)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_shift_detail']  = $id_shift_detail;
            $this->db->delete("mst_shift_detail", $id);
            $this->session->set_flashdata('msg', 'Shift berhasil dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //jabatan
    public function master_jabatan($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail         = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Jabatan | ' . $nama_perusahaan;
            $d['content']   = 'perusahaan/master_jabatan/index_jabatan';
            $this->load->view('master', $d);
        }
    }
    public function save_jabatan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_jabatan     = $this->input->post('id_jabatan');
            if (empty($id_jabatan)) {
                $id['id_jabatan']   = '0';
            } else {
                $id['id_jabatan']   = $id_jabatan;
            }
            $dt['nama_jabatan']     = $this->input->post('nama');
            $dt['id_perusahaan']    = $this->input->post('id_perusahaan');
            $c = $this->db->get_where("mst_jabatan", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_jabatan", $dt, $id);
                $this->session->set_flashdata('msg', 'Jabatan berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_jabatan", $dt);
                $this->session->set_flashdata('msg', 'Jabatan berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_jabatan()
    {
        $id['id_jabatan']     = $this->input->post('cari');
        $c = $this->db->get_where("mst_jabatan", $id);
        if ($c->num_rows() > 0) {
            foreach ($c->result() as $dt) {
                $d['id_jabatan']    = $dt->id_jabatan;
                $d['nama_jabatan']  = $dt->nama_jabatan;
            }
            echo json_encode($d);
        } else {
            $d['id_jabatan']    = '';
            $d['nama_jabatan']  = '';
            echo json_encode($d);
        }
    }
    public function delete_jabatan($id_jabatan)
    {
        $id['id_jabatan'] = $id_jabatan;
        $this->db->delete("mst_jabatan", $id);
        $this->session->set_flashdata('msg', 'Jabatan berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //golongan
    public function master_golongan($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail         = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Golongan | ' . $nama_perusahaan;
            $d['content']   = 'perusahaan/master_golongan/index_golongan';
            $this->load->view('master', $d);
        }
    }
    public function save_golongan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_golongan     = $this->input->post('id_golongan');
            if (empty($id_golongan)) {
                $id['id_golongan']   = '0';
            } else {
                $id['id_golongan']   = $id_golongan;
            }
            $dt['nama_golongan']     = $this->input->post('nama');
            $dt['id_perusahaan']    = $this->input->post('id_perusahaan');
            $c = $this->db->get_where("mst_golongan", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_golongan", $dt, $id);
                $this->session->set_flashdata('msg', 'Golongan berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_golongan", $dt);
                $this->session->set_flashdata('msg', 'Golongan berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_golongan()
    {
        $id['id_golongan']     = $this->input->post('cari');
        $c = $this->db->get_where("mst_golongan", $id);
        if ($c->num_rows() > 0) {
            foreach ($c->result() as $dt) {
                $d['id_golongan']    = $dt->id_golongan;
                $d['nama_golongan']  = $dt->nama_golongan;
            }
            echo json_encode($d);
        } else {
            $d['id_golongan']    = '';
            $d['nama_golongan']  = '';
            echo json_encode($d);
        }
    }
    public function delete_golongan($id_golongan)
    {
        $id['id_golongan'] = $id_golongan;
        $this->db->delete("mst_golongan", $id);
        $this->session->set_flashdata('msg', 'Golongan berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //sholat
    public function master_sholat($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail         = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Sholat | ' . $nama_perusahaan;
            $d['content']   = 'perusahaan/master_sholat/index_sholat';
            $this->load->view('master', $d);
        }
    }
    public function edit_sholat()
    {
        $id['id']   = $this->input->post('cari');

        $q      = $this->db->get_where("sholat_master", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id']            = $dt->id;
                $d['nama_sholat']   = $dt->nama_sholat;
                $d['waktu_awal']    = $dt->waktu_awal;
                $d['waktu_akhir']   = $dt->waktu_akhir;
            }
            echo json_encode($d);
        } else {
            $d['id']            = '';
            $d['nama_sholat']   = '';
            $d['waktu_awal']    = '';
            $d['waktu_akhir']   = '';
            echo json_encode($d);
        }
    }
    public function save_sholat()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id                 = $this->input->post('id');
            if (empty($id)) {
                $ids['id']      = '0';
            } else {
                $ids['id']      = $id;
            }
            $dt['nama_sholat']  = $this->input->post('nama');
            $dt['waktu_awal']   = $this->input->post('awal');
            $dt['waktu_akhir']  = $this->input->post('akhir');
            $dt['id_perusahaan'] = $this->input->post('id_perusahaan');
            $c  = $this->db->get_where("sholat_master", $ids);
            if ($c->num_rows() > 0) {
                $this->db->update("sholat_master", $dt, $ids);
                $this->session->set_flashdata('msg', 'Jadwal Sholat berhasil diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("sholat_master", $dt);
                $this->session->set_flashdata('msg', 'Jadwal Sholat berhasil disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_sholat($id_sholat)
    {
        $id['id'] = $id_sholat;
        $this->db->delete("sholat_master", $id);
        $this->session->set_flashdata('msg', 'Jadwal Sholat berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    //periode
    public function master_periode($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail         = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            $nama_perusahaan = $detail->row()->nama_perusahaan;
            $d['nama']      = $nama_perusahaan;
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_periode($id_perusahaan);
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Lokasi';
            $d['content']   = 'perusahaan/master_periode/index_periode';
            $this->load->view('master', $d);
        }
    }
    public function save_periode()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_periode                = $this->input->post('id_periode');
            $periode_tahun              = $this->input->post('periode_tahun');

            if ($id_periode == '') {
                $id_periode  = '0';
            } else {
                $id_periode  = $id_periode;
            }

            $id['id_periode'] = $id_periode;

            $dt['periode_tahun']   = $periode_tahun;

            $q = $this->db->get_where("mst_periode", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_periode", $dt, $id);
                $this->session->set_flashdata('msg', 'Tahun periode Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_periode", $dt);
                $this->session->set_flashdata('msg', 'Tahun periode Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function hapus()
    {
        $id['id_periode']    = $this->uri->segment(3);
        $dt['status'] = '1';
        $q = $this->db->get_where("mst_periode", $id);
        $row = $q->num_rows();
        if ($row > 0) {
            $this->db->update("mst_periode", $dt, $id);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function aktif()
    {
        $id['id_periode']    = $this->uri->segment(3);
        $dt['status'] = '0';
        $q = $this->db->get_where("mst_periode", $id);
        $row = $q->num_rows();
        if ($row > 0) {
            $this->db->update("mst_periode", $dt, $id);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_periode()
    {
        $id['id_periode']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_periode", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_periode']       = $dt->id_periode;
                $d['nama_value']          = $dt->nama_value;
            }
            echo json_encode($d);
        } else {
            $d['id_periode']       = '';
            $d['nama_value']          = '';
            echo json_encode($d);
        }
    }
    public function delete_periode($id_periode)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_periode'] = $id_periode;
            $this->db->delete("mst_periode", $id);
            $this->session->set_flashdata('msg', 'Periode dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function save_edit_periode()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_periode']    = $this->input->post('id_periode');
            $dt['nama_periode']  = $this->input->post('nama_periode');
            $dt['kode_periode']  = $this->input->post('kode_periode');
            //$dt['id_karyawan']  = $this->input->post('karyawan');
            $this->db->update("mst_periode", $dt, $id);
            $this->session->set_flashdata('msg', 'Lokasi diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //periode penilaian level 2
    public function master_periode_penilaian($id_periode, $id_perusahaan)
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $detail_periode_penilaian  = $this->enterprise_model->detail_periode($id_periode);
            $nama_periode    = $detail_periode_penilaian->row()->periode_tahun;

            // $detail          = $this->enterprise_model->get_detail_perusahaan($id_perusahaan);
            // $nama_perusahaan = $detail->row()->nama_perusahaan;

            $d['class']     = 'perusahaan';
            $d['id_p']      = $id_perusahaan;
            $d['id_periode']   = $id_periode;
            $d['header']    = 'Pertanyaan level 2 | ' . $nama_periode;
            $d['content']   = 'perusahaan/master_periode_penilaian/index_periode_penilaian';
            $this->load->view('master', $d);
        }
    }
    public function save_periode_penilaian()
    {
        $logged_in      = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_p_periode            = $this->input->post('id_p_periode');
            $nama_value              = $this->input->post('nama_value');
            $id_periode              = $this->input->post('id_periode');
            $flag_penilaian          = $this->input->post('flag_penilaian');

            if ($id_p_periode == '') {
                $id_p_periode  = '0';
            } else {
                $id_p_periode  = $id_p_periode;
            }

            $id['id_p_periode']     = $id_p_periode;
            $dt['nama_value']       = $nama_value;
            $dt['id_periode']       = $id_periode;
            $dt['flag_penilaian']   = $flag_penilaian;

            $c = $this->db->get_where("mst_periode_penilaian", $id);
            if ($c->num_rows() > 0) {
                $this->db->update("mst_periode_penilaian", $dt, $id);
                $this->session->set_flashdata('msg', 'Pertanyaan Level 2 Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_periode_penilaian", $dt);
                $this->session->set_flashdata('msg', 'Pertanyaan Level 2 Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_periode_penilaian()
    {
        $id['id_p_periode']   = $this->input->post('cari');

        $q      = $this->db2->get_where("mst_periode_penilaian", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_p_periode']   = $dt->id_p_periode;
                $d['nama_value']     = $dt->nama_value;
                $d['flag_penilaian'] = $dt->flag_penilaian;
            }
            echo json_encode($d);
        } else {
            $d['id_p_periode']  = '';
            $d['nama_value'] = '';
            $d['flag_penilaian'] = '';
            echo json_encode($d);
        }
    }
    public function delete_periode_penilaian($id_p_periode)
    {
        $id['id_p_periode']    = $id_p_periode;
        $this->db->delete("mst_periode_penilaian", $id);
        $this->session->set_flashdata('msg', 'Pertanyaan Level 2 Sukses dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    //jenis form
    public function master_jenis_form($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_jenis_form($id_perusahaan);
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Lokasi';
            $d['content']   = 'perusahaan/master_jenis_form/index_jenis_form';
            $this->load->view('master', $d);
        }
    }
    public function save_jenis_form()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_jenis_form           = $this->input->post('id_jenis_form');
            $nama_value              = $this->input->post('nama_value');
            $flag_jenis_form         = $this->input->post('flag_jenis_form');

            if ($id_jenis_form == '') {
                $id_jenis_form  = '0';
            } else {
                $id_jenis_form  = $id_jenis_form;
            }

            $id['id_jenis_form'] = $id_jenis_form;

            $dt['nama_value']   = $nama_value;
            $dt['flag_jenis_form']   = $flag_jenis_form;
            $q = $this->db->get_where("mst_jenis_form", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_jenis_form", $dt, $id);
                $this->session->set_flashdata('msg', 'Data Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_jenis_form", $dt);
                $this->session->set_flashdata('msg', 'Data Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_jenis_form()
    {
        $id['id_jenis_form']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_jenis_form", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_jenis_form']       = $dt->id_jenis_form;
                $d['nama_value']          = $dt->nama_value;
                $d['flag_jenis_form']     = $dt->flag_jenis_form;
            }
            echo json_encode($d);
        } else {
            $d['id_jenis_form']       = '';
            $d['nama_value']          = '';
            $d['flag_jenis_form']     = '';
            echo json_encode($d);
        }
    }
    public function delete_jenis_form($id_jenis_form)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_jenis_form'] = $id_jenis_form;
            $this->db->delete("mst_jenis_form", $id);
            $this->session->set_flashdata('msg', 'Data dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function save_edit_jenis_form()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_jenis_form']    = $this->input->post('id_jenis_form');
            $dt['nama_periode']  = $this->input->post('nama_periode');
            $dt['kode_periode']  = $this->input->post('kode_periode');
            //$dt['id_karyawan']  = $this->input->post('karyawan');
            $this->db->update("mst_jenis_form", $dt, $id);
            $this->session->set_flashdata('msg', 'Lokasi diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //penilaian 1-2
    public function master_penilaian_1_2($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_penilaian_1_2($id_perusahaan);
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Lokasi';
            $d['content']   = 'perusahaan/master_penilaian_1_2/index_penilaian_1_2';
            $this->load->view('master', $d);
        }
    }
    public function save_penilaian_1_2()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_nilai_pkk  = $this->input->post('id_nilai_pkk');
            $nama_value    = $this->input->post('nama_value');
            $bobot         = $this->input->post('bobot');

            if ($id_nilai_pkk == '') {
                $id_nilai_pkk  = '0';
            } else {
                $id_nilai_pkk  = $id_nilai_pkk;
            }

            $id['id_nilai_pkk'] = $id_nilai_pkk;
            $dt['nama_value']   = $nama_value;
            $dt['bobot']   = $bobot;

            $q = $this->db->get_where("mst_penilaian_1_2", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_penilaian_1_2", $dt, $id);
                $this->session->set_flashdata('msg', 'Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_penilaian_1_2", $dt);
                $this->session->set_flashdata('msg', 'Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_penilaian_1_2()
    {
        $id['id_nilai_pkk']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_penilaian_1_2", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_nilai_pkk']   = $dt->id_nilai_pkk;
                $d['nama_value']     = $dt->nama_value;
                $d['bobot']          = $dt->bobot;
            }
            echo json_encode($d);
        } else {
            $d['id_nilai_pkk']   = '';
            $d['nama_value']     = '';
            $d['bobot']          = '';

            echo json_encode($d);
        }
    }
    public function delete_penilaian_1_2($id_nilai_pkk)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_nilai_pkk'] = $id_nilai_pkk;
            $this->db->delete("mst_penilaian_1_2", $id);
            $this->session->set_flashdata('msg', 'Data dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // public function save_edit_penilaian_1_2()
    // {
    //     $logged_in          = $this->session->userdata('logged_in');
    //     if ($logged_in != TRUE || empty($logged_in)) {
    //         redirect(base_url('login'));
    //     } else {
    //         $id['id_nilai_pkk']    = $this->input->post('id_nilai_pkk');
    //         $dt['nama_value']  = $this->input->post('nama_value');
    //         $dt['bobot']  = $this->input->post('bobot');
    //         //$dt['id_karyawan']  = $this->input->post('karyawan');
    //         $this->db->update("mst_penilaian_1_2", $dt, $id);
    //         $this->session->set_flashdata('msg', 'Lokasi diupdate');
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }
    // }

    //penilaian 3-7 form penilaian
    public function master_penilaian_3_7_form_penilaian($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_penilaian_3_7_form_penilaian($id_perusahaan);
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Lokasi';
            $d['content']   = 'perusahaan/master_penilaian_3_7_form_penilaian/index_penilaian_3_7_form_penilaian';
            $this->load->view('master', $d);
        }
    }
    public function save_penilaian_3_7_form_penilaian()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_form_penilaian  = $this->input->post('id_form_penilaian');
            $nama_value    = $this->input->post('nama_value');

            if ($id_form_penilaian == '') {
                $id_form_penilaian  = '0';
            } else {
                $id_form_penilaian  = $id_form_penilaian;
            }

            $id['id_form_penilaian'] = $id_form_penilaian;
            $dt['nama_value']   = $nama_value;

            $q = $this->db->get_where("mst_penilaian_3_7_form_penilaian", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_penilaian_3_7_form_penilaian", $dt, $id);
                $this->session->set_flashdata('msg', 'Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_penilaian_3_7_form_penilaian", $dt);
                $this->session->set_flashdata('msg', 'Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_penilaian_3_7_form_penilaian()
    {
        $id['id_form_penilaian']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_penilaian_3_7_form_penilaian", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_form_penilaian']   = $dt->id_form_penilaian;
                $d['nama_value']     = $dt->nama_value;
            }
            echo json_encode($d);
        } else {
            $d['id_form_penilaian']   = '';
            $d['nama_value']     = '';

            echo json_encode($d);
        }
    }
    public function delete_penilaian_3_7_form_penilaian($id_form_penilaian)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_form_penilaian'] = $id_form_penilaian;
            $this->db->delete("mst_penilaian_3_7_form_penilaian", $id);
            $this->session->set_flashdata('msg', 'Data dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //penilaian 3-7 form a
    public function master_penilaian_3_7_form_a($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_penilaian_3_7_form_a($id_perusahaan);
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Lokasi';
            $d['content']   = 'perusahaan/master_penilaian_3_7_form_a/index_penilaian_3_7_form_a';
            $this->load->view('master', $d);
        }
    }
    public function save_penilaian_3_7_form_a()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_form_a  = $this->input->post('id_form_a');
            $nama_value    = $this->input->post('nama_value');
            $description    = $this->input->post('description');

            if ($id_form_a == '') {
                $id_form_a  = '0';
            } else {
                $id_form_a  = $id_form_a;
            }

            $id['id_form_a'] = $id_form_a;
            $dt['nama_value']   = $nama_value;
            $dt['description']   = $description;

            $q = $this->db->get_where("mst_penilaian_3_7_form_a", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_penilaian_3_7_form_a", $dt, $id);
                $this->session->set_flashdata('msg', 'Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_penilaian_3_7_form_a", $dt);
                $this->session->set_flashdata('msg', 'Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_penilaian_3_7_form_a()
    {
        $id['id_form_a']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_penilaian_3_7_form_a", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_form_a']   = $dt->id_form_a;
                $d['nama_value']     = $dt->nama_value;
                $d['description']     = $dt->description;
            }
            echo json_encode($d);
        } else {
            $d['id_form_a']   = '';
            $d['nama_value']     = '';
            $d['description']     = '';

            echo json_encode($d);
        }
    }
    public function delete_penilaian_3_7_form_a($id_form_a)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_form_a'] = $id_form_a;
            $this->db->delete("mst_penilaian_3_7_form_a", $id);
            $this->session->set_flashdata('msg', 'Data dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //penilaian 3-7 form b
    public function master_penilaian_3_7_form_b($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_penilaian_3_7_form_b($id_perusahaan);
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Lokasi';
            $d['content']   = 'perusahaan/master_penilaian_3_7_form_b/index_penilaian_3_7_form_b';
            $this->load->view('master', $d);
        }
    }
    public function save_penilaian_3_7_form_b()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_form_b  = $this->input->post('id_form_b');
            $nama_value    = $this->input->post('nama_value');
            $description    = $this->input->post('description');

            if ($id_form_b == '') {
                $id_form_b  = '0';
            } else {
                $id_form_b  = $id_form_b;
            }

            $id['id_form_b'] = $id_form_b;
            $dt['nama_value']   = $nama_value;
            $dt['description']   = $description;

            $q = $this->db->get_where("mst_penilaian_3_7_form_b", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_penilaian_3_7_form_b", $dt, $id);
                $this->session->set_flashdata('msg', 'Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_penilaian_3_7_form_b", $dt);
                $this->session->set_flashdata('msg', 'Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_penilaian_3_7_form_b()
    {
        $id['id_form_b']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_penilaian_3_7_form_b", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_form_b']   = $dt->id_form_b;
                $d['nama_value']     = $dt->nama_value;
                $d['description']     = $dt->description;
            }
            echo json_encode($d);
        } else {
            $d['id_form_b']   = '';
            $d['nama_value']     = '';
            $d['description']     = '';

            echo json_encode($d);
        }
    }
    public function delete_penilaian_3_7_form_b($id_form_b)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_form_b'] = $id_form_b;
            $this->db->delete("mst_penilaian_3_7_form_b", $id);
            $this->session->set_flashdata('msg', 'Data dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    //feedback karyawan
    public function master_feedback_karyawan($id_perusahaan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $d['class']     = 'perusahaan';
            $d['data']      = $this->enterprise_model->get_feedback_karyawan($id_perusahaan);
            $d['id_p']      = $id_perusahaan;
            $d['header']    = 'Lokasi';
            $d['content']   = 'perusahaan/master_feedback_karyawan/index_feedback_karyawan';
            $this->load->view('master', $d);
        }
    }
    public function save_feedback_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id_fb_karyawan                = $this->input->post('id_fb_karyawan');
            $nama_value              = $this->input->post('nama_value');
            $description              = $this->input->post('description');

            if ($id_fb_karyawan == '') {
                $id_fb_karyawan  = '0';
            } else {
                $id_fb_karyawan  = $id_fb_karyawan;
            }

            $id['id_fb_karyawan'] = $id_fb_karyawan;
            $dt['nama_value']   = $nama_value;
            $dt['description']   = $description;

            $q = $this->db->get_where("mst_feedback_karyawan", $id);
            $row = $q->num_rows();
            if ($row > 0) {
                $this->db->update("mst_feedback_karyawan", $dt, $id);
                $this->session->set_flashdata('msg', 'Data Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->insert("mst_feedback_karyawan", $dt);
                $this->session->set_flashdata('msg', 'Data Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_feedback_karyawan()
    {
        $id['id_fb_karyawan']   = $this->input->post('cari');

        $q      = $this->db->get_where("mst_feedback_karyawan", $id);
        $row    = $q->num_rows();
        if ($row > 0) {
            foreach ($q->result() as $dt) {
                $d['id_fb_karyawan']       = $dt->id_fb_karyawan;
                $d['nama_value']          = $dt->nama_value;
                $d['description']          = $dt->description;
            }
            echo json_encode($d);
        } else {
            $d['id_fb_karyawan']       = '';
            $d['nama_value']          = '';
            $d['description']          = '';
            echo json_encode($d);
        }
    }
    public function delete_feedback_karyawan($id_fb_karyawan)
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_fb_karyawan'] = $id_fb_karyawan;
            $this->db->delete("mst_feedback_karyawan", $id);
            $this->session->set_flashdata('msg', 'Data dihapus');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function save_edit_feedback_karyawan()
    {
        $logged_in          = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect(base_url('login'));
        } else {
            $id['id_fb_karyawan']    = $this->input->post('id_fb_karyawan');
            $dt['nama_value']  = $this->input->post('nama_value');
            $dt['description']  = $this->input->post('description');
            //$dt['id_karyawan']  = $this->input->post('karyawan');
            $this->db->update("mst_feedback_karyawan", $dt, $id);
            $this->session->set_flashdata('msg', 'Lokasi diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
