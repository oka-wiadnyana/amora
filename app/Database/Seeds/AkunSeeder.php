<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AkunSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('oka', PASSWORD_DEFAULT);
        $data = [
            'id_level' => '13',
            'username'    => 'oka',
            'password' => $password
        ];

        // Simple Queries

        // Using Query Builder
        $this->db->table('akun')->insert($data);
    }
}
