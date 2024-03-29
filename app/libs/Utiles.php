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

    public static function montoFormato($monto)
    {
        return number_format($monto, 2);
    }

    public static function fecha($fecha)
    {
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        return ucfirst(iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d - %B - %Y", strtotime($fecha))));
        //return date("Y-m-d", strtotime($fecha));
    }

    public static function fechaSinFormato($fecha)
    {

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

    public static function buscar($valor, $columna, $arreglo)
    {
        $encontrado = array();

        $key = array_search($valor, array_column($arreglo, $columna));

        if ($key !== false)
            $encontrado = $arreglo[$key];

        return $encontrado;
    }

    public static function posicionArreglo($valor, $columna, $arreglo)
    {

        return array_search($valor, array_column($arreglo, $columna));
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return substr($haystack, 0, $length) === $needle;
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }

    public static function is_base64($s)
    {
        // Check if there are valid base64 characters
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;

        // Decode the string in strict mode and check the results
        $decoded = base64_decode($s, true);
        if (false === $decoded) return false;

        // Encode the string again
        if (base64_encode($decoded) != $s) return false;

        return true;
    }

}
