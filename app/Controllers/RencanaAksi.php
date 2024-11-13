<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class RencanaAksi extends BaseController
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
        return view('rencana_aksi/laporan_monev', ['data_area' => $data_area]);
    }

    public function data_rencana_aksi_datatable($kode_area = null, $jenis_dokumen = null)
    {


        $queryBuilder = db_connect()->table('rencana_aksi a')->select('a.id as id_rencana_aksi,a.*')->where('area_zi', $kode_area);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_rencana_aksi . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_rencana_aksi . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_monev_zi/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });



        $datatables->only(['tahun', 'tanggal_dokumen', 'file']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan($kode_area = null)
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('rencana_aksi')->where('id', $id)->get()->getRowArray();

        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('rencana_aksi/modal_laporan', ['tahuns' => $tahun, 'kode_area' => $kode_area, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {
        $area_zi = $this->request->getVar('kode_area');
        if (!$ubah) {
            if (!$this->validate([

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


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('rencana_aksi/data_monev/' . $area_zi);
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


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('rencana_aksi/data_monev/' . $area_zi);
            }
        }




        $tahun = $this->request->getVar('tahun');

        $is_data_exist = db_connect()->table('rencana_aksi')->where('tahun', $tahun)->where('area_zi', $area_zi)->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('rencana_aksi/data_monev/' . $area_zi);
            }
        }
        $tanggal_dokumen = $this->request->getVar('tanggal_dokumen');
        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-Rencana-Aksi' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_monev_zi', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        $data_insert = compact('tahun', 'tanggal_dokumen', 'file', 'area_zi');
        if (!$ubah) {
            if (db_connect()->table('rencana_aksi')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('rencana_aksi/data_monev/' . $area_zi);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('rencana_aksi/data_monev/' . $area_zi);
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('rencana_aksi')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('rencana_aksi/data_monev/' . $area_zi);
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('rencana_aksi/data_monev/' . $area_zi);
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('rencana_aksi')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
