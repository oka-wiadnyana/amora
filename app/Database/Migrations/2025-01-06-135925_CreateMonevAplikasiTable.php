<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMonevAplikasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_aplikasi' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,

            ],

            'bulan' => [
                'type' => 'VARCHAR',
                'constraint' => 550,
                'null' => true
            ],

            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 550,
                'null' => true
            ],
            'tanggal_laporan' => [
                'type' => 'DATE',

                'null' => true
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 550,
                'null' => true
            ],




        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('monev_aplikasi');
    }

    public function down()
    {
        $this->forge->dropTable('monev_aplikasi');
    }
}
