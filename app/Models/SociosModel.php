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
    protected $allowedFields = [
        // Datos personales
        'nombre',
        'tipo',
        'forma_de_pago',
        'observaciones',
        'direccion',
        'codpostal',
        'poblacion',
        'provincia',
        'telefono',
        'email',
        'tipo_documentoId',
        'documentoId',
        'fecha_nacimiento',
        'fecha_alta',

        // Fotos DNI
        'foto_dni_anverso',
        'foto_dni_reverso',

        // Datos bancarios
        'entidad_bancaria',
        'swifth_bic',
        'iban',
        'mandato',
        'fecha_mandato',
        'complemento',
        'modalidad_pago',

        // Operador que crea o edita
        'created_by',
        'updated_by',
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
    protected $beforeInsert   = ['setCreatedBy'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['setUpdatedBy'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function setCreatedBy(array $data)
    {
        $data['data']['created_by'] = session()->get('usuario_nombre') ?? null;
        $data['data']['updated_by'] = session()->get('usuario_nombre') ?? null;
        return $data;
    }

    protected function setUpdatedBy(array $data)
    {
        $data['data']['updated_by'] = session()->get('usuario_nombre') ?? null;
        return $data;
    }
}