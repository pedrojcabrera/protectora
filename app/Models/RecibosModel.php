<?php

namespace App\Models;

use CodeIgniter\Model;

class RecibosModel extends Model
{
    protected $table = 'recibos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; //'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'socio_id', 'tipo', 'fecha_cobro', 'importe', 'estado', 'remesa'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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


    public function getRecibosConSocio()
    {
        return $this->select('recibos.*, socios.nombre as socio_nombre')
                    ->join('socios', 'socios.id = recibos.socio_id')
                    ->orderBy('fecha_cobro', 'ASC')
                    ->findAll();
    }
    public function getRecibosBancariosConSocio()
    {
        return $this->select('recibos.*, socios.nombre as socio_nombre')
                    ->join('socios', 'socios.id = recibos.socio_id')
                    ->where('recibos.tipo', 'recibo')
                    ->orderBy('fecha_cobro', 'ASC')
                    ->findAll();
    }
    public function getRecibosIngresosConSocio()
    {
        return $this->select('recibos.*, socios.nombre as socio_nombre')
                    ->join('socios', 'socios.id = recibos.socio_id')
                    ->where('recibos.tipo', 'ingreso')
                    ->orderBy('fecha_cobro', 'ASC')
                    ->findAll();
    }

}