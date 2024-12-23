<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStandarPelayananTable extends Migration
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
            'nama_standar_pelayanan' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true


            ],
            'bagian' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true


            ],
            'file_standar_pelayanan' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true


            ],
            
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('standar_pelayanan');
    }

    public function down()
    {
        $this->forge->dropTable('standar_pelayanan');
    }
}
