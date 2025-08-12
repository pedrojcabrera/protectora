<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\RazasModel;
use App\Models\EspeciesModel;
use App\Models\ColoniasModel;
use App\Models\AnimalesModel;
use App\Models\ProvinciasModel;
use App\Models\PoblacionesModel;
use App\Models\SitiosModel;

class AnimalesController extends BaseController
{
    
    public $animalesModel;
    public $coloniasModel;
    public $especiesModel;
    public $razasModel;
    public $provinciasModel;
    public $poblacionesModel;
    public $especies;
    public $colonias;
    public $provincias;
    public $pesos;
    
    public function __construct()
    {
        $this->razasModel = new RazasModel();
        $this->especiesModel = new EspeciesModel();
        $this->animalesModel = new AnimalesModel();
        $this->coloniasModel = new ColoniasModel();
        $this->provinciasModel = new ProvinciasModel();
        $this->poblacionesModel = new PoblacionesModel();
        
        $this->especies = $this->especiesModel->orderBy('especie', 'ASC')->findAll();
        $this->colonias = $this->coloniasModel->getColonias();
        $this->provincias = $this->provinciasModel->orderBy('provincia', 'ASC')->findAll();

        $this->pesos = [
				"Toy" => "Menos de 5kg.",
				"Pequeño" => "De 5 a 10kg.",
				"Mediano" => "De 10 a 25kg.",
				"Grande" => "De 25 a 35kg.",
				"Gigante" => "Más de 35kg.",
		        ];
    }
    
    public function list()
    {
        $animales = $this->animalesModel->findAll();
        return view('animales/list', ['animales' => $animales]);
    }

    public function new()
    {
        return view('animales/new',[
            'especies'      => $this->especies,
            'colonias'      => $this->colonias,
            'provincias'    => $this->provincias,
            'pesos'         => $this->pesos,
        ]);
    }

    public function store()
    {
        $rules = [
            'nombre'            => "required|min_length[3]|max_length[30]",
            'colonia'           => "required",
            'especie_id'        => "required",
            'raza_id'           => "required",
            'genero'            => "required",
            'peso'              => "required",
            'poblacion'         => "required",
            'provincia'         => "required",
            'se_entrega'        => "required|permit_empty",
            'compatible_con'    => "required|permit_empty",
            'personalidad'      => "required|permit_empty",
            'estado'            => "required|permit_empty",
            'observaciones'     => "required|permit_empty",
        ];
        
        // Validar los datos del formulario       

        if (!$this->validate($rules)) {
            // Solo POST, no FILES
            $input = $this->request->getPost();
            return redirect()->back()
                ->with('old', $input)
                ->with('validation', $this->validator);
        }

        $se_entrega         = $this->request->getPost('se_entrega') ? implode(",", $this->request->getPost('se_entrega')) : '';
        $compatible_con     = $this->request->getPost('compatible_con') ? implode(",", $this->request->getPost('compatible_con')) : '';
        $personalidad       = $this->request->getPost('personalidad') ? implode(",", $this->request->getPost('personalidad')) : '';
        $estado             = $this->request->getPost('estado') ? implode(",", $this->request->getPost('estado')) : '';
        
        $datos = [
            'nombre'            => $this->request->getPost('nombre'),
            'colonia_id'        => $this->request->getPost('colonia'),
            'especie_id'        => $this->request->getPost('especie_id'),
            'raza_id'           => $this->request->getPost('raza_id'),
            'genero'            => $this->request->getPost('genero'),
            'peso'              => $this->request->getPost('peso'),
            'provincia'         => $this->request->getPost('provincia'),
            'poblacion'         => $this->request->getPost('poblacion'),
            'fecha_nacimiento'  => $this->request->getPost('fecha_nacimiento') ?? null,
            'puede_viajar'      => $this->request->getPost('puede_viajar') ?? '0',
            'se_entrega'        => $se_entrega,
            'compatible_con'    => $compatible_con,
            'personalidad'      => $personalidad,
            'estado'            => $estado,
            'via_de_adopcion'   => $this->request->getPost('via_de_adopcion') ?? null,
            'observaciones'     => $this->request->getPost('observaciones') ?? null,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?? null,
            'descripcion_larga' => $this->request->getPost('descripcion_larga') ?? null,
            'created_by'        => session('usuario_nombre'),
            'updated_by'        => session('usuario_nombre'),
        ];
    

        // $db = \Config\Database::connect();
        // $builder = $db->table('animales');

        // $sql = $builder->set($datos)->getCompiledInsert();
        // dd($sql);


        $ultimoId = $this->animalesModel->insert($datos);

        $foto = $this->request->getFile('fotoCarnet');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!in_array($foto->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return redirect()->back()
                    ->with('old', $this->request->getPost())
                    ->with('error', 'La imagen debe ser JPG, PNG o WEBP');
            }

            if ($foto->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()
                    ->with('old', $this->request->getPost())
                    ->with('error', 'La imagen no puede superar los 2MB');
            }

            $nombre = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/imagenes/animales', $nombre);
            $ruta = 'imagenes/animales/' . $nombre;
        } else {
            $ruta = null; // No se subió imagen
        }

        $this->animalesModel->update($ultimoId,['foto' => $ruta]);

        return redirect()->to(site_url('animales'))->with('success', 'Animal creado correctamente.');
    }

    public function show($id = null)
    {
        $animal = $this->animalesModel->getAnimales($id);
        $provincia = $this->provinciasModel->find($animal->provincia);
        $poblacion = $this->poblacionesModel->find($animal->poblacion);

        return view('animales/show', [
            'animal'    => $animal,
            'poblacion' => $poblacion,
            'provincia' => $provincia,
            'pesos'     => $this->pesos,
        ]);
    }

    public function edit($id = null)
    {
        $animal = $this->animalesModel->getAnimales($id);
        
        return view('animales/edit',[
            'animal'        => $animal,
            'especies'      => $this->especies,
            'colonias'      => $this->colonias,
            'provincias'    => $this->provincias,
            'pesos'         => $this->pesos,
        ]);
  
    }

    public function update()
    {
        $id = $this->request->getPost('id') ?? null;

        $animal = $this->animalesModel->getAnimales($id);
        
        if (!$animal) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Animal no encontrado");
        }
    
        $rules = [
            'nombre'            => "required|min_length[3]|max_length[30]",
            'colonia'           => "required",
            'especie_id'        => "required",
            'raza_id'           => "required",
            'genero'            => "required",
            'peso'              => "required",
            'poblacion'         => "required",
            'provincia'         => "required",
            'se_entrega'        => "permit_empty",
            'compatible_con'    => "permit_empty",
            'personalidad'      => "permit_empty",
            'estado'            => "permit_empty",
            'observaciones'     => "permit_empty",
        ];
        
        // Validar los datos del formulario       


        if (!$this->validate($rules)) {
            // Solo POST, no FILES
            $input = $this->request->getPost();
            return redirect()->back()
                ->with('old', $input)
                ->with('validation', $this->validator);
        }

        $se_entrega         = $this->request->getPost('se_entrega') ? implode(",", $this->request->getPost('se_entrega')) : '';
        $compatible_con     = $this->request->getPost('compatible_con') ? implode(",", $this->request->getPost('compatible_con')) : '';
        $personalidad       = $this->request->getPost('personalidad') ? implode(",", $this->request->getPost('personalidad')) : '';
        $estado             = $this->request->getPost('estado') ? implode(",", $this->request->getPost('estado')) : '';
        
        $datos = [
            'nombre'            => $this->request->getPost('nombre'),
            'colonia_id'        => $this->request->getPost('colonia'),
            'especie_id'        => $this->request->getPost('especie_id'),
            'raza_id'           => $this->request->getPost('raza_id'),
            'genero'            => $this->request->getPost('genero'),
            'peso'              => $this->request->getPost('peso'),
            'provincia'         => $this->request->getPost('provincia'),
            'poblacion'         => $this->request->getPost('poblacion'),
            'fecha_nacimiento'  => $this->request->getPost('fecha_nacimiento') ?? null,
            'puede_viajar'      => $this->request->getPost('puede_viajar') ?? '0',
            'se_entrega'        => $se_entrega,
            'compatible_con'    => $compatible_con,
            'personalidad'      => $personalidad,
            'estado'            => $estado,
            'via_de_adopcion'   => $this->request->getPost('via_de_adopcion') ?? null,
            'observaciones'     => $this->request->getPost('observaciones') ?? null,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?? null,
            'descripcion_larga' => $this->request->getPost('descripcion_larga') ?? null,
            'updated_by'        => session('usuario_nombre'),
        ];

        if ($this->request->getPost('quitar_foto')) {
            // Borrar el archivo físico si existe
            $rutaFoto = base_url($animal->foto);
            if (!empty($animal->foto) && file_exists($rutaFoto)) {
                unlink($rutaFoto);
            }
            // Quitar el nombre de la foto para que no quede en la base de datos
            $minidatos = ['foto' => null];
            $this->animalesModel->update($id,$minidatos);
        }
        
        $foto = $this->request->getFile('fotoCarnet');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!in_array($foto->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return redirect()->back()
                    ->with('old', $this->request->getPost())
                    ->with('error', 'La imagen debe ser JPG, PNG o WEBP');
            }

            if ($foto->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()
                    ->with('old', $this->request->getPost())
                    ->with('error', 'La imagen no puede superar los 2MB');
            }

            $nombre = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/imagenes/animales', $nombre);
            $ruta = 'imagenes/animales/' . $nombre;
        } else {
            $ruta = null; // No se subió imagen
        }

        if ($ruta != null) {
            if (file_exists(base_url($animal->foto))) {
                unlink (base_url($animal->foto));
            }

            $datos['foto'] = $ruta;
        }

        $this->animalesModel->update($id,$datos);
    
        return redirect()->to(site_url('animales'))->with('message', 'Animal actualizado correctamente');
    }


    public function delete()
    {
        
        $id = $this->request->getPost('id') ?? null;
        
        $animal = $this->animalesModel->find($id);

        if (!$animal) {
            return redirect()->to('/animales')->with('error', 'Animal no encontrado.');
        }
    
        if(file_exists(base_url($animal->foto))) {
            unlink(base_url($animal->foto));
        }

        $this->animalesModel->delete($id);

        return redirect()->to('/animales')->with('success', 'Animal eliminado correctamente.');
    
    }

    public function pdf_list()
    {
        $animales = $this->animalesModel->getAnimales();
        $provincias = $this->provinciasModel->findAll();
        $poblaciones = $this->poblacionesModel->findAll();

        $html = view('animales/pdf_list',
            [
            'animales'      => $animales,
            'poblaciones'   => $poblaciones,
            'provincias'    => $provincias,
            'pesos'         => $this->pesos,
        ]);

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