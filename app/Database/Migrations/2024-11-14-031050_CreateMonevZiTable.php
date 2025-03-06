<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMonevZiTable extends Migration
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

            'bulan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'tanggal_dokumen' => [
                'type' => 'DATE',
                
                'null' => true
            ],
          
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'area_zi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'jenis_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('monev_zi');
    }

    public function down()
    {
        $this->forge->dropTable('monev_zi');
    }
}
