<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_e_model extends CI_Model {
    public function list_menu_utama()
    {
        $q = $this->db->query("SELECT *
        FROM mst_menu_parent_e
        order by urutan asc");
        return $q;
    }
    public function list_level_parent($id_menu_parent)
    {
        $q = $this->db->query("SELECT string_agg(CASE when level = 1 THEN 'Admin Head Office' when level = 2 THEN 'Admin Cabang' when level = 3 THEN 'Admin Keuangan' when level = 4 THEN 'Manager Keuangan' when level = 5 THEN 'Admin HRD' when level = 6 THEN 'Customer Service' else'PIC' END, ', ') as nama_level
        FROM mst_menu_parent_e_level a
        WHERE a.id_menu_parent = '$id_menu_parent'");
        return $q;
    }
    public function list_level_menu_utama($id_menu_parent)
    {
        $q = $this->db->query("SELECT id_parent_level,
        level,
        case 
        when level = 1 then
        'Admin Head Office'
        when level = 2 then
        'Admin Cabang'
        when level = 3 then
        'Admin Keuangan'
        when level = 4 then
        'Manager Keuangan'
        when level = 5 then
        'Admin HRD'
        when level = 6 then
        'Customer Service'
        else
        'PIC'
        end as nama_level
        FROM mst_menu_parent_e_level
        where id_menu_parent = '$id_menu_parent'
        order by level asc");
        return $q;
    }
    public function detail_menu_utama($id_menu_parent)
    {
        $q = $this->db->query("SELECT nama_parent
        FROM mst_menu_parent_e
        where id_menu_parent = '$id_menu_parent'");
        return $q;
    }
    public function detail_isi_menu($id_menu)
    {
        $q = $this->db->query("SELECT nama_menu
        FROM mst_menu_e
        where id_menu = '$id_menu'");
        return $q;
    }
    public function list_isi_menu($id_menu_parent)
    {
        $q = $this->db->query("SELECT id_menu,
        nama_menu,
        link,
        urutan
        FROM mst_menu_e
        where id_menu_parent = '$id_menu_parent'
        order by urutan asc");
        return $q;
    }
    public function list_level_isi($id_menu)
    {
        $q = $this->db->query("SELECT string_agg(CASE when level = 1 THEN 'Admin Head Office' when level = 2 THEN 'Admin Cabang' when level = 3 THEN 'Admin Keuangan' when level = 4 THEN 'Manager Keuangan' when level = 5 THEN 'Admin HRD' when level = 6 THEN 'Customer Service' else'PIC' END, ', ') as nama_level
        FROM mst_menu_e_level a
        WHERE a.id_menu = '$id_menu'");
        return $q;
    }
    public function list_level_isi_menu($id_menu)
    {
        $q = $this->db->query("SELECT id_menu_level,
        level,
        case 
        when level = 1 then
        'Admin Head Office'
        when level = 2 then
        'Admin Cabang'
        when level = 3 then
        'Admin Keuangan'
        when level = 4 then
        'Manager Keuangan'
        when level = 5 then
        'Admin HRD'
        when level = 6 then
        'Customer Service'
        else
        'PIC'
        end as nama_level
        FROM mst_menu_e_level
        where id_menu = '$id_menu'
        order by level asc");
        return $q;
    }
    //setting menu
    public function list_perusahaan()
    {
        $q = $this->db->query("SELECT id_perusahaan, nama_perusahaan
        from mst_perusahaan
        order by nama_perusahaan asc");
        return $q;
    }
    public function detail_perusahaan($id_perusahaan)
    {
        $q = $this->db->query("SELECT nama_perusahaan
        FROM mst_perusahaan
        where id_perusahaan = '$id_perusahaan'");
        return $q;
    }
    public function list_trans_menu_utama($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_trans_parent_menu,
        a.id_menu_parent,
        b.nama_parent
        FROM mst_menu_parent_e_trans a
        JOIN mst_menu_parent_e b ON a.id_menu_parent = b.id_menu_parent
        WHERE a.id_perusahaan = '$id_perusahaan'
        order by b.urutan asc");
        return $q;
    }
    public function detail_parent_menu($id_menu_parent)
    {
        $q = $this->db->query("SELECT nama_parent
        FROM mst_menu_parent_e
        where id_menu_parent = '$id_menu_parent'");
        return $q;
    }
    public function list_trans_isi_menu($id_trans_parent_menu)
    {
        $q = $this->db->query("SELECT a.id_trans_menu,
        b.nama_menu
        FROM mst_menu_e_trans a
        JOIN mst_menu_e b ON b.id_menu = a.id_menu
        WHERE a.id_trans_parent_menu = '$id_trans_parent_menu'
        ORDER BY b.urutan asc");
        return $q;
    }
    //user menu
    public function list_user_login($id_perusahaan)
    {
        $q = $this->db->query("SELECT b.id_karyawan,
        b.nama_lengkap,
        string_agg(c.nama_level_e,', ') AS nama_level
        FROM mst_level_login_p a
        JOIN mst_karyawan b ON a.id_karyawan = b.id_karyawan
        JOIN mst_level_e c ON c.kode_level_e = a.level
        where b.id_perusahaan = '$id_perusahaan'
        GROUP BY b.id_karyawan
        ORDER BY b.nama_lengkap asc");
        return $q;
    }
    public function detail_karyawan($id_karyawan)
    {
        $q = $this->db->query("SELECT nama_lengkap
        FROM mst_karyawan
        where id_karyawan = '$id_karyawan'");
        return $q;
    }
    public function list_menu_utama_user($id_karyawan)
    {
        $q = $this->db->query("SELECT a.id_menu_parent,
        b.nama_parent
        FROM mst_menu_parent_e_users a
        JOIN mst_menu_parent_e b ON a.id_menu_parent = b.id_menu_parent
        WHERE a.id_karyawan = '$id_karyawan'
        ORDER BY b.urutan asc");
        return $q;
    }
    public function list_isi_menu_user($id_menu_parent,$id_karyawan)
    {
        $q = $this->db->query("SELECT a.id_menu_e_user, b.nama_menu
        FROM mst_menu_e_users a
        JOIN mst_menu_e b ON a.id_menu = b.id_menu
        WHERE a.id_menu_parent = '$id_menu_parent' AND a.id_karyawan = '$id_karyawan'
        ORDER BY b.urutan asc");
        return $q;
    }
    public function list_isi_menu_user_ne($id_menu_parent,$id_karyawan)
    {
        $q = $this->db->query("SELECT a.id_menu, a.nama_menu
        FROM mst_menu_e a
        WHERE a.id_menu_parent = '$id_menu_parent'
        AND NOT EXISTS(SELECT 1 FROM mst_menu_e_users b WHERE a.id_menu = b.id_menu AND b.id_karyawan = '$id_karyawan')
        ORDER BY a.urutan ASC;");
        return $q;
    }
}