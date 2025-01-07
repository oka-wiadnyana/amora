<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Aplikasi extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {

        return view('aplikasi/daftar_aplikasi');
    }


    public function data_aplikasi_datatable()
    {


        $queryBuilder = db_connect()->table('aplikasi a')->select('a.id as id_aplikasi,a.*');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_aplikasi . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_aplikasi . '">Hapus</a> <a class="btn btn-success" data-id="' . $row->id_aplikasi . '" href="' . base_url('aplikasi/daftar_monev/' . $row->id_aplikasi) . '">Monev</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_manual_aplikasi/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->format('link', function ($value, $row) {
            $btn = '<a href="' . $value . '" target="_blank" class="btn btn-success">Link</a>';
            return $btn;
        });



        $datatables->only(['nama_aplikasi', 'file', 'penjelasan', 'latar_belakang', 'dampak_langsung', 'link']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function daftar_monev($id)
    {
        $aplikasi = db_connect()->table('aplikasi')->where('id', $id)->get()->getRowArray();

        return view('aplikasi/daftar_monev', ['aplikasi' => $aplikasi]);
    }

    public function data_monev_aplikasi_datatable($id)
    {


        $queryBuilder = db_connect()->table('monev_aplikasi a')->select('a.id as id_monev,a.file as file_monev, a.*,b.*')->join('aplikasi b', 'a.id_aplikasi=b.id', 'left');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_monev . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_monev . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file_monev', function ($value, $row) {
            $btn = '<a href="' . base_url('file_monev_aplikasi/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });



        $datatables->only(['bulan', 'tahun', 'tanggal_laporan', 'file_monev']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_upload($id_aplikasi = null)
    {

        $id_monev = $this->request->getVar('id');
        $data_laporan = db_connect()->table('monev_aplikasi')->where('id', $id_monev)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('aplikasi/modal_upload', ['tahuns' => $tahun, 'bulans' => $bulan, 'id_aplikasi' => $id_aplikasi, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {

        if (!$ubah) {
            if (!$this->validate([

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
                return redirect()->to('aplikasi/daftar_monev/' . $this->request->getVar('id_aplikasi'));
            }
        }

        if ($ubah) {
            if (!$this->validate([

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
                return redirect()->to('aplikasi/data_monev/' . $this->request->getVar('id_aplikasi'));
            }
        }


        $id_aplikasi = $this->request->getVar('id_aplikasi');

        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $tanggal_laporan = $this->request->getVar('tanggal_laporan');

        $is_data_exist = db_connect()->table('monev_aplikasi')->where('tahun', $tahun)->where('bulan', $bulan)->where('id_aplikasi', $id_aplikasi)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('aplikasi/daftar_monev/' . $id_aplikasi);
            }
        }
        $tanggal_dokumen = $this->request->getVar('tanggal_laporan');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-Monev-Aplikasi' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_monev_aplikasi', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('bulan', 'tahun', 'tanggal_laporan', 'file', 'id_aplikasi');
        if (!$ubah) {
            if (db_connect()->table('monev_aplikasi')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('aplikasi/daftar_monev/' . $id_aplikasi);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('aplikasi/daftar_monev/' . $id_aplikasi);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id_monev');
            if (db_connect()->table('monev_aplikasi')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('aplikasi/daftar_monev/' . $id_aplikasi);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('aplikasi/daftar_monev/' . $id_aplikasi);
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('monev_aplikasi')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    public function modal_tambah_aplikasi()
    {
        $id = $this->request->getVar('id');
        $aplikasi = db_connect()->table('aplikasi')->where('id', $id)->get()->getRowArray();

        return $this->response->setJSON([view('aplikasi/modal_tambah', ['id_aplikasi' => $id, 'aplikasi' => $aplikasi])]);
    }

    public function insert_aplikasi($ubah = null)
    {

        if (!$ubah) {
            if (!$this->validate([

                'nama_aplikasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'penjelasan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Penjelasan harus diisi'
                    ]
                ],
                'latar_belakang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Latar belakang harus diisi'
                    ]
                ],
                'dampak_langsung' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dampak harus diisi'
                    ]
                ],
                'link' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Link harus diisi'
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
                return redirect()->to('aplikasi');
            }
        }

        if ($ubah) {
            if (!$this->validate([


                'nama_aplikasi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tahun harus diisi'
                    ]
                ],
                'penjelasan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Penjelasan harus diisi'
                    ]
                ],
                'latar_belakang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Latar belakang harus diisi'
                    ]
                ],
                'dampak_langsung' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dampak harus diisi'
                    ]
                ],
                'link' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Link harus diisi'
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
                return redirect()->to('aplikasi');
            }
        }


        $id_aplikasi = $this->request->getVar('id_aplikasi');
        $nama_aplikasi = $this->request->getVar('nama_aplikasi');
        $penjelasan = $this->request->getVar('penjelasan');
        $latar_belakang = $this->request->getVar('latar_belakang');
        $dampak_langsung = $this->request->getVar('dampak_langsung');
        $link = $this->request->getVar('link');

        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-Manual-Aplikasi' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_manual_aplikasi', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('nama_aplikasi', 'penjelasan', 'file', 'latar_belakang', 'dampak_langsung', 'link');
        if (!$ubah) {
            if (db_connect()->table('aplikasi')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('aplikasi');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('aplikasi');
            }
        }

        if ($ubah) {

            if (db_connect()->table('aplikasi')->where('id', $id_aplikasi)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('aplikasi');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('aplikasi');
            }
        }
    }


    public function hapus_aplikasi()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('aplikasi')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
