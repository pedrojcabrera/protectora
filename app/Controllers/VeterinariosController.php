<?php

namespace App\Controllers;

use \App\Models\VeterinariosModel;

use Dompdf\Dompdf;
use Dompdf\Options;

use CodeIgniter\HTTP\ResponseInterface;

class VeterinariosController extends BaseController
{
    /**
    * Return an array of resource objects, themselves in array format.
    *
    * @return ResponseInterface
    */

    public $veterinariosModel;
    
    public function __construct()
    {
        $this->veterinariosModel = new VeterinariosModel;
    }

    public function index()
    {
        
    }
    
    public function list()
    {
        $veterinarios = $this->veterinariosModel->orderBy('nombre','ASC')->findAll();
        
        return view('veterinarios/list', ['veterinarios' => $veterinarios]);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $veterinario = $this->veterinariosModel->find($id);
        return view('veterinarios/show', ['veterinario' => $veterinario]);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('veterinarios/new');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function store()
    {
        $rules = [
            'nombre'        => 'required|min_length[3]|max_length[100]',
            'telefono'      => 'permit_empty|max_length[20]',
            'email'         => 'permit_empty|valid_email|max_length[100]',
            'direccion'     => 'permit_empty|max_length[500]',
            'observaciones' => 'permit_empty|max_length[500]',
        ];
    
        if (!$this->validate($rules)) {
            return view('veterinarios/new', [
                'validation' => $this->validator
            ]);
        }
    
        $datos = [
            'nombre'        => $this->request->getPost('nombre'),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $this->request->getPost('email'),
            'direccion'     => $this->request->getPost('direccion'),
            'observaciones' => $this->request->getPost('observaciones'),
        ];
    
        $modelo = new \App\Models\VeterinariosModel();
        $modelo->insert($datos);
    
        return redirect()->to(site_url('veterinarios'))->with('success', 'Veterinario creado correctamente.');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        $veterinario = $this->veterinariosModel->find($id);
    
        if (!$veterinario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Veterinario no encontrado");
        }
    
        return view('veterinarios/edit', ['veterinario' => $veterinario]);
    
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update()
    {

        $id = $this->request->getPost('id') ?? null;

        $veterinario = $this->veterinariosModel->find($id);
        if (!$veterinario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Veterinario no encontrado");
        }
    
        $rules = [
            'nombre'        => 'required|min_length[3]',
            'direccion'     => 'required',
            'telefono'      => 'permit_empty|regex_match[/^[0-9\-\s]+$/]',
            'email'         => 'permit_empty|valid_email',
            'observaciones' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Por favor, corrige los errores.')
                ->with('validation', $this->validator);
        }

        $this->veterinariosModel->update($id, [
            'nombre'        => $this->request->getPost('nombre'),
            'direccion'     => $this->request->getPost('direccion'),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $this->request->getPost('email'),
            'observaciones' => $this->request->getPost('observaciones'),
        ]);
    
        return redirect()->to(site_url('veterinarios'))->with('message', 'Veterinario actualizado correctamente');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete()
    {

        $id = $this->request->getPost('id') ?? null;

        $veterinario = $this->veterinariosModel->find($id);

        if (!$veterinario) {
            return redirect()->to('/veterinarios')->with('error', 'Veterinario no encontrado.');
        }
    
        $this->veterinariosModel->delete($id);
    
        return redirect()->to('/veterinarios')->with('success', 'Veterinario eliminado correctamente.');
    
    }
    public function pdf_list()
    {
        $veterinariosModel = new VeterinariosModel();
        $veterinarios = $this->veterinariosModel->orderBy('nombre','ASC')->findAll();

        $html = view('veterinarios/pdf_list', ['veterinarios' => $veterinarios]);

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