<?php

namespace Model;

class Game extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'games';
    protected static $columnasDB = ['id', 'usuarioId','hora', 'fecha'];

    public $id;
    public $usuarioId;
    public $hora;
    public $fecha;

    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }
}