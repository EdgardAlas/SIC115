<?php

class Utiles
{
    public static function monto($monto)
    {
        return "$" . number_format($monto, 2);
    }

    public static function convertirMonto($monto)
    {

        $monto = str_replace('$', '', $monto);
        return number_format($monto, 2);

    }

    public static function fecha($fecha)
    {
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        return ucfirst(iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d - %B - %Y", strtotime($fecha))));
        //return date("Y-m-d", strtotime($fecha));
    }

    public static function fechaSinFormato($fecha){
        
        return date("d-m-Y", strtotime($fecha));
    }

    public static function printScript($script)
    {
        return "<script src = '" . URL_BASE . "/public/js/" . $script . ".js'></script>";
    }

    public static function eliminarDuplicados($arreglo)
    {
        foreach ($arreglo as $key => $value) {
            foreach ($value as $eliminar => $valor) {
                if (is_numeric($eliminar)) {
                    unset($arreglo[$key][$eliminar]);
                }
            }
        }
        return $arreglo;
    }

    public static  function buscar($valor, $columna, $arreglo){
        $encontrado = array();

        $key = array_search($valor , array_column($arreglo, $columna));
        
        if($key!==false)
            $encontrado = $arreglo[$key];

        return $encontrado;
    }

    public static  function posicionArreglo($valor, $columna, $arreglo){

        return array_search($valor , array_column($arreglo, $columna));
    }

}
