<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAreaZiTable extends Migration
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
            'kode_area' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'nama_area' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('area_zi');
    }

    public function down()
    {
        $this->forge->dropTable('area_zi');
    }
}
