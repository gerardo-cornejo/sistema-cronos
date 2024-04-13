<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'cliente';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "nombre", "apellido_paterno", "apellido_materno", "tipo_doi", "numero_doi"];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "nombre" => "required|min_length[3]",
        "apellido_paterno" => "required|min_length[2]",
        "apellido_materno" => "required|min_length[2]",
        "tipo_doi" => "required|in_list[dni,ruc,pasaporte,ce]"
    ];

    protected $validationMessages   = [
        "nombre" => ["required" => REQUIRED, "min_length" => MIN_LENGTH],
        "apellido_paterno" => ["required" => REQUIRED, "min_length" => MIN_LENGTH],
        "apellido_materno" => ["required" => REQUIRED, "min_length" => MIN_LENGTH],
        "tipo_doi" => ["required" => REQUIRED, "in_list" => IN_LIST],

    ];
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
