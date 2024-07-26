<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\GameController;
use Controllers\LoginController;
use Controllers\ServiceController;
use MVC\Router;

$router = new Router();

// Iniciar Sesión
$router->get('/', [LoginController::class,'login']);
$router->post('/', [LoginController::class,'login']);
$router->get('/logout', [LoginController::class,'logout']);

// Recuperar Password
$router->get('/forget', [LoginController::class,'forget']);
$router->post('/forget', [LoginController::class,'forget']);
$router->get('/recover', [LoginController::class,'recover']);
$router->post('/recover', [LoginController::class,'recover']);

// Crear Cuenta
$router->get('/create-account', [LoginController::class,'create']);
$router->post('/create-account', [LoginController::class,'create']);

// Confirmar Cuenta
$router->get('/confirm-account', [LoginController::class,'confirm']);
$router->get('/message', [LoginController::class,'message']);

// Area privada
$router->get('/game', [GameController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

// API de Games
$router->get('/api/services', [APIController::class, 'index']);
$router->post('/api/games', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

// CRUD de Services
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/create', [ServiceController::class, 'create']);
$router->post('/services/create', [ServiceController::class, 'create']);
$router->get('/services/update', [ServiceController::class, 'update']);
$router->post('/services/update', [ServiceController::class, 'update']);
$router->post('/services/delete', [ServiceController::class, 'delete']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();