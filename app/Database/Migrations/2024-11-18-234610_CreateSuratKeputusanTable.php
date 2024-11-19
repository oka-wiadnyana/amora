<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratKeputusanTable extends Migration
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
            'nomor_sk' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'perihal_sk' => [
                'type' => 'TEXT',
                
                'null' => true


            ],
            'tanggal_sk' => [
                'type' => 'date',
                
                'null' => true


            ],
            'penandatangan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'file_sk' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'keterangan' => [
                'type' => 'TEXT',
                
                'null' => true


            ],
            
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('surat_keputusan');
    }

    public function down()
    {
        $this->forge->dropTable('surat_keputusan');
    }
}
