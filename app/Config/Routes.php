<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

use App\Controllers\Eksekusi;
use App\Controllers\Akreditasi;
use App\Controllers\Home;
use App\Controllers\Administrator;
use App\Controllers\Mis;
use App\Controllers\Pengaturan;
use App\Controllers\Suratkeputusan;
use App\Controllers\SOP;
use App\Controllers\Auth;
use App\Controllers\Eis;

$routes->group('eksekusi/', static function ($routes) {
    $routes->get('putusan_selesai', [Eksekusi::class, 'putusan_selesai']);
    $routes->post('data_eksekusi_datatable', [Eksekusi::class, 'data_eksekusi_datatable']);
    $routes->get('putusan_belum_selesai', [Eksekusi::class, 'putusan_belum_selesai']);
    $routes->post('data_eksekusi_belum_datatable', [Eksekusi::class, 'data_eksekusi_belum_datatable']);
    $routes->get('ht_selesai', [Eksekusi::class, 'ht_selesai']);
    $routes->post('data_ht_datatable', [Eksekusi::class, 'data_ht_datatable']);
    $routes->get('ht_belum_selesai', [Eksekusi::class, 'ht_belum_selesai']);
    $routes->post('data_ht_belum_datatable', [Eksekusi::class, 'data_ht_belum_datatable']);
});

$routes->group('akreditasi/', static function ($routes) {
    $routes->get('index', [Akreditasi::class, 'index']);
    $routes->get('excel_to_array', [Akreditasi::class, 'excel_to_array']);
    $routes->post('getDataApm', [Akreditasi::class, 'getDataApm']);
    $routes->post('modal_upload_doc', [Akreditasi::class, 'modal_upload_doc']);
    $routes->post('modal_link', [Akreditasi::class, 'modal_link']);
    $routes->post('upload_doc', [Akreditasi::class, 'upload_doc']);
    $routes->get('upload_to_drive', [Akreditasi::class, 'upload_to_drive']);
    $routes->get('modal_preview', [Akreditasi::class, 'modal_preview']);
    $routes->get('preview_checklist', [Akreditasi::class, 'preview_checklist']);
    $routes->get('daftar_assesment_internal', [Akreditasi::class, 'daftar_assesment_internal']);
    $routes->get('modal_upload_internal', [Akreditasi::class, 'modal_upload_internal']);
    $routes->post('upload_ass_internal', [Akreditasi::class, 'upload_ass_internal']);
    $routes->get('upload_internal_drive', [Akreditasi::class, 'upload_internal_drive']);
    $routes->get('hapus_internal/(:any)', [Akreditasi::class, 'hapus_internal']);
    $routes->get('hapus_internal_drive', [Akreditasi::class, 'hapus_internal_drive']);
    $routes->get('daftar_assesment_eksternal', [Akreditasi::class, 'daftar_assesment_eksternal']);
    $routes->get('modal_upload_eksternal', [Akreditasi::class, 'modal_upload_eksternal']);
    $routes->post('upload_ass_eksternal', [Akreditasi::class, 'upload_ass_eksternal']);
    $routes->get('upload_eksternal_drive', [Akreditasi::class, 'upload_eksternal_drive']);
    $routes->get('hapus_eksternal/(:any)', [Akreditasi::class, 'hapus_eksternal']);
    $routes->get('hapus_eksternal_drive', [Akreditasi::class, 'hapus_eksternal_drive']);
    $routes->get('import_checklist', [Akreditasi::class, 'import_checklist']);
    $routes->post('import_checklist_db', [Akreditasi::class, 'import_checklist_db']);
});

$routes->group('administrator/', static function ($routes) {
    // $routes->get('', [Akreditasi::class, 'index']);
    $routes->get('upload_excel_akreditasi', [Administrator::class, 'upload_excel_akreditasi']);
    $routes->get('upload_excel_mis', [Administrator::class, 'upload_excel_mis']);
});

$routes->group('mis/', static function ($routes) {
    // $routes->get('', [Akreditasi::class, 'index']);
    $routes->get('', [Mis::class, 'index']);
    $routes->get('mis_ajax', [Mis::class, 'mis_ajax']);
});
$routes->group('eis/', static function ($routes) {
    // $routes->get('', [Akreditasi::class, 'index']);
    $routes->get('daftar_eis', [Eis::class, 'daftar_eis']);
    $routes->post('daftar_eis_ajax', [Eis::class, 'daftar_eis_ajax']);
    $routes->get('daftar_eis_ajax', [Eis::class, 'daftar_eis_ajax']);
});

$routes->group('pengaturan/', static function ($routes) {

    $routes->get('bagian', [Pengaturan::class, 'bagian']);
    $routes->get('modal_bagian', [Pengaturan::class, 'modal_bagian']);
    $routes->post('modal_bagian', [Pengaturan::class, 'modal_bagian']);

    $routes->post('insert_bagian', [Pengaturan::class, 'insert_bagian']);
    $routes->post('insert_bagian/(:any)', [Pengaturan::class, 'insert_bagian']);
    $routes->post('hapus_bagian', [Pengaturan::class, 'hapus_bagian']);
    $routes->get('daftar_google_client', [Pengaturan::class, 'daftar_google_client']);
    $routes->post('insert_gc', [Pengaturan::class, 'insert_gc']);
    $routes->post('insert_gc/(:any)', [Pengaturan::class, 'insert_gc']);
    $routes->get('parent_folder', [Pengaturan::class, 'parent_folder']);
    $routes->get('modal_folder', [Pengaturan::class, 'modal_folder']);
    $routes->post('modal_folder', [Pengaturan::class, 'modal_folder']);
    $routes->post('insert_folder', [Pengaturan::class, 'insert_folder']);
    $routes->post('insert_folder/(:any)', [Pengaturan::class, 'insert_folder']);
    $routes->post('hapus_parent', [Pengaturan::class, 'hapus_parent']);
    $routes->get('redirect_uri', [Pengaturan::class, 'redirect_uri']);
    $routes->get('modal_uri', [Pengaturan::class, 'modal_uri']);
    $routes->post('modal_uri', [Pengaturan::class, 'modal_uri']);
    $routes->post('insert_uri', [Pengaturan::class, 'insert_uri']);
    $routes->post('insert_uri/(:any)', [Pengaturan::class, 'insert_uri']);
    $routes->post('hapus_uri', [Pengaturan::class, 'hapus_uri']);
    $routes->get('daftar_akun', [Pengaturan::class, 'daftar_akun']);
    $routes->get('modal_akun', [Pengaturan::class, 'modal_akun']);
    $routes->post('modal_akun', [Pengaturan::class, 'modal_akun']);
    $routes->post('insert_akun', [Pengaturan::class, 'insert_akun']);
    $routes->post('insert_akun/(:any)', [Pengaturan::class, 'insert_akun']);
});

$routes->group('home', static function ($routes) {

    $routes->post('getLinkApm', [Home::class, 'getLinkApm']);
});

$routes->group('suratkeputusan', static function ($routes) {

    $routes->get('daftar_surat_keputusan', [Suratkeputusan::class, 'daftar_surat_keputusan']);
    $routes->post('data_sk_datatable', [Suratkeputusan::class, 'data_sk_datatable']);
    $routes->get('modal_sk', [Suratkeputusan::class, 'modal_sk']);
    $routes->post('modal_sk', [Suratkeputusan::class, 'modal_sk']);
    $routes->post('upload_sk', [Suratkeputusan::class, 'upload_sk']);
    $routes->post('upload_sk/(:any)', [Suratkeputusan::class, 'upload_sk']);
    $routes->get('download/(:any)', [Suratkeputusan::class, 'download']);
    $routes->post('hapus_sk', [Suratkeputusan::class, 'hapus_sk']);
});

$routes->group('sop', static function ($routes) {

    $routes->get('daftar_sop/(:any)', [Sop::class, 'daftar_sop']);
    $routes->get('modal_sop', [Sop::class, 'modal_sop']);
    $routes->get('modal_sop/(:any)', [Sop::class, 'modal_sop']);
    $routes->post('modal_sop/(:any)', [Sop::class, 'modal_sop']);
    $routes->post('upload_sop', [Sop::class, 'upload_sop']);
    $routes->post('upload_sop/(:any)', [Sop::class, 'upload_sop']);
    $routes->get('download/(:any)', [Sop::class, 'download']);
    $routes->post('hapus_sop', [Sop::class, 'hapus_sop']);
    $routes->get('modal_import/(:any)', [Sop::class, 'modal_import']);
    $routes->post('import_excel', [Sop::class, 'import_excel']);
});

$routes->group('auth', static function ($routes) {

    $routes->get('', [Auth::class, 'index']);
    $routes->post('attempt_login', [Auth::class, 'attempt_login']);
    $routes->get('logout', [Auth::class, 'logout']);
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
