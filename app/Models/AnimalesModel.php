<?php

namespace App\Models;

use CodeIgniter\Model;

class AnimalesModel extends Model
{
    protected $table            = 'animales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; //'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
                'nombre', 'foto', 'colonia_id', 'especie_id', 'raza_id',
                 'genero', 'peso','fecha_nacimiento', 'poblacion', 'provincia',
                'puede_viajar', 'se_entrega', 'compatible_con', 'personalidad',
                'estado', 'via_de_adopcion', 'descripcion_corta', 'descripcion_larga',
                'observaciones', 'created_at', 'created_by', 'updated_at', 'updated_by',
                'nombre_colonia','nombre_especie','nombre_raza','nombre_responsable',
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

    public function getAnimales($id = null)
    {

        if (is_null($id)) {
            return $this->select('
                    animales.*, 
                    colonias.nombre as nombre_colonia, 
                    especies.especie as nombre_especie, 
                    razas.raza as nombre_raza,
                    socios.nombre as nombre_responsable,
                ')
                ->join('colonias', 'colonias.id = animales.colonia_id', 'left')
                ->join('especies', 'especies.id = animales.especie_id', 'left')
                ->join('razas', 'razas.id = animales.raza_id', 'left')
                ->join('socios', 'colonias.responsable_id = socios.id', 'left')
                ->orderBy('animales.nombre', 'ASC')
                ->findAll();
        }
        
        // Si se proporciona un ID, se busca una sola colonia
        // y se devuelven los datos relacionados con el responsable y el adjunto.

        return $this->select('
                    animales.*, 
                    colonias.nombre as nombre_colonia, 
                    especies.especie as nombre_especie, 
                    razas.raza as nombre_raza,
                    socios.nombre as nombre_responsable,
                ')
                ->join('colonias', 'colonias.id = animales.colonia_id', 'left')
                ->join('especies', 'especies.id = animales.especie_id', 'left')
                ->join('razas', 'razas.id = animales.raza_id', 'left')
                ->join('socios', 'colonias.responsable_id = socios.id', 'left')
                ->orderBy('animales.nombre', 'ASC')
                ->find($id);
    }
}