<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Sop extends BaseController
{
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        //
    }

    public function daftar_sop($bagian = null)
    {
        $nama_bagian = db_connect()->table('bagian')->where('level', $bagian)->get()->getRowArray();
        $data = db_connect()->table('sop a')->select('a.id id_sop,a.*,b.*')->join('bagian b', 'a.bagian=b.id', 'left')->where('level', $bagian)->get()->getResultArray();
        return view('sop/daftar_sop', ['bagian' => $nama_bagian, 'data' => $data]);
    }

    public function modal_sop($level = null)
    {
        $nama_bagian = db_connect()->table('bagian')->get()->getResultArray();
        $id = $this->request->getVar('id');
        $data_sop = db_connect()->table('sop')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('sop/modal_sop', ['level' => $level, 'bagian' => $nama_bagian, 'data_sop' => $data_sop])]);
    }

    public function upload_sop($ubah = null)
    {
        $level = $this->request->getVar('level');
        if (!$ubah) {
            if (!$this->validate([
                'file_sop' => [
                    'rules' => 'uploaded[file_sop]|ext_in[file_sop,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nama_sop' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama sop apm harus diisi',

                    ]
                ]

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('sop/daftar_sop/' . $level));
            }
        } else {
            if (!$this->validate([
                'file_sop' => [
                    'rules' => 'ext_in[file_sop,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nama_sop' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'nama sop harus diisi',

                    ]
                ],

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErros());
                return redirect()->to(base_url('sop/daftar_sop/' . $level));
            }
        }



        $nama_sop = $this->request->getVar('nama_sop');
        $nomor_sop = $this->request->getVar('nomor_sop');
        // $bagian = $this->request->getVar('bagian');
        $file_lama = $this->request->getVar('file_lama');
        $id = $this->request->getVar('id');
        $id_level = db_connect()->table('bagian')->where('level', $level)->get()->getRowArray();

        $file_sop = $this->request->getFile('file_sop');
        // dd($file_sop->getError() != 4);
        if ($file_sop->getError() != 4) {
            $file_name = preg_replace('/\/|\s/', "_", $nama_sop);
            $file_name = preg_replace('/\(|\)/', "", $file_name);
            $file_name = $file_name . '.' . $file_sop->guessExtension();

            if (file_exists(ROOTPATH . '/public/sop/' . $file_name)) {
                unlink(ROOTPATH . '/public/sop/' . $file_name);
            }
            $file_sop->move('sop', $file_name);
        } else {
            $file_name = $file_lama;
        }

        if (!$ubah) {
            if (db_connect()->table('sop')->insert(['nama_sop' => $nama_sop, 'nomor_sop' => $nomor_sop, 'bagian' => $id_level['id'], 'file_sop' => $file_name])) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to(base_url('sop/daftar_sop/' . $level));
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to(base_url('sop/daftar_sop/' . $level));
            }
        } else {
            if (db_connect()->table('sop')->where('id', $id)->update(['nama_sop' => $nama_sop, 'nomor_sop' => $nomor_sop,  'bagian' => $id_level['id'], 'file_sop' => $file_name])) {
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->to(base_url('sop/daftar_sop/' . $level));
            } else {
                session()->setFlashdata('validasi', ['Data gagal diubah']);
                return redirect()->to(base_url('sop/daftar_sop/' . $level));
            }
        }
    }

    public function download($file = null)
    {
        return $this->response->download('sop/' . $file, null);
    }

    public function hapus_sop()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('sop')->where('id', $id)->get()->getRowArray()['file_sop'];
        if ($file != "" && $file != null && file_exists(ROOTPATH . '/public/sop/' . $file)) {
            unlink(ROOTPATH . '/public/sop/' . $file);
        }
        db_connect()->table('sop')->where('id', $id)->delete();
        return $this->response->setJSON(['msg' => 'success']);
    }

    public function modal_import($level = null)
    {
        $id_bagian = db_connect()->table('bagian')->where('level', $level)->get()->getRowArray();
        return $this->response->setJSON([view('sop/modal_import', ['id_bagian' => $id_bagian['id'], 'level' => $level])]);
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
            return redirect()->to(base_url('sop/daftar_sop/' . $level));
        }

        $id_bagian = $this->request->getVar('id_bagian');
        $file = $this->request->getFile('file_excel');
        $file_name = 'SOP-' . $level . '-' . time() . '.' . $file->guessExtension();
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
        db_connect()->table('sop')->truncate();
        $jml_data = 0;
        foreach ($data as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $data_insert = [

                'nama_sop' => $value[1],
                'nomor_sop' => $value[2],
                'bagian' => $id_bagian,

            ];

            db_connect()->table('sop')->insert($data_insert);
            $jml_data++;
        }

        if (db_connect()->affectedRows()) {
            session()->setFlashdata('success', 'Berhasil import');
            return redirect()->to(base_url('sop/daftar_sop/' . $level));
        } else {
            session()->setFlashdata('validasi', ['Gagal import']);
            return redirect()->to(base_url('sop/daftar_sop/' . $level));
        }
    }
}
