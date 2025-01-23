<?php
namespace Controllers;

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

        }

       $router->render("auth/crear-cuenta",compact('usuario','alertas'));
    }

}