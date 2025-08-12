<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\JaulasModel;
use App\Models\SociosModel;

class JaulasController extends BaseController
{
    
    public $jaulasModel;
    public $sociosModel;
    public $socios;
    
    public function __construct()
    {
        $this->jaulasModel = new JaulasModel();
        $this->sociosModel = new SociosModel();
        $this->socios = $this->sociosModel->orderBy('nombre', 'ASC')->findAll();
    }
    
    public function list()
    {
        $jaulas = $this->jaulasModel->findAll();

        return view('jaulas/list', ['jaulas' => $jaulas]);
    }

    public function new()
    {
        //$jaulas = $this->jaulasModel->findAll();
        return view('jaulas/new',['socios' => $this->socios]);
    }

    public function store()
    {
        $rules = [
            'etiqueta'          => "required|min_length[3]|max_length[20]",
            'propietario'       => "required",
            'descripcion'       => "permit_empty",
            'caracteristicas'   => "permit_empty",
            'ubicacion'         => "required",
        ];
        
        
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        
        $datos = [
            'etiqueta'          => $this->request->getPost('etiqueta'),
            'estado'            => $this->request->getPost('estado') ?? 1,
            'propietario'       => $this->request->getPost('propietario') ?? null,
            'descripcion'       => trim($this->request->getPost('descripcion')) ?? null,
            'ubicacion'         => trim($this->request->getPost('ubicacion')) ?? null,
            'caracteristicas'   => trim($this->request->getPost('caracteristicas')) ?? null,
            'created_by'        => session('usuario_nombre'),
            'updated_by'        => session('usuario_nombre'),
        ];

        // Insertar los datos de la jaula
        $this->jaulasModel->insert($datos);

        return redirect()->to(site_url('jaulas'))->with('success', 'Jaula creada correctamente.');
    }

    public function show($id = null)
    {
        $jaula = $this->jaulasModel->find($id);
        return view('jaulas/show', ['jaula' => $jaula]);
    }

    public function edit($id = null)
    {
        $jaula = $this->jaulasModel->find($id);
    
        if (!$jaula) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Jaula no encontrada");
        }
    
        return view('jaulas/edit', ['jaula' => $jaula, 'socios' => $this->socios]);
    
    }

    public function update()
    {
        $id = $this->request->getPost('id') ?? null;

        // Reglas de validación
        $rules = [
            'etiqueta'          => "required|min_length[3]|max_length[20]",
            'propietario'       => "required",
            'caracteristicas'   => "permit_empty",
            'descripcion'       => "permit_empty",
            'ubicacion'         => "required",
        ];
        // Validar los datos del formulario
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        // Actualizar los datos de la jaula        
        $this->jaulasModel->update($id, [
            'etiqueta'          => $this->request->getPost('etiqueta'),
            'estado'            => $this->request->getPost('estado'),
            'propietario'       => $this->request->getPost('propietario') ?? null,
            'descripcion'       => trim($this->request->getPost('descripcion')) ?? null,
            'ubicacion'         => trim($this->request->getPost('ubicacion')) ?? null,
            'caracteristicas'   => trim($this->request->getPost('caracteristicas')) ?? null,
            'updated_by'        => session('usuario_nombre'),
       ]);
    
        return redirect()->to(site_url('jaulas'))->with('message', 'Jaula actualizada correctamente');
    }


    public function delete()
    {
        
        $id = $this->request->getPost('id') ?? null;

        if (!$id) {
            return redirect()->to('/jaulas')->with('error', 'ID de jaula no proporcionado.');
        }
        
        $this->jaulasModel->delete($id);

        return redirect()->to('/jaulas')->with('success', 'Jaula eliminada correctamente.');
    
    }

    public function pdf_list()
    {
        $jaulas = $this->jaulasModel->findAll();

        $html = view('jaulas/pdf_list', ['jaulas' => $jaulas]);

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