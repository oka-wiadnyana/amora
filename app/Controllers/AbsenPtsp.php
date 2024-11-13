<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class AbsenPtsp extends BaseController
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

        return view('absen_ptsp/laporan_absen_ptsp', ['level' => $level]);
    }

    public function data_absen_ptsp_datatable($level = null, $jenis_laporan = null)
    {


        $queryBuilder = db_connect()->table('absen_ptsp a')->select('a.id as id_absen_ptsp,a.*')->where('level', $level)->where('jenis_laporan', $jenis_laporan)->orderBy('tanggal', 'desc');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_absen_ptsp . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_absen_ptsp . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_absen_ptsp/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });

        $datatables->only(['tanggal', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan($level = null)
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('absen_ptsp')->where('id', $id)->get()->getRowArray();


        return $this->response->setJSON([view('absen_ptsp/modal_laporan', ['level' => $level, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {
        $level = $this->request->getVar('level');
        if (!$ubah) {
            if (!$this->validate([

                'tanggal' => [
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
                return redirect()->to('absen_ptsp/data_laporan/' . $level);
            }
        }

        if ($ubah) {
            if (!$this->validate([

                'tanggal' => [
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
                return redirect()->to('absen_ptsp/data_laporan/' . $level);
            }
        }



        $tanggal = $this->request->getVar('tanggal');
        $jenis_laporan = $this->request->getVar('jenis_laporan');
        $is_data_exist = db_connect()->table('absen_ptsp')->where('tanggal', $tanggal)->where('jenis_laporan', $jenis_laporan)->where('level', $level)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('absen_ptsp/data_laporan/' . $level);
            }
        }

        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-' . $jenis_laporan . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_absen_ptsp', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('tanggal', 'file', 'jenis_laporan', 'level');
        if (!$ubah) {
            if (db_connect()->table('absen_ptsp')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('absen_ptsp/data_laporan/' . $level);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('absen_ptsp/data_laporan/' . $level);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('absen_ptsp')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('absen_ptsp/data_laporan/' . $level);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('absen_ptsp/data_laporan/' . $level);
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('absen_ptsp')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
