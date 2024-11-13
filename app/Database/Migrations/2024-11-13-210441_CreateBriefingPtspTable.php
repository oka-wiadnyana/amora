<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBriefingPtspTable extends Migration
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
            'tanggal' => [
                'type' => 'DATE',

                'null' => true


            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],


            'jenis_laporan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('briefing_ptsp');
    }

    public function down()
    {
        $this->forge->dropTable('briefing_ptsp');
    }
}
