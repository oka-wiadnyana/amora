<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Audio extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('audio/daftar');
    }
    public function data_datatable()
    {


        $queryBuilder = db_connect()->table('audios');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_audio/' . $value) . '" target="_blank"><span class="mdi mdi-music-circle text-success h2"></span></a>';
            return $btn;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });

        $datatables->only(['nama_audio', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_tambah()
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('audios')->where('id', $id)->get()->getRowArray();


        return $this->response->setJSON([view('audio/modal_tambah', ['data' => $data])]);
    }

    public function insert($ubah = null)
    {

        if (!$ubah) {
            if (!$this->validate([


                'nama_audio' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama audio harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,mp3,wav,aac,wma,flac,ogg,pcm]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ]


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('audio');
            }
        }

        if ($ubah) {
            if (!$this->validate([

                'nama_audio' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama audio harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'ext_in[file,mp3,wav,aac,wma,flac,ogg,pcm]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('audio');
            }
        }



        $nama_audio = $this->request->getVar('nama_audio');

        $file_audio = $this->request->getFile('file');
        if ($file_audio->isValid()) {

            $file = 'audio-' . time() . '.' . $file_audio->guessExtension();
            $file_audio->move('file_audio', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('nama_audio', 'file');
        if (!$ubah) {
            if (db_connect()->table('audios')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('audio');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('audio');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('audios')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('audio');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('audio');
            }
        }
    }

    public function hapus()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('audios')->where('id', $id)->get()->getRow();

        if (file_exists(ROOTPATH . 'public/file_audio/' . $file->file)) {
            unlink('file_audio/' . $file->file);
        }

        if (db_connect()->table('audios')->where('id', $id)->delete()) {

            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
