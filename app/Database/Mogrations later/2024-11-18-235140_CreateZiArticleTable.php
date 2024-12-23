<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateZiArticleTable extends Migration
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
            'nomor_seri' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true


            ],
            'article' => [
                'type' => 'TEXT',
                
                'null' => true


            ],
                       
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ziarticles');
    }

    public function down()
    {
        $this->forge->dropTable('ziarticles');
    }
}
