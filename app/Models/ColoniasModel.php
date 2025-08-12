<?php

namespace App\Models;

use CodeIgniter\Model;

class ColoniasModel extends Model
{
    protected $table            = 'colonias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; //'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
                'nombre', 'tipo', 'ubicacion', 'gps',
                'responsable_id', 'adjunto_id', 'observaciones',
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

    public function getColonias($id = null)
    {

        if(is_null($id)) {
            return $this->select('
                    colonias.id as id, colonias.nombre as nombre, colonias.tipo as tipo, ubicacion, gps, colonias.observaciones as observaciones, responsable_id, adjunto_id, colonias.created_at as created_el, colonias.created_by as created_por, colonias.updated_at as updated_el, colonias.updated_by as updated_por,
                    responsable.nombre as responsable_nombre, adjunto.nombre AS adjunto_nombre
                ')
                ->join('socios as responsable', 'colonias.responsable_id = responsable.id', 'left')
                ->join('socios as adjunto', 'colonias.adjunto_id = adjunto.id', 'left')
                ->orderBy('nombre','ASC')->findAll();
        }
        // Si se proporciona un ID, se busca una sola colonia
        // y se devuelven los datos relacionados con el responsable y el adjunto.
        return $this->select('
                colonias.id as id, colonias.nombre as nombre, colonias.tipo as tipo, ubicacion, gps, colonias.observaciones as observaciones, responsable_id, adjunto_id, colonias.created_at as created_el, colonias.created_by as created_por, colonias.updated_at as updated_el, colonias.updated_by as updated_por,
                responsable.nombre as responsable_nombre, adjunto.nombre AS adjunto_nombre
            ')
            ->join('socios as responsable', 'colonias.responsable_id = responsable.id', 'left')
            ->join('socios as adjunto', 'colonias.adjunto_id = adjunto.id', 'left')
            ->orderBy('nombre','ASC')->find($id);
    }

    public function getSoloColonias()
    {
        return $this->select('
            colonias.id as id, colonias.nombre as nombre, colonias.tipo as tipo, ubicacion, gps, colonias.observaciones as observaciones, responsable_id, adjunto_id, colonias.created_at as created_el, colonias.created_by as created_por, colonias.updated_at as updated_el, colonias.updated_by as updated_por,
            responsable.nombre as responsable_nombre, adjunto.nombre AS adjunto_nombre
            ')
            ->join('socios as responsable', 'colonias.responsable_id = responsable.id', 'left')
            ->join('socios as adjunto', 'colonias.adjunto_id = adjunto.id', 'left')
            ->like('colonias.tipo', 'punto de alimentación', 'after')
            ->orderBy('nombre','ASC')->findAll();
    }

    public function getSoloColoniasDeSocio($id = null)
    {
        return $this->select('
            colonias.id as id, colonias.nombre as nombre, colonias.tipo as tipo, ubicacion, gps, colonias.observaciones as observaciones, responsable_id, adjunto_id, colonias.created_at as created_el, colonias.created_by as created_por, colonias.updated_at as updated_el, colonias.updated_by as updated_por,
            responsable.nombre as responsable_nombre, adjunto.nombre AS adjunto_nombre
            ')
            ->join('socios as responsable', 'colonias.responsable_id = responsable.id', 'left')
            ->join('socios as adjunto', 'colonias.adjunto_id = adjunto.id', 'left')
            ->like('colonias.tipo', 'punto de alimentación', 'after')
            ->where('colonias.responsable_id', $id)
            ->orWhere('colonias.adjunto_id', $id)
            ->orderBy('nombre','ASC')->findAll();
    }

}