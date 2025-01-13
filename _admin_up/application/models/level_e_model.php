<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class level_e_model extends CI_Model {
    public function list_level_aksi()
    {
        $q = $this->db->query("SELECT a.id_level_e,
        a.kode_level_e,
        a.nama_level_e,
        string_agg(CASE
        WHEN b.aksi = '1' THEN
        'Tambah'
        WHEN b.aksi = '2' THEN
        'Lihat'
        WHEN b.aksi = '3' THEN
        'Edit'
        ELSE
        'Hapus'
        end,', ') AS aksi
        FROM mst_level_e a
        JOIN mst_level_e_aksi b ON a.kode_level_e = b.kode_level_e
        GROUP BY a.id_level_e
        UNION ALL
        SELECT a.id_level_e,
        a.kode_level_e,
        a.nama_level_e,
        '' AS aksi
        FROM mst_level_e a
        WHERE NOT EXISTS(SELECT 1 FROM mst_level_e_aksi b WHERE a.kode_level_e = b.kode_level_e)
        ORDER BY kode_level_e asc");
        return $q;
    }
    public function list_level()
    {
        $q = $this->db->query("SELECT *
        from mst_level_e
        order by kode_level_e asc");
        return $q;
    }
    public function list_level_detail($perusahaan)
    {
        $q = $this->db->query("SELECT a.id_level_e_trans,
        b.kode_level_e,
        b.nama_level_e
        FROM mst_level_e_trans a
        join mst_level_e b on a.kode_level_e = b.kode_level_e
        where a.id_perusahaan = '$perusahaan'
        order by b.kode_level_e asc");
        return $q;
    }
    public function list_level_ne($perusahaan)
    {
        $q = $this->db->query("SELECT a.kode_level_e, a.nama_level_e
        FROM mst_level_e a
        WHERE NOT EXISTS(SELECT 1 FROM mst_level_e_trans b WHERE a.kode_level_e = b.kode_level_e AND b.id_perusahaan = '$perusahaan')
        ORDER BY a.kode_level_e asc");
        return $q;
    }
    public function list_level_p()
    {
        $q = $this->db->query("SELECT a.id_perusahaan, 
        c.nama_perusahaan, string_agg(b.nama_level_e, ', ') AS nama_level
        FROM mst_level_e_trans a
        JOIN mst_level_e b ON a.kode_level_e = b.kode_level_e
        JOIN mst_perusahaan c ON a.id_perusahaan = c.id_perusahaan
        GROUP BY a.id_perusahaan, c.nama_perusahaan
        ORDER BY c.nama_perusahaan asc");
        return $q;
    }
    public function list_perusahaan()
    {
        $q = $this->db->query("SELECT id_perusahaan, nama_perusahaan
        FROM mst_perusahaan
        order by nama_perusahaan asc");
        return $q;
    }
    public function detail_level($kode_level_e)
    {
        $q = $this->db->query("SELECT nama_level_e
        FROM mst_level_e
        where kode_level_e = '$kode_level_e'");
        return $q;
    }
    public function list_aksi_level($kode_level_e)
    {
        $q = $this->db->query("SELECT a.id_level_e_aksi,
        CASE
        WHEN a.aksi = '1' THEN
        'Tambah'
        WHEN a.aksi = '2' THEN
        'Lihat'
        WHEN a.aksi = '3' THEN
        'Edit'
        ELSE
        'Hapus'
        END AS aksi,
        a.aksi AS ak
        FROM mst_level_e_aksi a
        WHERE a.kode_level_e = '$kode_level_e'
        order by ak asc");
        return $q;
    }
    //menu
    public function list_menu_utama($kode_level_e)
    {
        $q = $this->db->query("SELECT a.id_parent_level,
        a.id_menu_parent,
        b.nama_parent
        FROM mst_menu_parent_e_level a
        JOIN mst_menu_parent_e b ON a.id_menu_parent = b.id_menu_parent
        JOIN mst_level_e c ON a.level = c.kode_level_e
        WHERE a.level = '$kode_level_e'
        ORDER BY b.urutan asc");
        return $q;
    }
    public function list_menu_utama_kode($kode_level_e)
    {
        $q = $this->db->query("SELECT a.id_menu_parent,
        a.nama_parent
        FROM mst_menu_parent_e a
        WHERE NOT EXISTS(SELECT 1 FROM mst_menu_parent_e_level b where a.id_menu_parent = b.id_menu_parent AND b.level = '$kode_level_e')
        ORDER BY a.urutan asc");
        return $q;
    }
    public function list_menu_utama_g($kode_level_e)
    {
        $q = $this->db->query("SELECT string_agg(a.nama_parent, ', ' ORDER BY a.urutan asc) AS nama_parent
        FROM mst_menu_parent_e a
        JOIN mst_menu_parent_e_level b ON b.id_menu_parent = a.id_menu_parent
        WHERE b.level = '$kode_level_e'
        GROUP BY b.level");
        return $q;
    }
    public function list_isi_menu($kode_level_e)
    {
        $q = $this->db->query("SELECT a.id_menu_level,
        c.nama_parent,
        b.nama_menu
        FROM mst_menu_e_level a
        JOIN mst_menu_e b ON a.id_menu = b.id_menu
        JOIN mst_menu_parent_e c ON b.id_menu_parent = c.id_menu_parent
        WHERE a.level = '$kode_level_e'");
        return $q;
    }
    public function list_isi_menu_ne($kode_level_e)
    {
        $q = $this->db->query("SELECT a.id_menu,
        c.nama_parent,
        a.nama_menu
        FROM mst_menu_e a
        JOIN mst_menu_parent_e c ON c.id_menu_parent = a.id_menu_parent
        WHERE NOT EXISTS(SELECT 1 FROM mst_menu_e_level b where b.id_menu = a.id_menu AND b.level = '$kode_level_e')
        ORDER BY c.urutan asc");
        return $q;
    }
    public function list_isi_menu_g($kode_level_e)
    {
        $q = $this->db->query("SELECT string_agg(a.nama_menu, ', ' ORDER BY a.urutan asc) AS nama_menu
        FROM mst_menu_e a
        JOIN mst_menu_e_level b ON b.id_menu = a.id_menu
        WHERE b.level = '$kode_level_e'
        GROUP BY b.level");
        return $q;
    }
}