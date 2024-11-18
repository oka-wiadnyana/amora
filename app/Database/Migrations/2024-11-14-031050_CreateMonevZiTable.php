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

            'nama_mou' => [
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
        $this->forge->createTable('mous');
    }

    public function down()
    {
        $this->forge->dropTable('mous');
    }
}
