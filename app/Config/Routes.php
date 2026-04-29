<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// main route
$routes->get('/', function() {
    return redirect()->to('/etudiants');
});

// routes accessible à tous
$routes->get('/login', 'AuthController::form');
$routes->post('/login', 'AuthController::login');
$routes->get('/etudiants', 'EtudiantController::index');
$routes->get('/note/form', 'NoteController::form');

// routes accessible aux utilisateurs connecter (après login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
});

// routes accessible à l'admin et au bibliothecaire
$routes->group('', ['filter' => 'role:admin,bibliothecaire'], function($routes) {

});

// routes accessible à l'admin uniquement
$routes->group('', ['filter' => 'role:admin'], function($routes) {

});