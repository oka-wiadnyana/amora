<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAkunTable extends Migration
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
            'id_level' => [
                'type' => 'INTEGER',

            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,


            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 500,


            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('akun');
    }

    public function down()
    {
        $this->forge->dropTable('akun');
    }
}
