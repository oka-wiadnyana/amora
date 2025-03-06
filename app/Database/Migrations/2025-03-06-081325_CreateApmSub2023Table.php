<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApmSub2023Table extends Migration
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
            'jumlah' => [
                'type' => 'INT',
                
                'null' => true


            ],
            
            
            
          
                       
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('apm_sub_2023');
    }

    public function down()
    {
        $this->forge->dropTable('apm_sub_2023');
    }
}
