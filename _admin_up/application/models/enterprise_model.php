<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enterprise_model extends CI_Model
{
    //PERUSAHAAN
    //SETTING
    public function list_om_it($id_perusahaan)
    {
        $q  = $this->db->query("SELECT a.id_om_it, b.nama_lengkap
        FROM trans_om_it a
        left join mst_karyawan b on b.id_karyawan = a.id_karyawan
        where b.id_perusahaan = '$id_perusahaan'
        order by b.nama_lengkap asc");
        return $q;
    }
    public function list_karyawan_omit($id_perusahaan)
    {
        $q  = $this->db->query("SELECT id_karyawan, nama_lengkap
        FROM mst_karyawan
        where id_perusahaan = '$id_perusahaan'
        order by nama_lengkap asc");
        return $q;
    }
    //MASTER PERUSAHAAN
    public function get_perusahaan()
    {
        //file soal
        $fl = base_url('assets/perusahaan/logo/');
        $q  = $this->db->query("SELECT a.id_perusahaan, a.nama_perusahaan, a.ip_perusahaan, 
        case when logo_link is null then 'null' else replace(concat('$fl',logo_link),' ','') end AS file,
        a.flag_logo
        FROM mst_perusahaan a
        ORDER BY a.nama_perusahaan asc");
        return $q;
    }
    public function get_detail_perusahaan($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_perusahaan, a.nama_perusahaan, a.logo, a.ip_perusahaan FROM enterprise.mst_perusahaan a WHERE a.id_perusahaan = '$id_perusahaan'");
        return $q;
    }
    public function get_sekolah()
    {
        $q = $this->db->query("SELECT id_sekolah, nama_sekolah FROM mst_sekolah order by nama_sekolah asc");
        return $q;
    }
    public function get_settings_perusahaan($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_sekolah, selfie_allowed, sppd_allowed, use_wa FROM mst_perusahaan where id_perusahaan = '$id_perusahaan'");
        return $q;
    }
    //MASTER LOKASI
    public function get_lokasi($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_lokasi, nama_lokasi, kode_lokasi
        FROM mst_lokasi
        where id_perusahaan = '$id_perusahaan'
        order by nama_lokasi asc");
        return $q;
    }
    public function nama_leader_lokasi($id_lokasi)
    {
        $q = $this->db->query("SELECT b.nama_lengkap
        FROM mst_lokasi a
        join mst_karyawan b on a.id_karyawan = b.id_karyawan
        where a.id_lokasi = '$id_lokasi'");
        return $q;
    }
    public function detail_lokasi($id_lokasi)
    {
        $q = $this->db->query("SELECT id_lokasi, nama_lokasi
        FROM mst_lokasi
        where id_lokasi = '$id_lokasi'");
        return $q;
    }
    public function list_sub_lokasi($id_lokasi)
    {
        $q = $this->db->query("SELECT id_sub_lokasi,
        nama_sub_lokasi,
        latitude_sub,
        longitude_sub,
        jarak_sub,
        sn
        FROM mst_lokasi_sub
        where id_lokasi = '$id_lokasi'
        order by nama_sub_lokasi asc");
        return $q;
    }
    public function list_sub_lokasi2($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_sub_lokasi, 
        concat(b.nama_lokasi,' | ',a.nama_sub_lokasi) AS nama 
        FROM mst_lokasi_sub a
        join mst_lokasi b on a.id_lokasi = b.id_lokasi
        WHERE b.id_perusahaan = '$id_perusahaan'
        order by b.nama_lokasi asc, a.nama_sub_lokasi ASC");
        return $q;
    }
    //MASTER BAGIAN
    public function list_bagian2($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_bagian, 
        a.nama_bagian
        FROM mst_bagian a
        where a.id_perusahaan = '$id_perusahaan'
        order by a.nama_bagian asc");
        return $q;
    }
    public function get_bagian($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_bagian, a.nama_bagian, string_agg(c.nama_lokasi, ',') AS lokasi, a.flag_absen_online as absen_o
        FROM mst_bagian a
        JOIN mst_bagian_detail b ON a.id_bagian = b.id_bagian
        JOIN mst_lokasi c ON b.id_lokasi = c.id_lokasi
        WHERE a.id_perusahaan = '$id_perusahaan'
        GROUP BY a.id_bagian");
        return $q;
    }

    public function get_idp()
    {
        $q = $this->db->query("SELECT *
        FROM mst_idp
		order by urutan asc");
        return $q;
    }

    public function get_inass()
    {
        $q = $this->db->query("SELECT *
        FROM mst_inass 
		order by urutan asc");
        return $q;
    }
    public function detail_bagian($id_bagian)
    {
        $q = $this->db->query("SELECT id_bagian, nama_bagian
        FROM mst_bagian
        WHERE id_bagian = '$id_bagian'");
        return $q;
    }

    public function detail_inass($id_iass)
    {
        $q = $this->db->query("SELECT id_iass, nama_value
        FROM mst_inass
        WHERE id_iass = '$id_iass'");
        return $q;
    }

    public function get_lokasi_bagian($id_bagian)
    {
        $q = $this->db->query("SELECT a.id_bagian_detail, b.id_lokasi, b.nama_lokasi
        FROM mst_bagian_detail a
        JOIN mst_lokasi b ON a.id_lokasi = b.id_lokasi
        WHERE a.id_bagian = '$id_bagian'");
        return $q;
    }
    public function list_leader($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_karyawan, nama_lengkap
        FROM mst_karyawan
        where id_perusahaan = '$id_perusahaan'
        order by nama_lengkap asc");
        return $q;
    }
    public function nama_leader1($id_bagian)
    {
        $q = $this->db->query("SELECT a.nama_lengkap
        FROM mst_karyawan a
        JOIN mst_bagian b on a.id_karyawan = b.id_karyawan
        where b.id_bagian = '$id_bagian'");
        return $q;
    }
    public function nama_leader2($id_bagian_2)
    {
        $q = $this->db->query("SELECT a.nama_lengkap
        FROM mst_karyawan a
        JOIN mst_bagian_2 b on a.id_karyawan = b.id_karyawan
        where b.id_bagian_2 = '$id_bagian_2'");
        return $q;
    }
    public function nama_leader3($id_bagian_3)
    {
        $q = $this->db->query("SELECT a.nama_lengkap
        FROM mst_karyawan a
        JOIN mst_bagian_3 b on a.id_karyawan = b.id_karyawan
        where b.id_bagian_3 = '$id_bagian_3'");
        return $q;
    }
    public function nama_leader4($id_bagian_4)
    {
        $q = $this->db->query("SELECT a.nama_lengkap
        FROM mst_karyawan a
        JOIN mst_bagian_4 b on a.id_karyawan = b.id_karyawan
        where b.id_bagian_4 = '$id_bagian_4'");
        return $q;
    }
    //MASTER BAGIAN 2
    public function list_bagian_lvl_2($id_bagian)
    {
        $q = $this->db->query("SELECT a.id_bagian_2, a.nama_bagian_2,
        case when a.flag_absen_online = 0 then
        'Tidak Aktif'
        else
        'Aktif'
        end as absen_online
        FROM mst_bagian_2 a
        where a.id_bagian = '$id_bagian'
        order by a.nama_bagian_2 asc");
        return $q;
    }

    public function list_inass_lvl_2($id_iass)
    {
        $q = $this->db->query("SELECT *
        FROM mst_inass_2
		where id_iass = $id_iass		
        order by urutan asc");
        return $q;
    }
    public function detail_bagian_2($id_bagian_2)
    {
        $q = $this->db->query("SELECT nama_bagian_2
        FROM mst_bagian_2
        where id_bagian_2 = '$id_bagian_2'");
        return $q;
    }
    public function detail_inass_2($id_iass_2)
    {
        $q = $this->db->query("SELECT nama_value
        FROM mst_inass_2
        where id_iass = '$id_iass_2'");
        return $q;
    }
    //MASTER BAGIAN 3
    public function list_bagian_lvl_3($id_bagian_2)
    {
        $q = $this->db->query("SELECT a.id_bagian_3, a.nama_bagian_3,
        case when a.flag_absen_online = 0 then
        'Tidak Aktif'
        else
        'Aktif'
        end as absen_online
        FROM mst_bagian_3 a
        where a.id_bagian_2 = '$id_bagian_2'
        order by a.nama_bagian_3 asc");
        return $q;
    }
    public function list_inass_lvl_3($id_iass_2)
    {
        $q = $this->db->query("SELECT *
        FROM mst_inass_3
		where id_iass_2 = $id_iass_2
        order by urutan asc");
        return $q;
    }
    public function detail_bagian_3($id_bagian_3)
    {
        $q = $this->db->query("SELECT nama_bagian_3
        FROM mst_bagian_3
        where id_bagian_3 = '$id_bagian_3'");
        return $q;
    }
    //MASTER BAGIAN 4
    public function list_bagian_lvl_4($id_bagian_3)
    {
        $q = $this->db->query("SELECT a.id_bagian_4, a.nama_bagian_4,
        case when a.flag_absen_online = 0 then
        'Tidak Aktif'
        else
        'Aktif'
        end as absen_online
        FROM mst_bagian_4 a
        where a.id_bagian_3 = '$id_bagian_3'
        order by a.nama_bagian_4 asc");
        return $q;
    }
    //jabatan
    public function list_jabatan($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_jabatan, nama_jabatan
        FROM mst_jabatan
        where id_perusahaan = '$id_perusahaan'
        order by nama_jabatan asc");
        return $q;
    }
    //golongan
    public function list_golongan($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_golongan, nama_golongan
        FROM mst_golongan
        where id_perusahaan = '$id_perusahaan'
        order by nama_golongan asc");
        return $q;
    }
    //master sholat
    public function list_sholat($id_perusahaan)
    {
        $q = $this->db->query("SELECT id, nama_sholat, waktu_awal, waktu_akhir
        FROM sholat_master
        where id_perusahaan = '$id_perusahaan'
        order by waktu_awal asc");
        return $q;
    }
    //master karyawan
    public function list_lokasi($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_lokasi, nama_lokasi
        FROM mst_lokasi
        where id_perusahaan = '$id_perusahaan'
        order by nama_lokasi asc");
        return $q;
    }
    public function list_bagian($id_lokasi)
    {
        $q = $this->db->query("SELECT a.id_bagian, a.nama_bagian
        FROM mst_bagian a
        JOIN mst_bagian_detail b ON a.id_bagian = b.id_bagian
        WHERE b.id_lokasi = '$id_lokasi'");
        return $q;
    }
    public function list_karyawan($id_perusahaan, $id_lokasi, $id_bagian, $status, $jenis)
    {
        // status = 0 (available)
        // status = 1 (resign)
        // status = 2 (phk)
        // status = 3 (hapus)

        // jenis = 1 (karyawan tetap)
        // jenis = 2 (karyawan borongan / magang)
        // jenis = 3 (kontrak)
        if ($id_lokasi == '0') {
            $lokasi = "";
        } else {
            $lokasi = "AND a.id_lokasi = '$id_lokasi'";
        }

        if ($id_bagian == '0') {
            $bagian = "";
        } else {
            $bagian = "AND a.id_bagian = '$id_bagian'";
        }

        if ($status == '3') {
            //hapus
            $stat   = "";
            $flag   = "AND a.flag_hapus = '1'";
        } else {
            $stat   = "AND a.status = '$status'";
            $flag   = "AND a.flag_hapus = '0'";
        }

        if ($jenis == '3') {
            $stat_jy = 'Kontrak';
        } else {
            $stat_jy = 'Tetap';
        }

        $q = $this->db->query("SELECT a.id_karyawan, a.department, a.job_grade,
        a.badgenumber,
        a.userid,
        a.nip,
        a.nama_lengkap,
        a.no_telepon
        FROM mst_karyawan a
        --JOIN mst_lokasi b ON a.id_lokasi = b.id_lokasi
        --JOIN mst_bagian c ON a.id_bagian = c.id_bagian
        WHERE a.id_perusahaan = '$id_perusahaan'
        and a.status_jaya = '$stat_jy'
        --$stat
        --$flag
        --$lokasi
        --$bagian
        ORDER BY a.nama_lengkap ASC");
        return $q;
    }
    public function detail_karyawan_full($id_karyawan)
    {
        $q = $this->db->query("SELECT 
		a.tgl_permanen,
        a.nip,
        a.status,
        a.job_grade,
		a.job_title,
		a.department,
        a.nama_lengkap,
        a.tempat_lahir,
        a.tgl_lahir,
		a.tgl_hire,
        a.jenis_kelamin,
        a.spv1,
		a.spv2,
		a.spv3,
        a.id_perusahaan
        FROM mst_karyawan a
        where a.id_karyawan = '$id_karyawan'");
        return $q;
    }
    public function detail_karyawan($id_karyawan)
    {
        $q = $this->db->query("SELECT id_karyawan, 
        nama_lengkap
        FROM mst_karyawan
        where id_karyawan = '$id_karyawan'");
        return $q;
    }
    public function download_data_karyawan($id_perusahaan, $lokasi, $bagian, $jenis)
    {
        if ($jenis == '3') {
            $stat_jy = 'Kontrak';
        } else {
            $stat_jy = 'Tetap';
        }

        $q = $this->db->query("SELECT 
        a.nip,
		a.foto,		
        a.nama_lengkap,
		a.jenis_kelamin,
		a.tgl_lahir,
		a.tgl_hire,
		a.tgl_permanen,
		a.status_jaya,
		a.job_title,
		a.department,
		a.job_grade,
		a.company,
		a.spv1,
		a.spv2,
		a.spv3
        FROM mst_karyawan a
        where a.id_perusahaan = '$id_perusahaan'
        and a.status_jaya = '$stat_jy'
        $lokasi
        $bagian
        ORDER BY a.nama_lengkap asc");
        return $q;
    }
    //SHIFT
    public function list_shift($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_shift,
        a.nama_shift,
        a.jenis_shift,
        CASE WHEN a.jenis_shift = '1' THEN
        'Non Shift'
        ELSE
        'Shift'
        END AS jenis,
        a.jam_masuk,
        a.jam_keluar,
        a.jam_telat,
        a.jam_setengah_hari,
        a.kategori as id_kategori,
        CASE WHEN a.kategori = '1' THEN
        'Lokasi'
        WHEN a.kategori = '2' THEN
        'Sub Lokasi'
        WHEN a.kategori = '3' THEN 
        'Bagian'
        ELSE
        'Semua'
        END AS kategori
        FROM mst_shift a
        WHERE a.id_perusahaan = '$id_perusahaan'
        order by a.id_shift asc");
        return $q;
    }
    public function list_shift_hari($id_shift)
    {
        $q = $this->db->query("SELECT string_agg(x.nama_hari, ', ') AS nama_hari
        FROM
        (
            SELECT a.id_shift, a.hari,
            CASE 
            WHEN a.hari = '1' THEN 
            'Senin'
            WHEN a.hari = '2' THEN 
            'Selasa'
            WHEN a.hari = '3' THEN 
            'Rabu'
            WHEN a.hari = '4' THEN 
            'Kamis'
            WHEN a.hari = '5' THEN 
            'Jumat'
            WHEN a.hari = '6' THEN 
            'Sabtu'
            ELSE
            'minggu'
            END AS nama_hari
            FROM mst_shift_hari a
            WHERE a.id_shift = '$id_shift'
            ORDER BY hari asc
        ) AS x");
        return $q;
    }
    public function list_shift_lokasi($id_shift)
    {
        $q = $this->db->query("SELECT string_agg(b.nama_lokasi, ', ') AS nama_lokasi
        FROM mst_shift_lokasi a 
        JOIN mst_lokasi b ON a.id_lokasi = b.id_lokasi
        WHERE a.id_shift = '$id_shift'");
        return $q;
    }
    public function list_shift_sub_lokasi($id_shift)
    {
        $q = $this->db->query("SELECT string_agg(b.nama_sub_lokasi, ', ') AS nama_sub_lokasi
        FROM mst_shift_lokasi a 
        JOIN mst_lokasi_sub b ON a.id_lokasi_sub = b.id_sub_lokasi
        WHERE a.id_shift = '$id_shift'");
        return $q;
    }
    public function list_shift_bagian($id_shift)
    {
        $q = $this->db->query("SELECT string_agg(b.nama_bagian, ', ') AS nama_bagian
        FROM mst_shift_bagian a
        JOIN mst_bagian b ON a.id_bagian = b.id_bagian
        WHERE a.id_shift = '$id_shift'");
        return $q;
    }
    public function detail_shift($id_shift)
    {
        $q = $this->db->query("SELECT nama_shift
        FROM mst_shift
        where id_shift = '$id_shift'");
        return $q;
    }
    public function list_hari_shift($id_shift)
    {
        $q = $this->db->query("SELECT id_shift,
        case 
        when hari = '1' then
        'Senin'
        when hari = '2' then
        'Selasa'
        when hari = '3' then
        'Rabu'
        when hari = '4' then
        'Kamis'
        when hari = '5' then
        'Jumat'
        when hari = '6' then
        'Sabtu'
        else
        'Minggu'
        end as nama_hari,
        hari
        FROM mst_shift_hari
        where id_shift = '$id_shift'
        order by hari asc");
        return $q;
    }
    public function list_lokasi_shift($id_shift)
    {
        $q = $this->db->query("SELECT b.id_shift, 
        b.id_lokasi,
        a.nama_lokasi
        FROM mst_lokasi a
        join mst_shift_lokasi b on a.id_lokasi = b.id_lokasi
        where b.id_shift = '$id_shift'
        order by a.nama_lokasi asc");
        return $q;
    }
    public function list_lokasi_shift_check($id_shift, $id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_lokasi,
        a.nama_lokasi
        FROM mst_lokasi a
        WHERE a.id_perusahaan = '$id_perusahaan'
        AND NOT EXISTS(SELECT 1 FROM mst_shift_lokasi b where a.id_lokasi = b.id_lokasi AND b.id_shift = '$id_shift')
        ORDER BY a.nama_lokasi asc");
        return $q;
    }
    public function list_sublokasi_shift($id_shift)
    {
        $q = $this->db->query("SELECT c.id_lokasi_sub, 
        concat(b.nama_lokasi,' | ',a.nama_sub_lokasi) AS nama 
        FROM mst_lokasi_sub a
        join mst_lokasi b on a.id_lokasi = b.id_lokasi
        join mst_shift_lokasi c on c.id_lokasi_sub = a.id_sub_lokasi
        WHERE c.id_shift = '$id_shift'
        order by b.nama_lokasi asc, a.nama_sub_lokasi ASC");
        return $q;
    }
    public function list_sublokasi_shift_check($id_shift, $id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_sub_lokasi, 
        concat(b.nama_lokasi,' | ',a.nama_sub_lokasi) AS nama 
        FROM mst_lokasi_sub a
        join mst_lokasi b on a.id_lokasi = b.id_lokasi
        WHERE b.id_perusahaan = '$id_perusahaan'
        AND NOT EXISTS(SELECT 1 FROM mst_shift_lokasi c WHERE a.id_sub_lokasi = c.id_lokasi_sub AND c.id_shift = '$id_shift')
        order by b.nama_lokasi asc, a.nama_sub_lokasi ASC");
        return $q;
    }
    public function list_bagian_shift($id_shift)
    {
        $q = $this->db->query("SELECT a.id_shift_bagian,
        b.nama_bagian 
        FROM mst_shift_bagian a
        JOIN mst_bagian b ON a.id_bagian = b.id_bagian
        WHERE a.id_shift = '$id_shift'");
        return $q;
    }
    public function list_shift_bagian_check($id_shift, $id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_bagian,
        a.nama_bagian
        FROM mst_bagian a
        WHERE a.id_perusahaan = '$id_perusahaan'
        AND NOT EXISTS(SELECT 1 FROM mst_shift_bagian b WHERE a.id_bagian = b.id_bagian AND b.id_shift = '$id_shift')
        ORDER BY a.nama_bagian asc");
        return $q;
    }
    public function list_detail_shift($id_shift)
    {
        $q = $this->db->query("SELECT a.id_shift_detail,
        a.kode_shift,
        a.shift_ke,
        a.jam_masuk,
        a.jam_keluar,
        a.jam_telat,
        a.jam_setengah_hari
        FROM mst_shift_detail a
        where a.id_shift = '$id_shift'
        order by a.shift_ke asc");
        return $q;
    }
    //USERID
    public function list_badgenumber_karyawan($id_perusahaan, $lokasi, $bagian, $jenis)
    {
        $q = $this->db->query("SELECT badgenumber
        FROM mst_karyawan
        where id_perusahaan = '$id_perusahaan'
        and jenis_karyawan = '$jenis'
        $lokasi
        $bagian
        order by nama_lengkap asc");
        return $q;
    }
    //LOGIN USER
    public function list_user_karyawan($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_karyawan, a.nama_lengkap
        FROM mst_karyawan a
        where a.id_perusahaan = '$id_perusahaan' and status = '0'
        order by a.nama_lengkap asc");
        return $q;
    }
    public function list_users_karyawan($id_perusahaan)
    {
        $q = $this->db->query("SELECT b.id_karyawan,
        b.nama_lengkap,
        b.job_title, b. job_grade, b.status_jaya,
        string_agg(e.nama_level_e, ', ') AS nama_level
        FROM mst_level_login_p a 
        JOIN mst_karyawan b ON a.id_karyawan = b.id_karyawan
        JOIN mst_level_e e ON a.level = e.kode_level_e
        where b.id_perusahaan = '$id_perusahaan'
        GROUP BY b.id_karyawan
        ORDER BY b.nama_lengkap asc");
        return $q;


        return $q;
    }
    public function list_level_user($id_karyawan)
    {
        $q = $this->db->query("SELECT a.id_level_login,
        e.nama_level_e
        FROM mst_level_login_p a 
        JOIN mst_karyawan b ON a.id_karyawan = b.id_karyawan
        JOIN mst_level_e e ON a.level = e.kode_level_e
        WHERE a.id_karyawan = '$id_karyawan'
        order by a.level asc");
        return $q;
    }
    public function list_level_user_ne($id_karyawan, $id_perusahaan)
    {
        $q = $this->db->query("SELECT a.kode_level_e,
        a.nama_level_e
        FROM mst_level_e a
        JOIN mst_level_e_trans b ON b.kode_level_e = a.kode_level_e
        WHERE b.id_perusahaan = '$id_perusahaan' AND NOT EXISTS(SELECT 1 FROM mst_level_login_p c WHERE c.level = a.kode_level_e AND c.id_karyawan = '$id_karyawan')
        ORDER by a.kode_level_e asc");
        return $q;
    }
    //LIBUR
    public function list_perusahaan()
    {
        $q = $this->db->query("SELECT id_perusahaan, nama_perusahaan
        FROM mst_perusahaan
        order by nama_perusahaan asc");
        return $q;
    }
    public function list_libur_perusahaan($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_libur_perusahaan, a.keterangan, TO_CHAR(a.tanggal::date, 'DD-MM-YYYY') as tanggal, TO_CHAR(a.tanggal::date, 'YYYY') as tahun, TO_CHAR(a.tanggal::date, 'MM') as bulan, TO_CHAR(a.tanggal::date, 'DD') as hari
        FROM mst_libur_perusahaan a
        JOIN mst_perusahaan b ON b.id_perusahaan = a.id_perusahaan
        WHERE a.id_perusahaan = '$id_perusahaan'
        order by tahun desc, bulan asc, hari asc");
        return $q;
    }
    public function data_libur_perusahaan($perusahaan, $tahun)
    {
        $q    = $this->db->query("SELECT a.keterangan, a.tanggal, b.nama_perusahaan, a.id_perusahaan
		FROM mst_libur_perusahaan a
		join mst_perusahaan b on a.id_perusahaan = b.id_perusahaan
		WHERE extract(year FROM a.tanggal::date) = '$tahun'
		and a.id_perusahaan = '$perusahaan'
		order by a.tanggal asc");
        return $q;
    }

    //PERIODE
    public function get_periode($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_periode, periode_tahun, status
        FROM mst_periode
        where id_perusahaan = '$id_perusahaan'
        order by periode_tahun asc");
        return $q;
    }

    public function detail_periode($id_periode)
    {
        $q = $this->db->query("SELECT id_periode, periode_tahun
        FROM mst_periode
        WHERE id_periode = '$id_periode'");
        return $q;
    }

    //PERIODE PENILAIAN
    public function get_periode_penilaian($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_p_periode, id_periode, id_perusahaan, nama_value, status, flag_diisi, desc
        FROM mst_periode_penilaian
        where id_perusahaan = '$id_perusahaan'
        order by nama_value asc");
        return $q;
    }

    public function detail_periode_penilaian($id_periode)
    {
        $q = $this->db->query("SELECT id_p_periode, id_periode, id_perusahaan, nama_value, status, flag_diisi
        FROM mst_periode_penilaian
        WHERE id_periode = '$id_periode'");
        return $q;
    }

    public function list_penilaian()
    {
        $q = $this->db->query("SELECT * FROM mst_periode_penilaian ");
        return $q;
    }

    //JENIS FORM
    public function get_jenis_form($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_jenis_form, id_perusahaan, nama_value, description
        FROM mst_jenis_form
        where id_perusahaan = '$id_perusahaan'
        order by nama_value asc");
        return $q;
    }

    public function detail_jenis_form($id_jenis_form)
    {
        $q = $this->db->query("SELECT id_jenis_form, id_perusahaan, nama_value, desc
        FROM mst_jenis_form
        WHERE id_jenis_form = '$id_jenis_form'");
        return $q;
    }
}
