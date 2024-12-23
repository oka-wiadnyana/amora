<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Ptsp extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        //
    }

    public function data_laporan($level = null)
    {

        return view('ptsp/laporan_ptsp', ['level' => $level]);
    }

    public function data_ptsp_datatable($level = null, $jenis_laporan = null)
    {


        $queryBuilder = db_connect()->table('monev_ptsp a')->select('a.id as id_ptsp,a.*')->where('level', $level)->where('jenis_laporan', $jenis_laporan);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_ptsp . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_ptsp . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_ptsp/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });

        $datatables->only(['bulan', 'tahun', 'tanggal_laporan', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan($level = null)
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('monev_ptsp')->where('id', $id)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('ptsp/modal_laporan', ['bulans' => $bulan, 'tahuns' => $tahun, 'level' => $level, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {
        $level = $this->request->getVar('level');
        if (!$ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'tanggal_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'jenis_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis laporan harus diisi'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('ptsp/data_laporan/' . $level);
            }
        }

        if ($ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'tanggal_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'ext_in[file,pdf]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'jenis_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis laporan harus diisi'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('ptsp/data_laporan/' . $level);
            }
        }



        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $jenis_laporan = $this->request->getVar('jenis_laporan');
        $is_data_exist = db_connect()->table('monev_ptsp')->where('bulan', $bulan)->where('tahun', $tahun)->where('jenis_laporan', $jenis_laporan)->where('level', $level)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('ptsp/data_laporan/' . $level);
            }
        }
        $tanggal_laporan = $this->request->getVar('tanggal_laporan');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-' . $jenis_laporan . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_ptsp', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('bulan', 'tahun', 'tanggal_laporan', 'file', 'jenis_laporan', 'level');
        if (!$ubah) {
            if (db_connect()->table('monev_ptsp')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('ptsp/data_laporan/' . $level);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('ptsp/data_laporan/' . $level);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('monev_ptsp')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('ptsp/data_laporan/' . $level);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('ptsp/data_laporan/' . $level);
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('monev_ptsp')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    public function data_korwasbid()
    {

        return view('ptsp/korwasbid_ptsp');
    }

    public function data_korwasbid_datatable()
    {


        $queryBuilder = db_connect()->table('korwasbid_ptsp a')->select('a.id as id_korwasbid,a.*');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_korwasbid . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_korwasbid . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_korwasbid/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });

        $datatables->only(['bulan', 'tahun', 'tanggal_laporan', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_korwasbid()
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('korwasbid_ptsp')->where('id', $id)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('ptsp/modal_korwasbid', ['bulans' => $bulan, 'tahuns' => $tahun, 'data_laporan' => $data_laporan])]);
    }

    public function insert_korwasbid($ubah = null)
    {
        $level = $this->request->getVar('level');
        if (!$ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'tanggal_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
               

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('ptsp/data_korwasbid');
            }
        }

        if ($ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'tanggal_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'ext_in[file,pdf]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('ptsp/data_korwasbid');
            }
        }



        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
       
        $is_data_exist = db_connect()->table('korwasbid_ptsp')->where('bulan', $bulan)->where('tahun', $tahun)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('ptsp/data_korwasbid');
            }
        }
        $tanggal_laporan = $this->request->getVar('tanggal_laporan');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-Korwasbid-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_korwasbid', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('bulan', 'tahun', 'tanggal_laporan', 'file');
        if (!$ubah) {
            if (db_connect()->table('korwasbid_ptsp')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('ptsp/data_korwasbid');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('ptsp/data_korwasbid');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('korwasbid_ptsp')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('ptsp/data_korwasbid');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('ptsp/data_korwasbid');
            }
        }
    }

    public function hapus_korwasbid()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('korwasbid_ptsp')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }


    // Pengawas
    public function data_pengawas()
    {

        return view('ptsp/pengawas_ptsp');
    }

    public function data_pengawas_datatable()
    {


        $queryBuilder = db_connect()->table('pengawas_ptsp a')->select('a.id as id_pengawas,a.*');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_pengawas . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_pengawas . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_pengawas_ptsp/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });

        $datatables->only(['bulan', 'tahun', 'tanggal_laporan', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_pengawas()
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('pengawas_ptsp')->where('id', $id)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('ptsp/modal_pengawas', ['bulans' => $bulan, 'tahuns' => $tahun, 'data_laporan' => $data_laporan])]);
    }

    public function insert_pengawas($ubah = null)
    {
        $level = $this->request->getVar('level');
        if (!$ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'tanggal_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
               

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('ptsp/data_pengawas');
            }
        }

        if ($ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'tanggal_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'ext_in[file,pdf]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('ptsp/data_pengawas');
            }
        }



        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
       
        $is_data_exist = db_connect()->table('pengawas_ptsp')->where('bulan', $bulan)->where('tahun', $tahun)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('ptsp/data_pengawas');
            }
        }
        $tanggal_laporan = $this->request->getVar('tanggal_laporan');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-Pengawas-PTSP-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_pengawas_ptsp', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('bulan', 'tahun', 'tanggal_laporan', 'file');
        if (!$ubah) {
            if (db_connect()->table('pengawas_ptsp')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('ptsp/data_pengawas');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('ptsp/data_pengawas');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('pengawas_ptsp')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('ptsp/data_pengawas');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('ptsp/data_pengawas');
            }
        }
    }

    public function hapus_pengawas()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('pengawas_ptsp')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    
}
