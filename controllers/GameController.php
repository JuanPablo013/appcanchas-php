<?php

namespace Controllers;

use MVC\Router;

class GameController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $router->render('game/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}