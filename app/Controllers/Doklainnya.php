<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Doklainnya extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function daftar($bagian = null)
    {
        $unit = db_connect()->table('bagian')->where('level', $bagian)->get()->getRow();
        return view('doklainnya/daftar', ['unit' => $unit]);
    }
    public function data_datatable($unit = null)
    {


        $queryBuilder = db_connect()->table('doklainnya')->where('bagian', $unit);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_doklainnya/' . $value) . '" target="_blank"><span class="mdi mdi-file-arrow-up-down text-danger h2"></span></a>';
            return $btn;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });

        $datatables->only(['nama_dokumen', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_tambah($unit = null)
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('doklainnya')->where('id', $id)->where('bagian', $unit)->get()->getRowArray();


        return $this->response->setJSON([view('doklainnya/modal_tambah', ['data' => $data, 'bagian' => $unit])]);
    }

    public function insert($ubah = null)
    {
        $bagian = $this->request->getVar('bagian');

        if (!$ubah) {
            if (!$this->validate([


                'nama_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Dokumen harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf,docx,doc,rtf,xlsx,xls,jpg,jpeg,png]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ]


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('doklainnya/daftar/' . $bagian);
            }
        }

        if ($ubah) {
            if (!$this->validate([

                'nama_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama dokumen harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'ext_in[file,pdf,docx,doc,rtf,xlsx,xls,jpg,jpeg,png]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('doklainnya/daftar/' . $bagian);
            }
        }



        $nama_dokumen = $this->request->getVar('nama_dokumen');

        $file_doklainnya = $this->request->getFile('file');
        if ($file_doklainnya->isValid()) {

            $file = 'doklainnya-' . time() . '.' . $file_doklainnya->guessExtension();
            $file_doklainnya->move('file_doklainnya', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('nama_dokumen', 'file', 'bagian');
        if (!$ubah) {
            if (db_connect()->table('doklainnya')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('doklainnya/daftar/' . $bagian);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('doklainnya/daftar/' . $bagian);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('doklainnya')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('doklainnya/daftar/' . $bagian);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('doklainnya/daftar/' . $bagian);
            }
        }
    }

    public function hapus()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('doklainnya')->where('id', $id)->get()->getRow();

        if (file_exists(ROOTPATH . 'public/file_doklainnya/' . $file->file)) {
            unlink('file_doklainnya/' . $file->file);
        }

        if (db_connect()->table('doklainnya')->where('id', $id)->delete()) {

            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
