<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Suratkeputusan extends BaseController
{
    private $validation;
    private $client;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->client = \Config\Services::curlrequest();
    }

    public function index()
    {
        //
    }

    public function daftar_surat_keputusan()
    {
        $data_surat_keputusan = db_connect()->table('surat_keputusan')->get()->getResultArray();
        return view('sk/daftar_sk', ['data' => $data_surat_keputusan]);
    }

    public function data_sk_datatable()
    {


        $queryBuilder = db_connect()->table('surat_keputusan')->orderBy('tanggal_sk','desc');


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {
            if (session()->get('level') == "administrator" || session()->get('level') == "ketua" || session()->get('level') == "wakil" || session()->get('level') == "sekretaris" || session()->get('level') == "ortala") {
                $button = '<a href="" data-id="' . $row->id . '" class="btn btn-info btn-ubah">Ubah</a> <a href="" data-id="' . $row->id . '" class="btn btn-danger btn-hapus">Hapus</a> <a href="' . base_url("suratkeputusan/download/" . $row->file_sk) . '" class="btn btn-success" target="_blank">Download</a>';
            } else {
                $button = '<a href="' . base_url("suratkeputusan/download/" . $row->file_sk) . '" class="btn btn-success" target="_blank">Download</a>';
            }


            return $button;
        });


        $datatables->only(['nomor_sk', 'perihal_sk', 'tanggal_sk', 'penandatangan', 'keterangan']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_sk()
    {
        $id = $this->request->getVar('id');
        $data_sk = db_connect()->table('surat_keputusan')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('sk/modal_sk', ['data_sk' => $data_sk])]);
    }

    public function upload_sk($ubah = null)
    {
        if (!$ubah) {
            if (!$this->validate([
                'file_sk' => [
                    'rules' => 'uploaded[file_sk]|ext_in[file_sk,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nomor_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor SK  harus diisi',

                    ]
                ],
                'perihal_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tentang SK  harus diisi',

                    ]
                ],

                'tanggal_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal SK harus diisi',

                    ]
                ],
                'penandatangan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Penandatangan  harus diisi',

                    ]
                ],

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('suratkeputusan/daftar_surat_keputusan'));
            }
        } else {
            if (!$this->validate([
                'file_sk' => [
                    'rules' => 'ext_in[file_sk,pdf]',
                    'errors' => [
                        'uploaded' => 'File harus diupload',
                        'ext_in' => 'Jenis file salah'
                    ]
                ],
                'nomor_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor SK apm harus diisi',

                    ]
                ],
                'perihal_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tentang SK apm harus diisi',

                    ]
                ],
                'tanggal_sk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal SK harus diisi',

                    ]
                ],
                'penandatangan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Penandatangan apm harus diisi',

                    ]
                ],

            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to(base_url('suratkeputusan/daftar_surat_keputusan'));
            }
        }



        $nomor_sk = $this->request->getVar('nomor_sk');
        $perihal_sk = $this->request->getVar('perihal_sk');
        $penandatangan = $this->request->getVar('penandatangan');
        $tanggal_sk = $this->request->getVar('tanggal_sk');
        $keterangan = $this->request->getVar('keterangan');
        $file_lama = $this->request->getVar('file_lama');
        $id = $this->request->getVar('id');

        $file_sk = $this->request->getFile('file_sk');
        // dd($file_sk->getError() != 4);
        if ($file_sk->getError() != 4) {
            $file_name = explode('/', $nomor_sk);
            $file_name = implode('_', $file_name) . '.' . $file_sk->guessExtension();
            // dd($file_name);

            if (file_exists(ROOTPATH . '/public/sk/' . $file_name)) {
                unlink(ROOTPATH . '/public/sk/' . $file_name);
            }
            $file_sk->move('sk', $file_name);
        } else {
            $file_name = $file_lama;
        }

        if (!$ubah) {
            if (db_connect()->table('surat_keputusan')->insert(['nomor_sk' => $nomor_sk, 'perihal_sk' => $perihal_sk, 'tanggal_sk' => $tanggal_sk, 'penandatangan' => $penandatangan, 'keterangan' => $keterangan, 'file_sk' => $file_name])) {
                $pesan = urlencode("Surat Keputusan Nomor : " . $nomor_sk . ", tanggal :" . $tanggal_sk . ", perihal : " . $perihal_sk . " telah diupload, silahkan cek di Aplikasi AMORA");
                $resp_message = "Data berhasil diinput";

                try {

                    $response = $this->client->request('GET', "http://192.168.50.250:3000/send-message-group/6285731112240-1517381276@g.us/" . $pesan);

                    if ($response->getStatusCode() == 200) {

                        $resp_message .= ", WA berhasil terkirim";
                    } else {
                        $resp_message .= ", WA gagal terkirim";
                    }
                } catch (\Exception $e) {

                    $resp_message .= ", WA gagal terkirim";
                }
                session()->setFlashdata('success', $resp_message);
                return redirect()->to(base_url('suratkeputusan/daftar_surat_keputusan'));
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
                return redirect()->to(base_url('suratkeputusan/daftar_surat_keputusan'));
            }
        } else {
            if (db_connect()->table('surat_keputusan')->where('id', $id)->update(['nomor_sk' => $nomor_sk, 'perihal_sk' => $perihal_sk, 'penandatangan' => $penandatangan, 'keterangan' => $keterangan, 'tanggal_sk' => $tanggal_sk, 'file_sk' => $file_name])) {
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->to(base_url('suratkeputusan/daftar_surat_keputusan'));
            } else {
                session()->setFlashdata('validasi', ['Data gagal diubah']);
                return redirect()->to(base_url('suratkeputusan/daftar_surat_keputusan'));
            }
        }
    }

    public function download($file = null)
    {
        return $this->response->download('sk/' . $file, null);
    }

    public function hapus_sk()
    {
        $id = $this->request->getVar('id');
        $file = db_connect()->table('surat_keputusan')->where('id', $id)->get()->getRowArray()['file_sk'];
        if (file_exists(ROOTPATH . '/public/sk/' . $file)) {
            unlink(ROOTPATH . '/public/sk/' . $file);
        }
        db_connect()->table('surat_keputusan')->where('id', $id)->delete();
        return $this->response->setJSON(['msg' => 'success']);
    }
}
