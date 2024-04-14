<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "nombre", "apellido_paterno", "apellido_materno", "dni", "tipo"];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "nombre" => "required",
        "apellido_paterno" => "required",
        "apellido_materno" => "required",
        "dni" => "required|exact_length[8]",
        "tipo" => "required|in_list[Administrador,Tecnico]"
    ];
    protected $validationMessages   = [
        "nombre" => ["required" => REQUIRED],
        "apellido_paterno" => ["required" => REQUIRED],
        "apellido_materno" => ["required" => REQUIRED],
        "dni" => ["required" => REQUIRED, "exact_length" => EXACT_LENGTH],
        "tipo" => ["required" => REQUIRED, "in_list" => IN_LIST]
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
