<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenMonevTable extends Migration
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
            'jenis_monev_id' => [
                'type' => 'INT',
               
                'null' => true


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
            'nama_file' => [
                'type' => 'TEXT',
               
               'null' => true


            ],
            
          
           
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokumen_monev');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_monev');
    }
}
