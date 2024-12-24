<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubSubReformTable extends Migration
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
            'kode_sub_sub_reform' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'area' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'sub_area' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'sub_sub_area' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'uraian' => [
                'type' => 'TEXT',
                
                'null' => true


            ],
            
          
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sub_sub_reform');
    }

    public function down()
    {
        $this->forge->dropTable('sub_sub_reform');
    }
}
