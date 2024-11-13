<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class StandarPelayanan extends BaseController
{
    public $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        //
    }

    public function daftar_standar_pelayanan($bagian = null)
    {

        $data = db_connect()->table('standar_pelayanan a')->select('a.id id_standar_pelayanan,a.*')->where('bagian', $bagian)->get()->getResultArray();
        return view('standar_pelayanan/daftar_standar_pelayanan', ['bagian' => $bagian, 'data' => $data]);
    }

    public function modal_standar_pelayanan($bagian = null)
    {

        $id = $this->request->getVar('id');
        $data_standar_pelayanan = db_connect()->table('standar_pelayanan')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('standar_pelayanan/modal_standar_pelayanan', ['bagian' => $bagian, 'data_standar_pelayanan' => $data_standar_pelayanan])]);
    }

    public function upload_standar_pelayanan($ubah = null)
    {
        $bagian = $this->request->getVar('bagian');
        if (!$ubah) {
            if (!$this->validate([
                'file_standar_pelayanan' => [
                    'rules' => 'uploaded[file_standar_pelayanan]|ext_in[file_standar_pelayanan,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nama_standar_pelayanan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama standar_pelayanan apm harus diisi',

                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $bagian));
            }
        } else {
            if (!$this->validate([
                'file_standar_pelayanan' => [
                    'rules' => 'ext_in[file_standar_pelayanan,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nama_standar_pelayanan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'nama standar_pelayanan harus diisi',

                    ]
                ],

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $bagian));
            }
        }



        $nama_standar_pelayanan = $this->request->getVar('nama_standar_pelayanan');
        $nomor_standar_pelayanan = $this->request->getVar('nomor_standar_pelayanan');
        // $bagian = $this->request->getVar('bagian');
        $file_lama = $this->request->getVar('file_lama');
        $id = $this->request->getVar('id');


        $file_standar_pelayanan = $this->request->getFile('file_standar_pelayanan');
        // dd($file_standar_pelayanan->getError() != 4);
        if ($file_standar_pelayanan->getError() != 4) {
            $file_name = preg_replace('/\/|\s/', "_", $nama_standar_pelayanan);
            $file_name = preg_replace('/\(|\)/', "", $file_name);
            $file_name = $file_name . '.' . $file_standar_pelayanan->guessExtension();

            if (file_exists(ROOTPATH . '/public/standar_pelayanan/' . $file_name)) {
                unlink(ROOTPATH . '/public/standar_pelayanan/' . $file_name);
            }
            $file_standar_pelayanan->move('standar_pelayanan', $file_name);
        } else {
            $file_name = $file_lama;
        }

        if (!$ubah) {
            if (db_connect()->table('standar_pelayanan')->insert(['nama_standar_pelayanan' => $nama_standar_pelayanan,  'bagian' => $bagian, 'file_standar_pelayanan' => $file_name])) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $bagian));
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $bagian));
            }
        } else {
            if (db_connect()->table('standar_pelayanan')->where('id', $id)->update(['nama_standar_pelayanan' => $nama_standar_pelayanan,   'bagian' => $bagian, 'file_standar_pelayanan' => $file_name])) {
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $bagian));
            } else {
                session()->setFlashdata('validasi', ['Data gagal diubah']);
                return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $bagian));
            }
        }
    }

    public function download($file = null)
    {
        return $this->response->download('standar_pelayanan/' . $file, null);
    }

    public function hapus_standar_pelayanan()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('standar_pelayanan')->where('id', $id)->get()->getRowArray()['file_standar_pelayanan'];
        if ($file != "" && $file != null && file_exists(ROOTPATH . '/public/standar_pelayanan/' . $file)) {
            unlink(ROOTPATH . '/public/standar_pelayanan/' . $file);
        }
        db_connect()->table('standar_pelayanan')->where('id', $id)->delete();
        return $this->response->setJSON(['msg' => 'success']);
    }

    public function modal_import($level = null)
    {
        $id_bagian = db_connect()->table('bagian')->where('level', $level)->get()->getRowArray();
        return $this->response->setJSON([view('standar_pelayanan/modal_import', ['id_bagian' => $id_bagian['id'], 'level' => $level])]);
    }

    public function import_excel()
    {
        $level = $this->request->getVar('level');
        if (!$this->validate([
            'file_excel' => [
                'rules' => 'uploaded[file_excel]|ext_in[file_excel,xlsx]',
                'errors' => [
                    'uploaded' => 'File harus diupload'
                ]
            ]
        ])) {

            session()->setFlashdata('validasi', ['Data gagal diubah']);
            return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $level));
        }

        $id_bagian = $this->request->getVar('id_bagian');
        $file = $this->request->getFile('file_excel');
        $file_name = 'standar_pelayanan-' . $level . '-' . time() . '.' . $file->guessExtension();
        $file->move('raw_file', $file_name);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(ROOTPATH . 'public/raw_file/' . $file_name);

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();

        // dd($data);
        db_connect()->table('standar_pelayanan')->truncate();
        $jml_data = 0;
        foreach ($data as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $data_insert = [

                'nama_standar_pelayanan' => $value[1],
                'nomor_standar_pelayanan' => $value[2],
                'bagian' => $id_bagian,

            ];

            db_connect()->table('standar_pelayanan')->insert($data_insert);
            $jml_data++;
        }

        if (db_connect()->affectedRows()) {
            session()->setFlashdata('success', 'Berhasil import');
            return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $level));
        } else {
            session()->setFlashdata('validasi', ['Gagal import']);
            return redirect()->to(base_url('standar_pelayanan/daftar_standar_pelayanan/' . $level));
        }
    }
}
