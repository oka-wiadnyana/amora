<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengadilantinggiTable extends Migration
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
            'semester' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'tanggal_laporan' => [
                'type' => 'DATE',

                'null' => true
            ],

            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'jenis_laporan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengadilantinggi');
    }

    public function down()
    {
        $this->forge->dropTable('pengadilantinggi');
    }
}
