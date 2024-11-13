<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('auth/login_page');
    }

    public function attempt_login()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username harus diisi'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi'
                ]
            ],

        ])) {
            $msg = implode(', ', $this->validation->getErrors());
            session()->setFlashdata('fail', $msg);
            return redirect()->to(base_url('auth'));
        }
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data_user = db_connect()->table('akun')->join('bagian', 'akun.id_level=bagian.id', 'left')->where('username', $username)->get()->getRowArray();

        if ($data_user) {
            if (password_verify($password, $data_user['password'])) {
                session()->set('login', true);
                session()->set('nama', $data_user['nama']);
                session()->set('username', $data_user['username']);
                session()->set('level', $data_user['level']);
                session()->set('nama_bagian', $data_user['nama_bagian']);
                $sub_unit = db_connect()->table('bagian')->where('is_sub_unit', 'Y')->get()->getResultArray();
                session()->set('daftar_sub_unit', $sub_unit);
                $area_zi = db_connect()->table('area_zi')->get()->getResultArray();
                session()->set('area_zi', $area_zi);
                session()->setFlashdata('success', 'Selamat datang' . $data_user['nama']);
                return redirect()->to(base_url('/'));
            } else {
                session()->setFlashdata('fail', 'Password salah');
                return redirect()->to(base_url('auth'));
            }
        } else {
            session()->setFlashdata('fail', 'Username tidak ada');
            return redirect()->to(base_url('auth'));
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('auth'));
    }

    public function register()
    {
        $id = $this->request->getVar('id');
        $data_akun = db_connect()->table('akun')->select('akun.id as id_akun, akun.*, bagian.*')->join('bagian', 'akun.id_level=bagian.id', 'left')->where('akun.id', $id)->get()->getRowArray();
        $data_bagian = db_connect()->table('bagian')->get()->getResultArray();
        return view('auth/register_page', ['data_akun' => $data_akun, 'bagian' => $data_bagian]);
    }

    public function attempt_register()
    {
        $id = $this->request->getVar('id');
        $nama = $this->request->getVar('nama');
        $level = $this->request->getVar('level');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $password2 = $this->request->getVar('password2');


        if (!$this->validate(
            [
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
                    'rules' => 'required|is_unique[akun.username]',
                    'errors' => [
                        'required' => 'Username harus diisi',
                        'is_unique' => 'Username sudah ada'
                    ]
                ], 'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password harus diisi',

                    ]
                ],
                'password2' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Konfirmasi password harus diisi',
                        'matches' => 'Konfirmasi password tidak sama'
                    ]
                ],

            ]
        )) {
            $msg = implode(', ', $this->validation->getErrors());

            session()->setFlashdata('fail', $msg);
            return redirect()->to('auth/register');
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if (db_connect()->table('akun')->insert(['nama' => $nama, 'id_level' => $level, 'username' => $username, 'password' => $password_hash])) {
            session()->setFlashdata('success', 'Akun berhasil dimasukkan');
            return redirect()->to('auth');
        } else {
            session()->setFlashdata('fail', ['Akun gagal dimasukkan']);
            return redirect()->to('auth/register');
        }
    }
}
