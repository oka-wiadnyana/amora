<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pengaturan extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    public function bagian()
    {
        $data_bagian = db_connect()->table('bagian')->get()->getResultArray();

        return view('pengaturan/daftar_bagian', ['data' => $data_bagian]);
    }

    public function modal_bagian()
    {
        $id = $this->request->getVar('id');
        $data_bagian = db_connect()->table('bagian')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('pengaturan/modal_bagian', ['data_bagian' => $data_bagian])]);
    }

    public function insert_bagian($ubah = null)
    {
        $level = $this->request->getVar('level');
        $level_lama = $this->request->getVar('level_lama');
        if (!$ubah) {
            if (!$this->validate([
                'nama_bagian' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama bagian harus diisi'
                    ]
                ],
                'level' => [
                    'rules' => 'required|is_unique[bagian.level]',
                    'errors' => [
                        'required' => 'Level harus diisi',
                        'is_unique' => 'Level sudah ada'
                    ]
                ],
                'is_sub_unit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pilihan sub unit harus diisi',

                    ]
                ]
            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->to('pengaturan/bagian');
            }
        }

        if ($ubah) {
            if ($level != $level_lama) {
                if (!$this->validate([
                    'nama_bagian' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama bagian harus diisi'
                        ]
                    ],
                    'level' => [
                        'rules' => 'required|is_unique[bagian.level]',
                        'errors' => [
                            'required' => 'Level harus diisi',
                            'is_unique' => 'Level sudah ada'
                        ]
                    ],
                    'is_sub_unit' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan sub unit harus diisi',

                        ]
                    ]
                ])) {
                    session()->setFlashdata('validasi', $this->validation->getErrors());
                    return redirect()->to('pengaturan/bagian');
                }
            }
            if ($level == $level_lama) {
                if (!$this->validate([
                    'nama_bagian' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama bagian harus diisi'
                        ]
                    ],
                    'is_sub_unit' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan sub unit harus diisi',

                        ]
                    ]
                ])) {
                    session()->setFlashdata('validasi', $this->validation->getErrors());
                    return redirect()->to('pengaturan/bagian');
                }
            }
        }

        $nama_bagian = $this->request->getVar('nama_bagian');
        $level = $this->request->getVar('level');
        $is_sub_unit = $this->request->getVar('is_sub_unit');
        $id = $this->request->getVar('id');
        // dd($level);
        if ($ubah == 'ubah') {
            if (db_connect()->table('bagian')->where('id', $id)->update(['nama_bagian' => $nama_bagian, 'level' => $level, 'is_sub_unit' => $is_sub_unit])) {
                session()->setFlashdata('success', 'Nama bagian berhasil diubah');
                return redirect()->to('pengaturan/bagian');
            } else {
                session()->setFlashdata('validasi', ['Nama bagian gagal diubah']);
                return redirect()->to('pengaturan/bagian');
            }
        } else {
            if (db_connect()->table('bagian')->insert(['nama_bagian' => $nama_bagian, 'level' => $level, 'is_sub_unit' => $is_sub_unit])) {
                session()->setFlashdata('success', 'Nama bagian berhasil dimasukkan');
                return redirect()->to('pengaturan/bagian');
            } else {
                session()->setFlashdata('validasi', ['Nama bagian gagal dimasukkan']);
                return redirect()->to('pengaturan/bagian');
            }
        }
    }

    public function hapus_bagian()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('bagian')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    public function daftar_google_client()
    {
        $data = db_connect()->table('google_client')->get()->getRowArray();

        return view('pengaturan/daftar_google_client', ['data' => $data]);
    }

    public function insert_gc($ubah = null)
    {

        if (!$this->validate([
            'client_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Client ID harus diisi'
                ]
            ],
            'client_secret' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Client Secret diisi',

                ]
            ]
        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('pengaturan/daftar_google_client');
        }
        $client_id = $this->request->getVar('client_id');
        $client_secret = $this->request->getVar('client_secret');

        // dd($level);
        if ($ubah == 'ubah') {
            if (db_connect()->table('google_client')->update(['client_id' => $client_id, 'client_secret' => $client_secret])) {
                session()->setFlashdata('success', 'GC berhasil diubah');
                return redirect()->to('pengaturan/daftar_google_client');
            } else {
                session()->setFlashdata('validasi', ['GC gagal diubah']);
                return redirect()->to('pengaturan/daftar_google_client');
            }
        } else {
            if (db_connect()->table('google_client')->insert(['client_id' => $client_id, 'client_secret' => $client_secret])) {
                session()->setFlashdata('success', 'GC berhasil dimasukkan');
                return redirect()->to('pengaturan/daftar_google_client');
            } else {
                session()->setFlashdata('validasi', ['GC gagal dimasukkan']);
                return redirect()->to('pengaturan/daftar_google_client');
            }
        }
    }

    public function parent_folder()
    {
        $data = db_connect()->table('parent_folder_akreditasi')->get()->getResultArray();

        return view('pengaturan/parent_folder', ['data' => $data]);
    }

    public function modal_folder()
    {
        $id = $this->request->getVar('id');
        // $data_bagian = db_connect()->table('bagian')->where('id', $id)->get()->getRowArray();

        $data_folder = db_connect()->table('parent_folder_akreditasi')->get()->getResultArray();
        $data_single_folder = db_connect()->table('parent_folder_akreditasi')->where('id', $id)->get()->getRowArray();

        // return $this->response->setJSON([view('pengaturan/modal_bagian', ['data_bagian' => $data_bagian])]);
        return $this->response->setJSON([view('pengaturan/modal_folder', ['data_folder' => $data_folder,  'data_single_folder' => $data_single_folder])]);
    }

    public function insert_folder($ubah = null)
    {

        if (!$this->validate([
            'folder' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Folder harus diisi'
                ]
            ],
            'folder_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Folder ID diisi',

                ]
            ],
            'link_folder' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Link diisi',

                ]
            ]
        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('pengaturan/parent_folder');
        }


        $id = $this->request->getVar('id');
        $folder = $this->request->getVar('folder');
        $folder_id = $this->request->getVar('folder_id');
        $link_folder = $this->request->getVar('link_folder');

        $data_insert = [
            'folder' => $folder,
            'folder_id' => $folder_id,
            'link_folder' => $link_folder,
        ];

        // dd($level);
        if ($ubah == 'ubah') {

            if (db_connect()->table('parent_folder_akreditasi')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->to('pengaturan/parent_folder');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diubah']);
                return redirect()->to('pengaturan/parent_folder');
            }
        } else {
            if (db_connect()->table('parent_folder_akreditasi')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil dimasukkan');
                return redirect()->to('pengaturan/parent_folder');
            } else {
                session()->setFlashdata('validasi', ['Data gagal dimasukkan']);
                return redirect()->to('pengaturan/parent_folder');
            }
        }
    }

    public function hapus_parent()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('parent_folder_akreditasi')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    public function redirect_uri()
    {
        $data = db_connect()->table('redirect_uri_akreditasi')->get()->getResultArray();

        return view('pengaturan/redirect_uri', ['data' => $data]);
    }

    public function modal_uri()
    {
        $id = $this->request->getVar('id');
        // $data_bagian = db_connect()->table('bagian')->where('id', $id)->get()->getRowArray();

        $data_uri = db_connect()->table('redirect_uri_akreditasi')->get()->getResultArray();
        $data_single_uri = db_connect()->table('redirect_uri_akreditasi')->where('id', $id)->get()->getRowArray();

        // return $this->response->setJSON([view('pengaturan/modal_bagian', ['data_bagian' => $data_bagian])]);
        return $this->response->setJSON([view('pengaturan/modal_uri', ['data_uri' => $data_uri,  'data_single_uri' => $data_single_uri])]);
    }

    public function insert_uri($ubah = null)
    {

        if (!$this->validate([
            'method' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Method harus diisi'
                ]
            ],
            'uri' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'URI harus  diisi',

                ]
            ],

        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('pengaturan/redirect_uri');
        }


        $id = $this->request->getVar('id');
        $method = $this->request->getVar('method');
        $uri = $this->request->getVar('uri');


        $data_insert = [
            'method' => $method,
            'uri' => $uri,

        ];

        // dd($level);
        if ($ubah == 'ubah') {

            if (db_connect()->table('redirect_uri_akreditasi')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->to('pengaturan/redirect_uri');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diubah']);
                return redirect()->to('pengaturan/redirect_uri');
            }
        } else {
            if (db_connect()->table('redirect_uri_akreditasi')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil dimasukkan');
                return redirect()->to('pengaturan/redirect_uri');
            } else {
                session()->setFlashdata('validasi', ['Data gagal dimasukkan']);
                return redirect()->to('pengaturan/redirect_uri');
            }
        }
    }

    public function hapus_uri()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('redirect_uri_akreditasi')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    public function daftar_akun()
    {
        $data_akun = db_connect()->table('akun')->select('akun.id as id_akun,akun.*,bagian.*')->join('bagian', 'akun.id_level=bagian.id', 'left')->get()->getResultArray();

        return view('pengaturan/daftar_akun', ['data' => $data_akun]);
    }

    public function modal_akun()
    {
        $id = $this->request->getVar('id');
        $data_akun = db_connect()->table('akun')->select('akun.id as id_akun, akun.*, bagian.*')->join('bagian', 'akun.id_level=bagian.id', 'left')->where('akun.id', $id)->get()->getRowArray();
        $data_bagian = db_connect()->table('bagian')->get()->getResultArray();
        return $this->response->setJSON([view('pengaturan/modal_akun', ['data_akun' => $data_akun, 'bagian' => $data_bagian])]);
    }

    public function insert_akun($ubah = null)
    {
        $id = $this->request->getVar('id');
        $nama = $this->request->getVar('nama');
        $level = $this->request->getVar('level');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $password2 = $this->request->getVar('password2');
        $password_lama = $this->request->getVar('password_lama');
        $username_lama = $this->request->getVar('username_lama');
        $validasi_password = [];
        $validasi_username = "";
        $is_unique = [];
        if ($username == $username_lama) {
            $validasi_username = 'required';
            $is_unique = [];
        }

        if ($username != $username_lama || !$username) {
            $validasi_username = 'required|is_unique[akun.username]';
            $is_unique = ['is_unique' => 'Username sudah ada'];
        }

        if (!$password && $password_lama) {
            $validasi_password = [];
        }


        if ((!$password && !$password_lama) || ($password && $password_lama)) {
            $validasi_password = [
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password harus diisi'
                    ]
                ],
                'password2' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Konfirmasi password harus diisi',
                        'matches' => 'Konfirmasi password tidak sama'
                    ]
                ]
            ];
        }
        if (!$this->validate(array_merge([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama  harus diisi'
                ]
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Level  harus diisi'
                ]
            ],
            'username' => [
                'rules' => $validasi_username,
                'errors' => array_merge([
                    'required' => 'Username harus diisi',
                ], $is_unique)
            ]
        ], $validasi_password))) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('pengaturan/daftar_akun');
        }


        if ($ubah == 'ubah') {
            $password_update = [];
            if ($password) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $password_update = ['password' => $password_hash];
            }

            if (db_connect()->table('akun')->where('id', $id)->update(array_merge(['nama' => $nama, 'id_level' => $level, 'username' => $username], $password_update))) {
                session()->setFlashdata('success', 'Akun berhasil diubah');
                return redirect()->to('pengaturan/daftar_akun');
            } else {
                session()->setFlashdata('validasi', ['Akun gagal diubah']);
                return redirect()->to('pengaturan/daftar_akun');
            }
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if (db_connect()->table('akun')->insert(['nama' => $nama, 'id_level' => $level, 'username' => $username, 'password' => $password_hash])) {
                session()->setFlashdata('success', 'Akun berhasil dimasukkan');
                return redirect()->to('pengaturan/daftar_akun');
            } else {
                session()->setFlashdata('validasi', ['Nama bagian gagal dimasukkan']);
                return redirect()->to('pengaturan/daftar_akun');
            }
        }
    }

    public function hapus_akun()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('akun')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    public function hakim()
    {
        $daftar_hakim = db_connect('sipp')->table('hakim_pn a')->join(env('AMORA_TABLE').'.jabatan b', 'a.id=b.jabatan_hakim_id', 'left')->where('aktif', 'Y')->get()->getResultArray();
        // dd($daftar_hakim);
        return view('pengaturan/daftar_hakim', ['data' => $daftar_hakim]);
    }

    public function modal_jabatan()
    {
        $id = $this->request->getVar('id');
        $daftar_hakim = db_connect('sipp')->table('hakim_pn a')->join('amora.jabatan b', 'a.id=b.jabatan_hakim_id', 'left')->where('id', $id)->get()->getRowArray();
        $jumlah_hakim = db_connect('sipp')->table('hakim_pn a')->join('amora.jabatan b', 'a.id=b.jabatan_hakim_id', 'left')->where('aktif', 'Y')->countAllResults();
        return $this->response->setJSON([view('pengaturan/modal_hakim', ['data_hakim' => $daftar_hakim, 'jumlah_hakim' => $jumlah_hakim])]);
    }

    public function insert_hakim($ubah = null)
    {
        $id = $this->request->getVar('id');
        $urutan = $this->request->getVar('urutan');

        $data_exist = db_connect()->table('jabatan')->where('jabatan_hakim_id', $id)->get()->getRowArray();
        if ($data_exist) {
            if (db_connect()->table('jabatan')->where('jabatan_hakim_id', $id)->update(['urutan' => $urutan])) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('pengaturan/hakim');
            } else {
                session()->setFlashdata('fail', ['Data gagal diupdate']);
                return redirect()->to('pengaturan/hakim');
            }
        } else {
            if (db_connect()->table('jabatan')->insert(['jabatan_hakim_id' => $id, 'urutan' => $urutan])) {
                session()->setFlashdata('success', 'Data berhasil diinput');
                return redirect()->to('pengaturan/hakim');
            } else {
                session()->setFlashdata('fail', ['Data gagal diinput']);
                return redirect()->to('pengaturan/hakim');
            }
        }
    }

    public function ref_monev_bagian($level = null)
    {

        $data_bagian = db_connect()->table('referensi_monev_bagian')->where('bagian', $level)->get()->getResultArray();

        return view('pengaturan/ref_monev_bagian', ['data_bagian' => $data_bagian, 'bagian' => $level]);
    }

    public function modal_ref_monev($bagian = null, $id = null)
    {
        
       $data_ref_monev= db_connect()->table('referensi_monev_bagian')->where('id', $id)->get()->getRowArray();
       
        return $this->response->setJSON([view('pengaturan/modal_ref_monev', ['bagian' => $bagian, 'data_ref_monev' => $data_ref_monev])]);
    }

    public function insert_ref_monev($ubah = null)
    {
        
        $bagian = $this->request->getVar('bagian');
        $id = $this->request->getVar('id');
       
       
        if (!$this->validate([
            'jenis_monev' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama  harus diisi'
                ]
            ]
            
        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('pengaturan/daftar_monev/'.$bagian);
        }

        $jenis_monev = $this->request->getVar('jenis_monev');


        if ($ubah == 'ubah') {
          
            if (db_connect()->table('referensi_monev_bagian')->where('id', $id)->update(['jenis_monev' => $jenis_monev])) {
                session()->setFlashdata('success', 'Jenis Monev berhasil diubah');
                return redirect()->to('pengaturan/daftar_monev/'.$bagian);
            } else {
                session()->setFlashdata('validasi', ['Jenis Monev diubah']);
                return redirect()->to('pengaturan/daftar_monev/'.$bagian);
            }
        } else {
          
            if (db_connect()->table('referensi_monev_bagian')->insert(['jenis_monev' => $jenis_monev, 'bagian' => $bagian])) {
                session()->setFlashdata('success', 'Jenis Monev berhasil dimasukkan');
                return redirect()->to('pengaturan/daftar_monev/'.$bagian);
            } else {
                session()->setFlashdata('validasi', ['Jenis Monev bagian gagal dimasukkan']);
                return redirect()->to('pengaturan/daftar_monev/'.$bagian);
            }
        }
    }
}
