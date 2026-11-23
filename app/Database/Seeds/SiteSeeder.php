<?php

namespace Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiteSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('site')->insertBatch([
            ['SiteLocation' => 'Ivato', 'SiteArea' => 500, 'OfficeID' => 1],
            ['SiteLocation' => 'Anosizato', 'SiteArea' => 800, 'OfficeID' => 1],
            ['SiteLocation' => 'Ambohipo', 'SiteArea' => 600, 'OfficeID' => 2],
            ['SiteLocation' => 'Foulpointe', 'SiteArea' => 400, 'OfficeID' => 3],
        ]);
    }
}
