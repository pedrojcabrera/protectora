<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\SociosModel;
use App\Models\SociosCHModel;

class SociosController extends BaseController
{
    
    public $sociosModel;
    public $historicoModel;
    public $tipos;
    public $modalidadPago;
    public $formas;

    public function __construct()
    {
        $this->sociosModel = new SociosModel();
        $this->historicoModel = new SociosCHModel();
        $this->modalidadPago = ['anual' => 'Anual (1 pago al año)', 'semestral' => 'Semestral (2 pagos al año)', 'cuatrimestral' => 'Cuatrimestral (3 pagos al año)' , 'trimestral' => 'Trimestral (4 pagos al año)', 'mensual' => 'Mensual (12 pagos al año)'];
        $this->tipos = ['socio' => 'Socio', 'colaborador' => 'Colaborador'];
        $this->formas = ['recibo' => 'Recibo', 'ingreso' => 'Ingreso', 'ninguna' => 'Ninguna'];
    }
    
    public function list()
    {
        $socios = $this->sociosModel->orderBy('tipo','DESC')->orderBy('nombre','ASC')->findAll();

        return view('socios/list', ['socios' => $socios, 'tipos' => $this->tipos, 'formas' => $this->formas]);
    }

    public function new()
    {
        return view('socios/new',['tipos' => $this->tipos, 'modalidadPago' => $this->modalidadPago, 'formas' => $this->formas]);
    }

    public function store()
    {
        $rules = [
            'nombre'           => "required|min_length[3]|max_length[100]",
            'telefono'         => "permit_empty|regex_match[/^[0-9]{9}$/]",
            'email'            => "permit_empty|valid_email|is_unique[socios.email]|max_length[150]",
            'tipo'             => "required|in_list[socio,colaborador]",
            'forma_de_pago'    => "required|in_list[recibo,ingreso,ninguna]",
            'direccion'        => "required",
            'codpostal'        => "required|regex_match[/^[0-9]{5}$/]",
            'poblacion'        => "required",
            'provincia'        => "required",
            'observaciones'    => "permit_empty",
            'tipo_documentoId' => "required|in_list[DNI,NIE,NIF]",
            'documentoId'      => "required",
            'fecha_nacimiento' => "required|valid_date",
            'fecha_alta'       => "required|valid_date",
            'foto_dni_anverso' => 'if_exist|is_image[foto_dni_anverso]|max_size[foto_dni_anverso,2048]|mime_in[foto_dni_anverso,image/jpg,image/jpeg,image/png]',
            'foto_dni_reverso' => 'if_exist|is_image[foto_dni_reverso]|max_size[foto_dni_reverso,2048]|mime_in[foto_dni_reverso,image/jpg,image/jpeg,image/png]',
            'entidad_bancaria' => "permit_empty|max_length[50]",
            'iban'             => "permit_empty|regex_match[/^[A-Z]{2}[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/]",
            'mandato'          => "permit_empty",
            'mandato_fecha'    => "permit_empty|valid_date",
            'modalidad_pago'   => "required|in_list[anual,semestral,cuatrimestral,trimestral,mensual,ninguna]",
            'complemento'      => "required|numeric|greater_than_equal_to[0]",
        ];
        
        
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }
        
        $datos = [
            'nombre'        => $this->request->getPost('nombre'),
            'telefono'      => $this->request->getPost('telefono') ?? null,
            'email'         => $this->request->getPost('email'),
            'tipo'          => $this->request->getPost('tipo'),
            'forma_de_pago' => $this->request->getPost('forma_de_pago'),
            'direccion'     => $this->request->getPost('direccion'),
            'codpostal'     => $this->request->getPost('codpostal'),
            'poblacion'     => $this->request->getPost('poblacion'),
            'provincia'     => $this->request->getPost('provincia'),
            'observaciones' => $this->request->getPost('observaciones') ?? null,
            'tipo_documentoId' => $this->request->getPost('tipo_documentoId'),
            'documentoId'      => $this->request->getPost('documentoId'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'fecha_alta'       => $this->request->getPost('fecha_alta'),
            'foto_dni_anverso' => $this->request->getPost('foto_dni_anverso') ?? null,
            'foto_dni_reverso' => $this->request->getPost('foto_dni_reverso') ?? null,
            'entidad_bancaria' => $this->request->getPost('entidad_bancaria') ?? null,
            'iban'             => $this->request->getPost('iban') ?? null,
            'mandato'          => $this->request->getPost('mandato') ?? null,
            'mandato_fecha'    => $this->request->getPost('mandato_fecha'),
            'modalidad_pago'   => $this->request->getPost('modalidad_pago'),
            'complemento'      => $this->request->getPost('complemento') ?? 0,
        ];
    
        $ultimoId = $this->sociosModel->insert($datos);

        $foto = $this->request->getFile('foto_dni_anverso');
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
            $foto->move(ROOTPATH . 'public/imagenes/socios', $nombre);
            $ruta_anverso = 'imagenes/socios/' . $nombre;
        } else {
            $ruta_anverso = null; // No se subió imagen anverso
        }

        $foto = $this->request->getFile('foto_dni_reverso');
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
            $foto->move(ROOTPATH . 'public/imagenes/socios', $nombre);
            $ruta_reverso = 'imagenes/socios/' . $nombre;
        } else {
            $ruta_reverso = null; // No se subió imagen reverso
        }

        if ($datos['mandato'] == null) {
            $this->sociosModel->update($ultimoId, ['mandato' => 'MANDATO-'.date("Y").'-' . str_pad($ultimoId, 5, '0', STR_PAD_LEFT)]);
        }

        $this->sociosModel->update($ultimoId,['foto_dni_anverso' => $ruta_anverso, 'foto_dni_reverso' => $ruta_reverso]);

        return redirect()->to(site_url('socios'))->with('success', 'Socio creado correctamente.');
    }

    public function show($id = null)
    {
        $socio = $this->sociosModel->find($id);
        $ultimoRecibo = $this->historicoModel->ultimoPorSocio($id);
        
        return view('socios/show', ['socio' => $socio, 'tipos' => $this->tipos, 'modalidadPago' => $this->modalidadPago, 'ultimoRecibo' => $ultimoRecibo, 'formas' => $this->formas]);
    }

    public function edit($id = null)
    {
        $socio = $this->sociosModel->find($id);
        $ultimoRecibo = $this->historicoModel->ultimoPorSocio($id);

        if (!$socio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Socio no encontrado");
        }

        return view('socios/edit', ['socio' => $socio, 'tipos' => $this->tipos, 'modalidadPago' => $this->modalidadPago, 'ultimoRecibo' => $ultimoRecibo, 'formas' => $this->formas]);

    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $preSocio = $this->sociosModel->find($id);

        if (!$id || !$preSocio) {
            return redirect()->to('socios')->with('error', 'Socio no encontrado.');
        }

        $rules = [
            'nombre'           => "required|min_length[3]|max_length[100]",
            'telefono'         => "permit_empty|regex_match[/^[0-9]{9}$/]",
            'email'            => "permit_empty|valid_email|is_unique[socios.email,id,{$id}]|max_length[150]",
            'tipo'             => "required|in_list[socio,colaborador]",
            'forma_de_pago'    => "required|in_list[recibo,ingreso,ninguna]",
            'direccion'        => "required",
            'codpostal'        => "required|regex_match[/^[0-9]{5}$/]",
            'poblacion'        => "required",
            'provincia'        => "required",
            'observaciones'    => "permit_empty",
            'tipo_documentoId' => "required|in_list[DNI,NIE,NIF]",
            'documentoId'      => "required",
            'fecha_nacimiento' => "required|valid_date",
            'fecha_alta'       => "required|valid_date",
            'foto_dni_anverso' => "permit_empty|is_image[foto_dni_anverso]|max_size[foto_dni_anverso,2048]|mime_in[foto_dni_anverso,image/jpg,image/jpeg,image/png]",
            'foto_dni_reverso' => "permit_empty|is_image[foto_dni_reverso]|max_size[foto_dni_reverso,2048]|mime_in[foto_dni_reverso,image/jpg,image/jpeg,image/png]",
            'entidad_bancaria' => "permit_empty|max_length[50]",
            'iban'             => "permit_empty|regex_match[/^[A-Z]{2}[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/]",
            'mandato'          => "permit_empty",
            'mandato_fecha'    => "permit_empty|valid_date",
            'modalidad_pago'   => "required|in_list[anual,semestral,cuatrimestral,trimestral,mensual,ninguna]",
            'complemento'      => "required|numeric|greater_than_equal_to[0]",
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $datos = [
            'nombre'              => $this->request->getPost('nombre'),
            'telefono'            => $this->request->getPost('telefono') ?? null,
            'email'               => $this->request->getPost('email'),
            'tipo'                => $this->request->getPost('tipo'),
            'forma_de_pago'       => $this->request->getPost('forma_de_pago'),
            'direccion'           => $this->request->getPost('direccion'),
            'codpostal'           => $this->request->getPost('codpostal'),
            'poblacion'           => $this->request->getPost('poblacion'),
            'provincia'           => $this->request->getPost('provincia'),
            'observaciones'       => $this->request->getPost('observaciones') ?? null,
            'tipo_documentoId'    => $this->request->getPost('tipo_documentoId'),
            'documentoId'         => $this->request->getPost('documentoId'),
            'fecha_nacimiento'    => $this->request->getPost('fecha_nacimiento'),
            'fecha_alta'          => $this->request->getPost('fecha_alta'),
            'entidad_bancaria'    => $this->request->getPost('entidad_bancaria') ?? null,
            'iban'                => $this->request->getPost('iban') ?? null,
            'mandato'             => $this->request->getPost('mandato') ?? null,
            'mandato_fecha'       => $this->request->getPost('mandato_fecha'),
            'modalidad_pago'      => $this->request->getPost('modalidad_pago'),
            'complemento'         => $this->request->getPost('complemento') ?? 0,
        ];

        // Procesar imagen anverso si hay
        $fotoAnverso = $this->request->getFile('foto_dni_anverso');
        if ($fotoAnverso && $fotoAnverso->isValid() && !$fotoAnverso->hasMoved()) {
            $nombre = $fotoAnverso->getRandomName();
            $fotoAnverso->move(ROOTPATH . 'public/imagenes/socios', $nombre);
            $datos['foto_dni_anverso'] = 'imagenes/socios/' . $nombre;
        }

        // Procesar imagen reverso si hay
        $fotoReverso = $this->request->getFile('foto_dni_reverso');
        if ($fotoReverso && $fotoReverso->isValid() && !$fotoReverso->hasMoved()) {
            $nombre = $fotoReverso->getRandomName();
            $fotoReverso->move(ROOTPATH . 'public/imagenes/socios', $nombre);
            $datos['foto_dni_reverso'] = 'imagenes/socios/' . $nombre;
        }

        $foto_dni_anverso = $preSocio->foto_dni_anverso;
        $foto_dni_reverso = $preSocio->foto_dni_reverso;
        
        if($this->request->getPost('borrar_foto_dni_anverso')) {
            if ($foto_dni_anverso) {
                unlink(FCPATH.$foto_dni_anverso);
                $datos['foto_dni_anverso'] = null; // Eliminar referencia si se borra
            }
        }
        
        if($this->request->getPost('borrar_foto_dni_reverso')) {
            if ($foto_dni_reverso) {
                unlink(FCPATH.$foto_dni_reverso);
                $datos['foto_dni_reverso'] = null; // Eliminar referencia si se borra
            }
        }

        // Actualizar los datos del socio
        $this->sociosModel->update($id, $datos);

        return redirect()->to(site_url('socios'))->with('success', 'Socio actualizado correctamente.');
    }

    public function delete()
    {
        
        $id = $this->request->getPost('id') ?? null;
        
        $socio = $this->sociosModel->find($id);

        if (!$socio) {
            return redirect()->to('/socios')->with('error', 'Socio no encontrado.');
        }

        $foto_dni_anverso = $socio->foto_dni_anverso;
        $foto_dni_reverso = $socio->foto_dni_reverso;

        if($this->sociosModel->delete($id)) {
            if ($foto_dni_anverso && file_exists(base_url($foto_dni_anverso))) {
                unlink(base_url($foto_dni_anverso));
            }
            if ($foto_dni_reverso && file_exists(base_url($foto_dni_reverso))) {
                unlink(base_url($foto_dni_reverso));
            }
        }

        return redirect()->to('/socios')->with('success', 'Socio eliminado correctamente.');
    
    }

    public function pdf_list()
    {
        $sociosModel = new SociosModel();
        $socios = $this->sociosModel->orderBy('nombre','ASC')->findAll();

        $html = view('socios/pdf_list', ['socios' => $socios, 'tipos' => $this->tipos]);

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