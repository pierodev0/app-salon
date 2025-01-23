<?php
namespace Controllers;

use Classes\Email;
use Helpers\Hash;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function index(Router $router){
        $router->render("auth/login");
    }

    public static function logout(){
        echo "Desde logout    ";
    }

    public static function olvide(Router $router){
        $router->render("auth/olvide");
    }

    public static function recuperar(){
        echo "Desde recuperar    ";
    }

    public static function crear(Router $router){
        $usuario = new Usuario;
        $alertas = [];

        if(isMethod('POST')){
           $usuario->sincronizar($_POST);

           $alertas = $usuario->validarNuevaCuenta();

           if(empty($alertas)){
                //Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                
                if($resultado){
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear el password
                    $usuario->password = Hash::make($usuario->password);

                    //Generar un token unico
                    $usuario->crearToken();

                    //Enviar email
                    $email = new Email ($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarConfirmacion();
                    $resultado = $usuario->crear();
                    if($resultado){
                       redirect('/mensaje');
                    }
                }
                
           }

        }

       $router->render("auth/crear-cuenta",compact('usuario','alertas'));
    }

    public static function mensaje(Router $router){
        $router->render("auth/mensaje");
    }

}