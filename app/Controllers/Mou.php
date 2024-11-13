<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Mou extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('mou/daftar');
    }
    public function data_datatable()
    {


        $queryBuilder = db_connect()->table('mous');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_mou/' . $value) . '" target="_blank"><span class="mdi mdi-file-arrow-up-down text-danger h2"></span></a>';
            return $btn;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });

        $datatables->only(['nama_mou', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_tambah()
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('mous')->where('id', $id)->get()->getRowArray();


        return $this->response->setJSON([view('mou/modal_tambah', ['data' => $data])]);
    }

    public function insert($ubah = null)
    {

        if (!$ubah) {
            if (!$this->validate([


                'nama_mou' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama mou harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,pdf,docx,doc,rtf]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ]


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('mou');
            }
        }

        if ($ubah) {
            if (!$this->validate([

                'nama_mou' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama mou harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'ext_in[file,pdf,docx,doc,rtf]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('mou');
            }
        }



        $nama_mou = $this->request->getVar('nama_mou');

        $file_mou = $this->request->getFile('file');
        if ($file_mou->isValid()) {

            $file = 'mou-' . time() . '.' . $file_mou->guessExtension();
            $file_mou->move('file_mou', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('nama_mou', 'file');
        if (!$ubah) {
            if (db_connect()->table('mous')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('mou');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('mou');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('mous')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('mou');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('mou');
            }
        }
    }

    public function hapus()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('mous')->where('id', $id)->get()->getRow();

        if (file_exists(ROOTPATH . 'public/file_mou/' . $file->file)) {
            unlink('file_mou/' . $file->file);
        }

        if (db_connect()->table('mous')->where('id', $id)->delete()) {

            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
