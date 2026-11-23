<?php

namespace Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('office')->insertBatch([
            ['OfficeName' => 'Agence Centre', 'OfficeAddress' => 'Analakely', 'ProvinceID' => 1],
            ['OfficeName' => 'Agence Nord', 'OfficeAddress' => 'Andohatapenaka', 'ProvinceID' => 1],
            ['OfficeName' => 'Agence Est', 'OfficeAddress' => 'Toamasina centre', 'ProvinceID' => 2],
        ]);
    }
}
