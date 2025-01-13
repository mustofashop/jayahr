<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    
    public function detail_perusahaan($id_perusahaan)
    {
        $q = $this->db->query("SELECT ip_perusahaan
        FROM mst_perusahaan
        WHERE id_perusahaan = '$id_perusahaan'");
        return $q;
    }
    public function list_lokasi($id_perusahaan)
    {
        $q = $this->db->query("SELECT id_lokasi, nama_lokasi
        FROM mst_lokasi
        where id_perusahaan = '$id_perusahaan'
        order by nama_lokasi");
        return $q;
    }
    public function detail_lokasi($id_lokasi)
    {
        $q = $this->db->query("SELECT nama_lokasi
        FROM mst_lokasi
        where id_lokasi = '$id_lokasi'");
        return $q;
    }
    public function jumlah_karyawan($id_lokasi)
    {
        $q = $this->db->query("SELECT id_karyawan
        FROM mst_karyawan
        where status = '0' and id_lokasi = '$id_lokasi'");
        return $q;
    }
    public function jumlah_sudah_absen($id_lokasi)
    {
        $q = $this->db->query("SELECT x.id_karyawan, x.nama_lengkap, x.jenis
        FROM
        (
            SELECT a.id_karyawan, b.nama_lengkap, a.jenis
           FROM checkinout_adms_karyawan a
           join mst_karyawan b on a.id_karyawan = b.id_karyawan
           WHERE b.id_lokasi = '$id_lokasi' and to_char(a.checktime, 'YYYY-MM-DD')::date = current_date
        ) AS x
        WHERE jenis = '0' OR jenis = '1'
        GROUP BY id_karyawan, nama_lengkap, jenis");
        return $q;
    }
    public function jumlah_izin_sakit($id_lokasi)
    {
        $q = $this->db->query("SELECT a.id
        FROM checkinout_adms_karyawan a
        join mst_karyawan b on a.id_karyawan = b.id_karyawan
        where b.id_lokasi = '$id_lokasi' and (current_date BETWEEN a.izin_tgl_awal AND a.izin_tgl_akhir) and a.jenis = '2'");
        return $q;
    }
    public function jumlah_telat_non_shift($id_lokasi)
    {
        $q = $this->db->query("SELECT COUNT(z.indikator_telat) AS jumlah_telat
        FROM (
            SELECT y.id_karyawan, CASE WHEN SUBSTRING(y.telat::VARCHAR,1,1) = '-' THEN '0' ELSE '1' END AS indikator_telat
            FROM (
                SELECT x.id_karyawan, x.jam_masuk::time - x.jam_telat::time AS telat
                FROM (
                    SELECT a.id_karyawan, TO_CHAR(a.checktime, 'HH24:MI:SS') AS jam_masuk, TO_CHAR(b.jam_telat, 'HH24:MI:SS') AS jam_telat
                    FROM checkinout_adms_karyawan a
                    JOIN mst_shift b ON a.id_shift = b.id_shift
                    JOIN mst_karyawan c ON c.id_karyawan = a.id_karyawan
                    WHERE a.id_shift_detail = '0' AND a.checktype = '0' AND TO_CHAR(a.checktime,'YYYY-MM-DD')::Date = CURRENT_DATE AND c.id_lokasi = '$id_lokasi'
                    GROUP BY a.id_karyawan, a.checktime, b.jam_telat
                ) AS x
            ) AS y
        ) AS z
        WHERE z.indikator_telat = '1'");
        return $q;
    }
    public function jumlah_telat_shift($id_lokasi)
    {
        $q = $this->db->query("SELECT COUNT(z.indikator_telat) AS jumlah_telat
        FROM (
            SELECT y.id_karyawan, CASE WHEN SUBSTRING(y.telat::VARCHAR,1,1) = '-' THEN '0' ELSE '1' END AS indikator_telat
            FROM (
                SELECT x.id_karyawan, x.jam_masuk::time - x.jam_telat::time AS telat
                FROM (
                    SELECT a.id_karyawan, TO_CHAR(a.checktime, 'HH24:MI:SS') AS jam_masuk, TO_CHAR(b.jam_telat, 'HH24:MI:SS') AS jam_telat
                    FROM checkinout_adms_karyawan a
                    JOIN mst_shift_detail b ON a.id_shift_detail = b.id_shift_detail
                    JOIN mst_karyawan c ON c.id_karyawan = a.id_karyawan
                    WHERE a.id_shift_detail != '0' AND a.checktype = '0' AND TO_CHAR(a.checktime,'YYYY-MM-DD')::Date = CURRENT_DATE AND c.id_lokasi = '$id_lokasi'
                    GROUP BY a.id_karyawan, a.checktime, b.jam_telat
                ) AS x
            ) AS y
        ) AS z
        WHERE z.indikator_telat = '1'");
        return $q;
    }
    public function list_karyawan($id_perusahaan,$id_lokasi)
    {
        $q = $this->db->query("SELECT id_karyawan, nip, nama_lengkap, no_telepon
		FROM mst_karyawan
		where id_perusahaan = $id_perusahaan
		AND id_lokasi = '$id_lokasi'
		and status = '0'
		and flag_hapus = '0'
        order by nama_lengkap asc");
        return $q;
    }
    public function detail_karyawan($id_karyawan)
    {
        $q = $this->db->query("SELECT nama_lengkap
        FROM mst_karyawan
        where id_karyawan = '$id_karyawan'");
        return $q;
    }
    //REFRESH ABSEN
    public function list_absen_adms_mysql($ip_perusahaan)
    {
        $q = $this->db2->query("SELECT a.userid, a.checktime, a.checktype, a.SN as sn
        FROM checkinout_adms a
        join mst_karyawan b on a.userid = b.userid
        JOIN mst_perusahaan c ON c.id_perusahaan = b.id_perusahaan
        where c.ip_perusahaan = '$ip_perusahaan' AND DATE(a.checktime) = CURDATE()");
        return $q;
    }
    public function cek_kontrak_terakhir($userid)
    {
        $q = $this->db->query("SELECT c.jenis_shift, a.id_shift
        FROM trans_kontrak_kerja a
        JOIN mst_karyawan b ON a.id_karyawan = b.id_karyawan
        JOIN mst_shift c ON a.id_shift = c.id_shift
        WHERE b.userid = '$userid' AND a.status_kontrak = '0'");
        return $q;
    }
    public function id_shift_detail_masuk($jam_masuk)
    {
        $q = $this->db->query("SELECT a.id_shift_detail
        FROM mst_shift_detail a
        WHERE a.jam_telat > '$jam_masuk' - INTERVAL '2 hours' AND a.jam_telat < '$jam_masuk' + INTERVAL '5 hours'");
        return $q;
    }
    public function id_shift_detail_pulang($jam_pulang)
    {
        $q = $this->db->query("SELECT a.id_shift_detail
        FROM mst_shift_detail a
        WHERE a.jam_keluar > '$jam_pulang' - INTERVAL '2 hours' AND a.jam_keluar < '$jam_pulang' + INTERVAL '5 hours'");
        return $q;
    }
    public function list_absen_adms_pg($userid,$checktime,$checktype)
    {
        $q = $this->db->query("SELECT a.id_karyawan, a.checktime, a.checktype
        FROM checkinout_adms_karyawan a
        where a.userid = '$userid' and a.checktime = '$checktime' and a.checktype = '$checktype'");
        return $q;
    }
    public function update_id_karyawan($userid)
    {
        $id_k   = $this->db->query("SELECT id_karyawan FROM mst_karyawan where userid = '$userid'");
        if($id_k->num_rows() > 0){
            $id['userid']       = $userid;
            $dt['id_karyawan']  = $id_k->row()->id_karyawan;
            $this->db->update('checkinout_adms_karyawan',$dt,$id);
        }
    }
    //SUDAH ABSEN
    public function list_tracking_absen($id_lokasi)
    {
        $q = $this->db->query("SELECT x.id_karyawan, min(x.checktime) AS checktime, x.nip, x.nama_lengkap, x.no_telepon, x.nama_lokasi, x.nama_bagian
        FROM
        (
            SELECT a.id_karyawan, a.checktime, b.nip,b.nama_lengkap, b.no_telepon,c.nama_lokasi, d.nama_bagian
                FROM checkinout_adms_karyawan a
                join mst_karyawan b on a.id_karyawan = b.id_karyawan
                join mst_lokasi c on c.id_lokasi = b.id_lokasi
                join mst_bagian d on d.id_bagian = b.id_bagian
                where b.id_lokasi = '$id_lokasi' and to_char(a.checktime,'YYYY-MM-DD')::date = current_date
        ) AS x
        GROUP BY x.id_karyawan, x.nip, x.nama_lengkap, x.no_telepon, x.nama_lokasi, x.nama_bagian
        ORDER BY checktime desc");
        return $q;
    }
    //TELAT
    public function list_telat($id_lokasi)
    {
        $q = $this->db->query("SELECT z.id_karyawan, z.telat, z.nip, z.nama_lengkap, z.no_telepon
        FROM (
            SELECT y.id_karyawan, CASE WHEN SUBSTRING(y.telat::VARCHAR,1,1) = '-' THEN '0' ELSE '1' END AS indikator_telat, y.telat, y.nip, y.nama_lengkap, y.no_telepon
            FROM (
                SELECT x.id_karyawan, x.jam_masuk::time - x.jam_telat::time AS telat, x.nip, x.nama_lengkap, x.no_telepon
                FROM (
                    SELECT a.id_karyawan, TO_CHAR(a.checktime, 'HH24:MI:SS') AS jam_masuk, TO_CHAR(b.jam_telat, 'HH24:MI:SS') AS jam_telat, c.nip, c.nama_lengkap, c.no_telepon
                    FROM checkinout_adms_karyawan a
                    JOIN mst_shift b ON a.id_shift = b.id_shift
                    JOIN mst_karyawan c ON c.id_karyawan = a.id_karyawan
                    WHERE a.id_shift_detail = '0' AND a.checktype = '0' and c.id_lokasi = '$id_lokasi' AND TO_CHAR(a.checktime,'YYYY-MM-DD')::Date = CURRENT_DATE
                    GROUP BY a.id_karyawan, a.checktime, b.jam_telat, c.nip, c.nama_lengkap, c.no_telepon
                ) AS x
            ) AS y
        ) AS z
        WHERE z.indikator_telat = '1'
        union all
        SELECT z.id_karyawan, z.telat, z.nip, z.nama_lengkap, z.no_telepon
        FROM (
            SELECT y.id_karyawan, CASE WHEN SUBSTRING(y.telat::VARCHAR,1,1) = '-' THEN '0' ELSE '1' END AS indikator_telat, y.telat, y.nip, y.nama_lengkap, y.no_telepon
            FROM (
                SELECT x.id_karyawan, x.jam_masuk::time - x.jam_telat::time AS telat, x.nip, x.nama_lengkap, x.no_telepon
                FROM (
                    SELECT a.id_karyawan, TO_CHAR(a.checktime, 'HH24:MI:SS') AS jam_masuk, TO_CHAR(b.jam_telat, 'HH24:MI:SS') AS jam_telat, c.nip, c.nama_lengkap, c.no_telepon
                    FROM checkinout_adms_karyawan a
                    JOIN mst_shift_detail b ON b.id_shift_detail = a.id_shift_detail
                    JOIN mst_karyawan c ON c.id_karyawan = a.id_karyawan
                    WHERE a.id_shift_detail != '0' AND a.checktype = '0' and c.id_lokasi = '$id_lokasi' AND TO_CHAR(a.checktime,'YYYY-MM-DD')::Date = CURRENT_DATE
                    GROUP BY a.id_karyawan, a.checktime, b.jam_telat, c.nip, c.nama_lengkap, c.no_telepon
                ) AS x
            ) AS y
        ) AS z
        WHERE z.indikator_telat = '1'
        ORDER BY nama_lengkap asc");
        return $q;
    }
    //IZIN
    public function list_izin($id_lokasi)
    {
        $q = $this->db->query("SELECT b.nip, b.nama_lengkap, a.jenis_izin, a.izin_tgl_awal, a.izin_tgl_akhir
        FROM checkinout_adms_karyawan a
        join mst_karyawan b on a.id_karyawan = b.id_karyawan
        where b.id_lokasi = '$id_lokasi' and (current_date BETWEEN a.izin_tgl_awal AND a.izin_tgl_akhir) and a.jenis = '2'");
        return $q;
    }
    //BELUM ABSEN
    public function list_belum_absen($id_lokasi)
    {
        $q = $this->db->query("SELECT a.nip, a.nama_lengkap, a.no_telepon, b.nama_lokasi, c.nama_bagian
        FROM mst_karyawan a
        join mst_lokasi b on b.id_lokasi = a.id_lokasi
        join mst_bagian c on c.id_bagian = a.id_bagian
        where a.id_lokasi = '$id_lokasi' and a.status = '0'
        and a.flag_hapus = '0' and not exists(select 1 from checkinout_adms_karyawan d where d.id_karyawan = a.id_karyawan and to_char(d.checktime, 'YYYY-MM-DD')::date = current_date and (d.checktype = '0' OR d.checktype = '1'))
        order by a.nama_lengkap asc");
        return $q;
    }
}