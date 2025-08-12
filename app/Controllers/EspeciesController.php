<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\EspeciesModel;

class EspeciesController extends BaseController
{
    
    public $especiesModel;
    
    public function __construct()
    {
        $this->especiesModel = new EspeciesModel();
    }
    
    public function list()
    {
        $especies = $this->especiesModel->orderBy('especie','ASC')->findAll();
        
        return view('especies/list', ['especies' => $especies]);
    }

    public function new()
    {
        return view('especies/new');
    }

    public function store()
    {
        $rules = [
            'especie'   => "required|max_length[50]|is_unique[especies.especie]",
        ];
        
        
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        
        $datos = [
            'especie'        => $this->request->getPost('especie'),
            'observaciones'  => $this->request->getPost('observaciones') ?? null,
            'created_by'     => session('usuario_nombre'),
            'updated_by'     => session('usuario_nombre'),
        ];
    
        $this->especiesModel->insert($datos);

        return redirect()->to(site_url('especies'))->with('success', 'Especie creada correctamente.');
    }

    public function show($id = null)
    {
        $especie = $this->especiesModel->find($id);
        return view('especies/show', ['especie' => $especie]);
    }

    public function edit($id = null)
    {
        $especie = $this->especiesModel->find($id);
    
        if (!$especie) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Especie no encontrada");
        }
    
        return view('especies/edit', ['especie' => $especie]);
    
    }

    public function update()
    {

        $id = $this->request->getPost('id') ?? null;

        $especie = $this->especiesModel->find($id);
        
        if (!$especie) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Especie no encontrada");
        }
    
        $rules = [
            'especie' => "required|max_length[50]|is_unique[especies.especie,id,$id]",
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
            ->withInput()
            ->with('error', 'Por favor, corrige los errores.')
            ->with('validation', $this->validator);
        }
        
        $this->especiesModel->update($id, [
            'especie'       => $this->request->getPost('especie'),
            'observaciones' => $this->request->getPost('observaciones') ?? null,
            'updated_by'    => session('usuario_nombre'),
       ]);
    
        return redirect()->to(site_url('especies'))->with('message', 'Especie actualizada correctamente');
    }


    public function delete()
    {
        
        $id = $this->request->getPost('id') ?? null;
        
        $especie = $this->especiesModel->find($id);

        if (!$especie) {
            return redirect()->to('/especies')->with('error', 'Especie no encontrada.');
        }
    
        $this->especiesModel->delete($id);

        return redirect()->to('/especies')->with('success', 'Especie eliminada correctamente.');
    
    }

    public function pdf_list()
    {
        $especiesModel = new EspeciesModel();
        $especies = $this->especiesModel->orderBy('especie','ASC')->findAll();

        $html = view('especies/pdf_list', ['especies' => $especies]);

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

}