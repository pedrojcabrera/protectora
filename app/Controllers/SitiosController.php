<?php

namespace App\Controllers;

use App\Models\PoblacionesModel;
use App\Models\ProvinciasModel;

class SitiosController extends BaseController
{
    public $poblacionesModel;
    public $provinciasModel;
    public $provincias;
    
    public function __construct()
    {
        $this->poblacionesModel = new PoblacionesModel();
        $this->provinciasModel = new ProvinciasModel();
        
        $this->provincias= $this->provinciasModel->orderBy('provincia', 'ASC')->findAll();
    }

    public function porProvincia($id = null)
    {

    if ($this->request->isAJAX()) {
        $data = $this->poblacionesModel->where('provincia_id', $id)->findAll();
        return $this->response->setJSON($data);
    }
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
 
    }
}