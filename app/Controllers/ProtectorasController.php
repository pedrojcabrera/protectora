<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProtectorasModel;

class ProtectorasController extends BaseController
{
    protected $protectorasModel;

    public function __construct()
    {
        $this->protectorasModel = new ProtectorasModel();
    }

    public function index()
    {
        // Obtener único registro o crear si no existe
        $protectora = $this->protectorasModel->first();

        if (!$protectora) {
            $id = $this->protectorasModel->insert([
                'nombre'        => '',
                'nombre_corto'  => '',
                'nif'           => '',
                'dirección'     => '',
                'codpostal'     => '',
                'poblacion'     => '',
                'provincia'     => '',
                'telefono'      => '',
                'email'         => '',
                'logo'          => '',
                'banco'         => '',
                'iban'          => '',
                'swifth_bic'    => '',
                'cuota_anual'   => 0,
                'dia_remesa'    => 5,
            ]);
            $protectora = $this->protectorasModel->find($id);
        }

        return view('protectoras/form', [
            'protectora' => $protectora
        ]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        // Obtener datos actuales
        $protectora = $this->protectorasModel->find($id);

        $data = [
            'nombre'        => $this->request->getPost('nombre'),
            'nombre_corto'  => $this->request->getPost('nombre_corto'),
            'nif'           => $this->request->getPost('nif'),
            'dirección'     => $this->request->getPost('dirección'),
            'codpostal'     => $this->request->getPost('codpostal'),
            'poblacion'     => $this->request->getPost('poblacion'),
            'provincia'     => $this->request->getPost('provincia'),
            'telefono'      => $this->request->getPost('telefono'),
            'email'         => $this->request->getPost('email'),
            'banco'         => $this->request->getPost('banco'),
            'swifth_bic'   => $this->request->getPost('swifth_bic'),
            'iban'          => $this->request->getPost('iban'),
            'cuota_anual'   => $this->request->getPost('cuota_anual'),
            'dia_remesa'    => $this->request->getPost('dia_remesa'),
        ];

        $file = $this->request->getFile('logo');
        // Si se marca eliminar logo
        if ($this->request->getPost('delete_logo') == '1') {
            if ($protectora && $protectora->logo && file_exists(FCPATH . 'imagenes/protectora/' . $protectora->logo)) {
                unlink(FCPATH . 'imagenes/protectora/' . $protectora->logo);
            }
            $data['logo'] = null;
        }

        // Si hay un nuevo archivo
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Borrar logo anterior si existe
            if ($protectora && $protectora->logo && file_exists(FCPATH . 'imagenes/protectora/' . $protectora->logo)) {
                unlink(FCPATH . 'imagenes/protectora/' . $protectora->logo);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'imagenes/protectora', $newName);
            $data['logo'] = $newName;
        }

        // Actualizar BD
        $this->protectorasModel->update($id, $data);

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
        // Redirigir con mensaje de éxito
        return redirect()->to('/protectora')->with('msg', 'Datos actualizados correctamente');
    }

}