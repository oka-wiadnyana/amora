<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Ziarticle extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('ziarticle/daftar');
    }

    public function data_datatable()
    {
        helper('text');


        $queryBuilder = db_connect()->table('ziarticles');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('article', function ($value, $row) {
            $excerpt = excerpt(strip_tags($value), null, 50);
            return $excerpt;
        });
        $datatables->format('nomor_seri', function ($value, $row) {
            $seri = 'Artikel seri-' . $value;
            return $seri;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });

        $datatables->only(['nomor_seri', 'article']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_tambah()
    {
        $id = $this->request->getVar('id');
        $data = db_connect()->table('ziarticles')->where('id', $id)->get()->getRowArray();


        return $this->response->setJSON([view('ziarticle/modal_tambah', ['data' => $data])]);
    }

    public function insert($ubah = null)
    {


        if (!$this->validate([


            'article' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Article harus diisi'
                ]
            ]


        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('ziarticle');
        }

        $article = $this->request->getVar('article');
        if (!$ubah) {
            $old_seri = db_connect()->table('ziarticles')->selectMax('nomor_seri')->get()->getRowArray();


            $nomor_seri = $old_seri['nomor_seri'] ? $old_seri['nomor_seri'] + 1 : 1;
        }



        if (!$ubah) {
            $data_insert = compact('article', 'nomor_seri');
            if (db_connect()->table('ziarticles')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('ziarticle');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('ziarticle');
            }
        }

        if ($ubah) {
            $data_insert = compact('article');
            $id = $this->request->getVar('id');
            if (db_connect()->table('ziarticles')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('ziarticle');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('ziarticle');
            }
        }
    }

    public function hapus()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('ziarticles')->where('id', $id)->get()->getRow();


        if (db_connect()->table('ziarticles')->where('id', $id)->delete()) {

            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
