<?php
class Exepcion
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
}
