<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApmTable extends Migration
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
            
            'uraian' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            'area_zi' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            'bobot' => [
                'type' => 'TEXT',
               
                'null' => true


            ],
            'jumlah_sub' => [
                'type' => 'INT',
               
                'null' => true


            ],
            
            
          
                       
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('apm');
    }

    public function down()
    {
        $this->forge->dropTable('apm');
    }
}