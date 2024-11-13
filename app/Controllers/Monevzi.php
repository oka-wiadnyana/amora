<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Monevzi extends BaseController
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

    public function data_monev($kode_area = null)
    {
        $data_area = db_connect()->table('area_zi')->where('kode_area', $kode_area)->get()->getRowArray();
        return view('monevzi/laporan_monev', ['data_area' => $data_area]);
    }

    public function data_monevzi_datatable($kode_area = null, $jenis_dokumen = null)
    {


        $queryBuilder = db_connect()->table('monev_zi a')->select('a.id as id_monev,a.*,b.*')->join('area_zi b', 'a.area_zi=b.kode_area')->where('kode_area', $kode_area)->where('jenis_dokumen', $jenis_dokumen)->orderBy('tanggal_dokumen', 'desc');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_monev . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_monev . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_monev_zi/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });

        $datatables->only(['bulan', 'tahun', 'tanggal_dokumen', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan($kode_area = null)
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('monev_zi')->where('id', $id)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('monevzi/modal_laporan', ['bulans' => $bulan, 'tahuns' => $tahun, 'kode_area' => $kode_area, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {
        $area_zi = $this->request->getVar('kode_area');
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
                'tanggal_dokumen' => [
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
                'jenis_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis laporan harus diisi'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('monevzi/data_monev/' . $area_zi);
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
                'tanggal_dokumen' => [
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
                'jenis_dokumen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis laporan harus diisi'
                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('monevzi/data_monev/' . $area_zi);
            }
        }



        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $jenis_dokumen = $this->request->getVar('jenis_dokumen');
        $is_data_exist = db_connect()->table('monev_zi')->where('bulan', $bulan)->where('tahun', $tahun)->where('jenis_dokumen', $jenis_dokumen)->where('area_zi', $area_zi)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('monevzi/data_monev/' . $area_zi);
            }
        }
        $tanggal_dokumen = $this->request->getVar('tanggal_dokumen');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-' . $jenis_dokumen . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_monev_zi', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('bulan', 'tahun', 'tanggal_dokumen', 'file', 'jenis_dokumen', 'area_zi');
        if (!$ubah) {
            if (db_connect()->table('monev_zi')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('monevzi/data_monev/' . $area_zi);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('monevzi/data_monev/' . $area_zi);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('monev_zi')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('monevzi/data_monev/' . $area_zi);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('monevzi/data_monev/' . $area_zi);
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('monev_zi')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
