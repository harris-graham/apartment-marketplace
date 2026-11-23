<?php

namespace Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficerSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('officer')->insertBatch([
            [
                'OfficerName'   => 'Admin',
                'OfficerPNum'   => '0340000000',
                'OfficerAddress'=> 'Admin office',
                'OfficerUName'  => 'admin',
                'OfficerPword'  => password_hash('admin123', PASSWORD_DEFAULT),
                'OfficerRole'   => 'admin',
            ],
            [
                'OfficerName'   => 'Agent 1',
                'OfficerPNum'   => '0340000010',
                'OfficerAddress'=> 'Agence Centre',
                'OfficerUName'  => 'agent1',
                'OfficerPword'  => password_hash('agent123', PASSWORD_DEFAULT),
                'OfficerRole'   => 'agent',
            ],
        ]);
    }
}
