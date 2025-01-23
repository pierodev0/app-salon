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

    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET['token']);
        if(!$token) redirect('/');

        //Buscar usuario por su token
        $usuario =Usuario::where('token', $token);

        if(empty($usuario)){
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

        $router->render("auth/confirmar-cuenta",compact('alertas'));
    }

}