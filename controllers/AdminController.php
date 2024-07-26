<?php

namespace Controllers;

use Model\AdminGame;
use MVC\Router;

class AdminController {
    public static function index( Router $router ) {
        session_start();

        isAdmin();

        $fecha = $_GET['date'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        if( !checkdate( $fechas[1], $fechas[2], $fechas[0]) ) {
            header('Location: /404');
        }

        // Consultar la base de datos
        $consulta = "SELECT games.id, games.hora, CONCAT( users.nombre, ' ', users.apellido) as cliente, ";
        $consulta .= " users.email, users.telefono, services.nombre as servicio, services.precio  ";
        $consulta .= " FROM games  ";
        $consulta .= " LEFT OUTER JOIN users ";
        $consulta .= " ON games.usuarioId=users.id  ";
        $consulta .= " LEFT OUTER JOIN gamesservices ";
        $consulta .= " ON gamesservices.gameId=games.id ";
        $consulta .= " LEFT OUTER JOIN services ";
        $consulta .= " ON services.id=gamesservices.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $games = AdminGame::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'games' => $games,
            'fecha' => $fecha
        ]);
    }
}