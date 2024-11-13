<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Dokumenrapat extends BaseController
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

        return view('dokumenrapat/daftar_dokumen');
    }

    public function data_dokumenrapat_datatable($jenis_dokumen = null)
    {


        $queryBuilder = db_connect()->table('dokumen_rapat')->where('jenis_dokumen', $jenis_dokumen);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $btn = '<a href="' . base_url('file_dokumen_rapat/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
            return $btn;
        });
        $datatables->format('lampiran', function ($value, $row) {

            $btn = $value ? '<a href="' . base_url('file_dokumen_rapat/lampiran/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>' : "";
            return $btn;
        });

        $datatables->format('bulan', function ($value, $row) {
            $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

            return $bulan[$value];
        });

        $datatables->only(['bulan', 'tahun', 'tanggal_dokumen', 'nama_dokumen', 'file', 'lampiran']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan()
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('dokumen_rapat')->where('id', $id)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('dokumenrapat/modal_laporan', ['bulans' => $bulan, 'tahuns' => $tahun, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {

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
                return redirect()->to('dokumenrapat/daftar_dokumen');
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
                return redirect()->to('dokumenrapat/daftar_dokumen');
            }
        }

        $jenis_dokumen = $this->request->getVar('jenis_dokumen');
        $nama_dokumen = $this->request->getVar('nama_dokumen');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $tanggal_dokumen = $this->request->getVar('tanggal_dokumen');
        $file_doc = $this->request->getFile('file');
        $file_lampiran = $this->request->getFile('lampiran');
        // dd($file_lampiran->isValid());

        if ($jenis_dokumen == 'lainnya') {
            if (!$nama_dokumen) {
                session()->setFlashdata('validasi', ['Nama Dokumen harus diisi']);
                return redirect()->to('dokumenrapat/daftar_dokumen');
            }
        }

        $bulan_array = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        if ($jenis_dokumen == 'rapat_bulanan') {
            $nama_dokumen = 'Rapat Bulanan bulan ' . $bulan_array[$bulan] . ' ' . $tahun;
        }

        if ($jenis_dokumen == 'monev_tl') {
            $nama_dokumen = 'Rapat Monev Tindak Lanjut bulan ' . $bulan_array[$bulan] . ' ' . $tahun;
        }
        if ($jenis_dokumen == 'pimpinan') {
            $nama_dokumen = 'Rapat Pimpinan bulan ' . $bulan_array[$bulan] . ' ' . $tahun;
        }
        if ($jenis_dokumen == 'hakim') {
            $nama_dokumen = 'Rapat Hakim bulan ' . $bulan_array[$bulan] . ' ' . $tahun;
        }


        $is_data_exist = db_connect()->table('dokumen_rapat')->where('bulan', $bulan)->where('tahun', $tahun)->where('jenis_dokumen', 'rapat_bulanan')->where('jenis_dokumen', 'monev_kinerja')->get()->getRowArray();
        if (!$ubah) {

            if ($is_data_exist) {
                session()->setFlashdata('validasi', ['Data sudah ada']);
                return redirect()->to('dokumenrapat/daftar_dokumen');
            }
        }

        if ($file_doc->isValid()) {

            $file = 'File-' . $jenis_dokumen . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_dokumen_rapat', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        if ($file_lampiran->isValid()) {

            $lampiran = 'Lampiran-' . $jenis_dokumen . '-' . time() . '.' . $file_lampiran->guessExtension();
            $file_lampiran->move('file_dokumen_rapat/lampiran', $lampiran);
            //  dd($lampiran);
        } else {
            $lampiran = $this->request->getVar('lampiran_lama');
        }



        $data_insert = !$lampiran ? compact('bulan', 'tahun', 'tanggal_dokumen', 'nama_dokumen', 'file', 'jenis_dokumen') : compact('bulan', 'tahun', 'tanggal_dokumen', 'nama_dokumen', 'file', 'lampiran', 'jenis_dokumen');

        if (!$ubah) {
            if (db_connect()->table('dokumen_rapat')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('dokumenrapat/daftar_dokumen');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to('dokumenrapat/daftar_dokumen');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('dokumen_rapat')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('dokumenrapat/daftar_dokumen');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
                return redirect()->to('dokumenrapat/daftar_dokumen');
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('dokumen_rapat')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }
}
