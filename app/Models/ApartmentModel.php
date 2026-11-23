<?php

namespace App\Models;

use CodeIgniter\Model;

class ApartmentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'apartment';
    protected $primaryKey       = 'ApartID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['ApartAddress', 'ApartPrice', 'ApartImg', 'ApartStatus', 'SiteID', 'CustID'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'ApartAddress' => 'required|max_length[255]',
        'ApartPrice'   => 'required|numeric|greater_than[0]',
        'SiteID'       => 'required|numeric|greater_than[0]',
        'ApartStatus'  => 'required|in_list[available,sold,reserved]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
