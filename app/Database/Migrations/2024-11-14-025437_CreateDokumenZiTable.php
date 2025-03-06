<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenZiTable extends Migration
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

            'jenis_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'sub_area' => [
                'type' => 'TEXT',
                
                'null' => true
            ],
            'sub_sub_area' => [
                'type' => 'TEXT',
                
                'null' => true
            ],
            'tahun' => [
               'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'nama_dokumen' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
           
            'area_zi' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokumen_zi');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_zi');
    }
}
