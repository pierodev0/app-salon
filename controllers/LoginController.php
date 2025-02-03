<?php

namespace Controllers;

use Classes\Email;
use Helpers\Hash;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function index(Router $router)
    {
        $alertas = [];
        if (isMethod('post')) {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                //Verificar que el usuario existe
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    //Verificar el password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        //Autenticar al usuario
                        startSession();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['telefono'] = $usuario->telefono;
                        $_SESSION['login'] = true;

                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            redirect('/admin');
                        } else {
                            redirect('/cita');
                        }
                    } 
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render("auth/login", compact('alertas'));
    }

    public static function logout()
    {
        startSession();
        $_SESSION = [];

        redirect('/');
    }

    public static function olvide(Router $router)
    {
        $alertas = [];
        if (isMethod('post')) {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === '1'){
                   //Generar un token unico
                   $usuario->crearToken();
                   $usuario->guardar();

                   //Enviar email
                   $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                   $email->enviarInstrucciones();

                   Usuario::setAlerta('exito', 'Revisa tu email para reiniciar tu password');

                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render("auth/olvide",compact('alertas'));
    }


    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        if(!$token){
            redirect('/');
        }
        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if(isMethod('POST')){
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;

                $usuario->password = Hash::make($password->password);
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado){
                    redirect('/');
                }
            }
        }


       
        $alertas = Usuario::getAlertas();
        $router->render("auth/recuperar",compact('alertas','error'));
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        if (isMethod('POST')) {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                //Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if ($resultado) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear el password
                    $usuario->password = Hash::make($usuario->password);

                    //Generar un token unico
                    $usuario->crearToken();

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    $resultado = $usuario->crear();
                    if ($resultado) {
                        redirect('/mensaje');
                    }
                }
            }
        }

        $router->render("auth/crear-cuenta", compact('usuario', 'alertas'));
    }

    public static function mensaje(Router $router)
    {
        $router->render("auth/mensaje");
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);
        if (!$token) redirect('/');

        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            //Modificar usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }
        //Obtener alertas
        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmar-cuenta", compact('alertas'));
    }
}
