<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{

    public static function index(Router $router)
    {
        $servicios = Servicio::all();
        $router->render('servicios/index', compact('servicios'));
    }

    public static function crear(Router $router)
    {
        $servicio = new Servicio;
        $alertas = [];
        if (isMethod('post')) {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if (empty($alertas)) {
                $servicio->guardar();
                redirect('/servicios');
            }
        }

        $alertas = Servicio::getAlertas();
        $router->render('servicios/crear', compact('servicio', 'alertas'));
    }

    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar($_GET["id"],'/servicios');

        $servicio = Servicio::find($id);
        if(!$servicio) redirect('/servicios');

        $alertas = [];

        if (isMethod('post')) {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if (empty($alertas)) {
                $servicio->guardar();
                redirect('/servicios');
            }
        }

        $alertas = Servicio::getAlertas();
        $router->render('servicios/actualizar', compact('servicio', 'alertas'));
    }

    public static function eliminar(Router $router)
    {
        echo "ServicioController eliminar";
    }
}
