<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\UsuariosModel;

class UsuariosController extends BaseController
{
    
    public $usuariosModel;
    public $niveles;
    public $estados;
    public $textosColores;
    
    public function __construct()
    {
        $this->usuariosModel = new UsuariosModel();
        $this->niveles = ['user' => 'Usuario', 'admin' => 'Administrador', 'super' => 'Dios'];
        $this->estados = ['activo' => 'Activo', 'inactivo' => 'Inactivo', 'pendiente' => 'Pendiente'];

        $this->textosColores = [
            'activo' => '',
            'inactivo' => 'text-secondary',
            'pendiente' => 'text-warning'
        ];
    }
    
    public function list()
    {
        $usuarios = $this->usuariosModel->where(['usuario !=' => 'superadmin'])->orderBy('nombre','ASC')->findAll();
        
        return view('usuarios/list', ['usuarios' => $usuarios, 'niveles' => $this->niveles, 'textosColores' => $this->textosColores]);
    }

    public function new()
    {
        return view('usuarios/new');
    }

    public function store()
    {
        $rules = [
            'usuario'       => 'required|min_length[3]|max_length[100]|is_unique[usuarios.usuario]',
            'nombre'        => 'required|min_length[3]|max_length[100]',
            'telefono'      => 'permit_empty|max_length[20]',
            'email'         => 'valid_email|is_unique[usuarios.email]|max_length[100]',
        ];
        
        if (!$this->validate($rules)) {
            return view('usuarios/new', [
                'validation' => $this->validator
            ]);
        }
        
        $nivel = $this->request->getPost('nivel') ? 'admin' : 'user';
        
        $token = bin2hex(random_bytes(16));
        
        $datos = [
            'usuario'       => $this->request->getPost('usuario'),
            'nombre'        => $this->request->getPost('nombre'),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $this->request->getPost('email'),
            'password'      => bin2hex(random_bytes(16)),
            'nivel'         => $nivel,
            'estado'        => 'pendiente',
        ];
    
        $this->usuariosModel->insert($datos);

        $this->enviarCorreoConfirmacion($datos['email'], $datos['nombre'], $datos['password']);        
    
        return redirect()->to(site_url('usuarios'))->with('success', 'Usuario creado correctamente.');
    }

    public function enviarCorreoConfirmacion($correo,$nombre,$token)
    {

        $subject = 'Confirmación de cuenta';
        $message = "Hola $nombre:\n\nTu cuenta ha sido creada exitosamente.\n\nTu contraseña será la que introduzcas al iniciar sesión por primera vez desde este ";
        $message .= "<a href='".base_url("primerLogin/$token")."' target='_blank'>enlace</a>.\n\nPor favor, asegúrate de cambiarla después de iniciar sesión.\n\nSaludos,\nTu protectora"; 

        $email = \Config\Services::email();
        $email->setTo($correo);
        $email->setSubject($subject);
        $email->setMessage(nl2br($message));   

        if(!$email->send()) {
            dd('Error al enviar el correo de confirmación: ' . $email->printDebugger());
        }

    }

    public function show($id = null)
    {
        $usuario = $this->usuariosModel->find($id);
        return view('usuarios/show', ['usuario' => $usuario, 'niveles' => $this->niveles, 'estados' => $this->estados]);
    }

    public function edit($id = null)
    {
        $usuario = $this->usuariosModel->find($id);
    
        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario no encontrado");
        }
    
        return view('usuarios/edit', ['usuario' => $usuario]);
    
    }

    public function update()
    {

        $id = $this->request->getPost('id') ?? null;

        $usuario = $this->usuariosModel->find($id);
        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario no encontrado");
        }
    
        $rules = [
            'nombre'        => "required",
            'telefono'      => "permit_empty|regex_match[/^[0-9\-\s]+$/]",
            'email'         => "valid_email|is_unique[usuarios.email,id,{$id}]",
            'estado'        => "required|in_list[activo,inactivo]",
            'nivel'         => "required|in_list[admin,user]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Por favor, corrige los errores.')
                ->with('validation', $this->validator);
        }

        $this->usuariosModel->update($id, [
            'nombre'        => $this->request->getPost('nombre'),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $this->request->getPost('email'),
            'estado'        => $this->request->getPost('estado'),
            'nivel'         => $this->request->getPost('nivel'),
        ]);
    
        return redirect()->to(site_url('usuarios'))->with('message', 'Usuario actualizado correctamente');
    }

    public function delete()
    {
        
        $id = $this->request->getPost('id') ?? null;
        
        $usuario = $this->usuariosModel->find($id);

        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado.');
        }
    
        $this->usuariosModel->delete($id);

        if($id == session('usuario_id')) {
            return redirect()->to('/salir');
        }
    
        return redirect()->to('/usuarios')->with('success', 'usuario eliminado correctamente.');
    
    }

    public function perfilDatosEdit()
    {
        $usuario = $this->usuariosModel->find(session('usuario_id'));

        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario no encontrado");
        }
        
        return view('usuarios/perfilDatos', ['usuario' => $usuario]);
    }

    public function perfilDatosUpdate()
    {
        $id = session('usuario_id');

        $usuario = $this->usuariosModel->find($id);
        
        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario no encontrado");
        }
        $rules = [
            'nombre'        => "required",
            'telefono'      => "permit_empty|regex_match[/^[0-9\-\s]+$/]",
            'email'         => "valid_email|is_unique[usuarios.email,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Por favor, corrige los errores.')
                ->with('validation', $this->validator);
        }

        $this->usuariosModel->update($id, [
            'nombre'        => $this->request->getPost('nombre'),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $this->request->getPost('email'),
        ]);

        return redirect()->to(site_url('/'));
    }

    public function perfilPasswordEdit()
    {
        $usuario = $this->usuariosModel->find(session('usuario_id'));

        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario no encontrado");
        }
        
        return view('usuarios/perfilPassword', ['usuario' => $usuario]);
    }

    public function perfilPasswordUpdate()
    {
        $id = session('usuario_id');

        $usuario = $this->usuariosModel->find($id);
        
        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario no encontrado");
        }
        $rules = [
            'password'         => 'required',
            'repite_Password'  => 'required|matches[password]',

        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Por favor, corrige los errores.')
                ->with('validation', $this->validator);
        }

        $passwordHash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $this->usuariosModel->update($id, [
            'password'        => $passwordHash,
        ]);
        
        return redirect()->to(site_url('salir'));
    }

    public function pdf_list()
    {
        $usuariosModel = new UsuariosModel();
        $usuarios = $this->usuariosModel->where(['usuario !=' => 'superadmin'])->orderBy('nombre','ASC')->findAll();

        $html = view('usuarios/pdf_list', ['usuarios' => $usuarios]);

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