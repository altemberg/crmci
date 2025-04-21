<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Home page
$routes->get('/', 'Auth::login');

$routes->get('/testauth', 'TestAuth::index');
$routes->get('/testauth/login', 'TestAuth::login');

$routes->get('/home', 'Home::index');
$routes->get('/hello', function() { return 'Hello World!'; });
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Dashboard
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
});

// Admin routes
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    // Users
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/create', 'Admin\Users::create');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
    
    // Pipelines
    $routes->get('pipelines', 'Admin\Pipelines::index');
    $routes->get('pipelines/create', 'Admin\Pipelines::create');
    $routes->post('pipelines/create', 'Admin\Pipelines::create');
    $routes->get('pipelines/edit/(:num)', 'Admin\Pipelines::edit/$1');
    $routes->post('pipelines/edit/(:num)', 'Admin\Pipelines::edit/$1');
    $routes->get('pipelines/delete/(:num)', 'Admin\Pipelines::delete/$1');
    $routes->get('pipelines/assign/(:num)', 'Admin\Pipelines::assign/$1');
    $routes->post('pipelines/assign/(:num)', 'Admin\Pipelines::assign/$1');
    
    // Leads
    $routes->get('leads', 'Admin\Leads::index');
    $routes->get('leads/export', 'Admin\Leads::export');
});

// User routes
$routes->group('user', ['filter' => 'auth'], function($routes) {
    // Leads
    $routes->get('leads', 'User\Leads::index');
    $routes->get('leads/create', 'User\Leads::create');
    $routes->post('leads/create', 'User\Leads::create');
    $routes->get('leads/edit/(:num)', 'User\Leads::edit/$1');
    $routes->post('leads/edit/(:num)', 'User\Leads::edit/$1');
    $routes->get('leads/delete/(:num)', 'User\Leads::delete/$1');
    $routes->get('leads/export', 'User\Leads::export');
    
    // Pipelines
    $routes->get('pipelines', 'User\Pipelines::index');
    $routes->get('pipelines/view/(:num)', 'User\Pipelines::view/$1');
});

// API routes
$routes->group('api', ['filter' => 'auth'], function($routes) {
    $routes->post('leads/(:num)/move', 'Api\Leads::move/$1');
});