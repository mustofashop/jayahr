<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {
    public function index()
	{   
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $d['header']    = 'Profil';
            $d['content']   = 'profil';
		    $this->load->view('master',$d);
        }
    }
    public function simpan()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $this->load->helper("file");
            $id['id_karyawan']  = $this->input->post('id');
            $dt['nama_lengkap'] = $this->input->post('name');
            $dt['no_telepon']   = $this->input->post('no_telepon');
            
            $lebar_gambar       = 640;
            $tinggi_gambar      = 480;
        
            $config['upload_path']          = './assets/foto_karyawan/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['encrypt_name']         = TRUE;
            // $config['max_size']             = 1024; // 1MB;
            //custom upload
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $gbr                            = $this->upload->data();
                if($_FILES['image']['size'] >  100000){
                    $config['image_library']    ='gd2';
                    $config['source_image']     ='./assets/foto_karyawan/'.$gbr['file_name'];
                    $config['create_thumb']     = FALSE;
                    $config['maintain_ratio']   = TRUE;
                    $config['quality']          = '100%';
                    $config['width']            = $lebar_gambar;
                    $config['height']           = $tinggi_gambar;
                    $config['new_image']        = './assets/foto_karyawan/'.$gbr['file_name'];
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $foto_profil                = './assets/foto_karyawan/'.$gbr['file_name'];
                    $dt['foto_file']            = $gbr['file_name'];
                }else{
                    $foto_profil                = './assets/foto_karyawan/'.$gbr['file_name'];
                    $dt['foto_file']            = $gbr['file_name'];
                }
                // encode
                $file_base64                    = base64_encode(file_get_contents($foto_profil)); 
                $dt['foto_64']                  = $file_base64;
                // unlink($foto_profil);
            }
            $this->db->update("mst_karyawan",$dt,$id);
            $this->session->set_flashdata('msg', 'Profil Berhasil diubah');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function simpan_password()
    {
        $masuk  = $this->session->userdata('masuk_k');
        if($masuk != TRUE){
            redirect(base_url('login'));
        }else{
            $id['id_karyawan']  = $this->input->post('id');
            $password1          = $this->input->post('password');
            $password2          = $this->input->post('konfirmasi');
            if($password1 != $password2){
                $this->session->set_flashdata('error', 'Password dan konfirmasi password tidak sesuai.');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $dt['password'] = md5($password1);
                $this->db->update("mst_karyawan",$dt,$id);
                $this->session->set_flashdata('msg', 'Password Berhasil diubah');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}