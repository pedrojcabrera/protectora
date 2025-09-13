<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UsuariosModel;
use App\Models\ProtectorasModel;

class LoginController extends BaseController
{
    
    protected $helpers = ['form'];
    public $usuariosModel;
    public $protectorasModel;
    
    public function __construct()
    {
        $this->usuariosModel = new UsuariosModel();
        $existe = $this->usuariosModel->where('usuario', 'superadmin')->first();
        if(!$this->usuariosModel->where('usuario', 'superadmin')->first())
        {
            $this->usuariosModel->insert([
                'usuario' => 'superadmin',
                'nombre' => 'Dios',
                'password' => password_hash('Super46134', PASSWORD_DEFAULT),
                'estado' => 'activo',
                'nivel' => 'super']);
        }
        if(!$this->usuariosModel->where('usuario', 'pruebas')->first())
        {
            $this->usuariosModel->insert([
                'usuario' => 'pruebas',
                'nombre' => 'Usuario temporal para pruebas',
                'password' => password_hash('pruebas', PASSWORD_DEFAULT),
                'estado' => 'activo',
                'nivel' => 'admin']);
        }
        $this->protectorasModel = new ProtectorasModel();
        $protectora = $this->protectorasModel->first();
        session('protectora', $protectora);
        session()->set('prote_nombre', $protectora->nombre);
        session()->set('prote_nombre_corto', $protectora->nombre_corto);
        session()->set('prote_logo', $protectora->logo);
        session()->set('prote_iban', $protectora->iban);
        session()->set('prote_bic', $protectora->swifth_bic);
        session()->set('prote_cuota_anual', $protectora->cuota_anual);
        session()->set('prote_dia_remesa', $protectora->dia_remesa);
    }

    public function index()
    {
        if (session('is_loged')) {
            return redirect()->to('/');
        }
        return view('login');
    }
    
    public function acceso()
    {
        $rules = [
            'usuario' => 'required',
            'password' => 'required',
        ];

        if(!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        $usuario = trim($usuario);
        $password = trim($password);

        $pendiente = $this->usuariosModel->where('usuario', $usuario)
                                ->where('estado', 'pendiente')
                                ->first();

        if ($pendiente) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $estado = 'activo';
            $this->usuariosModel->update($pendiente->id, [
                'password' => $password,
                'estado' => $estado
            ]);
            session()->setFlashdata('success', 'Usuario activado correctamente. Por favor, inicie sesión.');
            return redirect()->to('login');
        }
        
        if (empty($usuario) || empty($password)) {
            return redirect()->back()->with('error', 'Usuario y contraseña son requeridos');
        }


        $usuario = $this->usuariosModel->where('usuario', $usuario)
                                ->where('estado', 'activo')
                                ->first();

        if ($usuario && password_verify($password, $usuario->password)) {
            session()->set([
                'usuario_id' => $usuario->id,
                'usuario_usuario' => $usuario->usuario,
                'usuario_nombre' => $usuario->nombre,
                'usuario_nivel' => $usuario->nivel,
                'is_loged' => true
            ]);
            return redirect()->to('/')->with('success', 'Bienvenido ' . $usuario->nombre);
        }

        return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function primerLogin($token)
    {
        $usuario = $this->usuariosModel->where('password', $token)->first();
        if($usuario) {
            if (session('is_loged')) {
                session()->destroy();
            }
            $datos = [
                'usuario' => $usuario,
            ];
            return view('primerLogin', $datos);
        } else {
            return view('loginNoValido');
        }
    }

    public function primerAcceso()
    {
        $rules = [
            'password' => 'required',
            'repitePassword' => 'required|matches[password]',

        ];

        if(!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        $id = $this->request->getPost('id');
        $password = $this->request->getPost('password');

        $password = trim($password);

        $this->usuariosModel->update($id, [
            'password'  => password_hash($password,PASSWORD_DEFAULT),
            'estado'    => 'activo',
        ]);

        session()->setFlashdata('success', 'Usuario activado correctamente. Por favor, inicie sesión.');

        $usuario = $this->usuariosModel->find($id);
        $correo  = trim($usuario->email);
        $nombre  = trim($usuario->nombre);
        
        $subject  = 'Confirmación de cuenta';
        $message  = "Hola $nombre.\n\nYa puedes acceder a la aplicación web de la protectora, recuerda usar la contraseña que indicaste.\n\n";
        $message .= "Que tus acesos sean productivos y la suerte te acompañe.\n\n\nLos servicios gestores de\nLa Protectora"; 

        $email = \Config\Services::email();
        $email->setTo($correo);
        $email->setSubject($subject);
        $email->setMessage(nl2br($message));   

        if(!$email->send()) {
            dd('Error al enviar el correo de confirmación: ' . $email->printDebugger());
        }

        session()->destroy();
        return view('altaRealizada');
    }

}