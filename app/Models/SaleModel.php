<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sale';
    protected $primaryKey       = 'SaleID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['SaleTotal', 'SaleType', 'SaleDate', 'ApartID', 'CustID', 'OfficerID'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'SaleTotal' => 'required|numeric|greater_than[0]',
        'SaleType'  => 'required|in_list[Au comptant,À crédit]',
        'ApartID'   => 'required|numeric|greater_than[0]',
        'CustID'    => 'required|numeric|greater_than[0]',
        'OfficerID' => 'required|numeric|greater_than[0]',
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
