<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Panitera extends BaseController
{
    public function index()
    {
        $perkara_belum_selesai = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
        $perkara_selesai = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('tanggal_minutasi !=', null)->where('aktif', 'Y')->countAllResults();
        $perkara_total = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('aktif', 'Y')->countAllResults();

        return view('panitera/dashboard', ['perkara_belum_selesai' => $perkara_belum_selesai, 'perkara_selesai' => $perkara_selesai, 'perkara_total' => $perkara_total]);
    }

    public function daftar_pp_perdata()
    {
        $perkara_panitera = db_connect('sipp')->table('panitera_pn')->where('aktif', 'Y')->get()->getResultArray();
        $data_perkara = [];
        foreach ($perkara_panitera as $p) {
            // $jml_cerai_aktif = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('jenis_perkara_id', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            $jml_cerai_aktif_mh1 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('jenis_perkara_id', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id', '33,27,30')->countAllResults();
            $jml_cerai_aktif_mh2 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('jenis_perkara_id', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id', '38,28,31')->countAllResults();
            $jml_cerai_aktif_mh3 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('jenis_perkara_id', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id !=', '33,27,30')->where('majelis_hakim_id !=', '38,28,31')->countAllResults();

            // $jml_non_cerai_aktif = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->orWhere('alur_perkara_id', 8)->groupEnd()->where('jenis_perkara_id !=', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            // $jml_non_cerai_aktif = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->orWhere('alur_perkara_id', 8)->groupEnd()->where('jenis_perkara_id !=', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            $jml_non_cerai_aktif_mh1 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->orWhere('alur_perkara_id', 8)->groupEnd()->where('jenis_perkara_id !=', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id', '33,27,30')->countAllResults();
            $jml_non_cerai_aktif_mh2 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->orWhere('alur_perkara_id', 8)->groupEnd()->where('jenis_perkara_id !=', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id', '38,28,31')->countAllResults();
            $jml_non_cerai_aktif_mh3 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->orWhere('alur_perkara_id', 8)->groupEnd()->where('jenis_perkara_id !=', 64)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id !=', '33,27,30')->where('majelis_hakim_id !=', '38,28,31')->countAllResults();

            $perkara_gugatan = db_connect('sipp')->table('v_perkara_detil')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->groupEnd()->where('panitera_pengganti_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();

            $data_perkara[$p['nama_gelar']] = ['jml_cerai_mh1' => $jml_cerai_aktif_mh1, 'jml_cerai_mh2' => $jml_cerai_aktif_mh2, 'jml_cerai_mh3' => $jml_cerai_aktif_mh3, 'jml_non_cerai_mh1' => $jml_non_cerai_aktif_mh1, 'jml_non_cerai_mh2' => $jml_non_cerai_aktif_mh2, 'jml_non_cerai_mh3' => $jml_non_cerai_aktif_mh3, 'gugatan' => $perkara_gugatan, 'panitera_id' => $p['id']];
        }

        // dd($data_perkara);

        $data_gs = [];
        foreach ($perkara_panitera as $p) {
            $jml_gs_aktif = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->where('alur_perkara_id', 8)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_gs = db_connect('sipp')->table('v_perkara_detil')->groupStart()->where('alur_perkara_id', 8)->groupEnd()->where('panitera_pengganti_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_gs[$p['nama_gelar']] = ['jml_gs' => $jml_gs_aktif, 'gs' => $perkara_gs, 'panitera_id' => $p['id']];
        }

        $data_permohonan = [];
        foreach ($perkara_panitera as $p) {
            $jml_permohonan_aktif = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->where('alur_perkara_id', 2)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_permohonan = db_connect('sipp')->table('v_perkara_detil')->groupStart()->where('alur_perkara_id', 2)->groupEnd()->where('panitera_pengganti_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_permohonan[$p['nama_gelar']] = ['jml_permohonan' => $jml_permohonan_aktif, 'permohonan' => $perkara_permohonan, 'panitera_id' => $p['id']];
        }
        // dd($data_perkara);
        return view('panitera/daftar_pp', ['data' => $data_perkara, 'data_permohonan' => $data_permohonan, 'data_gs' => $data_gs]);
    }

    public function daftar_pp_pidana()
    {
        $perkara_panitera = db_connect('sipp')->table('panitera_pn')->where('aktif', 'Y')->get()->getResultArray();
        $data_perkara = [];
        foreach ($perkara_panitera as $p) {
            $jml_pidana_aktif_mh1 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 118)->groupEnd()->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id', '33,27,30')->countAllResults();
            $jml_pidana_aktif_mh2 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 118)->groupEnd()->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id', '38,28,31')->countAllResults();
            $jml_pidana_aktif_mh3 = db_connect('sipp')->table('perkara_panitera_pn a')->join('v_perkara_detil b', 'a.perkara_id=b.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 118)->groupEnd()->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('majelis_hakim_id !=', '33,27,30')->where('majelis_hakim_id !=', '38,28,31')->countAllResults();

            $perkara_pidana = db_connect('sipp')->table('v_perkara_detil')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 118)->groupEnd()->where('panitera_pengganti_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();

            $data_perkara[$p['nama_gelar']] = ['jml_pidana_mh1' => $jml_pidana_aktif_mh1, 'jml_pidana_mh2' => $jml_pidana_aktif_mh2, 'jml_pidana_mh3' => $jml_pidana_aktif_mh3, 'pidana' => $perkara_pidana, 'panitera_id' => $p['id']];
        }

        $data_cepat = [];
        foreach ($perkara_panitera as $p) {
            $jml_cepat_aktif = db_connect('sipp')->table('perkara_panitera_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->where('alur_perkara_id', 113)->where('panitera_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_cepat = db_connect('sipp')->table('v_perkara_detil')->groupStart()->where('alur_perkara_id', 113)->groupEnd()->where('panitera_pengganti_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_cepat[$p['nama_gelar']] = ['jml_cepat' => $jml_cepat_aktif, 'cepat' => $perkara_cepat, 'panitera_id' => $p['id']];
        }

        // dd($data_perkara);
        return view('panitera/daftar_pp_pidana', ['data' => $data_perkara, 'data_cepat' => $data_cepat]);
    }

    public function daftar_js_perdata()
    {
        $perkara_jurusita = db_connect('sipp')->table('jurusita')->where('aktif', 'Y')->get()->getResultArray();

        $data_perkara = [];
        foreach ($perkara_jurusita as $p) {

            $perkara_perdata_aktif = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->groupEnd()->where('jurusita_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            $perkara_gugatan = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->groupEnd()->where('jurusita_id', $p['id'])->where('aktif', 'Y')->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();

            $perkara_gs_aktif = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 8)->groupEnd()->where('jurusita_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            $perkara_gs = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 8)->groupEnd()->where('jurusita_id', $p['id'])->where('aktif', 'Y')->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();

            $perkara_permohonan_aktif = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 2)->groupEnd()->where('jurusita_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            $perkara_permohonan = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 2)->groupEnd()->where('jurusita_id', $p['id'])->where('aktif', 'Y')->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();



            $perkara_delegasi = db_connect('sipp')->table('delegasi_proses_masuk')->where('jurusita_id', $p['id'])->countAllResults();


            $data_perkara[$p['nama_gelar']] = ['jml_perdata' => $perkara_perdata_aktif, 'gugatan' => $perkara_gugatan, 'jml_gs' => $perkara_gs_aktif, 'data_gs' => $perkara_gs, 'jml_permohonan' => $perkara_permohonan_aktif, 'data_permohonan' => $perkara_permohonan, 'jumlah_delegasi' => $perkara_delegasi, 'js_id' => $p['id']];
        }

        return view('panitera/daftar_js', ['data' => $data_perkara]);
    }

    public function daftar_js_pidana()
    {
        $perkara_jurusita = db_connect('sipp')->table('jurusita')->where('aktif', 'Y')->get()->getResultArray();

        $data_perkara = [];
        foreach ($perkara_jurusita as $p) {

            $perkara_pidana_aktif = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 118)->groupEnd()->where('jurusita_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            $perkara_pidana = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 118)->groupEnd()->where('jurusita_id', $p['id'])->where('aktif', 'Y')->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->get()->getResultArray();

            $perkara_cepat_aktif = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 113)->groupEnd()->where('jurusita_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();
            $perkara_cepat = db_connect('sipp')->table('perkara_jurusita a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 113)->groupEnd()->where('jurusita_id', $p['id'])->where('aktif', 'Y')->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->get()->getResultArray();


            $data_perkara[$p['nama_gelar']] = ['jml_pidana' => $perkara_pidana_aktif, 'pidana' => $perkara_pidana, 'jml_cepat' => $perkara_cepat_aktif, 'data_cepat' => $perkara_cepat, 'js_id' => $p['id']];
        }

        return view('panitera/daftar_js_pidana', ['data' => $data_perkara]);
    }
}
