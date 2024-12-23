<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgenPerubahanTable extends Migration
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
            'bulan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true


            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true


            ],
            'tanggal_dokumen' => [
                'type' => 'DATE',

                'null' => true


            ],
            'nama_dokumen' => [
                'type' => 'TEXT',

                'null' => true


            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],


            'jenis_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('agen_perubahan');
    }

    public function down()
    {
        $this->forge->dropTable('agen_perubahan');
    }
}
