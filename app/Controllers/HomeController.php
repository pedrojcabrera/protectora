<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        if(!session('is_loged')) {
            return redirect()->to('login');
        }
        return view('home', ['title' => 'Panel de Control']);
    }
}