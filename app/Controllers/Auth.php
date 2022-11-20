<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
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
                session()->set('level', $data_user['level']);
                session()->set('nama_bagian', $data_user['nama_bagian']);
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
}
