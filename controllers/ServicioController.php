<?php
namespace Controllers;

use MVC\Router;

class ServicioController {
    
    public static function index(Router $router)
    {
        $router->render('servicios/index');
    }
    
    public static function crear(Router $router)
    {
        if(isMethod('post'))
        {
            echo "Guardando...";
        }

        $router->render('servicios/crear');
    }
    
    public static function actualizar(Router $router)
    {
        echo "ServicioController actualizar";
    }
    
    public static function eliminar(Router $router)
    {
        echo "ServicioController eliminar";
    }
}