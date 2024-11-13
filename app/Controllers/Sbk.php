<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;
use PhpOffice\PhpWord\TemplateProcessor;

class Sbk extends BaseController
{
    private $validation;
    private $client;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->client = \Config\Services::curlrequest();
    }
    public function daftar()
    {

        return view('sbk/daftar');
    }

    public function sbk_datatable()
    {

        helper('idndate_helper');

        $queryBuilder = db_connect('sbk')->table('surveys')->orderBy('month', 'desc')->orderBy('year', 'desc');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('bulan', function ($row) {

            $bulan = idndate("$row->year-$row->month-01")['bulan'];
            return $bulan;
        });
        $datatables->addColumn('tahun', function ($row) {


            return $row->year;
        });
        $datatables->addColumn('nama', function ($row) {


            return $row->playerName;
        });

        $datatables->addColumn('pimmen', function ($row) {

            $total_sum = 0;
            $column = [];
            for ($i = 1; $i <= 10; $i++) {
                $column[] = 'Q' . $i;
            }

            foreach ($row as $key => $value) {

                if (in_array($key, $column)) {
                    $total_sum += $value;
                }
            }
            return $total_sum;
        });
        $datatables->addColumn('kirja', function ($row) {

            $total_sum = 0;
            $column = [];
            for ($i = 11; $i <= 15; $i++) {
                $column[] = 'Q' . $i;
            }



            foreach ($row as $key => $value) {

                if (in_array($key, $column)) {
                    $total_sum += $value;
                }
            }
            return $total_sum;
        });
        $datatables->addColumn('perja', function ($row) {

            $total_sum = 0;
            $column = [];
            for ($i = 16; $i <= 32; $i++) {
                $column[] = 'Q' . $i;
            }



            foreach ($row as $key => $value) {

                if (in_array($key, $column)) {
                    $total_sum += $value;
                }
            }
            return $total_sum;
        });




        $datatables->only(['bulan', 'tahun', 'nama', 'pimmen', 'kirja', 'perja']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }


    public function modal_laporan()
    {
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        $employees = db_connect('sikreta')->table('employees')->get()->getResult();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        return $this->response->setJSON([view('sbk/modal_laporan', ['bulans' => $bulan, 'tahuns' => $tahun, 'employees' => $employees])]);
    }

    public function cetak_laporan()
    {

        if (!$this->validate([
            'bulan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bulan harus diisi',

                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi',

                ]
            ],
            'tanggal_laporan' => [
                'rules' => 'required',

            ],
            'koordinator' => [
                'rules' => 'required',

            ],
            'wakil' => [
                'rules' => 'required',

            ],



        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->back();
        }

        helper('idndate_helper');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $tanggal_laporan = idndate($this->request->getVar('tanggal_laporan'))['tanggal'];
        $koordinator = $this->request->getVar('koordinator');
        $wakil = $this->request->getVar('wakil');

        $koordinator = db_connect('sikreta')->table('employees')->where('id', $koordinator)->get()->getRow();
        $wakil = db_connect('sikreta')->table('employees')->where('id', $wakil)->get()->getRow();



        $bulanArray = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        $data = db_connect('sbk')->table('surveys')->where("month", $bulan)->where("year", $tahun)->get()->getResult();

        $total_sum1 = 0;
        $total_sum2 = 0;
        $total_sum3 = 0;
        foreach ($data as $d) {

            $column = [];
            for ($i = 1; $i <= 10; $i++) {
                $column[] = 'Q' . $i;
            }

            foreach ($d as $key => $value) {

                if (in_array($key, $column)) {
                    $total_sum1 += $value;
                }
            }


            $column = [];
            for ($i = 11; $i <= 15; $i++) {
                $column[] = 'Q' . $i;
            }

            foreach ($d as $key => $value) {

                if (in_array($key, $column)) {
                    $total_sum2 += $value;
                }
            }


            $column = [];
            for ($i = 16; $i <= 32; $i++) {
                $column[] = 'Q' . $i;
            }

            foreach ($d as $key => $value) {

                if (in_array($key, $column)) {
                    $total_sum3 += $value;
                }
            }
        }

        $nilai1 = round($total_sum1 / count($data));
        $nilai2 = round($total_sum2 / count($data));
        $nilai3 = round($total_sum3 / count($data));

        $arrayKeterangan = ['BAGUS-Untuk dipertahankan dan ditingkatkan', 'BELUM BAGUS-Perlu peningkatan (Sosialisasi)', 'KURANG BAGUS-Perlu sosialisasi, pelatihan dan penerapan secara konsisten', 'TIDAK BAGUS-Perlu sosialisasi, pelatihan dan penanganan insentif atau dengan "Law Enforcement"'];

        if ($nilai1 == 10 || $nilai1 == 11) {
            $keterangan1 = $arrayKeterangan[0];
        } elseif ($nilai1 >= 11 || $nilai1 <= 17) {
            $keterangan1 = $arrayKeterangan[1];
        } elseif ($nilai1 >= 18 || $nilai1 <= 27) {
            $keterangan1 = $arrayKeterangan[2];
        } else {
            $keterangan1 = $arrayKeterangan[3];
        }

        if ($nilai2 == 5 || $nilai2 == 6) {
            $keterangan2 = $arrayKeterangan[0];
        } elseif ($nilai2 >= 7 || $nilai2 <= 9) {
            $keterangan2 = $arrayKeterangan[1];
        } elseif ($nilai2 >= 10 || $nilai2 <= 13) {
            $keterangan2 = $arrayKeterangan[2];
        } else {
            $keterangan2 = $arrayKeterangan[3];
        }

        if ($nilai3 >= 17 || $nilai3 <= 20) {
            $keterangan3 = $arrayKeterangan[0];
        } elseif ($nilai3 >= 21 || $nilai3 <= 30) {
            $keterangan3 = $arrayKeterangan[1];
        } elseif ($nilai3 >= 31 || $nilai3 <= 45) {
            $keterangan3 = $arrayKeterangan[2];
        } else {
            $keterangan3 = $arrayKeterangan[3];
        }


        $templateBA = new TemplateProcessor(base_url('template_sbk/template_sbk.docx'));


        $templateBA->setValue('BULAN', strtoupper($bulanArray[$bulan]));
        $templateBA->setValue('TAHUN', $tahun);
        $templateBA->setValue('Nilai I', $nilai1);
        $templateBA->setValue('Nilai II', $nilai2);
        $templateBA->setValue('Nilai III', $nilai3);
        $templateBA->setValue('Keterangan I', $keterangan1);
        $templateBA->setValue('Keterangan II', $keterangan2);
        $templateBA->setValue('Keterangan III', $keterangan3);
        $templateBA->setValue('wakil', $wakil->nama);
        $templateBA->setValue('koordinator', $koordinator->nama);
        $templateBA->setValue('tanggal', $tanggal_laporan);

        $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $this->response->setHeader('Content-Disposition', 'attachment;filename="Hasil-Survey' . time() . '.docx"');
        $pathToSave = 'php://output';
        $templateBA->saveAs($pathToSave);
    }
}
