<?php
namespace Controllers;

use MVC\Router;

class CitaController{
    public static function index(Router $router){
        startSession();
        
        isAuth();

        $nombre = $_SESSION['nombre'];
        $router->render('cita/index',compact('nombre'));
    }
}