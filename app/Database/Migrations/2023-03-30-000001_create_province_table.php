<?php

namespace Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProvinceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ProvinceID' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'ProvinceName' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('ProvinceID', true);
        $this->forge->createTable('province');
    }

    public function down()
    {
        $this->forge->dropTable('province');
    }
}
