<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use Config\Validation;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Akreditasilocal extends BaseController
{
    private $validation;
    private $client;
    public function __construct()
    {

        $this->validation = Services::validation();
        $this->client = Services::curlrequest();
    }

    public function index($area = null)
    {
        $data_apm = db_connect()->table('apm')->get()->getResultArray();
        return view('akreditasilocal/daftar_akreditasi_new', ['data' => $data_apm]);
    }

    public function data_akreditasi_datatable()
    {


        $queryBuilder = db_connect()->table('apm_2023');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a href="' . base_url('akreditasilocal/detail_apm/' . $row->nomor) . '" class="btn btn-warning detail-btn" data-nomor="' . $row->nomor . '">Detail</a>';
            return $btn;
        });

        $datatables->format('uraian', function ($value, $row) {
            $data_apm_fix = [];

            $exploded = preg_split('/\d\./', $value);
            // dd($exploded);
            $uraian_fix = "";
            foreach ($exploded as $key => $value) {
                if ($key == 0) {
                    if ($value == "") {

                        continue;
                    } else {
                        $uraian_fix .= "- " . $value;
                    }
                }
                $uraian_fix .= $key . ". " . $value . '</br>';
            }


            return $uraian_fix;
        });

        $datatables->format('lokasi', function ($value, $row) {
            $lokasi_fix = implode('<br>', explode('-', $value));


            return $lokasi_fix;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });

        $datatables->only(['nomor', 'penilaian', 'uraian', 'kriteria', 'lokasi', 'bobot']);
        // $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function data_detail_datatable($nomor = null, $nomor_sub_apm = null, $tahun = null)
    {


        $queryBuilder = db_connect()->table('dokumen_apm_2023')->where('nomor_apm', $nomor)->where('nomor_sub_apm', $nomor_sub_apm)->where('tahun', $tahun);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });



        // $datatables->format('lokasi', function ($value, $row) {
        //     $lokasi_fix = implode('<br>', explode('-', $value));


        //     return $lokasi_fix;
        // });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });
        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('apm_local_file/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->only(['bulan', 'tahun', 'nama_dokumen', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }



    // public function getDataApm()
    // {
    //     $area = $this->request->getVar('area');

    //     if ($area == 'wakil') {
    //         $data_apm = db_connect()->table('apm')->where('area', 'WAKIL KETUA')->orWhere('area', 'WAKIL KETUA / MR')->get()->getResultArray();
    //     } else {
    //         $data_apm = db_connect()->table('apm')->where('area', $area)->get()->getResultArray();
    //     }
    //     // $data_apm = db_connect()->table('apm')->where('area', 'KETUA')->get()->getResultArray();

    //     $data_apm_fix = [];
    //     foreach ($data_apm as $d) {

    //         $exploded = preg_split('/\d\./', $d['uraian']);
    //         // dd($exploded);
    //         $uraian_fix = "";
    //         foreach ($exploded as $key => $value) {
    //             if ($key == 0) {
    //                 if ($value == "") {

    //                     continue;
    //                 } else {
    //                     $uraian_fix .= "- " . $value;
    //                 }
    //             }
    //             $uraian_fix .= $key . ". " . $value . '</br>';
    //         }

    //         $data_apm_fix[] = ['id' => $d['id'], 'nomor' => $d['nomor'], 'area' => $d['area'], 'penilaian' => $d['penilaian'], 'bobot' => $d['bobot'], 'area_zi' => $d['area_zi'], 'uraian' => $uraian_fix];
    //     }

    //     return $this->response->setJSON($data_apm_fix);
    // }

    public function detail_apm($nomor = null)
    {
        $data_apm = db_connect()->table('apm_2023')->where('nomor', $nomor)->get()->getRowArray();

        $jml_sub = db_connect()->table('apm_sub_2023')->where('nomor', $nomor)->get()->getRowArray();

        return view('akreditasilocal/detail_apm', ['data_apm' => $data_apm, 'jumlah_sub' => $jml_sub['jumlah']]);
    }

    public function tambah_dok_apm()
    {
        $nomor_apm = $this->request->getVar('nomor_apm');
        $file_lama = $this->request->getVar('file_lama');

        if ($file_lama) {
            if (!$this->validate([
                'file' => [
                    'rules' => 'ext_in[file,pdf]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nomor_sub_apm' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor sub apm harus diisi',

                    ]
                ],

                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi',

                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun apm harus diisi',

                    ]
                ],
                'nama_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama dokumen harus diisi',

                    ]
                ]

            ])) {

                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('akreditasilocal/detail_apm/' . $nomor_apm));
            }
        }

        if (!$file_lama) {
            if (!$this->validate([
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nomor_sub_apm' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor sub apm harus diisi',

                    ]
                ],

                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi',

                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun apm harus diisi',

                    ]
                ],
                'nama_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama dokumen harus diisi',

                    ]
                ]

            ])) {

                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('akreditasilocal/detail_apm/' . $nomor_apm));
            }
        }

        $id = $this->request->getVar('id');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $nomor_sub_apm = $this->request->getVar('nomor_sub_apm');
        $nama_dokumen = $this->request->getVar('nama_dokumen');
        $file = $this->request->getFile('file');

        if ($file_lama) {
            $file_name = $file_lama;

            $path = ROOTPATH . 'public/apm_local_file/' . $file_name;

            try {
                $file_exist = new \CodeIgniter\Files\File($path, true);
            } catch (\Exception $e) {
                $file_exist = false;
            }

            if ($file_exist) {
                unlink($path);
            }
        }

        if (!$file_lama) {
            $file_name = $nomor_apm . "-" . $nomor_sub_apm . "-" . $bulan . "-" . $tahun . "." . $file->guessExtension();
        }

        if ($file->isValid()) {

            $file->move('apm_local_file', $file_name);
        }
        $data_insert = [
            'nomor_apm' => $nomor_apm,
            'nomor_sub_apm' => $nomor_sub_apm,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'nama_dokumen' => $nama_dokumen,
            'file' => $file_name,

        ];

        if (!$id) {
            if (db_connect()->table('dokumen_apm_2023')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to(base_url('akreditasilocal/detail_apm/' . $nomor_apm));
            }
        }
        if ($id) {
            if (db_connect()->table('dokumen_apm_2023')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil udpate');
                return redirect()->to(base_url('akreditasilocal/detail_apm/' . $nomor_apm));
            }
        }
    }

    public function hapus_dok_apm()
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('dokumen_apm_2023')->where('id', $id)->get()->getRowArray();

        $path = ROOTPATH . 'public/apm_local_file/' . $data['nama_dokumen'];

        try {
            $file_exist = new \CodeIgniter\Files\File($path, true);
        } catch (\Exception $e) {
            $file_exist = false;
        }

        if ($file_exist) {
            unlink($path);
        }

        if (db_connect()->table('dokumen_apm_2023')->where('id', $id)->delete()) {

            session()->setFlashdata('success', 'Berhasil hapus data');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Gagal hapus data']);
            return $this->response->setJSON(['msg' => 'success']);
        }
    }


    public function modal_tambah()
    {
        $nomor = $this->request->getVar('nomor_apm');
        $id = $this->request->getVar('id');

        if ($id) {

            $data_apm = db_connect()->table('apm_2023 a')->join('dokumen_apm_2023 b', 'a.nomor=b.nomor_apm')->where('b.nomor_apm', $nomor)->where('b.id', $id)->get()->getRowArray();
        }
        if (!$id) {

            $data_apm = db_connect()->table('apm_2023')->where('nomor', $nomor)->get()->getRowArray();
        }
        $jml_sub = db_connect()->table('apm_sub_2023')->where('nomor', $nomor)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];


        return $this->response->setJSON([view('akreditasilocal/modal_tambah', ['data_apm' => $data_apm, 'jml_sub' => $jml_sub['jumlah'], 'bulan' => $bulan, 'id' => $id])]);
    }
    public function modal_upload_doc()
    {
        $id = $this->request->getVar('id');
        $data_apm = db_connect()->table('apm')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('akreditasilocal/modal_upload_doc', ['data' => $data_apm])]);
    }

    public function upload_doc()
    {
        if (!$this->validate([
            'file_apm' => [
                'rules' => 'uploaded[file_apm]|ext_in[file_apm,pdf]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'Jenis file salah'
                ]
            ],
            'nomor_sub_apm' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor sub apm harus diisi',

                ]
            ],

        ])) {
            $msg = implode(', ', $this->validation->getErrors());
            return $this->response->setJSON(['status' => 'invalid', 'msg' => $msg]);
        }


        $area = $this->request->getVar('area');
        $nomor_sub_apm = $this->request->getVar('nomor_sub_apm');
        $nomor_apm = $this->request->getVar('nomor_apm');
        $file_apm = $this->request->getFile('file_apm');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_name = $nomor_apm . "-" . $nomor_sub_apm . "-" . $semester . "-" . $tahun . "." . $file_apm->guessExtension();
        $data_exist = db_connect()->table('link_apm_local')->where('nomor_apm', $nomor_apm)->where('nomor_sub_apm', $nomor_sub_apm)->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();
        if ($data_exist) {
            if ($file_apm->isValid()) {
                unlink(ROOTPATH . 'public/apm_local_file/' . $data_exist['nama_file']);
            }
            if ($file_apm->move('apm_local_file', $file_name)) {

                session()->setFlashdata('success', 'Berhasil update file');
                return redirect()->to(base_url('akreditasilocal/index'));
            } else {
                session()->setFlashdata('validasi', ['Gagal update file']);
                return redirect()->to(base_url('akreditasilocal/index'));
            }
        } else {
            $file_apm->move('apm_local_file', $file_name);
            if (db_connect()->table('link_apm_local')->insert(['area' => $area, 'nomor_apm' => $nomor_apm, 'nomor_sub_apm' => $nomor_sub_apm, 'semester' => $semester, 'tahun' => $tahun,  'nama_file' => $file_name])) {

                session()->setFlashdata('success', 'Berhasil upload data');
                return redirect()->to(base_url('akreditasilocal/index'));
            } else {
                session()->setFlashdata('validasi', ['Gagal upload data']);
                return redirect()->to(base_url('akreditasilocal/index'));
            }
        }
    }


    public function modal_link()
    {
        $nomor_apm = $this->request->getVar('nomor');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $data_apm = db_connect()->table('link_apm_local')->where('nomor_apm', $nomor_apm)->where('semester', $semester)->where('tahun', $tahun)->orderBy('nomor_sub_apm')->get()->getResultArray();
        return $this->response->setJSON([view('akreditasilocal/modal_link', ['data' => $data_apm])]);
    }

    public function modal_preview()
    {

        return $this->response->setJSON([view('akreditasilocal/modal_preview')]);
    }

    public function preview_checklist()
    {
        if (!$this->validate([

            'semester' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Semester harus diisi',

                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi',

                ]
            ],

        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to(base_url('akreditasi'));
        }
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $data_apm = db_connect()->table('apm')->get()->getResultArray();
        $data_apm_fix = [];
        foreach ($data_apm as $d) {

            $exploded = preg_split('/\d\./', $d['uraian']);
            // dd($exploded);
            $uraian_fix = "";
            foreach ($exploded as $key => $value) {
                if ($key == 0) {
                    if ($value == "") {

                        continue;
                    } else {
                        $uraian_fix .= "- " . $value;
                    }
                }
                $uraian_fix .= $key . ". " . $value . '</br>';
            }

            $data_apm_fix[] = ['id' => $d['id'], 'nomor' => $d['nomor'], 'area' => $d['area'], 'penilaian' => $d['penilaian'], 'bobot' => $d['bobot'], 'area_zi' => $d['area_zi'], 'uraian' => $uraian_fix];
        }
        // dd($data_apm_fix);

        return view('akreditasilocal/preview_checklist', ['data_apm' => $data_apm_fix, 'semester' => $semester, 'tahun' => $tahun]);
    }

    public function daftar_assesment_internal()
    {
        $data_ass_internal = db_connect()->table('assesment_internal_local')->get()->getResultArray();
        return view('akreditasilocal/daftar_assesment_internal', ['data' => $data_ass_internal]);
    }

    public function modal_upload_internal()
    {
        $id = $this->request->getVar('id');
        $data_internal = db_connect()->table('assesment_internal_local')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('akreditasilocal/modal_upload_internal', ['data' => $data_internal])]);
    }

    public function upload_ass_internal()
    {
        if (!$this->validate([

            'semester' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Semester harus diisi',

                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi',

                ]
            ],
            'file_internal' => [
                'rules' => 'uploaded[file_internal]|ext_in[file_internal,pdf]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File salah',

                ]
            ],

        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
        }


        $file_internal = $this->request->getFile('file_internal');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_name = $semester . "-" . $tahun . "." . $file_internal->guessExtension();
        $data_exist = db_connect()->table('assesment_internal_local')->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();
        if ($data_exist) {
            if ($file_internal->isValid()) {
                unlink(ROOTPATH . 'public/ass_internal_local_file/' . $data_exist['nama_file']);
            }
            if ($file_internal->move('ass_internal_local_file', $file_name)) {

                session()->setFlashdata('success', 'Berhasil update file');
                return redirect()->to(base_url('akreditasilocal/index'));
            } else {
                session()->setFlashdata('validasi', ['Gagal update file']);
                return redirect()->to(base_url('akreditasilocal/index'));
            }
        } else {
            $file_internal->move('ass_internal_local_file', $file_name);
            if (db_connect()->table('assesment_internal_local')->insert(['semester' => $semester, 'tahun' => $tahun,  'nama_file' => $file_name])) {

                session()->setFlashdata('success', 'Berhasil upload data');
                return redirect()->to(base_url('akreditasilocal/daftar_assesment_internal'));
            } else {
                session()->setFlashdata('validasi', ['Gagal upload data']);
                return redirect()->to(base_url('akreditasilocal/daftar_assesment_internal'));
            }
        }
    }


    public function hapus_internal()
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('assesment_internal_local')->where('id', $id)->get()->getRowArray();

        if (db_connect()->table('assesment_internal_local')->where('id', $id)->delete()) {
            unlink(ROOTPATH . 'public/ass_internal_local_file/' . $data['nama_file']);
            session()->setFlashdata('success', 'Berhasil hapus data');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Gagal hapus data']);
            return $this->response->setJSON(['msg' => 'success']);
        }
    }


    public function daftar_assesment_eksternal()
    {
        $data_ass_eksternal = db_connect()->table('assesment_eksternal_local')->get()->getResultArray();
        return view('akreditasilocal/daftar_assesment_eksternal', ['data' => $data_ass_eksternal]);
    }

    public function modal_upload_eksternal()
    {
        $id = $this->request->getVar('id');
        $data_eksternal = db_connect()->table('assesment_eksternal')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('akreditasilocal/modal_upload_eksternal', ['data' => $data_eksternal])]);
    }

    public function upload_ass_eksternal()
    {
        if (!$this->validate([

            'semester' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Semester harus diisi',

                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi',

                ]
            ],
            'file_eksternal' => [
                'rules' => 'uploaded[file_eksternal]|ext_in[file_eksternal,pdf]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File salah',

                ]
            ],

        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to(base_url('akreditasilocal/daftar_assesment_eksternal'));
        }


        $file_eksternal = $this->request->getFile('file_eksternal');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_name = $semester . "-" . $tahun . "." . $file_eksternal->guessExtension();

        $data_exist = db_connect()->table('assesment_eksternal_local')->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();
        if ($data_exist) {
            if ($file_eksternal->isValid()) {
                unlink(ROOTPATH . 'public/ass_eksternal_local_file/' . $data_exist['nama_file']);
            }
            if ($file_eksternal->move('ass_eksternal_local_file', $file_name)) {

                session()->setFlashdata('success', 'Berhasil update file');
                return redirect()->to(base_url('akreditasilocal/index'));
            } else {
                session()->setFlashdata('validasi', ['Gagal update file']);
                return redirect()->to(base_url('akreditasilocal/index'));
            }
        } else {
            $file_eksternal->move('ass_eksternal_local_file', $file_name);
            if (db_connect()->table('assesment_eksternal_local')->insert(['semester' => $semester, 'tahun' => $tahun,  'nama_file' => $file_name])) {

                session()->setFlashdata('success', 'Berhasil upload data');
                return redirect()->to(base_url('akreditasilocal/daftar_assesment_eksternal'));
            } else {
                session()->setFlashdata('validasi', ['Gagal upload data']);
                return redirect()->to(base_url('akreditasilocal/daftar_assesment_eksternal'));
            }
        }
    }



    public function hapus_eksternal($id = null)
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('assesment_eksternal_local')->where('id', $id)->get()->getRowArray();

        if (db_connect()->table('assesment_eksternal_local')->where('id', $id)->delete()) {
            unlink(ROOTPATH . 'public/ass_eksternal_local_file/' . $data['nama_file']);
            session()->setFlashdata('success', 'Berhasil hapus data');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Gagal hapus data']);
            return $this->response->setJSON(['msg' => 'success']);
        }
    }



    public function import_checklist()
    {
        return view('akreditasilocal/v_import_checklist');
    }

    // 2022
    // public function import_checklist_db()
    // {
    //     $file = $this->request->getFile('file_checklist');
    //     $file_name = "checklist_" . time() . "." . $file->guessExtension();
    //     $file->move('raw_file', $file_name);
    //     # Create a new Xls Reader
    //     $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    //     // Tell the reader to only read the data. Ignore formatting etc.
    //     $reader->setReadDataOnly(true);

    //     // Read the spreadsheet file.
    //     // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
    //     $spreadsheet = $reader->load(ROOTPATH . 'public/raw_file/' . $file_name);

    //     $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
    //     $data = $sheet->toArray();
    //     db_connect()->table('apm')->truncate();
    //     // dd($data);
    //     $jml_data = 0;
    //     foreach ($data as $key => $value) {
    //         if ($key == 0) {
    //             continue;
    //         }

    //         $data_insert = [
    //             'nomor' => $value[0],
    //             'area' => $value[1],
    //             'penilaian' => $value[2],
    //             'uraian' => $value[3],
    //             'area_zi' => $value[4],
    //             'bobot' => $value[5],
    //             'jumlah_sub' => $value[6]
    //         ];

    //         db_connect()->table('apm')->insert($data_insert);
    //         $jml_data++;
    //     }

    //     if (db_connect()->affectedRows()) {
    //         session()->setFlashdata('success', 'Berhasil import');
    //         return redirect()->to(base_url('akreditasi/import_checklist'));
    //     } else {
    //         session()->setFlashdata('validasi', ['Gagal import']);
    //         return redirect()->to(base_url('akreditasi/import_checklist'));
    //     }
    // }


    // 2023
    public function import_checklist_db()
    {
        $file = $this->request->getFile('file_checklist');
        $file_name = "checklist_" . time() . "." . $file->guessExtension();
        $file->move('raw_file', $file_name);
        # Create a new Xls Reader
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(ROOTPATH . 'public/raw_file/' . $file_name);

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();

        db_connect()->table('apm_2023')->truncate();
        db_connect()->table('apm_sub_2023')->truncate();
        // dd($data);
        $jml_data = 0;
        foreach ($data as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $data_insert = [
                'nomor' => $value[0],

                'penilaian' => $value[1],
                'uraian' => $value[2],
                'kriteria' => $value[3],
                'lokasi' => $value[4],
                'bobot' => $value[5]
            ];

            db_connect()->table('apm_2023')->insert($data_insert);
            $jml_data++;

            $jml_sub = array_filter(preg_split('/\d\./', $value[2]));
            // dd($jml_sub);
            db_connect()->table('apm_sub_2023')->insert(['nomor' => $value[0], 'jumlah' => count($jml_sub)]);
        }

        if (db_connect()->affectedRows()) {
            session()->setFlashdata('success', 'Berhasil import');
            return redirect()->to(base_url('akreditasi/import_checklist'));
        } else {
            session()->setFlashdata('validasi', ['Gagal import']);
            return redirect()->to(base_url('akreditasi/import_checklist'));
        }
    }


    public function download_format_checklist()
    {
        return $this->response->download('/raw_file/checklist.xlsx', null);
    }
}
