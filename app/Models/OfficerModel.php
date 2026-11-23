<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficerModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'officer';
    protected $primaryKey       = 'OfficerID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['OfficerName', 'OfficerPNum', 'OfficerAddress', 'OfficerUName', 'OfficerPword', 'OfficerRole'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'OfficerName'  => 'required|max_length[100]',
        'OfficerUName' => 'required|max_length[100]|is_unique[officer.OfficerUName]',
        'OfficerPword' => 'required|min_length[6]',
        'OfficerRole'  => 'required|in_list[admin,agent]',
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
