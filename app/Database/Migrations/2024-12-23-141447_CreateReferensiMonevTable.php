<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReferensiMonevTable extends Migration
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

            'jenis_monev' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'bagian' => [
                'type' => 'INT',

                'null' => true
            ],




        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('referensi_monev_bagian');
    }

    public function down()
    {
        $this->forge->dropTable('referensi_monev_bagian');
    }
}
