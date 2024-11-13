<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Review extends BaseController
{
    private $validation;
    private $client;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->client = \Config\Services::curlrequest();
    }
    public function referensi()
    {

        return view('review/referensi');
    }

    public function referensi_datatable()
    {


        $queryBuilder = db_connect('review')->table('services');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href=https://review.pn-negara.info/sp/' . $value  . ' target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });



        $datatables->only(['service_unit', 'service_name', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_referensi()
    {
        $id = $this->request->getVar('id');
        $data_referensi = db_connect('review')->table('services')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('review/modal_referensi', ['data_referensi' => $data_referensi])]);
    }

    public function insert_referensi($ubah = null)
    {
        if (!$ubah) {
            if (!$this->validate([
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'service_unit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Unit  harus diisi',

                    ]
                ],
                'service_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama layanan  harus diisi',

                    ]
                ],


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('review/referensi'));
            }
        } else {
            if (!$this->validate([
                'file' => [
                    'rules' => 'ext_in[file,pdf]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ],

                'service_unit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Unit  harus diisi',

                    ]
                ],
                'service_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama layanan  harus diisi',

                    ]
                ],
            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('review/referensi'));
            }
        }



        $service_unit = $this->request->getVar('service_unit');
        $service_name = $this->request->getVar('service_name');

        $old_file = $this->request->getVar('old_file');
        $id = $this->request->getVar('id');

        $file = $this->request->getFile('file');
        // dd($file_sk->getError() != 4);

        if ($file->getError() != 4) {

            $file_name = time() . '.' . $file->guessExtension();
            $file->move('temp_sp_file', $file_name);

            $post_data = $ubah ? [
                'service_name'      => $service_name,
                'service_unit'      => $service_unit,
                '_method' => 'put',
                'file' => new \CURLFile(ROOTPATH . '/public/temp_sp_file/' . $file_name),
            ] : [
                'service_name'      => $service_name,
                'service_unit'      => $service_unit,

                'file' => new \CURLFile(ROOTPATH . '/public/temp_sp_file/' . $file_name),
            ];
        } else {
            $post_data = $ubah ? [
                'service_name'      => $service_name,
                'service_unit'      => $service_unit,
                '_method' => 'put',
                'old_file' => $old_file,
            ] : [
                'service_name'      => $service_name,
                'service_unit'      => $service_unit,

                'old_file' => $old_file,
            ];
        }

        try {
            if ($ubah) {


                $this->client->request('POST', getenv('REVIEW_API_URL') . '/' . $this->request->getVar('id'), [
                    'multipart' => $post_data,

                    'verify' => false
                ]);
                $message = 'Data berhasil diubah';
            } else {

                $this->client->request('POST', getenv('REVIEW_API_URL'), [
                    'multipart' => $post_data,
                    'verify' => false
                ]);
                $message = 'Data berhasil diupload';
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return redirect()->back()->with('success', $message);
    }


    public function list()
    {

        return view('review/list');
    }

    public function review_datatable()
    {


        $queryBuilder = db_connect('review')->table('reviews a')->select('a.id as id_review,a.*,b.*')->join('services b', 'a.service_id=b.id', 'left');


        $datatables = new DataTables($queryBuilder, '4');
        // $datatables->addColumn('action', function ($row) {

        //     $btn = '<a class="btn btn-warning response-btn" data-id="' . $row->id_input . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_input . '">Hapus</a>';
        //     return $btn;
        // });
        // $datatables->addColumn('evidence', function ($row) {

        //     if ($row->evidence) {

        //         $btn = '<a class="" href="' . getenv('SHANTI_CARE') . $row->evidence . '" data-id="">Evidence</a>';
        //         return $btn;
        //     }
        // });

        $suitabilities = [
            'time_suitability', 'term_suitability', 'cost_suitability', 'complaint_suitability', 'service_hours_suitability'
        ];

        foreach ($suitabilities as $suitability) {
            $datatables->format($suitability, function ($value, $row) use ($suitability) {

                // $arr=(array) $row;
                return $row->$suitability == 1 ? 'Sesuai' : 'Tidak sesuai';
            });
        }


        $datatables->only(['review_date', 'name', 'phone_number', 'service_name', 'time_suitability', 'time_review', 'term_suitability', 'term_review', 'cost_suitability', 'cost_review', 'complaint_suitability', 'complaint_review', 'service_hours_suitability', 'service_hours_review']);
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
        return $this->response->setJSON([view('review/modal_laporan', ['bulans' => $bulan, 'tahuns' => $tahun, 'employees' => $employees])]);
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
            'ketua' => [
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
        $ketua = $this->request->getVar('ketua');
        $koordinator = db_connect('sikreta')->table('employees')->where('id', $koordinator)->get()->getRow();
        $wakil = db_connect('sikreta')->table('employees')->where('id', $wakil)->get()->getRow();

        $ketua = db_connect('sikreta')->table('employees')->where('id', $ketua)->get()->getRow();



        $bulanArray = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        $data = db_connect('review')->table('reviews')->where("MONTH(review_date)", $bulan)->where("YEAR(review_date)", $tahun)->get()->getResult();

        return view('review/laporan', ['bulan' => $bulanArray[$bulan], 'tahun' => $tahun, 'data' => $data, 'tanggal_laporan' => $tanggal_laporan, 'koordinator' => $koordinator, 'wakil' => $wakil, 'ketua' => $ketua]);
    }
}
