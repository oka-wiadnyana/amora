<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateZiFileTable extends Migration
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
            'kode_sub_sub_area' => [
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
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true


            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true


            ],
          
                       
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('zi_file');
    }

    public function down()
    {
        $this->forge->dropTable('zi_file');
    }
}
