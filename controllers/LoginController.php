<?php
namespace Controllers;

use MVC\Router;

class LoginController{

    public static function index(Router $router){
        $router->render("auth/login");
    }

    public static function logout(){
        echo "Desde logout    ";
    }

    public static function olvide(){
        echo "Desde olvide    ";
    }

    public static function recuperar(){
        echo "Desde recuperar    ";
    }

    public static function crear(Router $router){
     
       $router->render("auth/crear-cuenta");
    }

}