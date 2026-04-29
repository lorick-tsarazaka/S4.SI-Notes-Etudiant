<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// main route
$routes->get('/', function() {
    return session()->get('user') ? redirect()->to('/liste-etudiants') : redirect()->to('/login');
});

// routes accessible à tous
$routes->get('/login', 'AuthController::form');
$routes->post('/login', 'AuthController::login');
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/etudiants', 'EtudiantController::index');
    $routes->get('/liste-etudiants', 'EtudiantController::listes');
    $routes->get('/notes', 'NoteController::index');
    $routes->get('/note/form', 'NoteController::form');
    $routes->post('/note/store', 'NoteController::store');
    $routes->get('/note/edit/(:num)', 'NoteController::edit/$1');
    $routes->post('/note/update/(:num)', 'NoteController::update/$1');
    $routes->post('/note/delete/(:num)', 'NoteController::delete/$1');
    $routes->get('/note-details', 'NoteController::details');
});

// routes accessible aux utilisateurs connecter (après login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
});

// routes accessible à l'admin et au bibliothecaire
$routes->group('', ['filter' => 'role:admin,professeur'], function($routes) {

});

// routes accessible à l'admin uniquement
$routes->group('', ['filter' => 'role:admin'], function($routes) {

});