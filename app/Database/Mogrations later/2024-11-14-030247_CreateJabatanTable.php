<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJabatanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jabatan' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'jabatan_hakim_id' => [
                'type' => 'INTEGER',
               
                'null' => true
            ],
            'urutan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
           


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jabatan');
    }

    public function down()
    {
        $this->forge->dropTable('jabatan');
    }
}
