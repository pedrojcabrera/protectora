<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\ColoniasModel;
use App\Models\SociosModel;

class ColoniasController extends BaseController
{
    
    public $coloniasModel;
    public $sociosModel;
    public $socios;
    public $tipos;

    
    public function __construct()
    {
        $this->coloniasModel = new ColoniasModel();
        $this->sociosModel = new SociosModel();

        $this->socios = $this->sociosModel->orderBy('nombre','ASC')->findAll();
        $this->tipos = [
            'punto de alimentación urbano',
            'punto de alimentación rural',
            'casa de cogida',
            'recinto animal controlado',
        ];
    }
    
    public function list()
    {
        //$colonias = $this->coloniasModel->orderBy('nombre','ASC')->findAll();
        $colonias = $this->coloniasModel->getColonias();
        
        return view('colonias/list', ['colonias' => $colonias]);
    }

    public function new()
    {
        return view('colonias/new',['socios' => $this->socios, 'tipos' => $this->tipos]);
    }

    public function store()
    {
        $rules = [
            'nombre'        => "required|min_length[3]|max_length[100]",
            'tipo'          => "required|in_list[" . implode(',', $this->tipos) . "]",
            'ubicacion'     => "permit_empty",
            'gps'           => "permit_empty|is_unique[colonias.gps]",
            'responsable'   => "required|is_not_unique[socios.id]",
            'observaciones' => "permit_empty",
        ];
        
        // Validar los datos del formulario       

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        
        $datos = [
            'nombre'        => $this->request->getPost('nombre'),
            'tipo'          => $this->request->getPost('tipo'),
            'ubicacion'     => trim($this->request->getPost('ubicacion') ?? null),
            'gps'           => $this->request->getPost('gps') ?? null,
            'responsable_id'=> trim($this->request->getPost('responsable') ?? null),
            'adjunto_id'    => trim($this->request->getPost('adjunto') ?? null),
            'observaciones' => trim($this->request->getPost('observaciones') ?? null),
            'created_by'    => session('usuario_nombre'),
            'updated_by'    => session('usuario_nombre'),
        ];
    
        $this->coloniasModel->insert($datos);

        return redirect()->to(site_url('colonias'))->with('success', 'Colonia creada correctamente.');
    }

    public function show($id = null)
    {
        $colonia = $this->coloniasModel->getColonias($id);
        
        if (!$colonia) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Colonia no encontrada");
        }

        if($colonia->gps) {
            $partes = explode(",", $colonia->gps);
            
            $lat  = trim($partes[0]);
            $lng  = trim($partes[1]);

        } else {

            $lat  = false;
            $lng = false;
        }
        
        return view('colonias/show', ['colonia' => $colonia, 'lat' => $lat, 'lng' => $lng]);
    }

    public function showMapa($id = null)
    {
        if(!isset($id)) {
            $colonias = $this->coloniasModel->getSoloColonias();
        } else {
            $colonias = $this->coloniasModel->getSoloColoniasDeSocio($id);
        }

        $puntos = [];

        foreach ($colonias as $colonia) {
            if($colonia->gps) {
                $partes = explode(",", $colonia->gps);
                // Opcional: quitar espacios en blanco
                $lat = trim($partes[0]);
                $lon = trim($partes[1]);
                $nom = esc($colonia->nombre);
                $tip = str_ends_with(esc($colonia->tipo), 'urbano') ? 'urb' : 'rur';
                $res = '<small>'.esc($colonia->responsable_nombre).'</small>';
                $puntos[] = [
                    'lat' => $lat,
                    'lon' => $lon,
                    'nom' => $nom,
                    'res' => $res,
                    'tip' => $tip,
                ];
            } else {
                $puntos = null;
            }
        }

        $datos = ['colonias' => $colonias, 'puntos' => $puntos];
        if(isset($id)) {
            $socio = $this->sociosModel->find($id);
            $datos['id'] = $socio->id;
            $datos['responsable'] = $socio->nombre;
        }
        return view('colonias/showMapa', $datos);
    }

    public function edit($id = null)
    {
        $colonia = $this->coloniasModel->getColonias($id);
    
        if (!$colonia) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Colonia no encontrada");
        }
    
        return view('colonias/edit', ['colonia' => $colonia, 'socios' => $this->socios, 'tipos' => $this->tipos]);
    
    }

    public function update()
    {

        $id = $this->request->getPost('id') ?? null;

        $colonia = $this->coloniasModel->getColonias($id);
        
        if (!$colonia) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Colonia no encontrada");
        }
    
        $rules = [
            'nombre'        => "required|min_length[3]|max_length[100]",
            'tipo'          => "required|in_list[" . implode(',', $this->tipos) . "]",
            'ubicacion'     => "permit_empty",
            'gps'           => "permit_empty|is_unique[colonias.gps,id,$id]",
            'responsable'   => "required",
            'observaciones' => "permit_empty",
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
            ->withInput()
            ->with('error', 'Por favor, corrige los errores.')
            ->with('validation', $this->validator);
        }
        
        $this->coloniasModel->update($id, [
            'nombre'        => $this->request->getPost('nombre'),
            'tipo'          => $this->request->getPost('tipo'),
            'ubicacion'     => trim($this->request->getPost('ubicacion') ?? null),
            'gps'           => $this->request->getPost('gps') ?? null,
            'responsable_id'=> trim($this->request->getPost('responsable') ?? null),
            'adjunto_id'    => trim($this->request->getPost('adjunto') ?? null),
            'observaciones' => trim($this->request->getPost('observaciones') ?? null),
            'updated_by'    => session('usuario_nombre'),
       ]);
    
        return redirect()->to(site_url('colonias'))->with('message', 'Colonia actualizada correctamente');
    }


    public function delete()
    {
        
        $id = $this->request->getPost('id') ?? null;
        
        $colonia = $this->coloniasModel->find($id);

        if (!$colonia) {
            return redirect()->to('/colonias')->with('error', 'Colonia no encontrada.');
        }
    
        $this->coloniasModel->delete($id);

        return redirect()->to('/colonias')->with('success', 'Colonia eliminada correctamente.');
    
    }

    public function pdf_list()
    {
        $colonias = $this->coloniasModel->getColonias();

        $html = view('colonias/pdf_list', ['colonias' => $colonias]);

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