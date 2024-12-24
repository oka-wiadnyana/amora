<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenRapatTable extends Migration
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
                'constraint' => 50,
                'null' => true
            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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
                'type' => 'TEXT',
                'null' => true
            ],
            'lampiran' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'jenis_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokumen_rapat');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_rapat');
    }
}
