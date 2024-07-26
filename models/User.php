<?php

namespace Model;

class User extends ActiveRecord {
    // Base de datos
    
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validación para la creación de una cuenta
    public function validateNewAccount() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Correo electrónico es obligatorio';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Correo electrónico no es valido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos 8 caracteres';
        }
        return self::$alertas;
    }

    public function validateLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Correo electrónico es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La Contraseña es obligatoria';
        }
        return self::$alertas;
    }

    public function validateEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Correo electrónico es obligatorio';
        }
        return self::$alertas;
    }

    public function validatePassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'La Contraseña es obligatoria';
        }
        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 8 caracteres';
        }
        return self::$alertas;
    }

    // Revisa si el usuario ya existe
    public function userExists() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado =  self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    }

    public function validatePasswordAndChecked($password) {
        $resultado = password_verify($password, $this->password);
        
        if(!$resultado) {
            self::$alertas['error'][] = 'Contraseña incorrecta';
        } elseif (!$this->confirmado) {
            self::$alertas['error'][] = 'Cuenta sin confirmar';
        } else {
            return true;
        }
    }

}