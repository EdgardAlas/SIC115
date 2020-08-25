<?php

class Utiles
{
    public static function monto($monto){
        return "$".number_format($monto,2);
    }

    public static function fecha($fecha){
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        return iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d - %B - %Y", strtotime($fecha)));
        //return date("Y-m-d", strtotime($fecha));
    }
}
