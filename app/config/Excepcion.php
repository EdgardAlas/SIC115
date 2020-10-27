<?php
class Excepcion
{
    public static function generarExcepcion($exepcion)
    {
        Flight::error(new Exception($exepcion));
        exit();
    }

    public static function noEncontrado()
    {
        Flight::notFound();
        exit();
    }

    public static function json($json){
        Flight::json($json);
        exit();
    }
}
