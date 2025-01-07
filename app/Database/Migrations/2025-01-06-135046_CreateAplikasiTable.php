<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMonevAplikasiTable extends Migration
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
            'nama_aplikasi' => [
                'type'           => 'VARCHAR',
                'constraint'     => 555,
                'unsigned'       => true,

            ],

            'penjelasan' => [
                'type' => 'TEXT',

                'null' => true
            ],

            'dampak_langsung' => [
                'type' => 'TEXT',

                'null' => true
            ],
            'latar_belakang' => [
                'type' => 'TEXT',

                'null' => true
            ],
            'link' => [
                'type' => 'VARCHAR',
                'constraint' => 550,
                'null' => true
            ],




        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('monev_aplikasi');
    }

    public function down()
    {
        $this->forge->dropTable('monev_aplikasi');
    }
}
