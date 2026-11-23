<?php

namespace Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'SaleID' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'SaleTotal' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
            'SaleType' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'SaleDate' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'ApartID' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
            'CustID' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
            'OfficerID' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('SaleID', true);
        $this->forge->addForeignKey('ApartID', 'apartment', 'ApartID', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('CustID', 'customer', 'CustID', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('OfficerID', 'officer', 'OfficerID', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sale');
    }

    public function down()
    {
        $this->forge->dropTable('sale');
    }
}
