<?php

namespace Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('province')->insertBatch([
            ['ProvinceName' => 'Antananarivo'],
            ['ProvinceName' => 'Toamasina'],
            ['ProvinceName' => 'Antsirabe'],
            ['ProvinceName' => 'Fianarantsoa'],
            ['ProvinceName' => 'Mahajanga'],
        ]);
    }
}
