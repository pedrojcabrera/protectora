<?php

namespace App\Models;

use CodeIgniter\Model;

class ProtectorasModel extends Model
{
    protected $table            = 'protectora';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'object'; // ya que normalmente trabajas con objetos
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nombre',
        'nombre_corto',
		'nif',
        'dirección',
        'codpostal',
        'poblacion',
        'provincia',
        'telefono',
        'email',
        'banco',
        'swifth_bic',
        'iban',
        'cuota_anual',
        'dia_remesar',
		'logo',
        'mail_protocolo',
        'mail_servidor',
        'mail_puerto',
        'mail_usuario',
        'mail_password',
        'mail_encriptacion',
        'mail_tipo',
        'mail_charset',
        'mail_wordwrap',
        'mail_newline',
    ];

    // Fechas
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

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