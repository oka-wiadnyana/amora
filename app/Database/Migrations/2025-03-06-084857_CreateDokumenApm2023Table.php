<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenApm2023Table extends Migration
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
            'nomor_apm' => [
                'type' => 'INT',
                
                'null' => true


            ],
            'nomor_sub_apm' => [
                'type' => 'INT',
                
                'null' => true


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
            'nama_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true


            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true


            ],
            
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokumen_apm_2023');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_apm_2023');
    }
}
