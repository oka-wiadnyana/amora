<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeriZiarticleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nomor_seri' => [
                'type'           => 'INT',
                
                'unsigned'       => true,
                'null' => true,
            ],
           
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('seri_ziarticle');
    }

    public function down()
    {
        $this->forge->dropTable('seri_ziarticle');
    }
}
