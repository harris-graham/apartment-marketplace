<?php

namespace Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOfficerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'OfficerID' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'OfficerName' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'OfficerPNum' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'OfficerAddress' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'OfficerUName' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
                'unique'     => true,
            ],
            'OfficerPword' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'OfficerRole' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'default'    => 'agent',
            ],
        ]);
        $this->forge->addKey('OfficerID', true);
        $this->forge->createTable('officer');
    }

    public function down()
    {
        $this->forge->dropTable('officer');
    }
}
