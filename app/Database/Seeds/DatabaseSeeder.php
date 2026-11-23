<?php

namespace Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('ProvinceSeeder');
        $this->call('OfficeSeeder');
        $this->call('SiteSeeder');
        $this->call('CustomerSeeder');
        $this->call('OfficerSeeder');
        $this->call('ApartmentSeeder');
    }
}
