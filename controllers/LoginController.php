<?php 

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);

            $alertas = $auth->validateLogin();

            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = User::where('email', $auth->email);

                if($usuario) {
                    // Verificar la contraseña
                    if($usuario->validatePasswordAndChecked($auth->password)) {
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento

                        if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /game');
                        }

                    }
                } else {
                    User::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = User::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        if(!isset($_SESSION)) {
            session_start();
        }

        $_SESSION = [];

        header('Location: /');
    }

    public static function forget(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alertas = $auth->validateEmail();

            if(empty($alertas)) {
                $usuario = User::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1") {

                    // Generar un token
                    $usuario->createToken();
                    $usuario->guardar();

                    // Enviar el Correo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->sendInstructions();

                    User::setAlerta('exito', 'Revisa tu Correo Electrónico');
                } else {
                    User::setAlerta('error', 'El Usuario no existe o no está confirmado');
                    
                }
            }
        }

        $alertas = User::getAlertas();

        $router->render('auth/forgot-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recover(Router $router) {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        // Buscar usuario por su token
        $usuario = User::where('token', $token);

        if(empty($usuario)) {
            User::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer la nueva contraseña y guardarla

            $password = new User($_POST);
            $alertas = $password->validatePassword();

            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    //Mostrar mensaje de éxito
                    User::setAlerta('exito', 'Contraseña actualizada correctamente');
                    
                    //Redireccionar al inicio luego de 3seg
                    header("Refresh: 3; url=/");
                }
            }
        }

        $alertas = User::getAlertas();
        $router->render('auth/recover-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function create(Router $router) {

        $usuario = new User;

        // Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validateNewAccount();  
            
            // Revisar que alertas este vacío
            if(empty($alertas)){
                // Verificar que el usuario no este registrado
                $resultado = $usuario->userExists();

                if($resultado->num_rows) {
                    $alertas = User::getAlertas();
                } else {
                    // Hashear el Password
                    $usuario->hashPassword();

                    // Generar Token único
                    $usuario->createToken();

                    // Enviar el Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->sendConfirmation();

                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    // debuguear($usuario);

                    if($resultado) {
                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('auth/create-account', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function message(Router $router) {
        $router->render('auth/message');
    }

    public static function confirm(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = User::where('token', $token);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            User::setAlerta('error', 'Token no válido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            User::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        // Obtener alertas
        $alertas = User::getAlertas();

        // Renderizar la vista
        $router->render('auth/confirm-account', [
            'alertas' => $alertas
        ]);
    }

}