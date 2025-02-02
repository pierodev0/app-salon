<?php

namespace Controllers;

use Helpers\JsonResponse;
use Model\Cita;
use Model\Servicio;

class APIController
{
    public static function index()
    {
        $servicios = Servicio::all();
        header('Content-Type: application/json');
        echo json_encode($servicios);
    }

    public static function guardar()
    {
        $cita = new Cita($_POST);

        $resultado = $cita->guardar();

        JsonResponse::data($resultado)->send();
    }
}
