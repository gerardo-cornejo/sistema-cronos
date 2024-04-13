<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoModel extends Model
{
    protected $table            = 'equipo';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "marca", "modelo", "serie", "codigo_barras", "id_usuario"];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "marca" => "required|min_length[3]",
        "modelo" => "required|min_length[3]",
        "serie" => "required|min_length[3]",
        // "id_usuario" => "required|numeric",
        "id_cliente" => "required|numeric"
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

    public function generarCodigoBarras()
    {
        $base = 1000000000000;
        $query = $this->db->query("SELECT MAX(codigo_barras) as cantidad from " . $this->table . ";");
        if ($query) {
            $resultado  = $query->getRowArray();
            if ($resultado["cantidad"] == 0) {
                return $base;
            }
            return $resultado["cantidad"]  + 1;
        }
        return $base;
    }
}
