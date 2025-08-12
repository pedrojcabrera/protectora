<?php

namespace App\Models;

use CodeIgniter\Model;

class SociosModel extends Model
{
    protected $table            = 'socios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; //'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
                'nombre', 'tipo', 'observaciones',
                'direccion', 'codpostal', 'poblacion', 'provincia',
                'telefono','email', 'tipo_documentoId', 'documentoId', 'fecha_nacimiento',
                'foto_dni_anverso', 'foto_dni_reverso',
                'entidad_bancaria', 'cuenta_bancaria', 'cuota_anual', 'complemento',
                'modalidad_pago', 'ultimo_recibo_fecha', 'ultimo_recibo_importe',
                'created_at', 'created_by', 'updated_at', 'updated_by',
                ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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