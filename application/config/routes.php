<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = 'page_404';
$route['translate_uri_dashes'] = FALSE;
//API
$route['rest/login']            = 'Rest/login_api/login';
$route['rest/logout']           = 'Rest/login_api/logout';
$route['rest/save_token']       = 'Rest/login_api/simpan_token';

$route['rest/profil']           = 'Rest/profil_api/profil';
$route['rest/ganti_password']   = 'Rest/profil_api/ganti_password';
$route['rest/update_profil']    = 'Rest/profil_api/update_profil';

$route['rest/gaji']             = 'Rest/gaji_api/gaji';
$route['rest/print_gaji']       = 'Rest/gaji_api/print_gaji';

$route['rest/list_sub_lokasi']      = 'Rest/hadir_api/list_sub_lokasi';
$route['rest/list_bagian']          = 'Rest/hadir_api/list_bagian';
$route['rest/sisa_cuti']            = 'Rest/hadir_api/sisa_cuti';
$route['rest/kehadiran_hari_ini']   = 'Rest/hadir_api/kehadiran_hari_ini';
$route['rest/kehadiran_resume']     = 'Rest/hadir_api/resume_kehadiran';
$route['rest/kehadiran_detail']     = 'Rest/hadir_api/detail_kehadiran';

$route['rest/list_nilai']       = 'Rest/nilai_api/list_nilai';
$route['rest/lap_nilai']        = 'Rest/nilai_api/lap_nilai';

$route['rest/list_berita']      = 'Rest/berita_api/list_berita';

$route['rest/simpan_izin']          = 'Rest/absen_api/simpan_izin';
$route['rest/simpan_absen']         = 'Rest/absen_api/tambah_absen_umum';
$route['rest/simpan_sppd']          = 'Rest/absen_api/tambah_sppd';
$route['rest/simpan_absen_brdi']    = 'Rest/absen_api/tambah_absen_brdi';
$route['rest/simpan_absen_sholat']  = 'Rest/absen_api/tambah_absen_sholat';

$route['rest/list_lapor']       = 'Rest/lapor_api/list_lapor';
$route['rest/lapor_non']        = 'Rest/lapor_api/lapor_non';
$route['rest/lapor_kejadian']   = 'Rest/lapor_api/lapor_kejadian';