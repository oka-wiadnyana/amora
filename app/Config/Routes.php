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

use App\Controllers\AbsenPtsp;
use App\Controllers\Eksekusi;
use App\Controllers\Akreditasi;
use App\Controllers\Akreditasilocal;
use App\Controllers\Home;
use App\Controllers\Administrator;
use App\Controllers\Mis;
use App\Controllers\Pengaturan;
use App\Controllers\Suratkeputusan;
use App\Controllers\SOP;
use App\Controllers\Auth;
use App\Controllers\Eis;
use App\Controllers\Panitera;
use App\Controllers\Hakim;
use App\Controllers\Hawasbid;
use App\Controllers\Monevzi;
use App\Controllers\Dokumenzi;
use App\Controllers\Dokumenrapat;
use App\Controllers\Agenperubahan;
use App\Controllers\Pengadilantinggi;
use App\Controllers\Bawas;
use App\Controllers\Bpk;
use App\Controllers\Pengawasanlainnya;
use App\Controllers\Video;
use App\Controllers\Audio;
use App\Controllers\Briefing;
use App\Controllers\Mou;
use App\Controllers\Doklainnya;
use App\Controllers\Dokprivate;
use App\Controllers\Ptsp;
use App\Controllers\Ziarticle;
use App\Controllers\Putusanpidana;
use App\Controllers\RencanaAksi;
use App\Controllers\StandarPelayanan;
use App\Controllers\Aplikasi;
use App\Controllers\Review;
use App\Controllers\Sbk;
use App\Controllers\ShantiCare;


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
$routes->group('akreditasilocal/', static function ($routes) {
    $routes->get('index', [Akreditasilocal::class, 'index']);
    $routes->post('data_akreditasi_datatable', [Akreditasilocal::class, 'data_akreditasi_datatable']);
    $routes->get('detail_apm/(:any)', [Akreditasilocal::class, 'detail_apm']);
    $routes->post('data_detail_datatable/(:any)', [Akreditasilocal::class, 'data_detail_datatable']);
    $routes->post('modal_tambah', [Akreditasilocal::class, 'modal_tambah']);
    $routes->post('tambah_dok_apm', [Akreditasilocal::class, 'tambah_dok_apm']);
    $routes->post('hapus_dok_apm', [Akreditasilocal::class, 'hapus_dok_apm']);
    $routes->get('excel_to_array', [Akreditasilocal::class, 'excel_to_array']);
    $routes->post('getDataApm', [Akreditasilocal::class, 'getDataApm']);
    $routes->post('modal_upload_doc', [Akreditasilocal::class, 'modal_upload_doc']);
    $routes->post('modal_link', [Akreditasilocal::class, 'modal_link']);
    $routes->post('upload_doc', [Akreditasilocal::class, 'upload_doc']);
    $routes->get('upload_to_drive', [Akreditasilocal::class, 'upload_to_drive']);
    $routes->get('modal_preview', [Akreditasilocal::class, 'modal_preview']);
    $routes->get('preview_checklist', [Akreditasilocal::class, 'preview_checklist']);
    $routes->get('daftar_assesment_internal', [Akreditasilocal::class, 'daftar_assesment_internal']);
    $routes->get('modal_upload_internal', [Akreditasilocal::class, 'modal_upload_internal']);
    $routes->post('upload_ass_internal', [Akreditasilocal::class, 'upload_ass_internal']);
    $routes->post('hapus_internal', [Akreditasilocal::class, 'hapus_internal']);


    $routes->get('daftar_assesment_eksternal', [Akreditasilocal::class, 'daftar_assesment_eksternal']);
    $routes->get('modal_upload_eksternal', [Akreditasilocal::class, 'modal_upload_eksternal']);
    $routes->post('upload_ass_eksternal', [Akreditasilocal::class, 'upload_ass_eksternal']);
    $routes->get('upload_eksternal_drive', [Akreditasilocal::class, 'upload_eksternal_drive']);
    $routes->post('hapus_eksternal', [Akreditasilocal::class, 'hapus_eksternal']);


    $routes->get('import_checklist', [Akreditasilocal::class, 'import_checklist']);
    $routes->post('import_checklist_db', [Akreditasilocal::class, 'import_checklist_db']);
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
    $routes->get('get_skor', [Eis::class, 'get_skor']);
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
    $routes->post('hapus_akun', [Pengaturan::class, 'hapus_akun']);
    $routes->get('hakim', [Pengaturan::class, 'hakim']);
    $routes->post('modal_jabatan', [Pengaturan::class, 'modal_jabatan']);
    $routes->post('insert_hakim/(:any)', [Pengaturan::class, 'insert_hakim']);
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
    $routes->get('register', [Auth::class, 'register']);
    $routes->post('attempt_register', [Auth::class, 'attempt_register']);
    $routes->get('logout', [Auth::class, 'logout']);
});

$routes->group('panitera', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('daftar_pp_perdata', [Panitera::class, 'daftar_pp_perdata']);
    $routes->get('daftar_pp_pidana', [Panitera::class, 'daftar_pp_pidana']);
    $routes->get('daftar_js_perdata', [Panitera::class, 'daftar_js_perdata']);
    $routes->get('daftar_js_pidana', [Panitera::class, 'daftar_js_pidana']);
    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('hakim', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('daftar_hakim_perdata', [Hakim::class, 'daftar_hakim_perdata']);
    $routes->get('daftar_hakim_pidana', [Hakim::class, 'daftar_hakim_pidana']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('hawasbid', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan/(:any)', [Hawasbid::class, 'data_laporan']);
    $routes->post('data_hawasbid_datatable/(:any)', [Hawasbid::class, 'data_hawasbid_datatable']);
    $routes->get('modal_laporan/(:any)', [Hawasbid::class, 'modal_laporan']);
    $routes->post('modal_laporan/(:any)', [Hawasbid::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Hawasbid::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Hawasbid::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Hawasbid::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('ptsp', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan/(:any)', [Ptsp::class, 'data_laporan']);
    $routes->post('data_ptsp_datatable/(:any)', [Ptsp::class, 'data_ptsp_datatable']);
    $routes->get('modal_laporan/(:any)', [Ptsp::class, 'modal_laporan']);
    $routes->post('modal_laporan/(:any)', [Ptsp::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Ptsp::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Ptsp::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Ptsp::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('absen_ptsp', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan/(:any)', [AbsenPtsp::class, 'data_laporan']);
    $routes->post('data_absen_ptsp_datatable/(:any)', [AbsenPtsp::class, 'data_absen_ptsp_datatable']);
    $routes->get('modal_laporan/(:any)', [AbsenPtsp::class, 'modal_laporan']);
    $routes->post('modal_laporan/(:any)', [AbsenPtsp::class, 'modal_laporan']);
    $routes->post('insert_laporan', [AbsenPtsp::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [AbsenPtsp::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [AbsenPtsp::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('briefing', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan/(:any)', [Briefing::class, 'data_laporan']);
    $routes->post('data_briefing_datatable/(:any)', [Briefing::class, 'data_briefing_datatable']);
    $routes->get('modal_laporan/(:any)', [Briefing::class, 'modal_laporan']);
    $routes->post('modal_laporan/(:any)', [Briefing::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Briefing::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Briefing::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Briefing::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('standar_pelayanan', static function ($routes) {

    $routes->get('daftar_standar_pelayanan/(:any)', [StandarPelayanan::class, 'daftar_standar_pelayanan']);
    $routes->get('modal_standar_pelayanan', [StandarPelayanan::class, 'modal_standar_pelayanan']);
    $routes->get('modal_standar_pelayanan/(:any)', [StandarPelayanan::class, 'modal_standar_pelayanan']);
    $routes->post('modal_standar_pelayanan/(:any)', [StandarPelayanan::class, 'modal_standar_pelayanan']);
    $routes->post('upload_standar_pelayanan', [StandarPelayanan::class, 'upload_standar_pelayanan']);
    $routes->post('upload_standar_pelayanan/(:any)', [StandarPelayanan::class, 'upload_standar_pelayanan']);
    $routes->get('download/(:any)', [StandarPelayanan::class, 'download']);
    $routes->post('hapus_standar_pelayanan', [StandarPelayanan::class, 'hapus_standar_pelayanan']);
    $routes->get('modal_import/(:any)', [StandarPelayanan::class, 'modal_import']);
    $routes->post('import_excel', [StandarPelayanan::class, 'import_excel']);
});

$routes->group('pengadilantinggi', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan', [Pengadilantinggi::class, 'data_laporan']);
    $routes->post('data_pengadilantinggi_datatable/(:any)', [Pengadilantinggi::class, 'data_pengadilantinggi_datatable']);
    $routes->get('modal_laporan', [Pengadilantinggi::class, 'modal_laporan']);
    $routes->post('modal_laporan', [Pengadilantinggi::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Pengadilantinggi::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Pengadilantinggi::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Pengadilantinggi::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});
$routes->group('bawas', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan', [Bawas::class, 'data_laporan']);
    $routes->post('data_bawas_datatable/(:any)', [Bawas::class, 'data_bawas_datatable']);
    $routes->get('modal_laporan', [Bawas::class, 'modal_laporan']);
    $routes->post('modal_laporan', [Bawas::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Bawas::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Bawas::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Bawas::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('bpk', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan', [Bpk::class, 'data_laporan']);
    $routes->post('data_bpk_datatable/(:any)', [Bpk::class, 'data_bpk_datatable']);
    $routes->get('modal_laporan', [Bpk::class, 'modal_laporan']);
    $routes->post('modal_laporan', [Bpk::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Bpk::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Bpk::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Bpk::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('pengawasanlainnya', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_laporan', [Pengawasanlainnya::class, 'data_laporan']);
    $routes->post('data_pengawasanlainnya_datatable/(:any)', [Pengawasanlainnya::class, 'data_pengawasanlainnya_datatable']);
    $routes->get('modal_laporan', [Pengawasanlainnya::class, 'modal_laporan']);
    $routes->post('modal_laporan', [Pengawasanlainnya::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Pengawasanlainnya::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Pengawasanlainnya::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Pengawasanlainnya::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('rencana_aksi', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_monev/(:any)', [RencanaAksi::class, 'data_monev']);
    $routes->post('data_rencana_aksi_datatable/(:any)', [RencanaAksi::class, 'data_rencana_aksi_datatable']);
    $routes->get('modal_laporan/(:any)', [RencanaAksi::class, 'modal_laporan']);
    $routes->post('modal_laporan/(:any)', [RencanaAksi::class, 'modal_laporan']);
    $routes->post('insert_laporan', [RencanaAksi::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [RencanaAksi::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [RencanaAksi::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('aplikasi', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('/', [Aplikasi::class, 'index']);
    $routes->post('data_aplikasi_datatable', [Aplikasi::class, 'data_aplikasi_datatable']);
    $routes->get('daftar_monev/(:any)', [Aplikasi::class, 'daftar_monev']);
    $routes->post('data_monev_aplikasi_datatable/(:any)', [Aplikasi::class, 'data_monev_aplikasi_datatable']);
    $routes->get('modal_upload/(:any)', [Aplikasi::class, 'modal_upload']);
    $routes->post('modal_upload/(:any)', [Aplikasi::class, 'modal_upload']);
    $routes->get('modal_tambah_aplikasi', [Aplikasi::class, 'modal_tambah_aplikasi']);
    $routes->post('modal_tambah_aplikasi', [Aplikasi::class, 'modal_tambah_aplikasi']);
    $routes->post('insert_laporan', [Aplikasi::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Aplikasi::class, 'insert_laporan']);
    $routes->post('insert_aplikasi', [Aplikasi::class, 'insert_aplikasi']);
    $routes->post('insert_aplikasi/(:any)', [Aplikasi::class, 'insert_aplikasi']);
    $routes->post('hapus_laporan', [Aplikasi::class, 'hapus_laporan']);
    $routes->post('hapus_aplikasi', [Aplikasi::class, 'hapus_aplikasi']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('monevzi', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_monev/(:any)', [Monevzi::class, 'data_monev']);
    $routes->post('data_monevzi_datatable/(:any)', [Monevzi::class, 'data_monevzi_datatable']);
    $routes->get('modal_laporan/(:any)', [Monevzi::class, 'modal_laporan']);
    $routes->post('modal_laporan/(:any)', [Monevzi::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Monevzi::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Monevzi::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Monevzi::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('dokumenzi', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('data_dokumen/(:any)', [Dokumenzi::class, 'data_dokumen']);
    $routes->get('data_dokumen', [Dokumenzi::class, 'data_dokumen']);
    $routes->post('data_dokumenzi_datatable/(:any)', [Dokumenzi::class, 'data_dokumenzi_datatable']);
    $routes->post('data_dokumenzi_datatable', [Dokumenzi::class, 'data_dokumenzi_datatable']);
    $routes->get('modal_laporan/(:any)', [Dokumenzi::class, 'modal_laporan']);
    $routes->get('modal_laporan', [Dokumenzi::class, 'modal_laporan']);
    $routes->post('modal_laporan/(:any)', [Dokumenzi::class, 'modal_laporan']);
    $routes->post('modal_laporan', [Dokumenzi::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Dokumenzi::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Dokumenzi::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Dokumenzi::class, 'hapus_laporan']);
    $routes->get('import_file', [Dokumenzi::class, 'import_file']);
    $routes->post('import_file_db', [Dokumenzi::class, 'import_file_db']);
    $routes->get('data_area/(:any)', [Dokumenzi::class, 'data_area']);
    $routes->post('modal_upload/(:any)', [Dokumenzi::class, 'modal_upload']);
    $routes->post('insert_file', [Dokumenzi::class, 'insert_file']);
    $routes->post('modal_file/(:any)', [Dokumenzi::class, 'modal_file']);
    $routes->get('data_reform/(:any)', [Dokumenzi::class, 'data_reform']);
    $routes->post('modal_upload_reform/(:any)', [Dokumenzi::class, 'modal_upload_reform']);
    $routes->post('insert_file_reform', [Dokumenzi::class, 'insert_file_reform']);
    $routes->post('modal_file_reform/(:any)', [Dokumenzi::class, 'modal_file_reform']);
    $routes->post('delete_file', [Dokumenzi::class, 'delete_file']);
    $routes->post('delete_file_reform', [Dokumenzi::class, 'delete_file_reform']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('dokumenrapat', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('daftar_dokumen', [Dokumenrapat::class, 'daftar_dokumen']);
    $routes->post('data_dokumenrapat_datatable/(:any)', [Dokumenrapat::class, 'data_dokumenrapat_datatable']);
    $routes->get('modal_laporan', [Dokumenrapat::class, 'modal_laporan']);
    $routes->post('modal_laporan', [Dokumenrapat::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Dokumenrapat::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Dokumenrapat::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Dokumenrapat::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('agenperubahan', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('daftar_dokumen', [Agenperubahan::class, 'daftar_dokumen']);
    $routes->post('data_dokumen_datatable/(:any)', [Agenperubahan::class, 'data_dokumen_datatable']);
    $routes->get('modal_laporan', [Agenperubahan::class, 'modal_laporan']);
    $routes->post('modal_laporan', [Agenperubahan::class, 'modal_laporan']);
    $routes->post('insert_laporan', [Agenperubahan::class, 'insert_laporan']);
    $routes->post('insert_laporan/(:any)', [Agenperubahan::class, 'insert_laporan']);
    $routes->post('hapus_laporan', [Agenperubahan::class, 'hapus_laporan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('video', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('/', [Video::class, 'index']);
    $routes->post('data_datatable', [Video::class, 'data_datatable']);
    $routes->get('modal_tambah', [Video::class, 'modal_tambah']);
    $routes->post('modal_tambah', [Video::class, 'modal_tambah']);
    $routes->post('insert', [Video::class, 'insert']);
    $routes->post('insert/(:any)', [Video::class, 'insert']);
    $routes->post('hapus', [Video::class, 'hapus']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('audio', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('/', [Audio::class, 'index']);
    $routes->post('data_datatable', [Audio::class, 'data_datatable']);
    $routes->get('modal_tambah', [Audio::class, 'modal_tambah']);
    $routes->post('modal_tambah', [Audio::class, 'modal_tambah']);
    $routes->post('insert', [Audio::class, 'insert']);
    $routes->post('insert/(:any)', [Audio::class, 'insert']);
    $routes->post('hapus', [Audio::class, 'hapus']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('mou', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('/', [Mou::class, 'index']);
    $routes->post('data_datatable', [Mou::class, 'data_datatable']);
    $routes->get('modal_tambah', [Mou::class, 'modal_tambah']);
    $routes->post('modal_tambah', [Mou::class, 'modal_tambah']);
    $routes->post('insert', [Mou::class, 'insert']);
    $routes->post('insert/(:any)', [Mou::class, 'insert']);
    $routes->post('hapus', [Mou::class, 'hapus']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('doklainnya', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('daftar/(:any)', [Doklainnya::class, 'daftar']);
    $routes->post('data_datatable/(:any)', [Doklainnya::class, 'data_datatable']);
    $routes->get('modal_tambah/(:any)', [Doklainnya::class, 'modal_tambah']);
    $routes->post('modal_tambah/(:any)', [Doklainnya::class, 'modal_tambah']);
    $routes->post('insert', [Doklainnya::class, 'insert']);
    $routes->post('insert/(:any)', [Doklainnya::class, 'insert']);
    $routes->post('hapus', [Doklainnya::class, 'hapus']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('dokprivate', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('daftar/(:any)', [Dokprivate::class, 'daftar']);
    $routes->post('data_datatable/(:any)', [Dokprivate::class, 'data_datatable']);
    $routes->get('modal_tambah/(:any)', [Dokprivate::class, 'modal_tambah']);
    $routes->post('modal_tambah/(:any)', [Dokprivate::class, 'modal_tambah']);
    $routes->post('insert', [Dokprivate::class, 'insert']);
    $routes->post('insert/(:any)', [Dokprivate::class, 'insert']);
    $routes->post('hapus', [Dokprivate::class, 'hapus']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('ziarticle', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('/', [Ziarticle::class, 'index']);
    $routes->post('data_datatable', [Ziarticle::class, 'data_datatable']);
    $routes->get('modal_tambah', [Ziarticle::class, 'modal_tambah']);
    $routes->post('modal_tambah', [Ziarticle::class, 'modal_tambah']);
    $routes->post('insert', [Ziarticle::class, 'insert']);
    $routes->post('insert/(:any)', [Ziarticle::class, 'insert']);
    $routes->post('hapus', [Ziarticle::class, 'hapus']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('putusanpidana', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('daftar_dokumen', [Putusanpidana::class, 'daftar_dokumen']);
    $routes->post('data_dokumen_datatable', [Putusanpidana::class, 'data_dokumen_datatable']);
    $routes->get('modal_upload', [Putusanpidana::class, 'modal_upload']);
    $routes->post('modal_upload', [Putusanpidana::class, 'modal_upload']);
    $routes->post('insert_putusan', [Putusanpidana::class, 'insert_putusan']);
    $routes->post('insert_putusan/(:any)', [Putusanpidana::class, 'insert_putusan']);
    $routes->post('hapus_putusan', [Putusanpidana::class, 'hapus_putusan']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('shanti_care', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('keluhan', [ShantiCare::class, 'keluhan']);
    $routes->post('keluhan_datatable', [ShantiCare::class, 'keluhan_datatable']);
    $routes->post('modal_response', [ShantiCare::class, 'modal_response']);
    $routes->post('insert_response', [ShantiCare::class, 'insert_response']);
    $routes->get('saran/(:any)', [ShantiCare::class, 'saran']);
    $routes->post('saran_datatable/(:any)', [ShantiCare::class, 'saran_datatable']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('review', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('referensi', [Review::class, 'referensi']);
    $routes->post('referensi_datatable', [Review::class, 'referensi_datatable']);
    $routes->get('modal_referensi', [Review::class, 'modal_referensi']);
    $routes->post('insert_referensi', [Review::class, 'insert_referensi']);
    $routes->get('list', [Review::class, 'list']);
    $routes->post('review_datatable', [Review::class, 'review_datatable']);
    $routes->get('modal_laporan', [Review::class, 'modal_laporan']);
    $routes->post('cetak_laporan', [Review::class, 'cetak_laporan']);



    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('shanti_care', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('keluhan', [ShantiCare::class, 'keluhan']);
    $routes->post('keluhan_datatable', [ShantiCare::class, 'keluhan_datatable']);
    $routes->post('modal_response', [ShantiCare::class, 'modal_response']);
    $routes->post('insert_response', [ShantiCare::class, 'insert_response']);
    $routes->get('saran/(:any)', [ShantiCare::class, 'saran']);
    $routes->post('saran_datatable/(:any)', [ShantiCare::class, 'saran_datatable']);

    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('review', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('referensi', [Review::class, 'referensi']);
    $routes->post('referensi_datatable', [Review::class, 'referensi_datatable']);
    $routes->get('modal_referensi', [Review::class, 'modal_referensi']);
    $routes->post('modal_referensi/(:any)', [Review::class, 'modal_referensi']);
    $routes->post('insert_referensi', [Review::class, 'insert_referensi']);
    $routes->post('insert_referensi/(:any)', [Review::class, 'insert_referensi']);
    $routes->get('list', [Review::class, 'list']);
    $routes->post('review_datatable', [Review::class, 'review_datatable']);
    $routes->get('modal_laporan', [Review::class, 'modal_laporan']);
    $routes->post('cetak_laporan', [Review::class, 'cetak_laporan']);



    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->group('sbk', static function ($routes) {

    // $routes->get('', [Panitera::class, 'index']);
    $routes->get('/', [Sbk::class, 'daftar']);
    $routes->post('sbk_datatable', [Sbk::class, 'sbk_datatable']);
    $routes->get('modal_laporan', [Sbk::class, 'modal_laporan']);
    $routes->post('cetak_laporan', [Sbk::class, 'cetak_laporan']);



    // $routes->get('logout', [Panitera::class, 'logout']);
});

$routes->post('apiakreditasi/create_internal', 'Apiakreditasi::create_internal');
$routes->post('apiakreditasi/delete_file', 'Apiakreditasi::delete_file');
$routes->post('apiakreditasi/create_eksternal', 'Apiakreditasi::create_eksternal');
$routes->post('apiakreditasi/insert_checklist', 'Apiakreditasi::insert_checklist');

$routes->resource('apiakreditasi');
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
