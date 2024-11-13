<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Hakim extends BaseController
{
    public function index()
    {
        //
    }


    public function daftar_hakim_perdata()
    {
        $perkara_hakim = db_connect('sipp')->table('hakim_pn a')->join('amora.jabatan b', 'a.id=b.jabatan_hakim_id')->where('aktif', 'Y')->orderBy('b.urutan')->get()->getResultArray();
        $data_perkara = [];
        foreach ($perkara_hakim as $p) {
            $jml_perkara_cerai_aktif = db_connect('sipp')->table('perkara_hakim_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('jenis_perkara_id', 64)->countAllResults();
            $jml_perkara_non_cerai_aktif = db_connect('sipp')->table('perkara_hakim_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->where('jenis_perkara_id !=', 64)->countAllResults();

            $perkara_gugatan = db_connect('sipp')->table('perkara_hakim_pn')->join('perkara', 'perkara_hakim_pn.perkara_id=perkara.perkara_id')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 7)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_perkara[$p['nama_gelar']] = ['jml_perkara_cerai' => $jml_perkara_cerai_aktif, 'jml_perkara_non_cerai' => $jml_perkara_non_cerai_aktif, 'gugatan' => $perkara_gugatan, 'hakim_id' => $p['id']];
        }

        $data_permohonan = [];
        foreach ($perkara_hakim as $p) {
            $jml_perkara_aktif = db_connect('sipp')->table('perkara_hakim_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 2)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_permohonan = db_connect('sipp')->table('perkara_hakim_pn')->join('perkara', 'perkara_hakim_pn.perkara_id=perkara.perkara_id')->groupStart()->where('alur_perkara_id', 2)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_permohonan[$p['nama_gelar']] = ['jml_permohonan' => $jml_perkara_aktif, 'permohonan' => $perkara_permohonan, 'hakim_id' => $p['id']];
        }

        $data_gs = [];
        foreach ($perkara_hakim as $p) {
            $jml_perkara_aktif = db_connect('sipp')->table('perkara_hakim_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 8)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_gs = db_connect('sipp')->table('perkara_hakim_pn')->join('perkara', 'perkara_hakim_pn.perkara_id=perkara.perkara_id')->groupStart()->where('alur_perkara_id', 8)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_gs[$p['nama_gelar']] = ['jml_gs' => $jml_perkara_aktif, 'gs' => $perkara_gs, 'hakim_id' => $p['id']];
        }


        return view('hakim/daftar_hakim', ['data' => $data_perkara, 'data_permohonan' => $data_permohonan, 'data_gs' => $data_gs]);
    }

    public function daftar_hakim_pidana()
    {
        $perkara_hakim = db_connect('sipp')->table('hakim_pn a')->join('amora.jabatan b', 'a.id=b.jabatan_hakim_id')->where('aktif', 'Y')->orderBy('b.urutan')->get()->getResultArray();
        $data_perkara = [];
        foreach ($perkara_hakim as $p) {
            $jml_perkara_aktif = db_connect('sipp')->table('perkara_hakim_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_pidana = db_connect('sipp')->table('perkara_hakim_pn')->join('perkara', 'perkara_hakim_pn.perkara_id=perkara.perkara_id')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_perkara[$p['nama_gelar']] = ['jml_perkara' => $jml_perkara_aktif, 'pidana' => $perkara_pidana, 'hakim_id' => $p['id']];
        }

        $data_cepat = [];
        foreach ($perkara_hakim as $p) {
            $jml_perkara_aktif = db_connect('sipp')->table('perkara_hakim_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 113)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_cepat = db_connect('sipp')->table('perkara_hakim_pn')->join('perkara', 'perkara_hakim_pn.perkara_id=perkara.perkara_id')->groupStart()->where('alur_perkara_id', 113)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_cepat[$p['nama_gelar']] = ['jml_cepat' => $jml_perkara_aktif, 'cepat' => $perkara_cepat, 'hakim_id' => $p['id']];
        }

        $data_anak = [];
        foreach ($perkara_hakim as $p) {
            $jml_perkara_aktif = db_connect('sipp')->table('perkara_hakim_pn a')->join('perkara b', 'a.perkara_id=b.perkara_id', 'left')->join('perkara_putusan c', 'a.perkara_id=c.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 118)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_minutasi', null)->where('aktif', 'Y')->countAllResults();

            $perkara_anak = db_connect('sipp')->table('perkara_hakim_pn')->join('perkara', 'perkara_hakim_pn.perkara_id=perkara.perkara_id')->groupStart()->where('alur_perkara_id', 118)->groupEnd()->where('hakim_id', $p['id'])->where('tanggal_pendaftaran >', '2022-11-25')->limit(5)->orderBy('tanggal_pendaftaran', 'desc')->get()->getResultArray();


            $data_anak[$p['nama_gelar']] = ['jml_anak' => $jml_perkara_aktif, 'anak' => $perkara_anak, 'hakim_id' => $p['id']];
        }


        return view('hakim/daftar_hakim_pidana', ['data' => $data_perkara, 'data_cepat' => $data_cepat, 'data_anak' => $data_anak]);
    }
}
