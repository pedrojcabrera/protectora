<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'HomeController::index');

$routes->get('login', 'LoginController::index');
$routes->post('acceso', 'LoginController::acceso');
$routes->get('salir', 'LoginController::salir');
$routes->get('primerLogin/(:hash)', 'LoginController::primerLogin/$1');
$routes->post('primerAcceso', 'LoginController::primerAcceso');

$routes->get('veterinarios', 'VeterinariosController::list');
$routes->get('veterinarios/show/(:num)', 'VeterinariosController::show/$1');
$routes->get('veterinarios/new', 'VeterinariosController::new');
$routes->post('veterinarios/store', 'VeterinariosController::store');
$routes->get('veterinarios/edit/(:num)', 'VeterinariosController::edit/$1');
$routes->put('veterinarios/update', 'VeterinariosController::update');
$routes->post('veterinarios/delete/(:num)', 'VeterinariosController::delete/$1');
$routes->get('veterinarios/pdf', 'VeterinariosController::pdf_list');

$routes->get('usuarios', 'UsuariosController::list');
$routes->get('usuarios/show/(:num)', 'UsuariosController::show/$1');
$routes->get('usuarios/new', 'UsuariosController::new');
$routes->post('usuarios/store', 'UsuariosController::store');
$routes->get('usuarios/edit/(:num)', 'UsuariosController::edit/$1');
$routes->put('usuarios/update', 'UsuariosController::update');
$routes->post('usuarios/delete/(:num)', 'UsuariosController::delete/$1');
$routes->get('usuarios/autoriza/(:hash)', 'UsuariosController::autoriza/$1');
$routes->get('usuarios/perfilDatos', 'UsuariosController::perfilDatosEdit');
$routes->post('usuarios/perfilDatos', 'UsuariosController::perfilDatosUpdate');
$routes->get('usuarios/perfilPassword', 'UsuariosController::perfilPasswordEdit');
$routes->post('usuarios/perfilPassword', 'UsuariosController::perfilPasswordUpdate');
$routes->get('usuarios/pdf', 'UsuariosController::pdf_list');

$routes->get('socios', 'SociosController::list');
$routes->get('socios/show/(:num)', 'SociosController::show/$1');
$routes->get('socios/new', 'SociosController::new');
$routes->post('socios/store', 'SociosController::store');
$routes->get('socios/edit/(:num)', 'SociosController::edit/$1');
$routes->put('socios/update', 'SociosController::update');
$routes->post('socios/delete', 'SociosController::delete');
$routes->get('socios/pdf', 'SociosController::pdf_list');

$routes->get('colonias', 'ColoniasController::list');
$routes->get('colonias/show/(:num)', 'ColoniasController::show/$1');
$routes->get('colonias/new', 'ColoniasController::new');
$routes->post('colonias/store', 'ColoniasController::store');
$routes->get('colonias/edit/(:num)', 'ColoniasController::edit/$1');
$routes->put('colonias/update', 'ColoniasController::update');
$routes->post('colonias/delete', 'ColoniasController::delete');
$routes->get('colonias/pdf', 'ColoniasController::pdf_list');
$routes->get('colonias/showMapa', 'ColoniasController::showMapa');
$routes->get('colonias/showMapa/(:num)', 'ColoniasController::showMapa/$1');

$routes->get('especies', 'EspeciesController::list');
$routes->get('especies/show/(:num)', 'EspeciesController::show/$1');
$routes->get('especies/new', 'EspeciesController::new');
$routes->post('especies/store', 'EspeciesController::store');
$routes->get('especies/edit/(:num)', 'EspeciesController::edit/$1');
$routes->put('especies/update', 'EspeciesController::update');
$routes->post('especies/delete', 'EspeciesController::delete');
$routes->get('especies/pdf', 'EspeciesController::pdf_list');

$routes->get('razas', 'RazasController::list');
$routes->get('razas/show/(:num)', 'RazasController::show/$1');
$routes->get('razas/new', 'RazasController::new');
$routes->post('razas/store', 'RazasController::store');
$routes->get('razas/edit/(:num)', 'RazasController::edit/$1');
$routes->put('razas/update', 'RazasController::update');
$routes->post('razas/delete', 'RazasController::delete');
$routes->get('razas/pdf', 'RazasController::pdf_list');
$routes->get('razas/porEspecie/(:num)', 'RazasController::porEspecie/$1');

$routes->get('jaulas', 'JaulasController::list');
$routes->get('jaulas/show/(:num)', 'JaulasController::show/$1');
$routes->get('jaulas/new', 'JaulasController::new');
$routes->post('jaulas/store', 'JaulasController::store');
$routes->get('jaulas/edit/(:num)', 'JaulasController::edit/$1');
$routes->put('jaulas/update', 'JaulasController::update');
$routes->post('jaulas/delete', 'JaulasController::delete');
$routes->get('jaulas/pdf', 'JaulasController::pdf_list');

$routes->get('animales', 'AnimalesController::list');
$routes->get('animales/show/(:num)', 'AnimalesController::show/$1');
$routes->get('animales/new', 'AnimalesController::new');
$routes->post('animales/store', 'AnimalesController::store');
$routes->get('animales/edit/(:num)', 'AnimalesController::edit/$1');
$routes->put('animales/update', 'AnimalesController::update');
$routes->post('animales/delete', 'AnimalesController::delete');
$routes->get('animales/pdf', 'AnimalesController::pdf_list');

$routes->get('poblaciones/porProvincia/(:num)', 'SitiosController::porProvincia/$1');
$routes->get('razas/porEspecie/(:num)', 'AnimalesController::porEspecie/$1');

$routes->get('protectora', 'ProtectorasController::index');
$routes->post('protectora/update', 'ProtectorasController::update');

$routes->get('remesas/listadoRemesas', 'RemesasController::listadoRemesas');

$routes->get('buscarNuevosRecibos', 'RemesasController::buscarNuevosRecibos');
$routes->get('remesas/exportar', 'RemesasController::exportar');
$routes->get('remesas/cartearRBAN', 'RemesasController::cartaAvisoRecibo');
$routes->get('remesas/cartearICTA', 'RemesasController::cartaAvisoIngreso');
