<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'page';
// PERBAIKAN: view pages/empat_nol_empat.php (halaman 404 bergaya situs) sudah
// ada sejak penggabungan 18 Sep 2026 tapi tidak pernah dipasang.
$route['404_override'] = 'page/tidak_ditemukan';
$route['translate_uri_dashes'] = FALSE;

// ==========================================================================
// Panel Admin TK & SD (terpisah)
// ==========================================================================
$route['admin-tk']           = 'admin_tk/index';
$route['admin-tk/login']     = 'admin_tk/login';
$route['admin-tk/logout']    = 'admin_tk/logout';
$route['admin-tk/profil']    = 'admin_tk/profil';
$route['admin-tk/add_konten']    = 'admin_tk/add_konten';
$route['admin-tk/update_konten'] = 'admin_tk/update_konten';
$route['admin-tk/delete_konten'] = 'admin_tk/delete_konten';

$route['admin-sd']           = 'admin_sd/index';
$route['admin-sd/login']     = 'admin_sd/login';
$route['admin-sd/logout']    = 'admin_sd/logout';
$route['admin-sd/profil']    = 'admin_sd/profil';
$route['admin-sd/add_konten']    = 'admin_sd/add_konten';
$route['admin-sd/update_konten'] = 'admin_sd/update_konten';
$route['admin-sd/delete_konten'] = 'admin_sd/delete_konten';

// Route SD K Citra Bangsa Mandiri
$route['sd'] = 'sd';
$route['sd/(:any)'] = 'sd/$1';

// Route TK K Citra Bangsa Mandiri
$route['tk'] = 'tk';
$route['tk/(:any)'] = 'tk/$1';

// Struktur Organisasi
$route['struktur'] = 'page/struktur';

// Profil & Jejaring
$route['profil'] = 'page/profil';
$route['jejaring'] = 'page/jejaring';

// Informasi
$route['berita'] = 'page/berita';
// PERBAIKAN: tautan berita memakai format berita/{id}/{slug} (2 segmen).
// (:any) hanya cocok 1 segmen, sehingga dulu semua halaman detail -> 404.
$route['berita/(:num)/(:any)'] = 'page/berita/$1/$2';
$route['berita/(:any)'] = 'page/berita/$1';
$route['kegiatan'] = 'page/kegiatan';
$route['kegiatan/(:any)'] = 'page/kegiatan/$1';
$route['galeri'] = 'page/galeri';
$route['galeri/(:any)'] = 'page/galeri/$1';

// Sitemap XML
$route['sitemap\.xml'] = 'sitemap';

// Kebijakan Privasi
$route['kebijakan-privasi'] = 'page/kebijakan_privasi';
$route['kebijakan_privasi'] = 'page/kebijakan_privasi';

// Kontak
$route['kontak'] = 'kontak';
$route['kontak/(:any)'] = 'kontak/$1';

// Search Sitewide
$route['search'] = 'search';
$route['search/(:any)'] = 'search/$1';

// Halaman pengarah pendaftaran (tautan "Pendaftaran" di footer situs yayasan).
// PERBAIKAN: view pages/daftar.php sudah ada tapi rutenya belum -> dulu 404.
$route['daftar'] = 'page/daftar';

// Portal Pendaftaran Terpadu Multi-Step
$route['pendaftaran'] = 'pendaftaran';
$route['pendaftaran/(:any)'] = 'pendaftaran/$1';

// Newsletter
$route['newsletter/(:any)'] = 'newsletter/$1';

// API Internal
$route['api/(:any)'] = 'api/$1';
