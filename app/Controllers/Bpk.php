<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Bpk extends BaseController
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

    public function data_laporan()
    {

        return view('bpk/laporan_bpk');
    }

    public function data_bpk_datatable($jenis_laporan = null)
    {


        $queryBuilder = db_connect()->table('bpk a')->where('jenis_laporan', $jenis_laporan);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_bpk/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });

        $datatables->only(['tahun', 'tanggal_laporan', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan()
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('bpk')->where('id', $id)->get()->getRowArray();

        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('bpk/modal_laporan', ['tahuns' => $tahun, 'data_laporan' => $data_laporan])]);
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
                'jenis_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis laporan harus diisi'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('bpk/data_laporan');
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
                'jenis_laporan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis laporan harus diisi'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('bpk/data_laporan');
            }
        }



        $tahun = $this->request->getVar('tahun');
        $jenis_laporan = $this->request->getVar('jenis_laporan');
        $is_data_exist = db_connect()->table('bpk')->where('tahun', $tahun)->where('jenis_laporan', $jenis_laporan)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('bpk/data_laporan');
            }
        }
        $tanggal_laporan = $this->request->getVar('tanggal_laporan');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-' . $jenis_laporan . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_bpk', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('tahun', 'tanggal_laporan', 'file', 'jenis_laporan');
        if (!$ubah) {
            if (db_connect()->table('bpk')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('bpk/data_laporan');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('bpk/data_laporan');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('bpk')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('bpk/data_laporan');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('bpk/data_laporan');
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('bpk')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
