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
$route['404_override'] = 'not_found';
$route['translate_uri_dashes'] = FALSE;

//CHAT API MASTER
$route['chat_api']              = 'Chat_api/Chat_api';
$route['chat_api/simpan']       = 'Chat_api/Chat_api/simpan';
$route['chat_api/edit']         = 'Chat_api/Chat_api/edit';
$route['chat_api/hapus/(:num)'] = 'Chat_api/Chat_api/hapus/$1';

//CHAT API PELANGGAN
$route['chat_api/pelanggan']                = 'Chat_api/chat_api/pelanggan';
$route['chat_api/simpan_pelanggan']         = 'Chat_api/chat_api/simpan_pelanggan';
$route['chat_api/edit_pelanggan']           = 'Chat_api/chat_api/edit_pelanggan';
$route['chat_api/hapus_pelanggan/(:num)']   = 'Chat_api/chat_api/hapus_pelanggan/$1';

//CHAT API TRANSAKSI
$route['chat_api/transaksi']                    = 'Chat_api/chat_api/transaksi';
$route['chat_api/simpan_transaksi']             = 'Chat_api/chat_api/simpan_transaksi';
$route['chat_api/edit_transaksi']               = 'Chat_api/chat_api/edit_transaksi';
$route['chat_api/tidak_aktif_transaksi/(:any)'] = 'Chat_api/chat_api/tidak_aktif/$1';

//CHAT API REST
$route['chat_api/kirim_rest']                   = 'Chat_api/Chat_api/kirim_rest';
$route['chat_api/kirim/(:any)/(:any)/(:any)']   = 'Chat_api/Chat_api/kirim/$1/$2/$3';

//EBOOK REST
$route['ebook/list_penerbit']                   = 'beone/list_penerbit_rest';
$route['ebook/list_ebook']                      = 'beone/list_ebook_rest';
$route['ebook/list_matpel']                     = 'beone/list_matpel_rest';
