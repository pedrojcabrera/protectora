<?php

namespace App\Controllers;

use App\Models\RecibosModel;

class RecibosController extends BaseController
{
    protected $recibosModel;

    public function __construct()
    {
        $this->recibosModel = new RecibosModel();
    }

    public function listadoRemesas()
    {
        $db = \Config\Database::connect();

        // Obtener resumen de remesas
        $sql = "
            SELECT r.fecha_cobro,
                   COUNT(r.id) AS num_recibos,
                   SUM(r.importe) AS total
            FROM recibos r
            GROUP BY r.fecha_cobro
            ORDER BY r.fecha_cobro DESC
        ";

        $remesas = $db->query($sql)->getResult();

        // Añadir detalles a cada remesa
        foreach ($remesas as &$remesa) {
            $remesa->detalles = $this->recibosModel
                ->select('recibos.fecha_cobro, recibos.importe, recibos.estado, socios.nombre')
                ->join('socios', 'socios.id = recibos.socio_id', 'left')
                ->where('recibos.fecha_cobro', $remesa->fecha_cobro)
                ->findAll();
        }

        return view('remesas/listadoRemesas', ['remesas' => $remesas]);
    }
}