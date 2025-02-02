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


}
