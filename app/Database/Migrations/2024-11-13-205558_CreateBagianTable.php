<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBagianTable extends Migration
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
            'nama_bagian' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'is_sub_unit' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bagian');
    }

    public function down()
    {
        $this->forge->dropTable('bagian');
    }
}
