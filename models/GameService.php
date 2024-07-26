<?php 

namespace Model;

class GameService extends ActiveRecord {
    protected static $tabla = 'gamesservices';
    protected static $columnasDB = ['id', 'servicioId', 'gameId'];

    public $id;
    public $servicioId;
    public $gameId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->servicioId = $args['servicioId'] ?? '';
        $this->gameId = $args['gameId'] ?? '';
    }
}