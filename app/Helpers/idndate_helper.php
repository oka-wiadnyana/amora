<?php

function idndate($tgl)
{

    $array_tgl = explode('-', $tgl);
    $bulan_angka = (int)($array_tgl[1]);
    $tanggal_reverse = $array_tgl[2] . '-' . $array_tgl[1] . '-' . $array_tgl[0];

    $bulan = '';


    switch ($bulan_angka) {
        case (1):
            $bulan = 'Januari';
            break;
        case (2):
            $bulan = 'Februari';
            break;
        case (3):
            $bulan = 'Maret';
            break;
        case (4):
            $bulan = 'April';
            break;
        case (5):
            $bulan = 'Mei';
            break;
        case (6):
            $bulan = 'Juni';
            break;
        case (7):
            $bulan = 'Juli';
            break;
        case (8):
            $bulan = 'Agustus';
            break;
        case (9):
            $bulan = 'September';
            break;
        case (10):
            $bulan = 'Oktober';
            break;
        case (11):
            $bulan = 'Nopember';
            break;
        case (12):
            $bulan = 'Desember';
            break;
    }
    $tanggal = $array_tgl[2] . ' ' . $bulan . ' ' . $array_tgl[0];

    $hari_eng = date('D', strtotime($tgl));

    switch ($hari_eng) {
        case ('Sun'):
            $hari_idn = 'Minggu';
            break;
        case ('Mon'):
            $hari_idn = 'Senin';
            break;
        case ('Tue'):
            $hari_idn = 'Selasa';
            break;
        case ('Wed'):
            $hari_idn = 'Rabu';
            break;
        case ('Thu'):
            $hari_idn = 'Kamis';
            break;
        case ('Fri'):
            $hari_idn = 'Jumat';
            break;
        case ('Sat'):
            $hari_idn = 'Sabtu';
            break;
    }

    $waktu_id = ['tanggal' => $tanggal, 'hari' => $hari_idn, 'bulan' => $bulan, 'tahun' => $array_tgl[0], 'tanggal_reverse' => $tanggal_reverse];
    return $waktu_id;
}
