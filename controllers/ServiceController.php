<?php

namespace Controllers;

use Model\Service;
use MVC\Router;

class ServiceController {
    public static function index(Router $router) {
        session_start();
        isAdmin();
        $servicios = Service::all();

        $router->render('servicess/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function create(Router $router) {
        session_start();
        isAdmin();
        $servicio = new Service;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /services');
            }
        }
        
        $router->render('servicess/create', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function update(Router $router) {
        session_start();
        isAdmin();

        if(!is_numeric($_GET['id'])) return;
        
        $servicio = Service::find($_GET['id']);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /services');
            }
        }

        $router->render('servicess/update', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function delete() {
        session_start();
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Service::find($id);
            $servicio->eliminar();
            header('Location: /services');
        }
    }

}