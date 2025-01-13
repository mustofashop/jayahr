<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Users extends CI_Controller {
    function __construct()
    {
        parent::__construct();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));		
		$this->load->library('session');		
        $this->load->helper(array('form', 'url'));
		$this->load->model('sischool_model');
    }
    // delete user
    public function delete_user(){
        $id['id_user_sekolah']	    = $this->uri->segment(3);
        $this->db->delete("mst_user_sekolah",$id);
        redirect($_SERVER['HTTP_REFERER']);
    }
     //delete user detail
     public function delete_sekolah_user(){
        $id['id_mst_sekolah_detail']= $this->uri->segment(3);
        $this->db->delete("mst_user_sekolah_detail",$id);
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function admin_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'users';
            $d['data']      = $this->sischool_model->get_admin_sekolah();
            $d['header']    = 'Admin Sekolah';
            $d['content']   = 'users/admin_sekolah/index_sekolah';
            $this->load->view('master',$d);
        }
    } 
    public function edit_admin_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_user_sekolah']      =   $this->input->post('cari');
			
            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                foreach($q->result() as $dt){
                    $d['id_user']        = $dt->id_user_sekolah;
                    $d['id_sekolah']     = $dt->id_sekolah;
                    $d['nama_lengkap']   = $dt->nama_lengkap;
                    $d['username']       = $dt->username;
                    $d['leader']         = $dt->flag_leader;
                    $d['ip']             = $dt->ip_sekolah;
                }
                echo json_encode($d);
            }else{
                    $d['id_user']        = '';
                    $d['id_sekolah']     = '';
                    $d['nama_lengkap']   = '';
                    $d['username']       = '';
                    $d['leader']         = '';
                    $d['ip']             = '';
                echo json_encode($d);
            }
        }
    }
    public function save_admin_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $id_sekolah             = $this->input->post('sekolah');
            $nama                   = $this->input->post('nama_lengkap');
            $username               = $this->input->post('username');
            $password               = $this->input->post('password');
            $level                  = '0';
            
            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            $dt['id_sekolah']       = $id_sekolah;
            $dt['nama_lengkap']     = $nama;
            $dt['username']         = $username;
            $dt['password']         = md5($password);
            $dt['level']            = $level; 

            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_user_sekolah",$dt,$id);
                $this->session->set_flashdata('msg', 'Admin Sekolah Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_user_sekolah",$dt);
                $this->session->set_flashdata('msg', 'Admin Sekolah Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    // admin yayasan
    public function yayasan(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'users';
            $d['data']      = $this->sischool_model->get_admin_yayasan();
            $d['header']    = 'Admin Yayasan';
            $d['content']   = 'users/admin_yayasan/index_yayasan';
            $this->load->view('master',$d);
        }
    }
    public function save_admin_yayasan(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            // $id_sekolah             = $this->input->post('sekolah');
            $nama                   = $this->input->post('nama_lengkap');
            $username               = $this->input->post('username');
            $password               = $this->input->post('password');
            $ip                     = $this->input->post('ip');
            $level                  = '1';

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            // $dt['id_sekolah']       = $id_sekolah;
            $dt['nama_lengkap']     = $nama;
            $dt['username']         = $username;
            $dt['password']         = md5($password);
            $dt['level']            = $level;
            $dt['ip_sekolah']       = $ip;
            //logo 
            $base64 = "";
            $css = "";
            $tag = "";
            
            if(isset($_FILES['image']['name'])){
                $file = rand(0, 10000000).$_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) {
                    if($fp = fopen($file,"rb", 0))
                    {
                        $picture = fread($fp,filesize($file));
                        fclose($fp);
                        $base64         = base64_encode($picture);
                        $tag            = '<img src="data:image/jpg;base64,'.$base64.'" alt="" />';
                        $css            = 'url(data:image/jpg;base64,'.str_replace("\n", "", $base64).'); ';
                        $dt['logo_yayasan']    = $base64;
                    }
                }
            }else{
                echo "Logo not change";
            }
            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_user_sekolah",$dt,$id);
                $this->session->set_flashdata('msg', 'Admin Yayasan Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_user_sekolah",$dt);
                $this->session->set_flashdata('msg', 'Admin Yayasan Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    // admin kepsek
    public function kepsek(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'users';
            $d['data']      = $this->sischool_model->get_admin_kepsek();
            $d['header']    = 'Admin Kepsek';
            $d['content']   = 'users/admin_kepsek/index_kepsek';
            $this->load->view('master',$d);
        }
    }
    public function save_admin_kepsek(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $id_sekolah             = $this->input->post('sekolah');
            $nama                   = $this->input->post('nama_lengkap');
            $username               = $this->input->post('username');
            $password               = $this->input->post('password');
            $level                  = '2';

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            $dt['id_sekolah']       = $id_sekolah;
            $dt['nama_lengkap']     = $nama;
            $dt['username']         = $username;
            $dt['password']         = md5($password);
            $dt['level']            = $level; 

            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_user_sekolah",$dt,$id);
                $this->session->set_flashdata('msg', 'Admin Kepsek Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_user_sekolah",$dt);
                $this->session->set_flashdata('msg', 'Admin Kepsek Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    // admin guru
    public function guru(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'users';
            $d['header']    = 'Admin Guru';
            $d['content']   = 'users/admin_guru/index_guru';
            $this->load->view('master',$d);
        }
    }
    public function list_guru(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_sekolah     = $this->input->get('sekolah');
            $data           = $this->sischool_model->get_admin_guru($id_sekolah);
            //echo $this->db->last_query();
            $check          = $data->num_rows();
            if($check > 0){
                $nama_sekolah   = $data->row()->nama_sekolah;
            }else{
                $get_detail     = $this->sischool_model->get_detail_sekolah($id_sekolah);
                $nama_sekolah   = $get_detail->row()->nama_sekolah;
            }
            $d['class']     = 'users';
            $d['data']      = $data;
            $d['id_sekolah']= $id_sekolah;
            $d['header']    = 'List Guru '.$nama_sekolah;
            $d['content']   = 'users/admin_guru/list_guru';
            $this->load->view('master',$d);
        }
    }
    public function edit_guru(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id['id_user_sekolah']      =   $this->input->post('cari');
			
            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                foreach($q->result() as $dt){
                    $d['id_user']        = $dt->id_user_sekolah;
                    $d['badgenumber']    = $dt->badgenumber;
                    $d['nama_lengkap']   = $dt->nama_lengkap;
                    $d['nip']            = $dt->nip;
                    $d['no_telepon']     = $dt->no_telepon;
                }
                echo json_encode($d);
            }else{
                    $d['id_user']        = '';
                    $d['badgenumber']    = '';
                    $d['nama_lengkap']   = '';
                    $d['nip']            = '';
                    $d['no_telepon']     = '';
                echo json_encode($d);
            }
        }
    }
    public function save_guru(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user        = $this->input->post('id_user');
            $id_sekolah     = $this->input->post('id_sekolah');
            $nama_guru      = $this->input->post('nama_lengkap');
            $nip            = $this->input->post('nip');
            $no_telepon     = $this->input->post('no_telepon');
            $level          = '3';
            $password       = md5('1234');
            $badgenumber    = $this->input->post('badgenumber');
            $username       = 'guru_'.$no_telepon;

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            $dt['id_sekolah']       = $id_sekolah;
            $dt['badgenumber']      = $badgenumber;
            $dt['username']         = $username;
            $dt['nama_lengkap']     = $nama_guru;
            $dt['nip']              = $nip;
            $dt['no_telepon']       = $no_telepon;
            $dt['level']            = $level;
            $dt['password']         = $password;

            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_user_sekolah",$dt,$id);
                $this->session->set_flashdata('msg', 'Data Guru Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_user_sekolah",$dt);
                $this->session->set_flashdata('msg', 'Data Guru Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function import_guru(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            date_default_timezone_set('Asia/Jakarta'); 
            $config['upload_path']      = './assets/'; 
            $config['allowed_types']    = '*';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file_excel')) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('errornya' => $this->upload->display_errors());
                print_r($error);
            } else {
                // jika berhasil upload ambil data dan masukkan ke database
                $upload_data            = $this->upload->data();
            }
                $inputFileName          = './assets/'.$upload_data['file_name'];
                try {
                    $inputFileType      = IOFactory::identify($inputFileName);
                    $objReader          = IOFactory::createReader($inputFileType);
                    $objPHPExcel        = $objReader->load($inputFileName);
                } catch(Exception $e) {
                    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                }
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                for ($row = 3; $row <= $highestRow; $row++){                                  
                    $rowData            = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                            NULL,
                                            TRUE,
                                            FALSE);                                                               
                $data = array(
                    "no"        => $rowData[0][0],
                    "pin"       => $rowData[0][1],
                    "name"      => $rowData[0][2],
                    "FPHONE"    => $rowData[0][3],
                );
                $dtx = array(
                    'no'        => $data['no'],
                    'pin'       => $data['pin'],
                    'name'      => $data['name'],
                    'FPHONE'    => $data['FPHONE'],
                    // 'userid' => $data['no'],
                );
                $dt['level']            = '3';
                $dt['username']         = 'guru_'.$dtx['FPHONE'];
                $dt['password']         = md5('1234');
                $dt['nama_lengkap']     = $dtx['name'];
                $dt['no_telepon']       = $dtx['FPHONE'];
                $dt['userid']           = '0';
                $dt['id_sekolah']       = $this->input->post('id_sekolah');
                $dt['nip']              = $dtx['pin'];
                $dt['created_at']       = date('Y-m-d h:i:s');
                
                //badgenumber
                $count_no = strlen($dtx['no']);
                if($count_no > 9){
                    $pin_mesin          = $dtx['no'];
                }else{
                    $jml_nol_no         = 9-$count_no;
                    $nol_no             = str_repeat("0", $jml_nol_no);
                    $pin_mesin          = $nol_no.$dtx['no'];
                }
                $this->db->where('badgenumber', $pin_mesin);
                $q = $this->db->get('mst_user_sekolah');
                if ( $q->num_rows() > 0 ){
                    if($this->db->where('badgenumber', $pin_mesin)->update('mst_user_sekolah', $dt)){
                        echo "Data Sukses diperbarui";
                    }else{
                        print $this->db->_error_message();
                    }
                }else{
                    if($this->db->set('badgenumber', $pin_mesin)->insert('mst_user_sekolah', $dt)){
                        echo "Data sukses diinput";
                    }else{
                        print $this->db->_error_message();
                    }
                }	
            }
            $this->session->set_flashdata('msg', 'Upload Guru Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // admin tu
    public function tu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'users';
            $d['data']      = $this->sischool_model->get_admin_tu();
            $d['header']    = 'Admin TU';
            $d['content']   = 'users/admin_tu/index_tu';
            $this->load->view('master',$d);
        }
    }
    public function save_admin_tu_1(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $nama                   = $this->input->post('nama_lengkap');
            $id_sekolah             = $this->input->post('sekolah');
            $username               = $this->input->post('username');
            $password               = $this->input->post('password');
            $level                  = '4';

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            $dt['id_sekolah']       = $id_sekolah;
            $dt['nama_lengkap']     = $nama;
            $dt['username']         = $username;
            $dt['password']         = md5($password);
            $dt['level']            = $level; 

            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_user_sekolah",$dt,$id);
                $this->session->set_flashdata('msg', 'Admin TU Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_user_sekolah",$dt);
                $this->session->set_flashdata('msg', 'Admin TU Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function save_admin_tu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $nama                   = $this->input->post('nama_lengkap');
            $username               = $this->input->post('username');
            $password               = $this->input->post('password');
            $level                  = '4';
            $leader                 = $this->input->post('leader');

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            $dt['nama_lengkap']     = $nama;
            $dt['username']         = $username;
            $dt['password']         = md5($password);
            $dt['level']            = $level; 
            $dt['leader']           = $leader;

            $this->db->insert("mst_user_sekolah",$dt);
             //get user
            $idnya                  = $this->db->insert_id('id_user_sekolah');
            $id_sekolah             = $this->input->post('sekolah',true);
            foreach($id_sekolah as $ids => $d){
                $isp[] = array(
                    'id_sekolah'        => $d,
                    'id_user_sekolah'   => $idnya
                );
            }
            $this->db->insert_batch("mst_user_sekolah_detail",$isp);
            $this->session->set_flashdata('msg', 'Admin TU Sukses disimpan');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function edit_user_tu($id){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $data1          = $this->sischool_model->list_sekolah_user($id);
            $data           = $this->sischool_model->list_sekolah_user_detail($id);
            foreach ($data1->result() as $dt) {
                $id_user    = $dt->id_user_sekolah;
                $nama_lngkp = $dt->nama_lengkap;
                $username   = $dt->username;
                $leader     = $dt->flag_leader;
            }
            $d = array(
                'id_user'   => $id_user,
                'nama_lngkp'=> $nama_lngkp,
                'username'  => $username,
                'leader'    => $leader,
                'data'      => $data,
                'header'    => 'Edit Admin TU',
                'content'   => 'users/admin_tu/edit_tu'
            );
            $this->load->view('master',$d);
        }
    }
    public function save_admin_tambah_sekolah(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $sekolah                = $this->input->post('sekolah');
            $dt['id_sekolah']       = $sekolah;
            $dt['id_user_sekolah']  = $id_user;
            $this->db->insert("mst_user_sekolah_detail",$dt);
            $this->session->set_flashdata('msg', 'Sekolah Sukses ditambah');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function save_edit_user_tu(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $nama_lengkap           = $this->input->post('nama_lengkap');
            $username               = $this->input->post('username');
            $password               = $this->input->post('password');
            $leader                 = $this->input->post('leader');

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']   = $id_users;
            $dt['nama_lengkap']      = $nama_lengkap;
            $dt['username']          = $username;
            $dt['password']          = md5($password);
            $dt['flag_leader']       = $leader;

            $this->db->update("mst_user_sekolah",$dt,$id);
            $this->session->set_flashdata('msg', 'Admin TU Sukses diupdate');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // admin bp
    public function bp(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $d['class']     = 'users';
            $d['data']      = $this->sischool_model->get_admin_bp();
            $d['header']    = 'Admin BP';
            $d['content']   = 'users/admin_bp/index_bp';
            $this->load->view('master',$d);
        }
    }
    public function save_admin_bp(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $id_sekolah             = $this->input->post('sekolah');
            $nama                   = $this->input->post('nama_lengkap');
            $username               = $this->input->post('username');
            $password               = $this->input->post('password');
            $level                  = '5';

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            $dt['id_sekolah']       = $id_sekolah;
            $dt['nama_lengkap']     = $nama;
            $dt['username']         = $username;
            $dt['password']         = md5($password);
            $dt['level']            = $level; 

            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_user_sekolah",$dt,$id);
                $this->session->set_flashdata('msg', 'Admin BP Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_user_sekolah",$dt);
                $this->session->set_flashdata('msg', 'Admin BP Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    // admin walas
    public function save_walas(){
        $logged_in          = $this->session->userdata('logged_in');
        if($logged_in != TRUE || empty($logged_in))
        {
            redirect(base_url('login'));
        }else{
            $id_user                = $this->input->post('id_user');
            $id_sekolah             = $this->input->post('id_sekolah');
            $kelas                  = $this->input->post('kelas');
            $walas                  = $this->input->post('walas');
            $get_nama               = $this->sischool_model->get_guru_telepon($walas);
            $hasil                  = $get_nama->row()->nama_lengkap;
            $nama                   = $hasil;
            $username               = 'walas_'.$walas;
            $password               = '1234';
            $level                  = '6';

            if($id_user == ''){
                $id_users           = '0';
            }else{
                $id_users           = $id_user;
            }

            $id['id_user_sekolah']  = $id_users;

            $dt['id_sekolah']       = $id_sekolah;
            $dt['nama_lengkap']     = $nama;
            $dt['username']         = $username;
            $dt['password']         = md5($password);
            $dt['level']            = $level; 
            $dt['kode_kelas']       = $kelas;
            $dt['no_telepon']       = $walas;

            $q = $this->db->get_where("mst_user_sekolah",$id);
            $row = $q->num_rows();
            if($row>0){
                $this->db->update("mst_user_sekolah",$dt,$id);
                $this->session->set_flashdata('msg', 'Admin WALAS Sukses diupdate');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->db->insert("mst_user_sekolah",$dt);
                $this->session->set_flashdata('msg', 'Admin WALAS Sukses disimpan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}