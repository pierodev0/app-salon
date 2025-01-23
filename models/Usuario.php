<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password', 'nombre', 'apellido', 'telefono', 'admin', 'confirmado', 'token'];
    public $id;
    public $email;
    public $password;
    public $nombre;
    public $apellido;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }


    //Mensaje de validacion para la creacion de una cuenta
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::setAlerta('error', 'El nombre es obligatorio');
        }

        if(!$this->apellido){
            self::setAlerta('error', 'El apellido es obligatorio');
        }

        if(!$this->telefono){
            self::setAlerta('error', 'El telefono es obligatorio');
        }

        if(!$this->email){
            self::setAlerta('error', 'El Email es obligatorio');
        }

        if($this->email &&!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::setAlerta('error', 'El email es invalido');
        }
        if(!$this->password){
            self::setAlerta('error', 'El password es obligatorio');
        }

        if($this->password && strlen($this->password) < 6){
            self::setAlerta('error', 'El password debe tener al menos 6 caracteres');
        }


        return self::$alertas;
    }

    public function existeUsuario(){
        $resultado = self::where('email', $this->email);
        if($resultado){
            self::setAlerta('error', 'El usuario ya esta registrado');
        }

        return $resultado;
    }


    


}
