<?php 

namespace Controllers;

use Model\Game;
use Model\GameService;
use Model\Service;

class APIController {
    public static function index() {
        $services = Service::all();
        echo json_encode($services);
    }

    public static function save() {
        
        // Almacena el game y devuelve el ID
        $game = new Game($_POST);
        $result = $game->guardar();

        $id = $result['id'];

        // Almacena los servicios con el ID del game
        $idServices = explode(",", $_POST['servicios']);

        foreach($idServices as $idService) {
            $args = [
                'servicioId' => $idService,
                'gameId' => $id
            ];
            $gameService = new GameService($args);
            $gameService->guardar();
        }
        
        echo json_encode(['resultado' => $result]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $game = Game::find($id);
            $game->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
