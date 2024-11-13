<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Eksekusi extends BaseController
{
    public function index()
    {
        return view('eksekusi/daftar_eksekusi');
        //
    }

    public function putusan_selesai()
    {

        return view('eksekusi/daftar_eksekusi');
        //
    }

    public function data_eksekusi_datatable()
    {


        $queryBuilder = db_connect('sipp')->table('perkara_eksekusi')->groupStart()->where('pelaksanaan_eksekusi_lelang !=', null)->where('pelaksanaan_eksekusi_lelang !=', '0000-00-00')->groupEnd()->orGroupStart()->where('pelaksanaan_eksekusi_rill !=', null)->where('pelaksanaan_eksekusi_rill !=', '0000-00-00')->groupEnd()->orGroupStart()->where('penetapan_noneksekusi !=', null)->where('penetapan_noneksekusi !=', '0000-00-00')->groupEnd()->orGroupStart()->where('tanggal_cabut_eks !=', null)->where('tanggal_cabut_eks !=', '0000-00-00')->groupEnd();


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('status', function ($row) {
            if ($row->pelaksanaan_eksekusi_lelang != null && $row->pelaksanaan_eksekusi_lelang != '0000-00-00') {
                $status = 'Pelaksanaan lelang';
            } elseif (($row->pelaksanaan_eksekusi_rill != null && $row->pelaksanaan_eksekusi_rill != '0000-00-00') && ($row->penetapan_noneksekusi != null || $row->penetapan_noneksekusi != '0000-00-00')) {
                $status = 'Pelaksanaan eksekusi rill';
            } elseif (($row->penetapan_noneksekusi != null && $row->penetapan_noneksekusi != '0000-00-00') && ($row->tanggal_cabut_eks != null || $row->tanggal_cabut_eks != '0000-00-00')) {
                $status = 'Non Eksekutabel';
            } elseif ($row->tanggal_cabut_eks != null && $row->tanggal_cabut_eks != '0000-00-00') {
                $status = 'Eksekusi dicabut';
            } else {
                $status = '-';
            }

            return $status;
        });
        $datatables->format('penetapan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_noneksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('tanggal_cabut_eks', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });


        $datatables->only(['nomor_register_eksekusi', 'pemohon_eksekusi', 'penetapan_teguran_eksekusi', 'pelaksanaan_teguran_eksekusi', 'penetapan_sita_eksekusi', 'pelaksanaan_sita_eksekusi', 'penetapan_perintah_eksekusi_lelang', 'pelaksanaan_eksekusi_lelang', 'penetapan_perintah_eksekusi_rill', 'pelaksanaan_eksekusi_rill', 'penetapan_noneksekusi', 'tanggal_cabut_eks', 'catatan_eksekusi']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function putusan_belum_selesai()
    {

        return view('eksekusi/daftar_eksekusi_belum');
        //
    }

    public function data_eksekusi_belum_datatable()
    {


        $queryBuilder = db_connect('sipp')->table('perkara_eksekusi')->groupStart()->where('pelaksanaan_eksekusi_lelang', null)->orWhere('pelaksanaan_eksekusi_lelang', '0000-00-00')->groupEnd()->groupStart()->where('pelaksanaan_eksekusi_rill', null)->orWhere('pelaksanaan_eksekusi_rill', '0000-00-00')->groupEnd()->groupStart()->where('penetapan_noneksekusi', null)->orWhere('penetapan_noneksekusi', '0000-00-00')->groupEnd()->groupStart()->orWhere('tanggal_cabut_eks', null)->orWhere('tanggal_cabut_eks', '0000-00-00')->groupEnd();


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('status', function ($row) {
            if (($row->pelaksanaan_teguran_eksekusi != null && $row->pelaksanaan_teguran_eksekusi != '0000-00-00') && ($row->pelaksanaan_sita_eksekusi == null || $row->pelaksanaan_sita_eksekusi == '0000-00-00')) {
                $status = 'Aanmaning';
            } elseif ($row->pelaksanaan_sita_eksekusi != null && $row->pelaksanaan_sita_eksekusi != '0000-00-00') {
                $status = 'Pelaksanaan sita eksekusi';
            } else {
                $status = '-';
            }

            return $status;
        });

        $datatables->format('penetapan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_noneksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('tanggal_cabut_eks', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });

        $datatables->only(['nomor_register_eksekusi', 'pemohon_eksekusi', 'penetapan_teguran_eksekusi', 'pelaksanaan_teguran_eksekusi', 'penetapan_sita_eksekusi', 'pelaksanaan_sita_eksekusi', 'penetapan_perintah_eksekusi_lelang', 'pelaksanaan_eksekusi_lelang', 'penetapan_perintah_eksekusi_rill', 'pelaksanaan_eksekusi_rill', 'penetapan_noneksekusi', 'tanggal_cabut_eks', 'catatan_eksekusi']);

        $datatables->format('penetapan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function ht_selesai()
    {

        return view('eksekusi/daftar_eksekusi_ht');
        //
    }

    public function data_ht_datatable()
    {


        $queryBuilder = db_connect('sipp')->table('perkara_eksekusi_ht')->select('perkara_eksekusi_ht.ht_id as id_ht')->select('perkara_eksekusi_ht.*')->selectSubquery(db_connect('sipp')->table('perkara_eksekusi_detil_ht')->select('pihak_nama')->where('ht_id=id_ht')->where('status_pihak_id', 1)->limit(1), 'nama')->groupStart()->where('pelaksanaan_eksekusi_lelang !=', null)->where('pelaksanaan_eksekusi_lelang !=', '0000-00-00')->groupEnd()->orGroupStart()->where('pelaksanaan_eksekusi_rill !=', null)->where('pelaksanaan_eksekusi_rill !=', '0000-00-00')->groupEnd()->orGroupStart()->where('penetapan_noneksekusi !=', null)->where('penetapan_noneksekusi !=', '0000-00-00')->groupEnd()->orGroupStart()->where('tanggal_cabut_ht !=', null)->where('tanggal_cabut_ht !=', '0000-00-00')->groupEnd();


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('status', function ($row) {
            if ($row->pelaksanaan_eksekusi_lelang != null && $row->pelaksanaan_eksekusi_lelang != '0000-00-00') {
                $status = 'Pelaksanaan lelang';
            } elseif (($row->pelaksanaan_eksekusi_rill != null && $row->pelaksanaan_eksekusi_rill != '0000-00-00') && ($row->penetapan_noneksekusi != null || $row->penetapan_noneksekusi != '0000-00-00')) {
                $status = 'Pelaksanaan eksekusi rill';
            } elseif (($row->penetapan_noneksekusi != null && $row->penetapan_noneksekusi != '0000-00-00') && ($row->tanggal_cabut_ht != null || $row->tanggal_cabut_ht != '0000-00-00')) {
                $status = 'Non Eksekutabel';
            } elseif ($row->tanggal_cabut_ht != null && $row->tanggal_cabut_ht != '0000-00-00') {
                $status = 'Eksekusi dicabut';
            } else {
                $status = '-';
            }

            return $status;
        });
        $datatables->format('penetapan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_noneksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('tanggal_cabut_ht', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });


        $datatables->only(['eksekusi_nomor_perkara', 'nama', 'penetapan_teguran_eksekusi', 'pelaksanaan_teguran_eksekusi', 'penetapan_sita_eksekusi', 'pelaksanaan_sita_eksekusi', 'penetapan_perintah_eksekusi_lelang', 'pelaksanaan_eksekusi_lelang', 'penetapan_perintah_eksekusi_rill', 'pelaksanaan_eksekusi_rill', 'penetapan_noneksekusi', 'tanggal_cabut_ht', 'catatan_eksekusi']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function ht_belum_selesai()
    {

        return view('eksekusi/daftar_eksekusi_ht_belum');
        //
    }

    public function data_ht_belum_datatable()
    {


        $queryBuilder = db_connect('sipp')->table('perkara_eksekusi_ht')->select('perkara_eksekusi_ht.ht_id as id_ht')->select('perkara_eksekusi_ht.*')->selectSubquery(db_connect('sipp')->table('perkara_eksekusi_detil_ht')->select('pihak_nama')->where('ht_id=id_ht')->where('status_pihak_id', 1)->limit(1), 'nama')->groupStart()->where('pelaksanaan_eksekusi_lelang', null)->orWhere('pelaksanaan_eksekusi_lelang', '0000-00-00')->groupEnd()->groupStart()->where('pelaksanaan_eksekusi_rill', null)->orWhere('pelaksanaan_eksekusi_rill', '0000-00-00')->groupEnd()->groupStart()->where('penetapan_noneksekusi', null)->orWhere('penetapan_noneksekusi', '0000-00-00')->groupEnd()->groupStart()->orWhere('tanggal_cabut_ht', null)->orWhere('tanggal_cabut_ht', '0000-00-00')->groupEnd();


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('status', function ($row) {
            if (($row->pelaksanaan_teguran_eksekusi != null && $row->pelaksanaan_teguran_eksekusi != '0000-00-00') && ($row->pelaksanaan_sita_eksekusi == null || $row->pelaksanaan_sita_eksekusi == '0000-00-00')) {
                $status = 'Aanmaning';
            } elseif ($row->pelaksanaan_sita_eksekusi != null && $row->pelaksanaan_sita_eksekusi != '0000-00-00') {
                $status = 'Pelaksanaan sita eksekusi';
            } else {
                $status = '-';
            }

            return $status;
        });
        $datatables->format('penetapan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_teguran_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_sita_eksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_lelang', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_perintah_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('pelaksanaan_eksekusi_rill', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('penetapan_noneksekusi', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });
        $datatables->format('tanggal_cabut_ht', function ($value, $row) {
            $format_tgl = ($value == null || $value == '0000-00-00') ? "-" : $value;
            return $format_tgl;
        });


        $datatables->only(['eksekusi_nomor_perkara', 'nama', 'penetapan_teguran_eksekusi', 'pelaksanaan_teguran_eksekusi', 'penetapan_sita_eksekusi', 'pelaksanaan_sita_eksekusi', 'penetapan_perintah_eksekusi_lelang', 'pelaksanaan_eksekusi_lelang', 'penetapan_perintah_eksekusi_rill', 'pelaksanaan_eksekusi_rill', 'penetapan_noneksekusi', 'tanggal_cabut_ht', 'catatan_eksekusi']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }
}
