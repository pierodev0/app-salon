<?php

namespace Controllers;

use Helpers\JsonResponse;
use Model\Cita;
use Model\CitaServicio;
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
        //Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $citaId = $resultado['id'];

        $serviciosId = explode(",", $_POST['servicios']);

        //Almacena los ervicios con el id de la cita
        foreach ($serviciosId as $servicioId) {

            $args = [
                'citaId' => $citaId,
                'servicioId' => $servicioId
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        
        //Retorna la respuesta
        JsonResponse::data(['resultado' => $resultado])->send();
    }
}
