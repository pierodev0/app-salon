<?php
namespace Controllers;

use Helpers\JsonResponse;
use Model\Servicio;

class APIController {
    public static function index(){
       $servicios = Servicio::all();
       header('Content-Type: application/json');
       echo json_encode($servicios);
    }

    public static function guardar(){
        $respuesta = [];

        if(isMethod('post')){
            $respuesta = ['data' => $_POST];
        }
        JsonResponse::data($respuesta)->send();
    }
}