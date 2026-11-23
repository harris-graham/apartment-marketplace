<?php

namespace Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApartmentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ApartID' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'ApartAddress' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'ApartPrice' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
            'ApartImg' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'ApartStatus' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'default'    => 'available',
            ],
            'SiteID' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
            'CustID' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('ApartID', true);
        $this->forge->addForeignKey('SiteID', 'site', 'SiteID', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('CustID', 'customer', 'CustID', 'SET NULL', 'SET NULL');
        $this->forge->createTable('apartment');
    }

    public function down()
    {
        $this->forge->dropTable('apartment');
    }
}
