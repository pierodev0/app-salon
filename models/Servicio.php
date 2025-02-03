<?php

namespace Model;

use Model\ActiveRecord;

class Servicio extends ActiveRecord
{
    //Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public ?string $id;
    public string $nombre;
    public string $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar(){
        if(!$this->nombre){
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if(!$this->precio){
            self::setAlerta('error', 'El precio es obligatorio');
        }
        if($this->precio && !is_numeric($this->precio)){
            self::setAlerta('error', 'El precio debe ser un numero');
        }
        return self::$alertas;
    }


}
