<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRencanaAksiTable extends Migration
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
                'constraint' => 250,
                'null' => true
            ],
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rencana_aksi');
    }

    public function down()
    {
        $this->forge->dropTable('rencana_aksi');
    }
}
