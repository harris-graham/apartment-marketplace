<?php

namespace Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('customer')->insertBatch([
            ['CustName' => 'Rakoto', 'CustPNum' => '0340000001', 'CustAddress' => 'Antananarivo'],
            ['CustName' => 'Rabe', 'CustPNum' => '0340000002', 'CustAddress' => 'Toamasina'],
            ['CustName' => 'Ravelo', 'CustPNum' => '0340000003', 'CustAddress' => 'Antsirabe'],
        ]);
    }
}
