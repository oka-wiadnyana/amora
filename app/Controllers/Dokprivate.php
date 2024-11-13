<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Dokprivate extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function daftar($user = null)
    {
        $user = db_connect()->table('akun')->where('username', $user)->get()->getRow();
        return view('dokprivate/daftar', ['user' => $user]);
    }
    public function data_datatable($user = null)
    {
        $queryBuilder = db_connect()->table('dokprivate')->where('user', $user);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_dokprivate/' . $value) . '" target="_blank"><span class="mdi mdi-file-arrow-up-down text-danger h2"></span></a>';
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

    public function modal_tambah($user = null)
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('dokprivate')->where('id', $id)->where('user', $user)->get()->getRowArray();


        return $this->response->setJSON([view('dokprivate/modal_tambah', ['data' => $data, 'user' => $user])]);
    }

    public function insert($ubah = null)
    {
        $user = $this->request->getVar('user');

        if (!$ubah) {
            if (!$this->validate([


                'nama_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Dokumen harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf,docx,doc,rtf,xlsx,xls]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ]


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('dokprivate/daftar/' . $user);
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
                    'rules' => 'ext_in[file,pdf,docx,doc,rtf,xlsx,xls]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('dokprivate/daftar/' . $user);
            }
        }



        $nama_dokumen = $this->request->getVar('nama_dokumen');

        $file_dokprivate = $this->request->getFile('file');
        if ($file_dokprivate->isValid()) {

            $file = 'dokprivate-' . time() . '.' . $file_dokprivate->guessExtension();
            $file_dokprivate->move('file_dokprivate', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('nama_dokumen', 'file', 'user');
        if (!$ubah) {
            if (db_connect()->table('dokprivate')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('dokprivate/daftar/' . $user);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('dokprivate/daftar/' . $user);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('dokprivate')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('dokprivate/daftar/' . $user);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('dokprivate/daftar/' . $user);
            }
        }
    }

    public function hapus()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('dokprivate')->where('id', $id)->get()->getRow();

        if (file_exists(ROOTPATH . 'public/file_dokprivate/' . $file->file)) {
            unlink('file_dokprivate/' . $file->file);
        }

        if (db_connect()->table('dokprivate')->where('id', $id)->delete()) {

            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
