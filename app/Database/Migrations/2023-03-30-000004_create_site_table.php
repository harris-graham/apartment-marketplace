<?php

namespace Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'SiteID' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'SiteLocation' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'SiteArea' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'OfficeID' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('SiteID', true);
        $this->forge->addForeignKey('OfficeID', 'office', 'OfficeID', 'CASCADE', 'CASCADE');
        $this->forge->createTable('site');
    }

    public function down()
    {
        $this->forge->dropTable('site');
    }
}
