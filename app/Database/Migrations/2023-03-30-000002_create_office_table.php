<?php

namespace Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOfficeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'OfficeID' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'OfficeName' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'OfficeAddress' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'ProvinceID' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('OfficeID', true);
        $this->forge->addForeignKey('ProvinceID', 'province', 'ProvinceID', 'CASCADE', 'CASCADE');
        $this->forge->createTable('office');
    }

    public function down()
    {
        $this->forge->dropTable('office');
    }
}
