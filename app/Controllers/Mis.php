<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class Mis extends BaseController
{
  public function index()
  {

    return view('mis/daftar_mis');
  }

  public function mis_ajax()
  {
    helper('idndate_helper');
    date_default_timezone_set('Asia/Bangkok');


    $data_1 = db_connect('sipp')->query('SELECT delegasi_masuk.id, nomor_perkara, DATE_FORMAT(tgl_relaas, "%d-%m-%Y") as tgl_relaas, delegasi_masuk.diinput_tanggal FROM delegasi_masuk LEFT JOIN delegasi_proses_masuk ON delegasi_masuk.id=delegasi_proses_masuk.delegasi_id WHERE YEAR(delegasi_masuk.diinput_tanggal) >= 2022 AND (tgl_relaas IS NULL OR tgl_relaas = "")  ORDER BY delegasi_masuk.id DESC')->getResultArray();
    $data_2 = db_connect('sipp')->query('SELECT
        tanggal_akhir,
        id,
        nomor_perkara,
        tanggal_putusan
      FROM
        (
          SELECT
            MAX(sampai) as tanggal_akhir,
            penahanan_terdakwa.perkara_id as id
          FROM
            penahanan_terdakwa
          GROUP BY
            penahanan_terdakwa.perkara_id
          ORDER BY
            penahanan_terdakwa.perkara_id DESC
        ) AS custom
        LEFT JOIN perkara ON custom.id = perkara.perkara_id
        LEFT JOIN perkara_putusan ON custom.id = perkara_putusan.perkara_id
      WHERE
        tanggal_akhir >= CURDATE()
        AND tanggal_akhir <= DATE_ADD(CURDATE(),INTERVAL 15 DAY)
        AND tanggal_putusan IS NULL')->getResultArray();
    $data_3 = db_connect('sipp')->query("SELECT nomor_perkara,DATE_FORMAT(tanggal_putusan, '%d-%m-%Y') as tanggal_putusan,panitera_nama FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id WHERE tanggal_putusan IS NOT NULL AND tanggal_minutasi IS NULL AND perkara_panitera_pn.aktif = 'Y' ORDER BY tanggal_putusan DESC")->getResultArray();
    $data_4 = db_connect('sipp')->query("SELECT nomor_perkara, DATE_FORMAT(tanggal_putusan, '%d-%m-%Y') as tanggal_putusan, DATE_FORMAT(tanggal_minutasi, '%d-%m-%Y') as tanggal_minutasi,panitera_nama FROM perkara  LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara_banding ON perkara.perkara_id=perkara_banding.perkara_id LEFT JOIN perkara_kasasi ON perkara.perkara_id=perkara_kasasi.perkara_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id WHERE perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.tanggal_minutasi IS NOT NULL AND perkara_putusan.tanggal_bht IS NULL AND permohonan_banding IS NULL AND permohonan_kasasi IS NULL AND YEAR(perkara_putusan.tanggal_putusan)>=2019 AND (((perkara.alur_perkara_id = 111 OR perkara.alur_perkara_id = 112 OR perkara.alur_perkara_id = 113 OR perkara.alur_perkara_id = 118) AND perkara_putusan.tanggal_minutasi <= CURDATE())) AND perkara_panitera_pn.aktif = 'Y' ORDER BY tanggal_putusan DESC")->getResultArray();
    $data_5 = db_connect('sipp')->query("SELECT nomor_perkara, DATE_FORMAT(tanggal_putusan, '%d-%m-%Y') as tanggal_putusan, DATE_FORMAT(tanggal_minutasi, '%d-%m-%Y') as tanggal_minutasi,panitera_nama FROM perkara  LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara_banding ON perkara.perkara_id=perkara_banding.perkara_id LEFT JOIN perkara_kasasi ON perkara.perkara_id=perkara_kasasi.perkara_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id WHERE perkara_putusan.tanggal_putusan IS NOT NULL AND perkara_putusan.tanggal_minutasi IS NOT NULL AND perkara_putusan.tanggal_bht IS NULL AND permohonan_banding IS NULL AND permohonan_kasasi IS NULL AND YEAR(perkara_putusan.tanggal_putusan)>=2019 AND (((perkara.alur_perkara_id = 1 OR perkara.alur_perkara_id = 2 OR perkara.alur_perkara_id = 7 OR perkara.alur_perkara_id = 8) AND perkara_putusan.tanggal_minutasi <= CURDATE())) AND perkara_panitera_pn.aktif = 'Y' ORDER BY tanggal_putusan DESC")->getResultArray();
    $data_6 = db_connect('sipp')->query("SELECT perkara_banding.nomor_perkara_pn, DATE_FORMAT(perkara_banding.putusan_banding, '%d-%m-%Y') as putusan_banding, DATE_FORMAT(perkara_banding.pemberitahuan_putusan_banding, '%d-%m-%Y') as pemberitahuan_putusan_banding from perkara_banding join perkara_putusan on perkara_banding.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara_kasasi on perkara_banding.perkara_id=perkara_kasasi.perkara_id where perkara_banding.pemberitahuan_putusan_banding IS NOT NULL AND tanggal_bht is null and permohonan_kasasi IS NULL AND year(perkara_banding.pemberitahuan_putusan_banding)>=2021")->getResultArray();
    // dd($data_6);
    $data_7 = db_connect('sipp')->query("SELECT nomor_perkara_pn, DATE_FORMAT(putusan_kasasi, '%d-%m-%Y') as putusan_kasasi, DATE_FORMAT(pemberitahuan_putusan_kasasi, '%d-%m-%Y') as pemberitahuan_putusan_kasasi from perkara_kasasi join perkara_putusan on perkara_kasasi.perkara_id=perkara_putusan.perkara_id where pemberitahuan_putusan_kasasi IS NOT NULL AND tanggal_bht is null AND year(pemberitahuan_putusan_kasasi)>=2021")->getResultArray();
    $data_8 = db_connect('sipp')->query("SELECT nomor_perkara, panitera_nama FROM (SELECT DISTINCT(perkara_id) FROM perkara_jadwal_sidang WHERE agenda LIKE '%saksi%' AND alasan_ditunda NOT LIKE '%saksi%' AND dihadiri_oleh!=4 AND tanggal_sidang <= CURDATE()) as pemeriksaan_saksi LEFT JOIN perkara ON pemeriksaan_saksi.perkara_id=perkara.perkara_id LEFT JOIN perkara_pihak5 ON perkara.perkara_id=perkara_pihak5.perkara_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id WHERE perkara_pihak5.perkara_id IS NULL AND YEAR(perkara.tanggal_pendaftaran)>=2021 AND perkara_panitera_pn.aktif = 'Y' ORDER BY perkara.perkara_id DESC")->getResultArray();
    $data_9 = db_connect('sipp')->query("SELECT perkara.perkara_id, alur_perkara_id,nomor_perkara, nama, pihak,perkara_putusan_pemberitahuan_putusan.pihak_id as pihak_pemb, tanggal_pemberitahuan_putusan, DATE_FORMAT(tanggal_putusan, '%d-%m-%Y') as tanggal_putusan,status_putusan_id FROM perkara LEFT JOIN perkara_putusan_pemberitahuan_putusan ON perkara.perkara_id=perkara_putusan_pemberitahuan_putusan.perkara_id LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id LEFT JOIN pihak ON perkara_putusan_pemberitahuan_putusan.pihak_id=pihak.id WHERE alur_perkara_id !=114 AND tanggal_putusan is not null AND year(tanggal_putusan) > 2020 AND tanggal_pemberitahuan_putusan is null AND status_putusan_id !=28  ORDER BY perkara.perkara_id DESC")->getResultArray();
    $data_10 = db_connect('sipp')->query("SELECT nomor_perkara_pn,  DATE_FORMAT(permohonan_banding, '%d-%m-%Y') as permohonan_banding,  alur_perkara_id FROM perkara_banding WHERE pengiriman_berkas_banding IS NULL AND tanggal_cabut IS NULL")->getResultArray();
    // dd(count($data_1));
    $data_banding = [];
    foreach ($data_10 as $d_b) {
      if ($d_b['alur_perkara_id'] == 111) {
        $jangka_waktu = 14;
      } else if ($d_b['alur_perkara_id'] == 1 || $d_b['alur_perkara_id'] == 7) {
        $jangka_waktu = 30;
      }
      $tanggal_kirim = new Time($d_b['permohonan_banding']);
      $tanggal_kirim = $tanggal_kirim->addDays($jangka_waktu);
      $tanggal_kirim = $tanggal_kirim->toDateString();
      $tanggal_kirim = idndate($tanggal_kirim)['tanggal_reverse'];

      $data_banding[] = ['nomor_perkara_pn' => $d_b['nomor_perkara_pn'], 'permohonan_banding' => $d_b['permohonan_banding'], 'tanggal_akhir_kirim' => $tanggal_kirim];
    }

    $data_11 = db_connect('sipp')->query("SELECT nomor_perkara_pn, DATE_FORMAT(permohonan_kasasi, '%d-%m-%Y') as permohonan_kasasi, alur_perkara_id FROM perkara_kasasi WHERE pengiriman_berkas_kasasi IS NULL AND tanggal_cabut IS NULL AND tidak_memenuhi_syarat IS NULL AND YEAR(permohonan_kasasi)>2021")->getResultArray();
    $data_kasasi = [];
    foreach ($data_11 as $d_k) {
      if ($d_k['alur_perkara_id'] == 111) {
        $jangka_waktu = 29;
      } else if ($d_k['alur_perkara_id'] == 1 || $d_k['alur_perkara_id'] == 7) {
        $jangka_waktu = 64;
      }
      $tanggal_kirim_kasasi = new Time($d_k['permohonan_kasasi']);
      $tanggal_kirim_kasasi = $tanggal_kirim_kasasi->addDays($jangka_waktu);
      $tanggal_kirim_kasasi = $tanggal_kirim_kasasi->toDateString();
      $tanggal_kirim_kasasi = idndate($tanggal_kirim_kasasi)['tanggal_reverse'];

      $data_kasasi[] = ['nomor_perkara_pn' => $d_k['nomor_perkara_pn'], 'permohonan_kasasi' => $d_k['permohonan_kasasi'], 'tanggal_akhir_kirim' => $tanggal_kirim_kasasi];
    }

    $data_12 = db_connect('sipp')->query("SELECT nomor_perkara_pn, DATE_FORMAT(permohonan_pk, '%d-%m-%Y') as permohonan_pk, alur_perkara_id, pendapat_hakim, penyerahan_kontra_pk FROM perkara_pk WHERE pengiriman_berkas_pk IS NULL AND tanggal_cabut IS NULL AND tidak_memenuhi_syarat IS NULL")->getResultArray();

    $data_pk = [];
    foreach ($data_12 as $d_pk) {

      if ($d_pk['alur_perkara_id'] == 111) {
        if ($d_pk['pendapat_hakim'] == null) {
          $tanggal_kirim_pk = "Pendapat Hakim belum diisi";
        } else {
          $tanggal_kirim_pk = new Time($d_pk['permohonan_pk']);
          $tanggal_kirim_pk = $tanggal_kirim_pk->addDays(29);
          $tanggal_kirim_pk = $tanggal_kirim_pk->toDateString();
          $tanggal_kirim_pk = idndate($tanggal_kirim_pk)['tanggal_reverse'];
        }
      } else if ($d_pk['alur_perkara_id'] == 1 || $d_pk['alur_perkara_id'] == 7) {
        if ($d_pk['penerimaan_kontra_pk'] == null) {
          $tanggal_kirim_pk = "Kontra memori PK belum diterima";
        } else {
          $tanggal_kirim_pk = new Time($d_pk['permohonan_pk']);
          $tanggal_kirim_pk = $tanggal_kirim_pk->addDays(29);
          $tanggal_kirim_pk = $tanggal_kirim_pk->toDateString();
          $tanggal_kirim_pk = idndate($tanggal_kirim_pk)['tanggal_reverse'];
        }
      }



      $data_pk[] = ['nomor_perkara_pn' => $d_pk['nomor_perkara_pn'], 'permohonan_pk' => $d_pk['permohonan_pk'], 'tanggal_akhir_kirim' => $tanggal_kirim_pk];
    }

    $data_13 = db_connect('sipp')->query("SELECT nomor_perkara, petitum_dok, DATE_FORMAT(tanggal_pendaftaran, '%d-%m-%Y') as tanggal_pendaftaran FROM perkara WHERE YEAR(tanggal_pendaftaran)=2022 AND (alur_perkara_id =1 OR alur_perkara_id =2 OR alur_perkara_id =8 ) AND petitum_dok = ' '")->getResultArray();

    $data_14 = db_connect('sipp')->query("SELECT nomor_perkara, petitum_dok, DATE_FORMAT(tanggal_pendaftaran, '%d-%m-%Y') as tanggal_pendaftaran FROM perkara WHERE YEAR(tanggal_pendaftaran)=2022 AND (alur_perkara_id =111 OR alur_perkara_id =112 OR alur_perkara_id =113 OR alur_perkara_id =118 ) AND dakwaan_dok = ' '")->getResultArray();

    $data_15 = db_connect('sipp')->query('SELECT nomor_perkara, DATE_FORMAT(tanggal_putusan, "%d-%m-%Y") as tanggal_putusan FROM perkara_putusan LEFT JOIN perkara ON perkara_putusan.perkara_id = perkara.perkara_id WHERE YEAR(tanggal_putusan)=YEAR(CURDATE()) AND tanggal_putusan IS NOT NULL AND (jenis_perkara_nama = "Perceraian" OR jenis_perkara_nama = "Permohonan Pengangkatan Anak" OR jenis_perkara_nama = "Wasiat" OR jenis_perkara_nama = "Kejahatan Terhadap Kesusilaan" OR jenis_perkara_nama = "Kekerasan Dalam Rumah Tangga" OR alur_perkara_id =118) AND amar_putusan_anonimisasi_dok IS NULL')->getResultArray();

    $data_16 = db_connect('sipp')->query("SELECT nomor_perkara, nama_mediator, panitera_nama FROM perkara LEFT JOIN perkara_mediasi ON perkara.perkara_id=perkara_mediasi.perkara_id  LEFT JOIN perkara_mediator ON perkara.perkara_id=perkara_mediator.perkara_id LEFT JOIN perkara_jadwal_mediasi ON perkara_mediasi.mediasi_id=perkara_jadwal_mediasi.mediasi_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id WHERE tanggal_mediasi = CURDATE() AND perkara_panitera_pn.aktif = 'Y' ORDER BY perkara.perkara_id DESC")->getResultArray();

    $data_17 = db_connect('sipp')->query("SELECT DATE_FORMAT(tanggal_terakhir, '%d-%m-%Y') as tanggal_terakhir, nomor_perkara, panitera_nama FROM (SELECT MAX(tanggal_sidang) AS tanggal_terakhir, perkara_id FROM perkara_jadwal_sidang GROUP BY perkara_id) as jadwal_sidang LEFT JOIN perkara ON jadwal_sidang.perkara_id=perkara.perkara_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara_mediasi ON perkara.perkara_id=perkara_mediasi.perkara_id WHERE tanggal_putusan IS NULL AND (mediasi_id IS NULL OR hasil_mediasi IS NOT NULL) AND tanggal_terakhir <= CURDATE() AND perkara_panitera_pn.aktif = 'Y' ORDER BY tanggal_terakhir DESC")->getResultArray();

    $data_18 = db_connect('sipp')->query("SELECT
        perk.nomor_perkara,
        perk.perkara_id,
        perk.alur_perkara_id,
        alur.nama AS nama_alur,
       
        (
          SELECT
            GROUP_CONCAT(
              DISTINCT hkpn.nama_gelar
              ORDER BY
                hk.id ASC SEPARATOR '<br>'
            ) AS nama_hakim
          FROM
            perkara_hakim_pn AS hk
            JOIN hakim_pn AS hkpn ON hkpn.id = hk.hakim_id
          WHERE
            hk.perkara_id = perk.perkara_id
            AND hk.aktif = 'Y'
          ORDER BY
            hk.urutan ASC
        ) AS majelis_hakim,
        (
          SELECT
            GROUP_CONCAT(
              DISTINCT pp.nama
              ORDER BY
                ppp.id ASC SEPARATOR '<br>'
            ) AS nama_js
          FROM
            perkara_panitera_pn AS ppp
            JOIN panitera_pn AS pp ON pp.id = ppp.panitera_id
          WHERE
            ppp.perkara_id = perk.perkara_id
            AND ppp.aktif = 'Y'
          ORDER BY
            ppp.urutan ASC
        ) AS panitera_nama,
        (
          SELECT
            GROUP_CONCAT(
              DISTINCT jspn.nama
              ORDER BY
                pjs.id ASC SEPARATOR '<br>'
            ) AS nama_js
          FROM
            perkara_jurusita AS pjs
            JOIN jurusita AS jspn ON jspn.id = pjs.jurusita_id
          WHERE
            pjs.perkara_id = perk.perkara_id
            AND pjs.aktif = 'Y'
          ORDER BY
            pjs.urutan ASC
        ) AS jurusita,
        sidang.id AS sidang_id,
        DATE_FORMAT(sidang.tanggal_sidang, '%d-%m-%Y') AS tanggal_sidang,
        sidang.agenda,
        perkarapihak.pihak_id,
        perkarapihak.nama AS nama_pihak,
        perkarapihak.pihakke,
        perkarapihak.ketpihak,
        perkarapihak.pengacara_pihak_id,
        datarelaas.id AS relaas_id,
        DATE_FORMAT(datarelaas.tanggal_relaas, '%d-%m-%Y') AS tanggal_relaas,
        datarelaas.doc_relaas,
        sidang.urutan,
        jadwalsidang.urutan AS urutan_sebelumnya,
        jadwalsidang.dihadiri_oleh AS status_kehadiran_sebelumnya,
        (
          CASE
            WHEN(phs.tahapan_id = 12) THEN 'Y'
            ELSE 'T'
          END
        ) AS sidang_pertama
      FROM
        perkara AS perk
        JOIN perkara_jadwal_sidang AS sidang ON sidang.perkara_id = perk.perkara_id
        JOIN (
          SELECT
            p1.perkara_id,
            p1.pihak_id,
            p1.nama,
            1 AS pihakke,
            'pihak' AS ketpihak,
            '' AS pengacara_pihak_id
          FROM
            perkara_pihak1 AS p1
            JOIN perkara ON perkara.perkara_id = p1.perkara_id
          WHERE
            alur_perkara_id < 111
          UNION
          SELECT
            p2.perkara_id,
            p2.pihak_id,
            p2.nama,
            2 AS pihakke,
            'pihak' AS ketpihak,
            '' AS pengacara_pihak_id
          FROM
            perkara_pihak2 AS p2
            JOIN perkara ON perkara.perkara_id = p2.perkara_id
          WHERE
            alur_perkara_id < 111
            AND (
              status_penahanan_id IS NULL
              OR status_penahanan_id = 0
            )
            AND (
              jenis_tahanan_id = 0
              OR jenis_tahanan_id IS NULL
            )
          UNION
          SELECT
            p3.perkara_id,
            p3.pihak_id,
            p3.nama,
            3 AS pihakke,
            'intervensi' AS ketpihak,
            '' AS pengacara_pihak_id
          FROM
            perkara_pihak3 AS p3
          UNION
          SELECT
            p4.perkara_id,
            p4.pihak_id,
            p4.nama,
            4 AS pihakke,
            'turut' AS ketpihak,
            '' AS pengacara_pihak_id
          FROM
            perkara_pihak4 AS p4
          UNION
          SELECT
            p5.perkara_id,
            p5.pengacara_id,
            p5.nama,
            p5.pihak_ke AS pihhkke,
            'pengacara' AS ketpihak,
            p5.pihak_id AS pengacara_pihak_id
          FROM
            perkara_pengacara AS p5
        ) AS perkarapihak ON perkarapihak.perkara_id = perk.perkara_id
        LEFT JOIN perkara_pelaksanaan_relaas AS datarelaas ON datarelaas.pihak_id = perkarapihak.pihak_id
        AND datarelaas.perkara_id = perk.perkara_id
        AND datarelaas.sidang_id = sidang.id
        LEFT JOIN (
          SELECT
            perkara.perkara_id AS perkara_id,
            perkara_jadwal_sidang.urutan AS urutan,
            perkara_jadwal_sidang.dihadiri_oleh
          FROM
            (
              perkara
              JOIN perkara_jadwal_sidang ON (
                perkara_jadwal_sidang.perkara_id = perkara.perkara_id
              )
            )
        ) AS jadwalsidang ON (
          jadwalsidang.perkara_id = perk.perkara_id
          AND jadwalsidang.urutan = sidang.urutan - 1
        )
        LEFT JOIN perkara_penetapan_hari_sidang AS phs ON (
          phs.perkara_id = perk.perkara_id
          AND phs.jadwalsidang_id = sidang.id
        )
        JOIN alur_perkara AS alur ON alur.id = perk.alur_perkara_id
       
      WHERE
        YEAR(perk.tanggal_pendaftaran) = YEAR(CURDATE())
        AND perk.alur_perkara_id < 111
        AND perkarapihak.pihak_id NOT IN (
          SELECT
            pp.pihak_id
          FROM
            perkara_pelaksanaan_relaas
            JOIN perkara_pengacara AS pp ON pp.pengacara_id = perkara_pelaksanaan_relaas.pihak_id
            AND pp.perkara_id = perkara_pelaksanaan_relaas.perkara_id
            JOIN perkara ON pp.perkara_id = perkara.perkara_id
          WHERE
            perk.alur_perkara_id < 111
            AND perkara_pelaksanaan_relaas.perkara_id = perk.perkara_id
            AND perkara_pelaksanaan_relaas.sidang_id = sidang.id
            AND (
              perkara_pelaksanaan_relaas.tanggal_relaas IS NOT NULL
              OR perkara_pelaksanaan_relaas.tanggal_relaas <> ''
            )
            AND (
              perkara_pelaksanaan_relaas.doc_relaas IS NOT NULL
              OR perkara_pelaksanaan_relaas.doc_relaas <> ''
            )
          UNION
          SELECT
            ppb.pengacara_id
          FROM
            perkara_pelaksanaan_relaas
            JOIN perkara_pengacara AS ppb ON ppb.pihak_id = perkara_pelaksanaan_relaas.pihak_id
            AND ppb.perkara_id = perkara_pelaksanaan_relaas.perkara_id
            JOIN perkara ON ppb.perkara_id = perkara.perkara_id
          WHERE
            perk.alur_perkara_id < 111
            AND perkara_pelaksanaan_relaas.perkara_id = perk.perkara_id
            AND perkara_pelaksanaan_relaas.sidang_id = sidang.id
            AND (
              perkara_pelaksanaan_relaas.tanggal_relaas IS NOT NULL
              OR perkara_pelaksanaan_relaas.tanggal_relaas <> ''
            )
            AND (
              perkara_pelaksanaan_relaas.doc_relaas IS NOT NULL
              OR perkara_pelaksanaan_relaas.doc_relaas <> ''
            )
        )
        AND (
          (
            datarelaas.tanggal_relaas IS NULL
            OR datarelaas.tanggal_relaas = ''
          )
          OR (
            datarelaas.doc_relaas IS NULL
            OR datarelaas.doc_relaas = ''
          )
        )
        AND(
          perk.alur_perkara_id >= 1
          AND perk.alur_perkara_id <= 17
        )
        AND (
          (jadwalsidang.dihadiri_oleh <> 1)
          AND (
            jadwalsidang.dihadiri_oleh = 2
            AND (
              perkarapihak.pihakke = 2
              OR perkarapihak.pihakke = 4
            )
          )
          OR (
            jadwalsidang.dihadiri_oleh = 3
            AND perkarapihak.pihakke = 1
          )
          OR (
            jadwalsidang.dihadiri_oleh = 4
            OR jadwalsidang.dihadiri_oleh IS NULL
          )
        )
        AND DATEDIFF(CURRENT_DATE, sidang.tanggal_sidang) >= -5
        AND sidang.urutan = 1
      ORDER BY
        perk.perkara_id DESC,
        sidang.tanggal_sidang ASC")->getResultArray();

    $data_19 = db_connect('sipp')->query("SELECT distinct(perkara_biaya.perkara_id) as id_perkara, nomor_perkara, DATE_FORMAT(tanggal_putusan,'%d-%m-%Y') as tanggal_putusan, FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara),0) as biaya_masuk,FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = -1 and perkara_id=id_perkara),0) as biaya_keluar, FORMAT(((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara)-(SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi = -1 and perkara_id=id_perkara)),0) as sisa_panjar FROM perkara_biaya LEFT JOIN perkara_putusan ON perkara_biaya.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara ON perkara_biaya.perkara_id=perkara.perkara_id WHERE tahapan_terakhir_id=15 AND (alur_perkara_id = 1 OR alur_perkara_id = 2 OR alur_perkara_id = 8) HAVING sisa_panjar > 0 ORDER BY perkara_biaya.perkara_id DESC")->getResultArray();

    // dd($data_19);


    $data_20 = db_connect('sipp')->query("SELECT distinct(perkara_biaya.perkara_id) as id_perkara, nomor_perkara, DATE_FORMAT(putusan_banding,'%d-%m-%Y') as tanggal_putusan, FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara),0) as biaya_masuk,FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = -1 and perkara_id=id_perkara),0) as biaya_keluar, FORMAT(((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara)-(SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi = -1 and perkara_id=id_perkara)),0) as sisa_panjar FROM perkara_biaya LEFT JOIN perkara_putusan ON perkara_biaya.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara ON perkara_biaya.perkara_id=perkara.perkara_id LEFT JOIN perkara_banding ON perkara_biaya.perkara_id=perkara_banding.perkara_id WHERE proses_terakhir_id=400 AND (perkara.alur_perkara_id = 1 OR perkara.alur_perkara_id = 2 OR perkara.alur_perkara_id = 8) HAVING sisa_panjar > 0 ORDER BY perkara_biaya.perkara_id DESC")->getResultArray();

    $data_21 = db_connect('sipp')->query("SELECT distinct(perkara_biaya.perkara_id) as id_perkara, nomor_perkara, DATE_FORMAT(putusan_kasasi,'%d-%m-%Y') as tanggal_putusan, FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara),0) as biaya_masuk,FORMAT((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = -1 and perkara_id=id_perkara),0) as biaya_keluar, FORMAT(((SELECT SUM(jumlah) FROM perkara_biaya  WHERE jenis_transaksi = 1 and perkara_id=id_perkara)-(SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi = -1 and perkara_id=id_perkara)),0) as sisa_panjar FROM perkara_biaya LEFT JOIN perkara_putusan ON perkara_biaya.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara ON perkara_biaya.perkara_id=perkara.perkara_id LEFT JOIN perkara_kasasi ON perkara_biaya.perkara_id=perkara_kasasi.perkara_id WHERE proses_terakhir_id=500 AND (perkara.alur_perkara_id = 1 OR perkara.alur_perkara_id = 2 OR perkara.alur_perkara_id = 8) HAVING sisa_panjar > 0 ORDER BY perkara_biaya.perkara_id DESC")->getResultArray();

    $data_22 = db_connect('sipp')->query("SELECT nomor_perkara,DATE_FORMAT(tanggal_sidang, '%d-%m-%Y') AS tanggal_sidang,agenda,panitera_nama FROM perkara LEFT JOIN perkara_jadwal_sidang ON perkara.perkara_id=perkara_jadwal_sidang.perkara_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id WHERE (alur_perkara_id=1 OR alur_perkara_id =2 OR alur_perkara_id=111 OR alur_perkara_id=112 OR alur_perkara_id=118 OR alur_perkara_id=119 OR alur_perkara_id=120 OR alur_perkara_id=121) AND (YEAR(tanggal_sidang)=YEAR(NOW()) AND tanggal_sidang < CURDATE() AND edoc_bas IS NULL) AND perkara_panitera_pn.aktif = 'Y' ORDER BY tanggal_sidang DESC")->getResultArray();

    $data_23 = db_connect('sipp')->query("SELECT id, perkara.nomor_perkara, DAtE_FORMAT(tanggal_putusan,'%d-%m-%Y') as tanggal_putusan, DAtE_FORMAT(tanggal_minutasi,'%d-%m-%Y') as tanggal_minutasi, DAtE_FORMAT(tanggal_bht,'%d-%m-%Y') as tanggal_bht FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id LEFT JOIN arsip ON perkara.perkara_id=arsip.perkara_id WHERE id IS NULL AND tanggal_bht IS NOT NULL AND YEAR(tanggal_bht) >=2019 ORDER BY tanggal_bht DESC")->getResultArray();

    $data_24 = db_connect('sipp')->query("SELECT 					
    A.tanggal_pendaftaran, 
    A.nomor_perkara, 
    A.proses_terakhir_text,
    A.para_pihak, 
    
    (SELECT panitera_nama 
    FROM perkara_panitera_pn 
    LEFT JOIN panitera_pn  ON panitera_pn.id = perkara_panitera_pn.panitera_id
    WHERE perkara_panitera_pn.perkara_id= A.perkara_id AND perkara_panitera_pn.aktif='Y' ORDER BY perkara_panitera_pn.urutan ASC) AS paniteraku,
    (SELECT GROUP_CONCAT(DISTINCT hkpn.nama_gelar ORDER BY hk.id ASC SEPARATOR '<br>') AS nama_hakim 
    FROM perkara_hakim_pn AS hk
    LEFT JOIN hakim_pn AS hkpn ON hkpn.id = hk.hakim_id
    WHERE hk.perkara_id= A.perkara_id AND hk.aktif='Y' ORDER BY hk.urutan ASC) AS majelis_hakim
          FROM perkara as A
          LEFT JOIN perkara_hakim_pn as B ON B.perkara_id=A.perkara_id
          LEFT JOIN perkara_jadwal_sidang as C ON C.perkara_id=A.perkara_id
          LEFT JOIN perkara_panitera_pn as D ON D.perkara_id=A.perkara_id
          WHERE A.alur_perkara_id NOT IN (18,112,113,114)	
          AND A.perkara_id NOT IN (SELECT perkara_id FROM perkara_court_calendar 
                                   WHERE (rencana_agenda LIKE '%putus%' OR rencana_agenda LIKE '%penetapan%' OR rencana_agenda LIKE '%cabut%' OR rencana_agenda LIKE '%gugur%' OR rencana_agenda LIKE '%akta perdamaian%' OR rencana_agenda LIKE '%P U T U S%'))
          AND B.aktif = 'Y'		
          AND D.aktif = 'Y'
          AND C.tanggal_sidang IS NOT NULL								
          AND A.perkara_id NOT IN (SELECT perkara_id FROM perkara_mediasi
                                   WHERE dimulai_mediasi IS NOT NULL 
                       AND hasil_mediasi IS NULL)
          AND YEAR(A.tanggal_pendaftaran) = 2022
          GROUP BY A.perkara_id
          ORDER BY A.perkara_id DESC")->getResultArray();
    $data_25 = db_connect('sipp')->query("SELECT nomor_perkara, panitera_nama, tanggal_putusan, edoc_calender FROM perkara LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id LEFT JOIN perkara_edoc_calendar  ON perkara.perkara_id=perkara_edoc_calendar.perkara_id LEFT JOIN perkara_panitera_pn ON perkara.perkara_id=perkara_panitera_pn.perkara_id WHERE YEAR(tanggal_putusan)>=2022 and (alur_perkara_id=1 or alur_perkara_id=2 or alur_perkara_id=7 or alur_perkara_id=7 or alur_perkara_id=111 or alur_perkara_id=112 or alur_perkara_id=118) and edoc_calender IS NULL and (status_putusan_id != 28 AND status_putusan_id != 6 AND status_putusan_id != 7 AND status_putusan_id != 29 AND status_putusan_id != 31 AND status_putusan_id != 37 AND status_putusan_id != 38 AND status_putusan_id != 65 AND status_putusan_id != 67 AND status_putusan_id != 93)")->getResultArray();

    $data_26 = db_connect('sipp')->query("SELECT nomor_register, DATE_FORMAT(tanggal_pendaftaran, '%d-%m-%Y') as tanggal_pendaftaran, nama FROM perkara_efiling LEFT JOIN perkara_efiling_id ON perkara_efiling.efiling_id=perkara_efiling_id.efiling_id LEFT JOIN alur_perkara  ON perkara_efiling.alur_perkara_id=alur_perkara.id WHERE perkara_id IS NULL AND status_pendaftaran_id!=11 AND tanggal_bayar IS NOT NULL")->getResultArray();


    $data_27 = db_connect('sipp')->query("SELECT nomor_perkara, DATE_FORMAT(tanggal_pendaftaran, '%d-%m-%Y') as tanggal_pendaftaran, jenis_perkara_nama FROM perkara WHERE ((jenis_perkara_id IN (64,65,63,83,88,98,130,200,293,354,248) AND pihak_dipublikasikan='Y') OR (jenis_perkara_id NOT IN (64,65,63,83,88,98,130,200,293,354,248) AND pihak_dipublikasikan='T' AND alur_perkara_id !=118) OR (alur_perkara_id=118 AND pihak_dipublikasikan='Y')) AND YEAR(tanggal_pendaftaran)>=2022")->getResultArray();
    // dd($data_27);


    $uraian_mis = db_connect()->table('mis')->get()->getResultArray();
    $mis_show = [];
    foreach ($uraian_mis as $u) {
      $slug = explode(' ', $u['uraian']);
      $slug = implode('_', $slug);
      if ($u['id'] == 1) { // Delegasi
        $data_mis = $data_1;
      }
      if ($u['id'] == 2) { // Penahanan
        $data_mis = $data_2;
      }
      if ($u['id'] == 3) { //Putusan belum minut
        $data_mis = $data_3;
      }
      if ($u['id'] == 4) { //pidana belum bht
        $data_mis = $data_4;
      }
      if ($u['id'] == 5) { //perdata belum bht
        $data_mis = $data_5;
      }
      if ($u['id'] == 6) { // banding belum bht
        $data_mis = $data_6;
      }
      if ($u['id'] == 7) { ////kasasi belum bht
        $data_mis = $data_7;
      }
      if ($u['id'] == 8) { //saksi tidak lengkap
        $data_mis = $data_8;
      }
      if ($u['id'] == 9) { //Putus belum beritahu
        $data_mis = $data_9;
      }
      if ($u['id'] == 10) { // banding belum kirim
        $data_mis = $data_banding;
      }
      if ($u['id'] == 11) { // kasasi belum kirim
        $data_mis = $data_kasasi;
      }
      if ($u['id'] == 12) { // pk belum kirim
        $data_mis = $data_pk;
      }
      if ($u['id'] == 13) { // Belum edoc petitum
        $data_mis = $data_13;
      }
      if ($u['id'] == 14) { // Belum edoc dakwaan
        $data_mis = $data_14;
      }
      if ($u['id'] == 15) { // Belum Anonimisasi
        $data_mis = $data_15;
      }
      if ($u['id'] == 16) { // Jadwal mediasi
        $data_mis = $data_16;
      }
      if ($u['id'] == 17) { // Belum tunda
        $now = Time::now();
        if ($now->getHour() == '14') {
          $data_mis = $data_17;
        }
      }

      if ($u['id'] == 18) { // Belum manggil
        $data_mis = $data_18;
      }

      if ($u['id'] == 19) { // Sisa panjar I
        $data_mis = $data_19;
      }

      if ($u['id'] == 20) { // Sisa panjar banding
        $data_mis = $data_20;
      }

      if ($u['id'] == 21) { // Sisa panjar kasasi
        $data_mis = $data_21;
      }

      if ($u['id'] == 22) { // Belum BA
        $data_mis = $data_22;
      }

      if ($u['id'] == 23) { // Belum Serah
        $data_mis = $data_23;
      }

      if ($u['id'] == 24) { // Belum CC
        $data_mis = $data_24;
      }

      if ($u['id'] == 25) { // Belum CC
        $data_mis = $data_25;
      }

      if ($u['id'] == 26) { // Belum CC
        $data_mis = $data_26;
      }

      if ($u['id'] == 27) { // Belum CC
        $data_mis = $data_27;
      }

      $mis_show[] = ['id' => $u['id'], 'uraian' => $u['uraian'], 'slug' => $slug, 'data_mis' => $data_mis];
      $data_mis = false;
    }
    return $this->response->setJSON([view('mis/daftar_mis_ajax', ['data' => $mis_show])]);
  }
}
