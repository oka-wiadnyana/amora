<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AkunSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('admin', PASSWORD_DEFAULT);
        $data = [
            'id_level' => '13',
            'username'    => 'admin',
            'password' => $password
        ];

        // Simple Queries

        // Using Query Builder
        $this->db->table('akun')->insert($data);
    }
}
