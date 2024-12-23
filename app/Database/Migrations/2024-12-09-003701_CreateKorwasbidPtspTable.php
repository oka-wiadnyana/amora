<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKorwasbidPtspTable extends Migration
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
            'tanggal_laporan' => [
                'type' => 'DATE',
                
                'null' => true
            ],
          
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
           


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('korwasbid_ptsp');
    }

    public function down()
    {
        $this->forge->dropTable('korwasbid_ptsp');
    }
}
