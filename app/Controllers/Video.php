<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Video extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('video/daftar');
    }
    public function data_datatable()
    {


        $queryBuilder = db_connect()->table('videos');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_video/' . $value) . '" target="_blank"><span class="mdi mdi-video-box text-info h2"></span></a>';
            return $btn;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });

        $datatables->only(['nama_video', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_tambah()
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('videos')->where('id', $id)->get()->getRowArray();


        return $this->response->setJSON([view('video/modal_tambah', ['data' => $data])]);
    }

    public function insert($ubah = null)
    {

        if (!$ubah) {
            if (!$this->validate([


                'nama_video' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama video harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|ext_in[file,mp4,mpg,webm,mkv,gifv,wmv,mov,flv,avi]',
                    'errors' => [
                        'uploaded' => 'File harus  diisi',
                        'ext_in' => 'Jenis file salah'
                    ]
                ]


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('video');
            }
        }

        if ($ubah) {
            if (!$this->validate([

                'nama_video' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama video harus diisi'
                    ]
                ],
                'file' => [
                    'rules' => 'ext_in[file,mp4,mpg,webm,mkv,gifv,wmv,mov,flv,avi]',
                    'errors' => [

                        'ext_in' => 'Jenis file salah'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('video');
            }
        }



        $nama_video = $this->request->getVar('nama_video');

        $file_vid = $this->request->getFile('file');
        if ($file_vid->isValid()) {

            $file = 'Video-' . time() . '.' . $file_vid->guessExtension();
            $file_vid->move('file_video', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('nama_video', 'file');
        if (!$ubah) {
            if (db_connect()->table('videos')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('video');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('video');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('videos')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('video');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('video');
            }
        }
    }

    public function hapus()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('videos')->where('id', $id)->get()->getRow();

        if (file_exists(ROOTPATH . 'public/file_video/' . $file->file)) {
            unlink('file_video/' . $file->file);
        }

        if (db_connect()->table('videos')->where('id', $id)->delete()) {

            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
