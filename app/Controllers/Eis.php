<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class Eis extends BaseController
{
    public function index()
    {
        //
    }

    public function daftar_eis()
    {
        $tahun = [];
        $tahun_sekarang = date('Y');
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_sekarang - $i;
        }

        return view('eis/daftar_eis', ['tahun' => $tahun]);
    }

    public function daftar_eis_ajax()
    {
        helper('idndate_helper');
        $bulan = $this->request->getVar('bulan');
        // $bulan = 11;
        $tahun = $this->request->getVar('tahun');
        // $tahun = 2022;


        //KINERJA

        $sisa_tahun_lalu = db_connect('sipp')->query('SELECT COUNT(perkara.perkara_id) as jumlah_sisa FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id WHERE alur_perkara_id != 114 and YEAR(tanggal_pendaftaran) < YEAR(CURDATE()) AND (tanggal_putusan IS NULL OR YEAR(tanggal_putusan) = YEAR(CURDATE()))')->getRowArray()['jumlah_sisa'];
        $masuk_tahun_ini = db_connect('sipp')->query('SELECT COUNT(perkara.perkara_id) as jumlah_masuk FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id WHERE alur_perkara_id != 114 and YEAR(tanggal_pendaftaran) = YEAR(CURDATE())')->getRowArray()['jumlah_masuk'];
        $putus_tahun_ini = db_connect('sipp')->query('SELECT COUNT(perkara.perkara_id) as jumlah_putus FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id = perkara_putusan.perkara_id WHERE alur_perkara_id != 114 AND YEAR(tanggal_putusan) = YEAR(CURDATE()) AND tanggal_putusan IS NOT NULL')->getRowArray()['jumlah_putus'];
        // dd($putus_tahun_ini);
        $data_rasio = ((int)$putus_tahun_ini / ((int)$sisa_tahun_lalu + (int)$masuk_tahun_ini)) * 100;
        $data_rasio = number_format($data_rasio, 2, ',', '.');


        $pelaksanaan_delegasi = db_connect('sipp')->table('delegasi_masuk a')->select('a.pn_asal_text, DATE_FORMAT(tgl_delegasi, "%d-%m-%Y") as tanggal_delegasi, DATE_FORMAT(tgl_relaas, "%d-%m-%Y") as pelaksanaan_delegasi, DATEDIFF(tgl_relaas,tgl_delegasi) as diff')->join('delegasi_proses_masuk b', 'a.id=b.delegasi_id')->where('DATEDIFF(tgl_relaas,tgl_delegasi)>7')->where('MONTH(tgl_relaas)', $bulan)->where('YEAR(tgl_relaas)', $tahun)->get()->getResultArray();

        $data_kinerja = ['data_rasio' => $data_rasio, 'pelaksanaan_delegasi' => $pelaksanaan_delegasi];


        // KEPATUHAN
        $data_kepatuhan = [];
        $pendaftaran_perkara = db_connect('sipp')->table('perkara')->select('nomor_perkara, DATE_FORMAT(tanggal_pendaftaran, "%d-%m-%Y") as tanggal_pendaftaran, DATE_FORMAT(DATE(diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->where('DATE(diinput_tanggal)>tanggal_pendaftaran')->where('alur_perkara_id !=', 114)->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();

        $data_kepatuhan['pendaftaran_perkara'] = $pendaftaran_perkara;

        $barang_bukti = db_connect('sipp')->table('perkara')->select('perkara.nomor_perkara, DATE_FORMAT(tanggal_pendaftaran, "%d-%m-%Y") as tanggal_pendaftaran, jenis_barang_bukti')->join('perkara_barang_bukti', 'perkara.perkara_id=perkara_barang_bukti.perkara_id', 'left')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 118)->groupEnd()->where('jenis_barang_bukti', null)->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();
        $data_kepatuhan['barang_bukti'] = $barang_bukti;

        // $data_contoh = db_connect('sipp')->table('perkara_hakim_pn')->selectMin('tanggal_penetapan')->where('perkara_id=79608')->get()->getResultArray();
        $penetapan_majelis_hakim = db_connect('sipp')->table('perkara a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal_pendaftaran, "%d-%m-%Y") as tanggal_pendaftaran, DATE_FORMAT(DATE(penetapan_majelis_hakim),"%d-%m-%Y") as penetapan_majelis_hakim')->selectSubquery(db_connect('sipp')->table('perkara_hakim_pn b')->selectMin('tanggal_penetapan')->where('b.perkara_id=a.perkara_id'), 'tanggal_penetapan_hakim')->join('perkara_penetapan c', 'c.perkara_id=a.perkara_id', 'left')->where('alur_perkara_id!=', 114)->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();
        $data_pen_hakim = [];
        foreach ($penetapan_majelis_hakim as $ph) {
            $t1 = Time::parse($ph['tanggal_pendaftaran']);
            $t2 = Time::parse($ph['tanggal_penetapan_hakim']);
            $tanggal_pen_fix = idndate($ph['tanggal_penetapan_hakim'])['tanggal_reverse'];
            $diff = $t1->difference($t2);
            // $data_pen_hakim[] = $diff->getDays();
            // $data_pen_hakim[] = (int) $diff->getDays();
            if ((int)$diff->getDays() > 3) {
                $data_pen_hakim[] = ['nomor_perkara' => $ph['nomor_perkara'], 'tanggal_pendaftaran' => $ph['tanggal_pendaftaran'], 'tanggal_penetapan' => $tanggal_pen_fix];
            }
        }
        $data_kepatuhan['penetapan_majelis_hakim'] = $data_pen_hakim;

        $penetapan_pp = db_connect('sipp')->table('perkara a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal_pendaftaran, "%d-%m-%Y") as tanggal_pendaftaran')->selectSubquery(db_connect('sipp')->table('perkara_panitera_pn b')->selectMin('tanggal_penetapan')->where('b.perkara_id=a.perkara_id'), 'tanggal_penetapan_pp')->where('alur_perkara_id!=', 114)->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();
        // dd($penetapan_pp);
        $data_pen_pp = [];
        foreach ($penetapan_pp as $pp) {
            $t1 = Time::parse($pp['tanggal_pendaftaran']);
            $t2 = Time::parse($pp['tanggal_penetapan_pp']);
            $tanggal_pen_fix = idndate($pp['tanggal_penetapan_pp'])['tanggal_reverse'];
            $diff = $t1->difference($t2);
            // $data_pen_pp[] = $diff->getDays();
            // $data_pen_pp[] = (int) $diff->getDays();
            if ((int)$diff->getDays() > 3) {
                $data_pen_pp[] = ['nomor_perkara' => $pp['nomor_perkara'], 'tanggal_pendaftaran' => $pp['tanggal_pendaftaran'], 'tanggal_penetapan' => $tanggal_pen_fix];
            }
        }
        $data_kepatuhan['penetapan_pp'] = $data_pen_pp;

        $penetapan_js = db_connect('sipp')->table('perkara a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal_pendaftaran, "%d-%m-%Y") as tanggal_pendaftaran')->selectSubquery(db_connect('sipp')->table('perkara_jurusita b')->selectMin('tanggal_penetapan')->where('b.perkara_id=a.perkara_id'), 'tanggal_penetapan_js')->where('alur_perkara_id!=', 114)->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();
        // dd($penetapan_pp);
        $data_pen_js = [];
        foreach ($penetapan_js as $js) {
            $t1 = Time::parse($js['tanggal_pendaftaran']);
            $t2 = Time::parse($js['tanggal_penetapan_js']);
            $tanggal_pen_fix = idndate($js['tanggal_penetapan_js'])['tanggal_reverse'];
            $diff = $t1->difference($t2);
            // $data_pen_pp[] = $diff->getDays();
            // $data_pen_pp[] = (int) $diff->getDays();
            if ((int)$diff->getDays() > 3) {
                $data_pen_js[] = ['nomor_perkara' => $js['nomor_perkara'], 'tanggal_pendaftaran' => $js['tanggal_pendaftaran'], 'tanggal_penetapan' => $tanggal_pen_fix];
            }
        }
        $data_kepatuhan['penetapan_js'] = $data_pen_js;


        $penetapan_hari_sidang = db_connect('sipp')->table('perkara a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal_pendaftaran, "%d-%m-%Y") as tanggal_pendaftaran')->selectSubquery(db_connect('sipp')->table('perkara_penetapan_hari_sidang b')->selectMin('tanggal_penetapan')->where('b.perkara_id=a.perkara_id'), 'tanggal_penetapan_hari_sidang')->where('alur_perkara_id!=', 114)->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();

        $data_pen_hs = [];
        foreach ($penetapan_hari_sidang as $hs) {

            $t1 = Time::parse($hs['tanggal_pendaftaran']);
            $t2 = ($hs['tanggal_penetapan_hari_sidang']) ? Time::parse($hs['tanggal_penetapan_hari_sidang']) : $t1;
            $tanggal_pen_fix = ($hs['tanggal_penetapan_hari_sidang']) ? idndate($hs['tanggal_penetapan_hari_sidang'])['tanggal_reverse'] : idndate($hs['tanggal_pendaftaran'])['tanggal_reverse'];
            $diff = $t1->difference($t2);
            // $data_pen_pp[] = $diff->getDays();
            // $data_pen_pp[] = (int) $diff->getDays();
            if ((int)$diff->getDays() > 3) {
                $data_pen_hs[] = ['nomor_perkara' => $hs['nomor_perkara'], 'tanggal_pendaftaran' => $hs['tanggal_pendaftaran'], 'tanggal_penetapan' => $tanggal_pen_fix];
            }
        }
        $data_kepatuhan['penetapan_hari_sidang'] = $data_pen_hs;
        // dd($data_kepatuhan['penetapan_hari_sidang']);

        $perkara_penuntutan = db_connect('sipp')->table('perkara')->select('nomor_perkara, DATE_FORMAT(tanggal_penuntutan, "%d-%m-%Y") as tanggal_penuntutan, DATE_FORMAT(DATE(perkara_penuntutan.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara_penuntutan', 'perkara.perkara_id=perkara_penuntutan.perkara_id', 'left')->where('DATE(perkara_penuntutan.diinput_tanggal)>tanggal_penuntutan')->where('alur_perkara_id !=', 114)->where('MONTH(tanggal_penuntutan)', $bulan)->where('YEAR(tanggal_penuntutan)', $tahun)->get()->getResultArray();

        $data_kepatuhan['perkara_penuntutan'] = $perkara_penuntutan;

        $penginputan_putusan = db_connect('sipp')->table('perkara_proses')->select('proses_id, nomor_perkara, DATE_FORMAT(tanggal_putusan, "%d-%m-%Y") as tanggal_putusan, DATE_FORMAT(DATE(perkara_proses.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara', 'perkara.perkara_id=perkara_proses.perkara_id', 'left')->join('perkara_putusan', 'perkara_proses.perkara_id=perkara_putusan.perkara_id', 'left')->where('DATE(perkara_proses.diinput_tanggal)>tanggal_putusan')->where('alur_perkara_id !=', 114)->where('MONTH(tanggal_putusan)', $bulan)->where('YEAR(tanggal_putusan)', $tahun)->where('proses_id', 210)->get()->getResultArray();
        $data_kepatuhan['penginputan_putusan'] = $penginputan_putusan;

        $penginputan_minutasi = db_connect('sipp')->table('perkara_proses')->select('proses_id, nomor_perkara, DATE_FORMAT(tanggal_minutasi, "%d-%m-%Y") as tanggal_minutasi, DATE_FORMAT(DATE(perkara_proses.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara', 'perkara.perkara_id=perkara_proses.perkara_id', 'left')->join('perkara_putusan', 'perkara_proses.perkara_id=perkara_putusan.perkara_id', 'left')->where('DATE(perkara_proses.diinput_tanggal)>tanggal_minutasi')->where('alur_perkara_id !=', 114)->where('MONTH(tanggal_minutasi)', $bulan)->where('YEAR(tanggal_minutasi)', $tahun)->where('proses_id', 220)->get()->getResultArray();
        $data_kepatuhan['penginputan_minutasi'] = $penginputan_minutasi;

        $ketepatan_minutasi = db_connect('sipp')->table('perkara')->select('perkara.perkara_id,tanggal_putusan,tanggal_minutasi,alur_perkara_id, nomor_perkara, DATE_FORMAT(tanggal_putusan, "%d-%m-%Y") as tanggal_putusan_reverse, DATE_FORMAT(DATE(tanggal_minutasi),"%d-%m-%Y") as tanggal_minutasi_reverse')->join('perkara_putusan', 'perkara.perkara_id=perkara_putusan.perkara_id', 'left')->where('alur_perkara_id !=', 114)->where('MONTH(tanggal_minutasi)', $bulan)->where('YEAR(tanggal_minutasi)', $tahun)->where('tanggal_minutasi !=', null)->get()->getResultArray();
        $ketepatan_minutasi_array = [];
        foreach ($ketepatan_minutasi as $kt) {
            if ($kt['alur_perkara_id'] == 111 || $kt['alur_perkara_id'] == 112 || $kt['alur_perkara_id'] == 118) {
                $t1 = Time::parse($kt['tanggal_putusan']);
                $t2 = Time::parse($kt['tanggal_minutasi']);
                $diff = $t1->difference($t2);
                if ((int)$diff->getDays() > 7) {
                    $ketepatan_minutasi_array[] = ['nomor_perkara' => $kt['nomor_perkara'], 'tanggal_putusan' => $kt['tanggal_putusan_reverse'], 'tanggal_minutasi' => $kt['tanggal_minutasi_reverse']];
                }
            }

            if ($kt['alur_perkara_id'] == 1 || $kt['alur_perkara_id'] == 2 || $kt['alur_perkara_id'] == 7 || $kt['alur_perkara_id'] == 8) {
                $t1 = Time::parse($kt['tanggal_putusan']);
                $t2 = Time::parse($kt['tanggal_minutasi']);
                $diff = $t1->difference($t2);
                // $ketepatan_minutasi_array[] = $diff->getDays();
                if ((int)$diff->getDays() > 14) {
                    $ketepatan_minutasi_array[] = ['nomor_perkara' => $kt['nomor_perkara'], 'tanggal_putusan' => $kt['tanggal_putusan_reverse'], 'tanggal_minutasi' => $kt['tanggal_minutasi_reverse']];
                }
            }
        }
        $data_kepatuhan['ketepatan_minutasi'] = $ketepatan_minutasi_array;

        $penginputan_banding = db_connect('sipp')->table('perkara_banding')->select('nomor_perkara_pn,DATE_FORMAT(permohonan_banding, "%d-%m-%Y") as permohonan_banding, DATE_FORMAT(DATE(diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->where('DATE(diinput_tanggal)>permohonan_banding')->where('MONTH(permohonan_banding)', $bulan)->where('YEAR(permohonan_banding)', $tahun)->get()->getResultArray();

        $data_kepatuhan['penginputan_banding'] = $penginputan_banding;

        $penginputan_kasasi = db_connect('sipp')->table('perkara_kasasi')->select('nomor_perkara_pn,DATE_FORMAT(permohonan_kasasi, "%d-%m-%Y") as permohonan_kasasi, DATE_FORMAT(DATE(diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->where('DATE(diinput_tanggal)>permohonan_kasasi')->where('MONTH(permohonan_kasasi)', $bulan)->where('YEAR(permohonan_kasasi)', $tahun)->get()->getResultArray();

        $data_kepatuhan['penginputan_kasasi'] = $penginputan_kasasi;

        $penginputan_pk = db_connect('sipp')->table('perkara_pk')->select('nomor_perkara_pn,DATE_FORMAT(permohonan_pk, "%d-%m-%Y") as permohonan_pk, DATE_FORMAT(DATE(diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->where('DATE(diinput_tanggal)>permohonan_pk')->where('MONTH(permohonan_pk)', $bulan)->where('YEAR(permohonan_pk)', $tahun)->get()->getResultArray();

        $data_kepatuhan['penginputan_pk'] = $penginputan_pk;

        $pengiriman_banding = db_connect('sipp')->table('perkara_banding')->select('perkara_id,permohonan_banding,pengiriman_berkas_banding,alur_perkara_id, nomor_perkara_pn, DATE_FORMAT(permohonan_banding, "%d-%m-%Y") as permohonan_banding_reverse, DATE_FORMAT(DATE(pengiriman_berkas_banding),"%d-%m-%Y") as pengiriman_berkas_banding_reverse')->where('MONTH(pengiriman_berkas_banding)', $bulan)->where('YEAR(pengiriman_berkas_banding)', $tahun)->get()->getResultArray();

        $pengiriman_banding_array = [];
        foreach ($pengiriman_banding as $pb) {
            if ($pb['alur_perkara_id'] == 111 || $pb['alur_perkara_id'] == 112 || $pb['alur_perkara_id'] == 118) {
                $t1 = Time::parse($pb['permohonan_banding']);
                $t2 = Time::parse($pb['pengiriman_berkas_banding']);
                $diff = $t1->difference($t2);
                // $pengiriman_banding_array[] = $diff->getDays();
                if ((int)$diff->getDays() > 14) {
                    $pengiriman_banding_array[] = ['nomor_perkara' => $pb['nomor_perkara_pn'], 'permohonan_banding' => $pb['permohonan_banding_reverse'], 'pengiriman_berkas_banding' => $pb['pengiriman_berkas_banding_reverse']];
                }
            }

            if ($pb['alur_perkara_id'] == 1 || $pb['alur_perkara_id'] == 2 || $pb['alur_perkara_id'] == 7 || $pb['alur_perkara_id'] == 8) {
                $t1 = Time::parse($pb['permohonan_banding']);
                $t2 = Time::parse($pb['pengiriman_berkas_banding']);
                $diff = $t1->difference($t2);
                // $pengiriman_banding_array[] = $diff->getDays();
                if ((int)$diff->getDays() > 30) {
                    $pengiriman_banding_array[] = ['nomor_perkara' => $pb['nomor_perkara_pn'], 'permohonan_banding' => $pb['permohonan_banding_reverse'], 'pengiriman_berkas_banding' => $pb['pengiriman_berkas_banding_reverse']];
                }
            }
        }

        $data_kepatuhan['pengiriman_banding'] = $pengiriman_banding_array;

        $pengiriman_kasasi = db_connect('sipp')->table('perkara_kasasi')->select('perkara_id,permohonan_kasasi,pengiriman_berkas_kasasi,alur_perkara_id, nomor_perkara_pn, DATE_FORMAT(permohonan_kasasi, "%d-%m-%Y") as permohonan_kasasi_reverse, DATE_FORMAT(DATE(pengiriman_berkas_kasasi),"%d-%m-%Y") as pengiriman_berkas_kasasi_reverse')->where('MONTH(pengiriman_berkas_kasasi)', $bulan)->where('YEAR(pengiriman_berkas_kasasi)', $tahun)->get()->getResultArray();

        $pengiriman_kasasi_array = [];
        foreach ($pengiriman_kasasi as $pk) {

            $t1 = Time::parse($pk['permohonan_kasasi']);
            $t2 = Time::parse($pk['pengiriman_berkas_kasasi']);
            $diff = $t1->difference($t2);
            // $pengiriman_kasasi_array[] = $diff->getDays();
            if ((int)$diff->getDays() > 65) {
                $pengiriman_kasasi_array[] = ['nomor_perkara' => $pk['nomor_perkara_pn'], 'permohonan_kasasi' => $pk['permohonan_kasasi_reverse'], 'pengiriman_berkas_kasasi' => $pk['pengiriman_berkas_kasasi_reverse']];
            }
        }

        $data_kepatuhan['pengiriman_kasasi'] = $pengiriman_kasasi_array;

        $pengiriman_pk = db_connect('sipp')->table('perkara_pk')->select('perkara_id,permohonan_pk,pengiriman_berkas_pk,alur_perkara_id, nomor_perkara_pn, pemeriksaan_pk, penerimaan_kontra_pk, DATE_FORMAT(permohonan_pk, "%d-%m-%Y") as permohonan_pk_reverse, DATE_FORMAT(DATE(pengiriman_berkas_pk),"%d-%m-%Y") as pengiriman_berkas_pk_reverse')->where('MONTH(pengiriman_berkas_pk)', $bulan)->where('YEAR(pengiriman_berkas_pk)', $tahun)->get()->getResultArray();

        $pengiriman_pk_array = [];
        foreach ($pengiriman_pk as $pkk) {

            if ($pkk['alur_perkara_id'] == 111 || $pkk['alur_perkara_id'] == 112 || $pkk['alur_perkara_id'] == 118) {
                if ($pkk['pemeriksaan_pk']) {

                    $t1 = Time::parse($pkk['pemeriksaan_pk']);
                    $t2 = Time::parse($pkk['pengiriman_berkas_pk']);
                    $diff = $t1->difference($t2);
                    // $pengiriman_pk_array[] = $diff->getDays();
                    if ((int)$diff->getDays() > 30) {
                        $pengiriman_pk_array[] = ['nomor_perkara' => $pkk['nomor_perkara_pn'], 'pemeriksaan_pk' => $pkk['pemeriksaan_pk_reverse'], 'pengiriman_berkas_pk' => $pkk['pengiriman_berkas_pk_reverse']];
                    }
                }
            }

            if ($pkk['alur_perkara_id'] == 1 || $pkk['alur_perkara_id'] == 2 || $pkk['alur_perkara_id'] == 7 || $pkk['alur_perkara_id'] == 8) {
                if ($pkk['penerimaan_kontra_pk']) {
                    $t1 = Time::parse($pkk['penerimaan_kontra_pk']);
                    $t2 = Time::parse($pkk['pengiriman_berkas_pk']);
                    $diff = $t1->difference($t2);
                    // $pengiriman_pk_array[] = $diff->getDays();
                    if ((int)$diff->getDays() > 30) {
                        $pengiriman_pk_array[] = ['nomor_perkara' => $pkk['nomor_perkara_pn'], 'permohonan_pk' => $pkk['permohonan_pk_reverse'], 'pengiriman_berkas_pk' => $pkk['pengiriman_berkas_pk_reverse']];
                    }
                }
                if ($pkk['penerimaan_kontra_pk'] == null || $pkk['penerimaan_kontra_pk'] == "") {

                    $t1 = Time::parse($pkk['permohonan_pk']);
                    $t1 = $t1->addDays(30);
                    $t2 = Time::parse($pkk['pengiriman_berkas_pk']);
                    $diff = $t1->difference($t2);
                    // $pengiriman_pk_array[] = $diff->getDays();
                    if ((int)$diff->getDays() > 30) {
                        $pengiriman_pk_array[] = ['nomor_perkara' => $pkk['nomor_perkara_pn'], 'permohonan_pk' => $pkk['permohonan_pk_reverse'], 'pengiriman_berkas_pk' => $pkk['pengiriman_berkas_pk_reverse']];
                    }
                }
            }
        }

        $data_kepatuhan['pengiriman_pk'] = $pengiriman_pk_array;

        $pemberitahuan_putusan = db_connect('sipp')->table('perkara_proses a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal, "%d-%m-%Y") as pemberitahuan_putusan, DATE_FORMAT(DATE(a.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara b', 'a.perkara_id=b.perkara_id')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->where('DATE(a.diinput_tanggal)>tanggal')->where('alur_perkara_id !=', 114)->where('proses_id', 218)->get()->getResultArray();

        $data_kepatuhan['pemberitahuan_putusan'] = $pemberitahuan_putusan;

        $penginputan_hakim = db_connect('sipp')->table('perkara_proses a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal, "%d-%m-%Y") as penginputan_hakim, DATE_FORMAT(DATE(a.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara b', 'a.perkara_id=b.perkara_id')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->where('DATE(a.diinput_tanggal)>tanggal')->where('alur_perkara_id !=', 114)->groupStart()->where('proses_id', 20)->orWhere('proses_id', 21)->groupEnd()->get()->getResultArray();

        $data_kepatuhan['penginputan_hakim'] = $penginputan_hakim;

        $penginputan_pp = db_connect('sipp')->table('perkara_proses a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal, "%d-%m-%Y") as penginputan_pp, DATE_FORMAT(DATE(a.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara b', 'a.perkara_id=b.perkara_id')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->where('DATE(a.diinput_tanggal)>tanggal')->where('alur_perkara_id !=', 114)->groupStart()->where('proses_id', 30)->orWhere('proses_id', 31)->groupEnd()->get()->getResultArray();

        $data_kepatuhan['penginputan_pp'] = $penginputan_pp;

        $penginputan_hs = db_connect('sipp')->table('perkara_proses a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal, "%d-%m-%Y") as penginputan_js, DATE_FORMAT(DATE(a.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara b', 'a.perkara_id=b.perkara_id')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->where('DATE(a.diinput_tanggal)>tanggal')->where('alur_perkara_id !=', 114)->groupStart()->where('proses_id', 80)->groupEnd()->get()->getResultArray();

        $data_kepatuhan['penginputan_hs'] = $penginputan_hs;

        $penginputan_js = db_connect('sipp')->table('perkara_proses a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(tanggal, "%d-%m-%Y") as penginputan_js, DATE_FORMAT(DATE(a.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara b', 'a.perkara_id=b.perkara_id')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->where('DATE(a.diinput_tanggal)>tanggal')->where('alur_perkara_id !=', 114)->groupStart()->where('proses_id', 40)->orWhere('proses_id', 41)->groupEnd()->get()->getResultArray();

        $data_kepatuhan['penginputan_js'] = $penginputan_js;

        $penginputan_delegasi = db_connect('sipp')->table('delegasi_proses_masuk')->select('pn_asal_text, nomor_relaas, DATE_FORMAT(tgl_relaas, "%d-%m-%Y") as tgl_relaas_reverse, DATE_FORMAT(DATE(diinput_tanggal),"%d-%m-%Y") as diinput_tanggal_reverse')->where('MONTH(tgl_relaas)', $bulan)->where('YEAR(tgl_relaas)', $tahun)->where('DATE(diinput_tanggal)>tgl_relaas')->get()->getResultArray();

        $data_kepatuhan['penginputan_delegasi'] = $penginputan_delegasi;

        $penginputan_jadwal_sidang = db_connect('sipp')->query('SELECT id, s.perkara_id, DATE_FORMAT(tanggal_sidang,"%d-%m-%Y") as tanggal_sidang, nomor_perkara, DATE_FORMAT(DATE(s.diinput_tanggal),"%d-%m-%Y") AS input,
        (SELECT DATE_FORMAT(tanggal_sidang,"%d-%m-%Y") FROM perkara_jadwal_sidang s1
         WHERE s1.id < s.id AND
         s1.perkara_id=s.`perkara_id` ORDER BY id DESC LIMIT 1) AS previous_sidang
 FROM perkara_jadwal_sidang s JOIN perkara a ON s.`perkara_id`=a.`perkara_id` WHERE MONTH(tanggal_sidang)=' . $bulan . ' AND  
 YEAR(tanggal_sidang)=' . $tahun . ' AND DATE(s.diinput_tanggal) > 
 (SELECT tanggal_sidang FROM perkara_jadwal_sidang s1
         WHERE s1.id < s.id AND
         s1.perkara_id=s.`perkara_id` ORDER BY id DESC LIMIT 1) ORDER BY s.perkara_id')->getResultArray();
        $data_kepatuhan['penginputan_jadwal_sidang'] = $penginputan_jadwal_sidang;

        $penginputan_penahanan = db_connect('sipp')->table('penahanan_terdakwa a')->select('a.perkara_id, nomor_perkara, DATE_FORMAT(a.tanggal_surat, "%d-%m-%Y") as tanggal_surat, DATE_FORMAT(DATE(a.diinput_tanggal),"%d-%m-%Y") as diinput_tanggal')->join('perkara b', 'a.perkara_id=b.perkara_id')->where('MONTH(a.tanggal_surat)', $bulan)->where('YEAR(a.tanggal_surat)', $tahun)->where('DATE(a.diinput_tanggal)>a.tanggal_surat')->groupStart()->where('jenis_penahanan_id', 8)->orWhere('jenis_penahanan_id', 9)->groupEnd()->get()->getResultArray();

        $data_kepatuhan['penginputan_penahanan'] = $penginputan_penahanan;

        // KELENGKAPAN
        $data_kelengkapan = [];
        $petitum_kosong = db_connect('sipp')->table('perkara')->select('nomor_perkara, DATE_FORMAT(tanggal_pendaftaran,"%d-%m-%Y") as tanggal_pendaftaran')->groupStart()->where('alur_perkara_id', 1)->orWhere('alur_perkara_id', 2)->orWhere('alur_perkara_id', 7)->orWhere('alur_perkara_id', 8)->groupEnd()->where('petitum_dok', '')->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();
        $dakwaan_kosong = db_connect('sipp')->table('perkara')->select('nomor_perkara, DATE_FORMAT(tanggal_pendaftaran,"%d-%m-%Y") as tanggal_pendaftaran')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 112)->orWhere('alur_perkara_id', 113)->orWhere('alur_perkara_id', 118)->groupEnd()->where('dakwaan_dok', '')->where('MONTH(tanggal_pendaftaran)', $bulan)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();

        $data_kelengkapan['petitum_dakwaan'] = array_merge($petitum_kosong, $dakwaan_kosong);

        $data_saksi = db_connect('sipp')->query("SELECT nomor_perkara FROM (SELECT DISTINCT(perkara_id) FROM perkara_jadwal_sidang WHERE agenda LIKE '%saksi%' AND alasan_ditunda NOT LIKE '%saksi%' AND dihadiri_oleh!=4 AND tanggal_sidang <= CURDATE() AND MONTH(tanggal_sidang) = " . $bulan . " AND YEAR(tanggal_sidang)=" . $tahun . ") as pemeriksaan_saksi LEFT JOIN perkara ON pemeriksaan_saksi.perkara_id=perkara.perkara_id LEFT JOIN perkara_pihak5 ON perkara.perkara_id=perkara_pihak5.perkara_id WHERE perkara_pihak5.perkara_id IS NULL")->getResultArray();

        $data_kelengkapan['data_saksi'] = $data_saksi;

        $edoc_tuntutan = db_connect('sipp')->table('perkara_penuntutan a')->select('nomor_perkara, DATE_FORMAT(tanggal_penuntutan,"%d-%m-%Y") as tanggal_penuntutan')->join('perkara b', 'a.perkara_id=b.perkara_id')->groupStart()->where('isi_penuntutan_dok', null)->orWhere('isi_penuntutan_dok', "")->groupEnd()->where('MONTH(tanggal_penuntutan)', $bulan)->where('YEAR(tanggal_penuntutan)', $tahun)->get()->getResultArray();

        $data_kelengkapan['edoc_tuntutan'] = $edoc_tuntutan;

        $edoc_putusan = db_connect('sipp')->table('perkara_putusan a')->select('nomor_perkara, DATE_FORMAT(tanggal_putusan,"%d-%m-%Y") as tanggal_putusan')->join('perkara b', 'a.perkara_id=b.perkara_id')->groupStart()->where('amar_putusan_dok', null)->orWhere('amar_putusan_dok', "")->groupEnd()->where('alur_perkara_id !=', 114)->where('MONTH(tanggal_putusan)', $bulan)->where('YEAR(tanggal_putusan)', $tahun)->get()->getResultArray();

        $data_kelengkapan['edoc_putusan'] = $edoc_putusan;

        $lapor_mediasi = db_connect('sipp')->table('perkara_mediasi a')->select('nomor_perkara, DATE_FORMAT(keputusan_mediasi,"%d-%m-%Y") as keputusan_mediasi')->join('perkara b', 'a.perkara_id=b.perkara_id')->groupStart()->where('tgl_laporan_mediator', null)->orWhere('tgl_laporan_mediator', "")->groupEnd()->groupStart()->where('keputusan_mediasi !=', null)->where('keputusan_mediasi !=', "")->groupEnd()->where('MONTH(keputusan_mediasi)', $bulan)->where('YEAR(keputusan_mediasi)', $tahun)->get()->getResultArray();

        $data_kelengkapan['lapor_mediasi'] = $lapor_mediasi;

        $lapor_diversi = db_connect('sipp')->table('perkara_diversi a')->select('nomor_perkara, DATE_FORMAT(tgl_kesepakatan_diversi,"%d-%m-%Y") as tgl_kesepakatan_diversi')->join('perkara b', 'a.perkara_id=b.perkara_id')->groupStart()->where('tgl_laporan_hakim', null)->orWhere('tgl_laporan_hakim', "")->groupEnd()->groupStart()->where('tgl_kesepakatan_diversi !=', null)->where('tgl_kesepakatan_diversi !=', "")->groupEnd()->where('MONTH(tgl_kesepakatan_diversi)', $bulan)->where('YEAR(tgl_kesepakatan_diversi)', $tahun)->get()->getResultArray();

        $data_kelengkapan['lapor_diversi'] = $lapor_diversi;

        $nilai_gs = db_connect('sipp')->table('perkara')->select('nomor_perkara')->where('alur_perkara_id', 8)->groupStart()->where('nilai_sengketa', null)->orWhere('nilai_sengketa', "")->groupEnd()->where('MONTH(tanggal_pendaftaran)', $tahun)->where('YEAR(tanggal_pendaftaran)', $tahun)->get()->getResultArray();

        $data_kelengkapan['nilai_gs'] = $nilai_gs;

        // KESESUAIAN

        $data_kesesuaian = [];
        $kesesuaian_agenda = db_connect('sipp')->query("SELECT nomor_perkara, (SELECT MAX(id) FROM perkara_jadwal_sidang WHERE perkara_id=a.perkara_id) AS id_sidang, agenda FROM perkara a JOIN perkara_jadwal_sidang b ON a.perkara_id=b.perkara_id WHERE MONTH(tanggal_sidang)=" . $bulan . " AND YEAR(tanggal_sidang)=" . $tahun . " and alur_perkara_id != 114 AND b.id=(SELECT MAX(id) FROM perkara_jadwal_sidang 
        WHERE perkara_id=a.perkara_id) and tahapan_terakhir_id=15 AND (agenda  NOT LIKE '%putusan%' AND agenda NOT LIKE '%penetapan%')")->getResultArray();

        $data_kesesuaian['kesesuaian_agenda'] = $kesesuaian_agenda;

        // dd($penginputan_jadwal_sidang);

        $kesesuaian_tanggal_sidang = db_connect('sipp')->query("SELECT nomor_perkara, (SELECT MAX(id) FROM perkara_jadwal_sidang WHERE perkara_id=a.perkara_id) AS id_sidang, 
        agenda, DATE_FORMAT(tanggal_sidang,'%d-%m-%Y') as tanggal_sidang,DATE_FORMAT(tanggal_putusan,'%d-%m-%Y') as tanggal_putusan FROM perkara a JOIN perkara_jadwal_sidang b ON a.perkara_id=b.perkara_id 
        JOIN perkara_putusan c ON a.perkara_id=c.perkara_id 
        WHERE MONTH(tanggal_sidang)=" . $bulan . " AND YEAR(tanggal_sidang)=" . $tahun . " and alur_perkara_id != 114 
        AND b.id=(SELECT MAX(id) FROM perkara_jadwal_sidang WHERE perkara_id=a.perkara_id) 
        AND tanggal_putusan!=tanggal_sidang")->getResultArray();

        $data_kesesuaian['kesesuaian_tanggal_sidang'] = $kesesuaian_tanggal_sidang;

        $data_publikasi = db_connect('sipp')->query("SELECT nomor_perkara, DATE_FORMAT(tanggal_pendaftaran,'%d-%m-%Y') as tanggal_pendaftaran, jenis_perkara_nama FROM perkara WHERE ((jenis_perkara_id IN (64,65,63,83,88,98,130,200,293,354,248) AND pihak_dipublikasikan='Y') OR (jenis_perkara_id NOT IN (64,65,63,83,88,98,130,200,293,354,248) AND pihak_dipublikasikan='T' AND alur_perkara_id !=118) OR (alur_perkara_id=118 AND pihak_dipublikasikan='Y')) AND MONTH(tanggal_pendaftaran)=" . $bulan . " AND YEAR(tanggal_pendaftaran)=" . $tahun . "")->getResultArray();

        $data_kesesuaian['data_publikasi'] = $data_publikasi;

        $data_bht = db_connect('sipp')->table('perkara a')->select('nomor_perkara, DATE_FORMAT(tanggal_putusan,"%d-%m-%Y") as tanggal_putusan, tanggal_bht')->join('perkara_putusan b', 'a.perkara_id=b.perkara_id')->join('perkara_banding c', 'a.perkara_id=c.perkara_id', 'left')->join('perkara_kasasi d', 'a.perkara_id=d.perkara_id', 'left')->where('tanggal_putusan !=', null)->where('tanggal_bht', null)->where('permohonan_banding', null)->where('permohonan_kasasi', null)->where('MONTH(tanggal_putusan)', $bulan)->where('YEAR(tanggal_putusan)', $tahun)->where('a.alur_perkara_id !=', 114)->get()->getResultArray();
        // dd($data_bht);

        $data_kesesuaian['data_bht'] = $data_bht;

        $penahanan_habis = db_connect('sipp')->query("SELECT nomor_perkara, DATE_FORMAT(tanggal_putusan, '%d-%m-%Y') as tanggal_putusan, (SELECT sampai FROM penahanan_terdakwa WHERE id=(SELECT MAX(id) FROM penahanan_terdakwa WHERE perkara_id=a.perkara_id GROUP BY perkara_id)) as sampai FROM perkara a JOIN perkara_putusan c ON a.perkara_id=c.perkara_id 
        WHERE tanggal_putusan> (SELECT sampai FROM penahanan_terdakwa WHERE id=(SELECT MAX(id) FROM penahanan_terdakwa WHERE perkara_id=a.perkara_id GROUP BY perkara_id)) AND month(tanggal_putusan)=" . $bulan . " AND year(tanggal_putusan)=" . $tahun . "")->getResultArray();
        // dd($data_bht);

        $data_kesesuaian['penahanan_habis'] = $penahanan_habis;

        $sisa_panjar = db_connect('sipp')->query("SELECT distinct(perkara_biaya.perkara_id) as id_perkara, nomor_perkara, DATE_FORMAT(tanggal_putusan,'%d-%m-%Y') as tanggal_putusan, FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara),0) as biaya_masuk,FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = -1 and perkara_id=id_perkara),0) as biaya_keluar, FORMAT(((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara)-(SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi = -1 and perkara_id=id_perkara)),0) as sisa_panjar FROM perkara_biaya LEFT JOIN perkara_putusan ON perkara_biaya.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara ON perkara_biaya.perkara_id=perkara.perkara_id WHERE tahapan_terakhir_id=15 AND (alur_perkara_id = 1 OR alur_perkara_id = 2 OR alur_perkara_id = 8) AND month(tanggal_putusan)=" . $bulan . " AND year(tanggal_putusan)=" . $tahun . " HAVING sisa_panjar > 0")->getResultArray();

        $data_kesesuaian['sisa_panjar'] = $sisa_panjar;


        return $this->response->setJSON([view('eis/daftar_eis_ajax', ['data_kinerja' => $data_kinerja, 'data_kepatuhan' => $data_kepatuhan, 'data_kelengkapan' => $data_kelengkapan, 'data_kesesuaian' => $data_kesesuaian])]);
    }
}
