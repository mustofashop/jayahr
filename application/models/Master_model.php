<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model
{
	//KARYAWAN PKK
	public function get_detail_perusahaan($id_perusahaan)
	{
		$q = $this->db->query("SELECT a.id_perusahaan, a.nama_perusahaan, a.logo, a.ip_perusahaan FROM enterprise.mst_perusahaan a WHERE a.id_perusahaan = '$id_perusahaan'");
		return $q;
	}

	public function list_member_pkk($nrp)
	{

		$q = $this->db->query("SELECT a.id_karyawan, a.nip, a.nama_lengkap, a.status_jaya, a.department, 
		a.job_title, a.job_grade, a.tgl_hire, a.tgl_permanen, a.tgl_lahir
		FROM mst_karyawan a
		where (spv1 = '$nrp' OR spv2 = '$nrp' OR spv3 = '$nrp')
		and flag_hapus = '0' and jenis_karyawan = '3'
		order by nama_lengkap ASC");
		return $q;
	}

	public function list_member_pkk_2($nrp)
	{

		$q = $this->db->query("SELECT a.id_karyawan, a.nip, a.nama_lengkap, a.status_jaya, a.department, 
		a.job_title, a.job_grade, a.tgl_hire, a.tgl_permanen, a.tgl_lahir, b.flag_jenis_form
		FROM mst_karyawan a
		JOIN trans_pkk b ON a.nip = b.nrp
		where (spv1 = '$nrp' OR spv2 = '$nrp' OR spv3 = '$nrp')
		and flag_hapus = '0' and jenis_karyawan = '3'
		order by nama_lengkap ASC");
		return $q;
	}

	public function set_pkk()
	{
		$q = $this->db->query("SELECT a.periode_tahun, b.nama_value, 
		a.id_periode, b.id_p_periode, b.flag_penilaian
        FROM mst_periode a
        JOIN mst_periode_penilaian b on a.id_periode = b.id_periode
        WHERE a.id_perusahaan = '12' and a.status = 0
		order by a.id_periode asc");
		return $q;
	}

	public function list_jenis_form()
	{
		$q = $this->db->query("SELECT * from mst_jenis_form");
		return $q;
	}

	public function get_penilaian_1_2()
	{
		$q = $this->db->query("SELECT * from mst_penilaian_1_2");
		return $q;
	}

	public function isi_pkk($atasan)
	{
		$q = $this->db->query("SELECT a.*, b.nama_lengkap, b.spv1, b.spv2
		FROM trans_pkk a
		JOIN mst_karyawan b ON a.nrp = b.nip
		WHERE a.insert_by = '$atasan' order by id_trans_pkk asc");
		return $q;
	}
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

	public function list_unit($level)
	{
		$q = $this->db->query("SELECT distinct a.id_bagian, a.nama_bagian, c.level
		FROM mst_bagian a
		LEFT JOIN mst_karyawan b on a.id_perusahaan = b.id_perusahaan
		Left join mst_level_login_p c on b.id_karyawan = c.id_karyawan
		WHERE c.level = '$level'");
		return $q;
	}

	public function list_unit2($bagian, $id_karyawan, $level)
	{
		$q = $this->db->query("SELECT a.id_bagian, a.nama_bagian, c.id_karyawan, c.level
			FROM mst_bagian a
			LEFT JOIN mst_karyawan b on a.id_perusahaan = b.id_perusahaan
			Left join mst_level_login_p c on b.id_karyawan = c.id_karyawan
			where a.nama_bagian = '$bagian' AND c.id_karyawan = '$id_karyawan' AND c.level = '$level'");
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
		$q = $this->db->query("SELECT nama_lengkap, nip
		FROM mst_karyawan 
		where id_karyawan = '$id_karyawan'");
		return $q;
	}
	public function detail_karyawan2($nrp)
	{
		$q = $this->db->query("SELECT nama_lengkap, nip
		FROM mst_karyawan 
		where nip = '$nrp'");
		return $q;
	}
	public function detail_karyawan_full($id_karyawan)
	{
		$q = $this->db->query("SELECT *
		FROM mst_karyawan
		where id_karyawan = '$id_karyawan'");
		return $q;
	}
	public function list_karyawan($kategori, $id_perusahaan, $tatus)
	{
		if ($kategori == '3') {
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
        WHERE a.id_perusahaan = '$id_perusahaan'
        and a.status_jaya = '$stat_jy'
        ORDER BY a.nama_lengkap ASC");
		return $q;
	}

	public function list_karyawan_pkk($id_perusahaan, $id_lokasi, $id_bagian, $status, $jenis)
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

	public function profile_assessment($nrp)
	{
		$q = $this->db->query("SELECT *
        FROM trans_assessment
		where nrp = '$nrp'");
		return $q;
	}

	public function profile_appraisal($nrp)
	{
		$q = $this->db->query("SELECT *
        FROM trans_appraisal
		where nrp = '$nrp'");
		return $q;
	}

	public function profile_training($nrp)
	{
		$q = $this->db->query("SELECT *
        FROM trans_training_history
		where nrp = '$nrp'");
		return $q;
	}

	public function profile_job($nrp)
	{
		$q = $this->db->query("SELECT *
        FROM trans_job_experience
		where nrp = '$nrp'");
		return $q;
	}

	public function profile_education($nrp)
	{
		$q = $this->db->query("SELECT *
        FROM trans_education
		where nrp = '$nrp'");
		return $q;
	}

	public function profile_career($nrp)
	{
		$q = $this->db->query("SELECT *
        FROM trans_career
		where nrp = '$nrp'");
		return $q;
	}

	public function profile_idp($nrp)
	{
		$q = $this->db->query("select a.nip nrp, a.nama_lengkap nama_karyawan, b.insert_date date_of_enrty, b.tahun, c.nama_lengkap assesor
		from enterprise.mst_karyawan a, 
		(select distinct nrp, tahun, insert_by, insert_date from enterprise.trans_idp_new where nrp = '$nrp') b,
		enterprise.mst_karyawan c
		where a.nip = b.nrp and a.nip = '$nrp'
		and b.insert_by = c.nip");
		return $q;
	}

	public function profile_idp_dtl_spv1($nrp, $tahun, $atasan)
	{
		$q = $this->db->query("select isi_idp from enterprise.trans_idp_new where nrp = '$nrp'  and tahun = '$tahun' and id_idp = 1 and insert_by = '$atasan'");
		return $q;
	}

	public function profile_idp_dtl_spv2($nrp, $tahun, $atasan)
	{
		$q = $this->db->query("select isi_idp from enterprise.trans_idp_new where nrp = '$nrp'  and tahun = '$tahun' and id_idp = 1 and insert_by = '$atasan'");
		return $q;
	}

	public function profile_idp_dtl2($nrp, $tahun)
	{
		$q = $this->db->query("select isi_idp from enterprise.trans_idp_new where nrp = '$nrp'  and tahun = '$tahun' and id_idp = 2");
		return $q;
	}

	public function profile_idp_dtl3($nrp, $tahun)
	{
		$q = $this->db->query("select isi_idp from enterprise.trans_idp_new where nrp = '$nrp'  and tahun = '$tahun' and id_idp = 3");
		return $q;
	}

	public function profile_idp_dtl4($nrp, $tahun)
	{
		$q = $this->db->query("select isi_idp from enterprise.trans_idp_new where nrp = '$nrp'  and tahun = '$tahun' and id_idp = 4");
		return $q;
	}

	public function profile_inass($nrp)
	{
		$q = $this->db->query("select a.nip nrp, a.nama_lengkap nama_karyawan, b.insert_date date_of_enrty, b.tahun, c.nama_lengkap assesor
		from enterprise.mst_karyawan a, 
		(select distinct nrp, tahun, insert_by, insert_date from enterprise.trans_idp_new where nrp = '$nrp') b,
		enterprise.mst_karyawan c
		where a.nip = b.nrp and a.nip = '$nrp'
		and b.insert_by = c.nip");
		return $q;
	}

	public function list_member($nrp)
	{

		$q = $this->db->query("SELECT id_karyawan, nip, nama_lengkap, status_jaya, department, job_title, job_grade, tgl_hire, tgl_permanen, tgl_lahir
		FROM mst_karyawan
		where (spv1 = '$nrp' OR spv2 = '$nrp' OR spv3 = '$nrp')
		and flag_hapus = '0'
		order by nama_lengkap asc");
		return $q;
	}

	public function list_member_rekap($unit)
	{

		$q = $this->db->query("SELECT a.id_karyawan, a.nip, a.nama_lengkap, a.status_jaya, a.department, 
		a.job_title, a.job_grade, a.tgl_hire, a.tgl_permanen, a.tgl_lahir, b.id_bagian
		FROM mst_karyawan a
		LEFT JOIN mst_bagian b on a.department = b.nama_bagian
		where flag_hapus = '0'
		and b.id_bagian = '$unit'
		order by nama_lengkap asc");
		return $q;
	}
	public function detail_bagian($unit)
	{
		$q  = $this->db->query("SELECT nama_bagian
        FROM mst_bagian
        WHERE id_bagian = '$unit'")->row();
		return $q;
	}

	public function list_idp_belum($thn)
	{

		$q = $this->db->query("SELECT id_karyawan, nip, nama_lengkap, status_jaya, department, job_title, job_grade, tgl_hire, tgl_permanen, tgl_lahir, spv1, spv2, spv3
		FROM mst_karyawan
		where nip not in (select distinct x.nrp from trans_idp_new x)
		and flag_hapus = '0'
		order by nama_lengkap asc");
		return $q;
	}
	public function list_idp_rekap($thn, $nrp)
	{

		$q = $this->db->query("select idp.insert_by, idp.nrp, mk.nama_lengkap, mi.nama_value, idp.isi_idp, idp.insert_date, 
		(select x.nama_lengkap from enterprise.mst_karyawan x where x.nip = idp.insert_by) as insertby 
		from enterprise.trans_idp_new idp, enterprise.mst_idp mi, enterprise.mst_karyawan mk 
		where idp.id_idp = mi.id_idp and mk.nip = idp.nrp and idp.tahun = '$thn' 
		AND idp.insert_by = '$nrp'
		order by nama_lengkap , insertby asc");
		return $q;
	}

	public function list_idp_rekap_admin($unit)
	{

		$q = $this->db->query("select idp.insert_by, idp.nrp, mk.nama_lengkap, mi.nama_value, idp.isi_idp, idp.insert_date, 
		(select x.nama_lengkap from enterprise.mst_karyawan x where x.nip = idp.insert_by) as insertby 
		from enterprise.trans_idp_new idp, enterprise.mst_idp mi, enterprise.mst_karyawan mk
		LEFT JOIN enterprise.mst_bagian mb ON mk.department = mb.nama_bagian
		where idp.id_idp = mi.id_idp and mk.nip = idp.nrp and mb.id_bagian = '$unit'
		order by nama_lengkap , insertby asc");
		return $q;
	}

	public function list_inass_rekap($thn, $nrp)
	{
		$q = $this->db->query("SELECT DISTINCT  inass.nrp, mk.nama_lengkap, inass.tahun,
		(select x.nama_lengkap from enterprise.mst_karyawan x where x.nip = inass.insert_by) as insertby,
		 
		(SELECT AVG(isi_inass2) AS inas2_2 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('6','7','8','9','10','11')LIMIT 1),
		
		(SELECT AVG(isi_inass2)  AS inas2_3 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('12','13')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_4 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('14','15','16')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_5 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('17','18','19')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_6 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('20','21','22','23')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_1 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp =mk.nip AND id_inass3 IN('1','2','3','4','5','6','7','8','9','10')LIMIT 1),
		
		(SELECT  AVG(isi_inass3) AS inas3_2 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('11','12','13','14','15')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_3 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('16','17','18','19','20')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_4 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('21')LIMIT 1),

		(SELECT AVG(isi_inass3) AS inas3_5 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('22', '23')LIMIT 1),

		(SELECT (isi_inass) AS isi_inass1 FROM enterprise.trans_inass inass
		WHERE inass.nrp = mk.nip AND id_inass IN('7')LIMIT 1),
		
		(SELECT (isi_inass) AS isi_inass11 FROM enterprise.trans_inass inass
		WHERE inass.nrp = mk.nip AND id_inass IN('8')LIMIT 1)

		from enterprise.trans_inass inass, enterprise.mst_inass ma, enterprise.mst_karyawan mk
		WHERE inass.id_inass = ma.id_iass and mk.nip = inass.nrp and inass.tahun = '$thn' and inass.insert_by = '$nrp'
		order by nama_lengkap , insertby ASC");
		return $q;
	}

	public function list_inass_rekap_admin($unit)
	{
		$q = $this->db->query("SELECT DISTINCT  inass.nrp, mk.nama_lengkap, inass.tahun,
		(select x.nama_lengkap from enterprise.mst_karyawan x where x.nip = inass.insert_by) as insertby,
		 
		(SELECT AVG(isi_inass2) AS inas2_2 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('6','7','8','9','10','11')LIMIT 1),
		
		(SELECT AVG(isi_inass2)  AS inas2_3 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('12','13')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_4 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('14','15','16')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_5 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('17','18','19')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_6 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('20','21','22','23')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_1 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp =mk.nip AND id_inass3 IN('1','2','3','4','5','6','7','8','9','10')LIMIT 1),
		
		(SELECT  AVG(isi_inass3) AS inas3_2 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('11','12','13','14','15')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_3 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('16','17','18','19','20')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_4 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('21')LIMIT 1),

		(SELECT AVG(isi_inass3) AS inas3_5 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('22', '23')LIMIT 1),

		(SELECT (isi_inass) AS isi_inass1 FROM enterprise.trans_inass inass
		WHERE inass.nrp = mk.nip AND id_inass IN('7')LIMIT 1),
		
		(SELECT (isi_inass) AS isi_inass11 FROM enterprise.trans_inass inass
		WHERE inass.nrp = mk.nip AND id_inass IN('8')LIMIT 1)

		from enterprise.trans_inass inass, enterprise.mst_inass ma, enterprise.mst_karyawan mk
		LEFT JOIN enterprise.mst_bagian mb ON mk.department = mb.nama_bagian
		WHERE inass.id_inass = ma.id_iass and mk.nip = inass.nrp and mb.id_bagian = '$unit'
		order by nama_lengkap , insertby ASC");
		return $q;
	}

	public function list_inass_rekap_score($id, $thn)
	{
		$q = $this->db->query("SELECT DISTINCT  inass.nrp, mk.nama_lengkap, inass.tahun,
		(select x.nama_lengkap from enterprise.mst_karyawan x where x.nip = inass.insert_by) as insertby,
		 
		(SELECT AVG(isi_inass2) AS inas2_2 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('6','7','8','9','10','11')LIMIT 1),
		
		(SELECT AVG(isi_inass2)  AS inas2_3 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('12','13')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_4 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('14','15','16')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_5 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('17','18','19')LIMIT 1),
		
		(SELECT AVG(isi_inass2) AS inas2_6 FROM enterprise.trans_inass2 inass2 
		WHERE inass2.nrp = mk.nip AND id_inass2 IN('20','21','22','23')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_1 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp =mk.nip AND id_inass3 IN('1','2','3','4','5','6','7','8','9','10')LIMIT 1),
		
		(SELECT  AVG(isi_inass3) AS inas3_2 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('11','12','13','14','15')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_3 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('16','17','18','19','20')LIMIT 1),
		
		(SELECT AVG(isi_inass3) AS inas3_4 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('21')LIMIT 1),

		(SELECT AVG(isi_inass3) AS inas3_5 FROM enterprise.trans_inass3 inass3 
		WHERE inass3.nrp = mk.nip AND id_inass3 IN('22', '23')LIMIT 1),

		(SELECT (isi_inass) AS isi_inass1 FROM enterprise.trans_inass inass
		WHERE inass.nrp = mk.nip AND id_inass IN('7')LIMIT 1),
		
		(SELECT (isi_inass) AS isi_inass11 FROM enterprise.trans_inass inass
		WHERE inass.nrp = mk.nip AND id_inass IN('8')LIMIT 1)

		from enterprise.trans_inass inass, enterprise.mst_inass ma, enterprise.mst_karyawan mk
		LEFT JOIN enterprise.mst_bagian mb ON mk.department = mb.nama_bagian
		WHERE inass.id_inass = ma.id_iass and inass.nrp = mk.nip AND inass.nrp = '$id' AND inass.tahun = '$thn'
		order by nama_lengkap , insertby ASC");
		return $q;
	}
	public function list_idp_sudah($thn)
	{

		$q = $this->db->query("SELECT id_karyawan, nip, nama_lengkap, status_jaya, department, job_title, job_grade, tgl_hire, tgl_permanen, tgl_lahir, spv1, spv2, spv3
		FROM mst_karyawan
		where nip in (select distinct x.nrp from trans_idp_new x)
		and flag_hapus = '0'
		order by nama_lengkap asc");
		return $q;
	}

	public function list_inass_belum()
	{

		$q = $this->db->query("SELECT id_karyawan, nip, nama_lengkap, status_jaya, department, job_title, job_grade, tgl_hire, tgl_permanen, tgl_lahir, spv1, spv2, spv3
		FROM mst_karyawan
		where nip not in (select distinct x.nrp from trans_inass x)
		and flag_hapus = '0'
		order by nama_lengkap asc");
		return $q;
	}

	public function list_inass_sudah()
	{

		$q = $this->db->query("SELECT id_karyawan, nip, nama_lengkap, status_jaya, department, job_title, job_grade, tgl_hire, tgl_permanen, tgl_lahir, spv1, spv2, spv3
		FROM mst_karyawan
		where nip in (select distinct x.nrp from trans_inass x)
		and flag_hapus = '0'
		order by nama_lengkap asc");
		return $q;
	}

	public function list_member_sudah_idp($nrp)
	{
		$q = $this->db->query("
				select
			kar.id_karyawan,
			kar.nip,
			kar.nama_lengkap
		from
			enterprise.mst_karyawan kar,
			(select
				distinct x.nrp
			from
				enterprise.trans_idp_new x
			where
				x.tahun = '2024'
				and x.flag_sent = '1'
				and insert_by = '$nrp') as trn
		where
			(kar.spv1 = '$nrp'
				or kar.spv2 = '$nrp'
				or kar.spv3 = '$nrp')
			and kar.flag_hapus = '0'
			and kar.nip = trn.nrp||''
		order by
			kar.nama_lengkap asc");
		return $q;
	}
	public function list_member_sudah_inass($nrp)
	{
		$q = $this->db->query("
				select
			kar.id_karyawan,
			kar.nip,
			kar.nama_lengkap
		from
			enterprise.mst_karyawan kar,
			(select
				distinct x.nrp
			from
				enterprise.trans_inass x
			where
				x.tahun = '2024'
				and insert_by = '$nrp') as trn
		where
			(kar.spv1 = '$nrp'
				or kar.spv2 = '$nrp'
				or kar.spv3 = '$nrp')
			and kar.flag_hapus = '0'
			and kar.nip = trn.nrp||''
		order by
			kar.nama_lengkap asc");
		return $q;
	}

	public function cek_idp($tahun, $nrp, $insert_by)
	{
		$p = $this->db->query("
		select idp_jwb.jml_jwb||'/'||idp_mst.jml_idp as hasil, idp_mst.jml_idp-idp_jwb.jml_jwb as cek FROM (SELECT count(*) jml_jwb FROM trans_idp_new 
		where tahun = '$tahun' and nrp = '$nrp' and insert_by = '$insert_by') idp_jwb,
		(SELECT count(*) jml_idp from mst_idp) idp_mst");

		return $p;
	}

	public function cek_idp_rekap($tahun, $nrp)
	{
		$p = $this->db->query("
		select idp_jwb.jml_jwb||'/'||idp_mst.jml_idp as hasil, idp_mst.jml_idp-idp_jwb.jml_jwb as cek FROM (SELECT count(*) jml_jwb FROM trans_idp_new 
		where tahun = '$tahun' and nrp = '$nrp') idp_jwb,
		(SELECT count(*) jml_idp from mst_idp) idp_mst");

		return $p;
	}

	public function cek_sent_idp_rekap($tahun, $nrp)
	{
		$q = $this->db->query("SELECT distinct flag_sent as f_sent
		FROM trans_idp_new
		where tahun = '$tahun'
		and nrp = '$nrp'");
		return $q;
	}

	public function cek_sent_idp($tahun, $nrp, $insert_by)
	{
		$q = $this->db->query("SELECT distinct flag_sent as f_sent
		FROM trans_idp_new
		where tahun = '$tahun'
		and nrp = '$nrp'
		and insert_by = '$insert_by'");
		return $q;
	}

	public function cek_sent_inass($tahun, $nrp, $insert_by)
	{
		$q = $this->db->query("SELECT *
		FROM trans_inass
		where tahun = '$tahun'
		and nrp = '$nrp'
		and insert_by = '$insert_by'");
		return $q;
	}

	public function cek_sent_inass_rekap($tahun, $nrp)
	{
		$q = $this->db->query("SELECT distinct flag_sent as f_sent
		FROM trans_inass
		where tahun = '$tahun'
		and nrp = '$nrp'");
		return $q;
	}

	public function detail_nrp($nrp)
	{
		$q = $this->db->query("SELECT nama_lengkap
        FROM mst_karyawan
        WHERE nip = '$nrp'");
		return $q;
	}

	public function list_tanya_idp()
	{
		$q = $this->db->query("SELECT *
        FROM mst_idp
        ORDER BY urutan asc");
		return $q;
	}

	public function list_tanya_inass1($id)
	{
		$q = $this->db->query("SELECT *
        FROM mst_inass
		WHERE id_iass = '$id'
		AND flag_diisi = 'Y'
        ORDER BY urutan asc");
		return $q;
	}

	public function list_tanya_inass2($id)
	{
		$q = $this->db->query("SELECT *
        FROM mst_inass_2
		WHERE id_iass = '$id'
		AND flag_diisi = 'Y'
        ORDER BY urutan asc");
		return $q;
	}

	public function list_tanya_inass3($id)
	{
		$q = $this->db->query("SELECT *
        FROM mst_inass_3
        WHERE id_iass_2 = '$id'
		AND flag_diisi = 'Y'
		ORDER BY urutan asc");
		return $q;
	}

	public function list_isi_inass3($id, $nrp, $tahun, $atasan)
	{
		$q = $this->db->query("select ina3.id_iass_3, ina3.nama_value, tina3.isi_inass3 
		from enterprise.mst_inass_3 ina3, enterprise.trans_inass3 tina3
		where id_iass_2 = '$id'
		and ina3.id_iass_3 = tina3.id_inass3
		and tina3.tahun = '$tahun'
		and tina3.nrp = '$nrp'
		and tina3.insert_by = '$atasan'
		and ina3.flag_diisi = 'Y'
		order by ina3.urutan asc;");
		return $q;
	}

	public function list_isi_inass2($id, $nrp, $tahun, $atasan)
	{
		$q = $this->db->query("select ina2.id_iass_2, ina2.nama_value, tina2.isi_inass2 
		from enterprise.mst_inass_2 ina2, enterprise.trans_inass2 tina2
		where id_iass = '$id'
		and ina2.id_iass_2 = tina2.id_inass2
		and tina2.tahun = '$tahun'
		and tina2.nrp = '$nrp'
		and tina2.insert_by = '$atasan'
		and ina2.flag_diisi = 'Y'
		order by ina2.urutan asc;");
		return $q;
	}

	public function list_isi_inass($id, $nrp, $tahun, $atasan)
	{
		$q = $this->db->query("select ina.id_iass, ina.nama_value, tina.isi_inass 
		from enterprise.mst_inass ina, enterprise.trans_inass tina
		where id_iass = '$id'
		and ina.id_iass = tina.id_inass
		and tina.tahun = '$tahun'
		and tina.nrp = '$nrp'
		and tina.insert_by = '$atasan'
		and ina.flag_diisi = 'Y'
		order by ina.urutan asc;");
		return $q;
	}

	public function cek_jawab_idp($tahun, $id_idp, $nrp, $atasan)
	{
		$q = $this->db->query("SELECT id_trn_idp, isi_idp
        FROM trans_idp_new
		WHERE tahun = '$tahun'
		AND id_idp = '$id_idp' AND nrp = '$nrp' AND insert_by = '$atasan'");
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

	public function cek_jwb_inass3($nrp, $tahun, $id_inass3, $atasan)
	{
		$q = $this->db->query("SELECT isi_inass3
		FROM trans_inass3
		WHERE tahun = '$tahun' AND nrp = '$nrp'  AND id_inass3 = '$id_inass3' and insert_by = '$atasan'");
		return $q;
	}

	public function cek_jwb_inass2($nrp, $tahun, $id_inass2, $atasan)
	{
		$q = $this->db->query("SELECT isi_inass2
		FROM trans_inass2
		WHERE tahun = '$tahun' AND nrp = '$nrp'  AND id_inass2 = '$id_inass2'and insert_by = '$atasan'");
		return $q;
	}

	public function cek_jwb_inass($nrp, $tahun, $id_inass, $atasan)
	{
		$q = $this->db->query("SELECT isi_inass
		FROM trans_inass
		WHERE tahun = '$tahun' AND nrp = '$nrp'  AND id_inass = '$id_inass' and insert_by = '$atasan'");
		return $q;
	}

	//MASTER - ASSESSMENT
	public function list_assessment($nrp)
	{
		$q = $this->db->query("SELECT *
		FROM trans_assessment
		WHERE nrp = '$nrp'");
		return $q;
	}
	//MASTER - APPRAISAIL
	public function list_appraisal($nrp)
	{
		$q = $this->db->query("SELECT *
		FROM trans_appraisal
		WHERE nrp = '$nrp'");
		return $q;
	}
	//MASTER - TRAINING
	public function list_training($nrp)
	{
		$q = $this->db->query("SELECT *
		FROM trans_training_history
		WHERE nrp = '$nrp'");
		return $q;
	}
	//MASTER - JOB
	public function list_job($nrp)
	{
		$q = $this->db->query("SELECT *
		FROM trans_job_experience
		WHERE nrp = '$nrp'");
		return $q;
	}
	//MASTER - EDUCATION
	public function list_education($nrp)
	{
		$q = $this->db->query("SELECT *
		FROM trans_education
		WHERE nrp = '$nrp'");
		return $q;
	}
	//MASTER - CAREER
	public function list_career($nrp)
	{
		$q = $this->db->query("SELECT *
		FROM trans_career
		WHERE nrp = '$nrp'");
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

	public function list_slip_gaji($bulan)
	{
		$q = $this->db->query("SELECT * 
			FROM trans_slip 
			WHERE LEFT(bulan, 7) = '$bulan'");
		return $q;
	}

	public function detail_slip($bulan)
	{
		$q = $this->db->query("SELECT nig, nama_guru, gapok, tpt, jabatan, jht, bpjs, transport, tahsin, ko_bhs, k_jilid, sat, piket, pengganti_pelajaran, jht_2, bpjs_2, eskul, pinj_yayasan, koperasi, pembinaan_tahfidz, pph, qurban, dll 
		FROM trans_slip 
		WHERE bulan = '$bulan'");
		return $q;
	}

	public function detail_gaji_guru($id_slip)
	{
		$q = $this->db->query("SELECT nig, nama_guru
		FROM trans_slip 
		where id_slip = '$id_slip'");
		return $q;
	}

	public function gaji($id_slip)
	{
		$this->db->select('nig, nama_guru, gapok, tpt, jabatan, jht, bpjs, transport, tahsin, ko_bhs, k_jilid, sat, piket, pengganti_pelajaran, jht_2, bpjs_2, eskul, pinj_yayasan, koperasi, pembinaan_tahfidz, pph, qurban, dll');
		$this->db->from('trans_slip');
		$this->db->where('id_slip', $id_slip);
		$query = $this->db->get();
		return $query;
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
