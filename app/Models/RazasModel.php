<?php

namespace App\Models;

use CodeIgniter\Model;

class RazasModel extends Model
{
    protected $table            = 'razas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; //'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
                'raza', 'especie_id', 'observaciones',
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

    public function getRazasByEspecie($especieId)
    {
        return $this->where('especie_id', $especieId)
                    ->orderBy('raza', 'ASC')
                    ->findAll();
    }

    public function getRazas($id = null)
    {
        if($id !== null) {
            return $this
            ->select('
            razas.id as id, razas.raza as raza, razas.observaciones as observaciones, razas.especie_id as especie_id, especies.especie as especie,
            razas.created_at, razas.created_by, razas.updated_at, razas.updated_by
            ')
            ->join('especies', 'especies.id = razas.especie_id')
            ->find($id);
        }

        return $this
        ->select('
        razas.id as id, razas.raza as raza, razas.observaciones as observaciones, especies.especie as especie,
        razas.created_at, razas.created_by, razas.updated_at, razas.updated_by
        ')
        ->join('especies', 'especies.id = razas.especie_id')
        ->orderBy('razas.raza', 'ASC')
        ->findAll();
    }

    public function getRazasPorEspecie()
    {
        return $this
        ->select('
        razas.*, especies.especie as especie
        ')
        ->join('especies', 'especies.id = razas.especie_id')
        ->orderBy('especies.especie', 'ASC')
        ->orderBy('razas.raza', 'ASC')
        ->findAll();
    }

}