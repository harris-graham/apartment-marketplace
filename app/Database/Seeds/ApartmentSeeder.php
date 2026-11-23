<?php

namespace Database\Seeds;

use CodeIgniter\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('apartment')->insertBatch([
            ['ApartAddress' => 'Appart T3 Ivato', 'ApartPrice' => 15000000, 'ApartImg' => null, 'ApartStatus' => 'available', 'SiteID' => 1, 'CustID' => null],
            ['ApartAddress' => 'Appart T4 Anosizato', 'ApartPrice' => 20000000, 'ApartImg' => null, 'ApartStatus' => 'available', 'SiteID' => 2, 'CustID' => null],
            ['ApartAddress' => 'Appart T2 Ambohipo', 'ApartPrice' => 12000000, 'ApartImg' => null, 'ApartStatus' => 'available', 'SiteID' => 3, 'CustID' => null],
            ['ApartAddress' => 'Appart T5 Foulpointe', 'ApartPrice' => 25000000, 'ApartImg' => null, 'ApartStatus' => 'available', 'SiteID' => 4, 'CustID' => null],
        ]);
    }
}
