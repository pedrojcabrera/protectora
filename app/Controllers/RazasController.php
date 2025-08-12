<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\RazasModel;
use App\Models\EspeciesModel;

class RazasController extends BaseController
{
    
    public $razasModel;
    public $especiesModel;
    public $especies;
    
    public function __construct()
    {
        $this->razasModel = new RazasModel();
        $this->especiesModel = new EspeciesModel();
        
        $this->especies= $this->especiesModel->orderBy('especie', 'ASC')->findAll();
    }
    
    public function list()
    {
        $razas = $this->razasModel->getRazasPorEspecie();
        return view('razas/list', ['razas' => $razas]);
    }

    public function new()
    {
        return view('razas/new',['especies' => $this->especies]);
    }

    public function store()
    {
           
        if(
            $this
            ->razasModel
            ->where('especie_id', $this->request->getPost('especie'))
            ->where('raza', $this->request->getPost('raza'))
            ->first()
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'la combinación de especie y raza ya existe.');
        }
        
        $datos = [
            'raza'           => $this->request->getPost('raza'),
            'especie_id'     => $this->request->getPost('especie'),
            'observaciones'  => $this->request->getPost('observaciones') ?? null,
            'created_by'     => session('usuario_nombre'),
            'updated_by'     => session('usuario_nombre'),
        ];
    
        $this->razasModel->insert($datos);

        return redirect()->to(site_url('razas'))->with('success', 'Raza creada correctamente.');
    }

    public function show($id = null)
    {
        $raza = $this->razasModel->getRazas($id);
        return view('razas/show', ['raza' => $raza]);
    }

    public function edit($id = null)
    {
        $raza = $this->razasModel->getRazas($id);
        if (!$raza) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Raza no encontrada");
        }
    
        return view('razas/edit', ['raza' => $raza, 'especies' => $this->especies]);
    
    }

    public function update()
    {
        $id = $this->request->getPost('id') ?? null;

        $raza = $this->razasModel->getRazas($id);
        
        if (!$raza) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Raza no encontrada");
        }
    
        $validacion = $this
            ->razasModel
            ->where('especie_id', $this->request->getPost('especie'))
            ->where('raza', $this->request->getPost('raza'))
            ->first();
        
        if($validacion && $validacion->id != $id) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'la combinación de especie y raza ya existe.');
        }
        
        $datos = [
            'raza'           => $this->request->getPost('raza'),
            'especie_id'     => $this->request->getPost('especie'),
            'observaciones'  => $this->request->getPost('observaciones') ?? null,
            'updated_by'     => session('usuario_nombre'),
        ];


        $this->razasModel->update($id,$datos);
    
        return redirect()->to(site_url('razas'))->with('message', 'Raza actualizada correctamente');
    }


    public function delete()
    {
        
        $id = $this->request->getPost('id') ?? null;
        
        $raza = $this->razasModel->find($id);

        if (!$raza) {
            return redirect()->to('/razas')->with('error', 'Raza no encontrada.');
        }
    
        $this->razasModel->delete($id);

        return redirect()->to('/razas')->with('success', 'Raza eliminada correctamente.');
    
    }

    public function pdf_list()
    {
        $razas = $this->razasModel->getRazasPorEspecie();

        $html = view('razas/pdf_list', ['razas' => $razas]);

        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Limpiar buffer de salida anterior (muy importante)
        ob_clean();
        flush();

        // Enviar PDF al navegador con headers correctos
        return $this->response
            ->setContentType('application/pdf')
            ->setBody($dompdf->output());
    }

    public function porEspecie($especieId)
    {
        $razas = $this->razasModel->where('especie_id', $especieId)->findAll();

        return $this->response->setJSON($razas);
    }


}