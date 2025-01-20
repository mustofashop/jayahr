<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('./vendor/autoload.php');

class Trans_pkk extends CI_Controller
{
    public function save_set_pkk()
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
}
