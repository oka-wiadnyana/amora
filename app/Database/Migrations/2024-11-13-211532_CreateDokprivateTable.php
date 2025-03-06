<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokprivateTable extends Migration
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

            'nama_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true
            ],
            'user' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokprivate');
    }

    public function down()
    {
        $this->forge->dropTable('dokprivate');
    }
}
