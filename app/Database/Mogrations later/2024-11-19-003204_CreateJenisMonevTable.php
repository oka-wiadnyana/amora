<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisMonevTable extends Migration
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
            'bagian' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'nama_dokumen_monev' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
          
           
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jenis_monev');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_monev');
    }
}
