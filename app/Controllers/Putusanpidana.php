<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Putusanpidana extends BaseController
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

    public function daftar_dokumen()
    {

        return view('putusanpidana/daftar_dokumen');
    }

    public function data_dokumen_datatable()
    {


        $queryBuilder = db_connect('sipp')->table('perkara a')->select('a.perkara_id as id_perkara, c.id as file_id,a.*,b.*,c.*')->join('perkara_putusan b', 'a.perkara_id=b.perkara_id')->join('amora.putusan_pidana c', 'b.perkara_id=c.perkara_id', 'left')->where('tanggal_putusan>', '2023-07-01')->groupStart()->where('alur_perkara_id', 111)->orWhere('alur_perkara_id', 118)->groupEnd()->orderBy('tanggal_putusan', 'desc');

        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning upload-btn" data-id="' . $row->id_perkara . '">Upload</a> ';
            if ($row->nama_file) {
                $btn .= '<a class="btn btn-danger delete-btn" data-id="' . $row->file_id . '">Delete</a> ';
            }
            return $btn;
        });

        $datatables->format('nama_file', function ($value, $row) {
            if ($value) {
                $btn = '<a href="' . base_url('putusan_pidana/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
                return $btn;
            }
        });


        $datatables->only(['nomor_perkara', 'tanggal_putusan',  'nama_file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_upload()
    {
        $id_perkara = $this->request->getVar('id_perkara');
        $data_file = db_connect()->table('putusan_pidana')->where('perkara_id', $id_perkara)->get()->getRowArray();


        return $this->response->setJSON([view('putusanpidana/modal_upload', ['data_file' => $data_file, 'perkara_id' => $id_perkara])]);
    }

    public function insert_putusan($ubah = null)
    {


        if (!$this->validate([

            'nama_file' => [
                'rules' => 'uploaded[nama_file]|ext_in[nama_file,pdf]',
                'errors' => [
                    'uploaded' => 'File harus  diisi',
                    'ext_in' => 'Jenis file salah'
                ]
            ],


        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('putusanpidana/daftar_dokumen');
        }


        $id = $this->request->getVar('id');
        $perkara_id = $this->request->getVar('perkara_id');
        $file_doc = $this->request->getFile('nama_file');


        $nama_file = 'Putusan-Pidana-' . '-' . time() . '.' . $file_doc->guessExtension();
        $file_doc->move('putusan_pidana', $nama_file);

        // $is_data_exist = db_connect()->table('putusan_pidana')->where('perkara_id', $perkara_id)->get()->getRowArray();


        // if ($is_data_exist) {
        //     session()->setFlashdata('validasi', ['Data sudah ada']);
        //     return redirect()->to('dokumenrapat/daftar_dokumen');
        // }




        $data_insert = compact('perkara_id', 'nama_file');
        if (!$ubah) {
            if (db_connect()->table('putusan_pidana')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('putusanpidana/daftar_dokumen');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('putusanpidana/daftar_dokumen');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('putusan_pidana')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('putusanpidana/daftar_dokumen');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('putusanpidana/daftar_dokumen');
            }
        }
    }

    public function hapus_putusan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('putusan_pidana')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
