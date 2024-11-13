<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Hawasbid extends BaseController
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
        $data_bagian = $level!="ptsp" ? db_connect()->table('bagian')->where('level', $level)->get()->getRowArray() : ['nama_bagian' => "ptsp"];
        return view('hawasbid/laporan_hawasbid', ['level' => $level, 'data_bagian' => $data_bagian]);
    }

    public function data_hawasbid_datatable($level = null, $jenis_laporan = null)
    {


        if($level!="ptsp"){

            $queryBuilder = db_connect()->table('hawasbid a')->select('a.id as id_hawasbid,a.*,b.*')->join('bagian b', 'a.sub_unit=b.level')->where('level', $level)->where('jenis_laporan', $jenis_laporan)->orderBy('tanggal_laporan', 'desc');
        }else {
            $queryBuilder = db_connect()->table('hawasbid a')->select('a.id as id_hawasbid,a.*')->where('sub_unit', $level)->where('jenis_laporan', $jenis_laporan)->orderBy('tanggal_laporan', 'desc');
        }


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_hawasbid . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_hawasbid . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_hawasbid/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });

        $datatables->only(['bulan', 'tahun', 'tanggal_laporan', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan($level = null)
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('hawasbid')->where('id', $id)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('hawasbid/modal_laporan', ['bulans' => $bulan, 'tahuns' => $tahun, 'level' => $level, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {
        $sub_unit = $this->request->getVar('level');
        if (!$ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
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
                return redirect()->to('hawasbid/data_laporan/' . $sub_unit);
            }
        }

        if ($ubah) {
            if (!$this->validate([
                'bulan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bulan harus diisi'
                    ]
                ],
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
                return redirect()->to('hawasbid/data_laporan/' . $sub_unit);
            }
        }



        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $jenis_laporan = $this->request->getVar('jenis_laporan');
        $is_data_exist = db_connect()->table('hawasbid')->where('bulan', $bulan)->where('tahun', $tahun)->where('sub_unit', $sub_unit)->where('jenis_laporan', $jenis_laporan)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('hawasbid/data_laporan/' . $sub_unit);
            }
        }
        $tanggal_laporan = $this->request->getVar('tanggal_laporan');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-' . $jenis_laporan . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_hawasbid', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('bulan', 'tahun', 'tanggal_laporan', 'file', 'jenis_laporan', 'sub_unit');
        if (!$ubah) {
            if (db_connect()->table('hawasbid')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('hawasbid/data_laporan/' . $sub_unit);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('hawasbid/data_laporan/' . $sub_unit);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('hawasbid')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('hawasbid/data_laporan/' . $sub_unit);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('hawasbid/data_laporan/' . $sub_unit);
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('hawasbid')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
