<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssesmentInternalLocalTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'semester' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true


            ],
            'nama_file' => [
                'type' => 'TEXT',

                'null' => true
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('assement_internal_local');
    }

    public function down()
    {
        $this->forge->dropTable('assement_internal_local');
    }
}
