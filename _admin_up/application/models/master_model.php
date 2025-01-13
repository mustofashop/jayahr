<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model {
    //USERS
    public function get_user(){
		$id= $this->session->userdata('id_admin');
        $q = $this->db->query("SELECT * FROM admins WHERE id_username='$id'");
        return $q;
    }
    //SETTINGS
    public function hari_ini($hari){
		date_default_timezone_set('Asia/Jakarta');
		$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		$hari_ini = $seminggu[$hari];
		return $hari_ini;
    }
    public function tgl_indo($tgl){
        $jam = substr($tgl,11,10);
        $tgl = substr($tgl,0,10);
        $tanggal = substr($tgl,8,2);
        $bulan = $this->master_model->getBulan(substr($tgl,5,2));
        $tahun = substr($tgl,0,4);
        return $tanggal.' '.$bulan.' '.$tahun.' '.$jam;		 
	}
	//Konversi tanggal
	public function tgl_sql($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
    public function getBulan($bln){
		switch ($bln){
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
	//LIBUR 
	public function list_libur_nasional()
	{
		$q	= $this->db->query("SELECT id_libur_nasional, keterangan, to_char(tanggal::date, 'DD-MM-YYYY') as tanggal, to_char(tanggal::date, 'YYYY') as tahun, to_char(tanggal::date, 'MM') as bulan, to_char(tanggal::date, 'DD') as hari
		FROM mst_libur_nasional
		order by tahun desc, bulan asc, hari asc");
		return $q;
	}
	public function list_libur_sekolah()
	{
		$q	= $this->db->query("SELECT a.id_libur_sekolah, a.keterangan, to_char(a.tanggal::date, 'DD-MM-YYYY') as tanggal, to_char(a.tanggal::date, 'YYYY') as tahun, b.nama_sekolah
		FROM mst_libur_sekolah a
		JOIN mst_sekolah b on a.id_sekolah = b.id_sekolah
		order by b.nama_sekolah asc, tahun asc, tanggal asc");
		return $q;
	}
	public function list_tahun_libur_nasional()
	{
		$q	= $this->db->query("SELECT to_char(tanggal::date, 'YYYY') as tahun
		FROM mst_libur_nasional
		group by tahun
		order by tahun asc");
		return $q;
	}
	public function list_tahun_libur_sekolah()
	{
		$q	= $this->db->query("SELECT to_char(tanggal::date, 'YYYY') as tahun
		FROM mst_libur_sekolah
		group by tahun
		order by tahun asc");
		return $q;
	}
	public function data_libur_nasional($tahun)
	{
		$q	= $this->db->query("SELECT keterangan, tanggal
		FROM mst_libur_nasional
		WHERE extract(year FROM tanggal::date) = '$tahun'
		order by tanggal asc");
		return $q;
	}
	public function data_libur_sekolah($sekolah,$tahun)
	{
		$q	= $this->db->query("SELECT a.keterangan, a.tanggal, b.nama_sekolah, a.id_sekolah
		FROM mst_libur_sekolah a
		join mst_sekolah b on a.id_sekolah = b.id_sekolah
		WHERE extract(year FROM a.tanggal::date) = '$tahun'
		and a.id_sekolah = '$sekolah'
		order by a.tanggal asc");
		return $q;
	}
	//APLIKASI MOBILE
	public function list_aplikasi_mobile()
	{
		$q = $this->db->query("SELECT id_aplikasi_mobile,
		nama_aplikasi,
		nama_package,
		link_aplikasi,
		kode_aplikasi
		FROM mst_aplikasi_mobile2
		order by nama_aplikasi asc");
		return $q;
	}
	public function list_transaksi_aplikasi()
	{
		$q = $this->db->query("SELECT a.id_trans_aplikasi_mobile,
		a.version,
		to_char(a.release_date, 'DD-MM-YYYY') as release_date,
		to_char(a.last_update, 'DD-MM-YYYY HH24:MI:SS') as last_update,
		b.nama_aplikasi
		FROM mst_aplikasi_mobile2_trans a
		join mst_aplikasi_mobile2 b on a.id_aplikasi_mobile = b.id_aplikasi_mobile
		order by last_update desc");
		return $q;
	}
}