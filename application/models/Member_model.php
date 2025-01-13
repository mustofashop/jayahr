<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model
{
    //USERS
    public function get_user($id_karyawan)
    {
        $q = $this->db->query("SELECT id_karyawan, nama_lengkap, foto_64, no_telepon
        FROM mst_karyawan 
        WHERE id_karyawan = '$id_karyawan'");
        return $q;
    }
    //AKSI
    public function list_aksi($id_karyawan)
    {
        $q = $this->db->query("SELECT a.level, b.nama_level_e, c.aksi
		FROM mst_level_login_p a
		JOIN mst_level_e b ON b.kode_level_e = a.level
		JOIN mst_level_e_aksi c ON c.kode_level_e = b.kode_level_e
		WHERE a.id_karyawan = '$id_karyawan'
		GROUP BY c.aksi, a.level, b.nama_level_e
		ORDER BY c.aksi asc");
        return $q;
    }
    //MASTER - KARYAWAN
    public function list_lokasi($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_lokasi, nama_lokasi, kode_lokasi
		FROM mst_lokasi
		where id_perusahaan = '$id_perusahaan'
		order by nama_lokasi asc");
        return $q;
    }
    public function detail_lokasi($id_lokasi)
    {
        $q = $this->db->query("SELECT nama_lokasi
		FROM mst_lokasi
		where id_lokasi = '$id_lokasi'");
        return $q;
    }
    public function detail_karyawan($id_karyawan)
    {
        $q = $this->db->query("SELECT nama_lengkap
		FROM mst_karyawan 
		where id_karyawan = '$id_karyawan'");
        return $q;
    }

    public function detail_karyawan_full($id_karyawan)
    {
        $q = $this->db->query("SELECT nama_lengkap, nip, badgenumber, id_lokasi, id_bagian, tempat_lahir, tgl_lahir, jenis_kelamin, status_nikah, pendidikan, alamat, domisili, kode_pos, kelurahan, kecamatan, kota, provinsi,no_telepon, no_wa, email, gol_darah, npwp, ktp, bpjskes, bpjstk, nama_ayah, nama_ibu, nama_pasangan, nama_anak1,nama_anak2, nama_anak3, hp_keluarga, alamat_anak, alamat_pasangan, uk_baju, uk_celana, uk_sepatu, nama_bank,no_rekening, foto_file, foto_64, status
		FROM mst_karyawan
		where id_karyawan = '$id_karyawan'");
        return $q;
    }
    public function list_karyawan($kategori, $id_perusahaan, $lokasi, $status)
    {
        if ($lokasi == '0') {
            //semua lokasi
            $l    = "";
        } else {
            $l    = "AND id_lokasi = '$lokasi'";
        }
        $q = $this->db->query("SELECT id_karyawan, nip, nama_lengkap, no_telepon
		FROM mst_karyawan
		where id_perusahaan = $id_perusahaan
		AND jenis_karyawan = '$kategori'
		and status = '$status'
		and flag_hapus = '0'
		$l
		order by nama_lengkap asc");
        return $q;
    }
    public function list_bagian_lokasi($id_lokasi)
    {
        $q = $this->db->query("SELECT a.id_bagian, a.nama_bagian
		FROM mst_bagian a
		join mst_bagian_detail b on b.id_bagian = a.id_bagian
		where b.id_lokasi = '$id_lokasi'
		order by a.nama_bagian asc");
        return $q;
    }
    //MASTER - JABATAN
    public function list_jabatan($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_jabatan, nama_jabatan
		FROM mst_jabatan
		WHERE id_perusahaan = '$id_perusahaan' and flag_hapus = '0'
		ORDER BY nama_jabatan asc");
        return $q;
    }
    //MASTER - GOLONGAN
    public function list_golongan($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_golongan, nama_golongan
		FROM mst_golongan
		WHERE id_perusahaan = '$id_perusahaan' and flag_hapus = '0'
		ORDER BY nama_golongan asc");
        return $q;
    }
    //MASTER - LOKASI
    public function list_sub_lokasi($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_sub_lokasi, a.nama_sub_lokasi as nama
		FROM mst_lokasi_sub a
		join mst_lokasi b on a.id_lokasi = b.id_lokasi
		WHERE b.id_perusahaan = '$id_perusahaan'
		order by a.nama_sub_lokasi asc");
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
    public function list_sub_lokasi2($id_lokasi)
    {
        $q = $this->db->query("SELECT id_sub_lokasi, nama_sub_lokasi, latitude_sub, longitude_sub, jarak_sub, sn
		FROM mst_lokasi_sub
		where id_lokasi = '$id_lokasi'
		order by nama_sub_lokasi asc");
        return $q;
    }
    //MASTER - BAGIAN
    public function list_bagian($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_bagian, nama_bagian
		FROM mst_bagian
		WHERE id_perusahaan = '$id_perusahaan'
		ORDER BY nama_bagian asc");
        return $q;
    }
    public function list_bagian2($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_bagian, a.nama_bagian, string_agg(c.nama_lokasi, ',') AS lokasi, a.flag_absen_online as absen_o
        FROM mst_bagian a
        JOIN mst_bagian_detail b ON a.id_bagian = b.id_bagian
        JOIN mst_lokasi c ON b.id_lokasi = c.id_lokasi
        WHERE a.id_perusahaan = '$id_perusahaan'
        GROUP BY a.id_bagian");
        return $q;
    }
    public function detail_bagian1($id_bagian)
    {
        $q = $this->db->query("SELECT nama_bagian
		FROM mst_bagian
		where id_bagian = '$id_bagian'");
        return $q;
    }
    public function list_lokasi_bagian($id_bagian)
    {
        $q = $this->db->query("SELECT a.id_bagian_detail, b.id_lokasi, b.nama_lokasi
        FROM mst_bagian_detail a
        JOIN mst_lokasi b ON a.id_lokasi = b.id_lokasi
        WHERE a.id_bagian = '$id_bagian'");
        return $q;
    }
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
    public function detail_bagian_2($id_bagian_2)
    {
        $q = $this->db->query("SELECT nama_bagian_2
        FROM mst_bagian_2
        where id_bagian_2 = '$id_bagian_2'");
        return $q;
    }
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
    public function detail_bagian_3($id_bagian_3)
    {
        $q = $this->db->query("SELECT nama_bagian_3
        FROM mst_bagian_3
        where id_bagian_3 = '$id_bagian_3'");
        return $q;
    }
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
    //MASTER - SHIFT
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
    //MASTER - LIBUR
    public function list_libur_nasional()
    {
        $q = $this->db->query("SELECT a.keterangan, TO_CHAR(a.tanggal::DATE, 'DD-MM-YYYY') AS tanggal,
        TO_CHAR(a.tanggal::DATE, 'MM') AS bulan,
        TO_CHAR(a.tanggal::DATE, 'DD') AS hari 
        FROM mst_libur_nasional a
        WHERE extract(year FROM tanggal::DATE) = EXTRACT(YEAR FROM CURRENT_DATE)
        ORDER BY bulan ASC, hari asc");
        return $q;
    }
    public function list_libur_perusahaan($id_perusahaan)
    {
        $q = $this->db->query("SELECT a.id_libur_perusahaan, a.keterangan, TO_CHAR(a.tanggal::DATE, 'DD-MM-YYYY') AS tanggal,
        TO_CHAR(a.tanggal::DATE, 'YYYY') AS tahun,
        TO_CHAR(a.tanggal::DATE, 'MM') AS bulan,
        TO_CHAR(a.tanggal::DATE, 'DD') AS hari 
        FROM mst_libur_perusahaan a
        WHERE a.id_perusahaan = '$id_perusahaan'
        ORDER BY tahun desc,bulan ASC, hari ASC");
        return $q;
    }
    //SIDEBAR
    public function list_menu_parent($id_perusahaan, $id_karyawan)
    {
        $q = $this->db->query("SELECT *
		FROM
		(
			SELECT a.id_menu_parent, a.nama_parent, a.urutan, a.logo
			FROM mst_menu_parent_e a
			JOIN mst_menu_parent_e_trans b ON b.id_menu_parent = a.id_menu_parent
			WHERE b.id_perusahaan = '$id_perusahaan'
			UNION ALL
			SELECT d.id_menu_parent, d.nama_parent, d.urutan, d.logo
			FROM mst_menu_parent_e d
			JOIN mst_menu_parent_e_users e ON e.id_menu_parent = d.id_menu_parent
			WHERE e.id_karyawan = '$id_karyawan'
			UNION all
			SELECT a.id_menu_parent, a.nama_parent, a.urutan, a.logo
			FROM mst_menu_parent_e a
			JOIN mst_menu_parent_e_level b ON b.id_menu_parent = a.id_menu_parent
			JOIN mst_level_e c ON c.kode_level_e = b.level
			JOIN mst_level_login_p e ON e.level = c.kode_level_e
			WHERE e.id_karyawan = '$id_karyawan'
		) AS v
		GROUP BY v.id_menu_parent, v.nama_parent, v.urutan, v.logo
		ORDER BY v.urutan asc");
        return $q;
    }
    public function list_isi_menu($id_menu_parent, $id_karyawan, $id_perusahaan)
    {
        $q = $this->db->query("SELECT *
		FROM
		(
			SELECT a.id_menu, a.nama_menu, a.link, a.urutan
			FROM mst_menu_e a
			JOIN mst_menu_e_trans b ON b.id_menu = a.id_menu
			WHERE a.id_menu_parent = '$id_menu_parent' AND b.id_perusahaan = '$id_perusahaan'
			UNION ALL
			SELECT a.id_menu, a.nama_menu, a.link, a.urutan
			FROM mst_menu_e a
			JOIN mst_menu_e_users b ON b.id_menu = a.id_menu
			WHERE a.id_menu_parent = '$id_menu_parent' AND b.id_karyawan = '$id_karyawan'
			UNION ALL
			SELECT a.id_menu, a.nama_menu, a.link, a.urutan
			FROM mst_menu_e a
			JOIN mst_menu_e_level b ON b.id_menu = a.id_menu
			JOIN mst_level_e c ON c.kode_level_e = b.level
			JOIN mst_level_login_p e ON e.level = c.kode_level_e
			WHERE a.id_menu_parent = '$id_menu_parent' AND e.id_karyawan = '$id_karyawan'
		) AS w
		GROUP BY w.id_menu, w.nama_menu, w.link, w.urutan
		ORDER BY w.urutan asc");
        return $q;
    }
    //SETTING
    public function hari_ini($hari)
    {
        date_default_timezone_set('Asia/Jakarta');
        $seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $hari_ini = $seminggu[$hari];
        return $hari_ini;
    }
    public function tgl_indo($tgl)
    {
        $jam    = substr($tgl, 11, 10);
        $tgl    = substr($tgl, 0, 10);
        $tanggal = substr($tgl, 8, 2);
        $bulan  = $this->master_model->getBulan(substr($tgl, 5, 2));
        $tahun  = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam;
    }
    public function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}
