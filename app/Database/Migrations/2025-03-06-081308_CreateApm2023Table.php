<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApm2023Table extends Migration
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
            'nomor' => [
                'type' => 'INT',
                
                'null' => true


            ],
            'area' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            
            'penilaian' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            'uraian' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            'kriteria' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            'lokasi' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            'bobot' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            
            
          
                       
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('apm_2023');
    }

    public function down()
    {
        $this->forge->dropTable('apm_2023');
    }
}
