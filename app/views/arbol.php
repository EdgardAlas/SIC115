<?php
$cuentas = isset($datos) ? $datos : array();
//Excepcion::json(obtenerCodigoPadre('1101R'));
//Excepcion::json(Utiles::posicionArreglo('1101', 'codigo', $cuentas));
$arbol = array();


foreach ($cuentas as $key => $cuenta) {
    if ($cuenta['nivel'] == 1) {
        $arbol[] = array(
            'text' => $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
            'icon' => "fas fa-stream",
            'codigo' => $cuenta['codigo']
        );
        continue;
    }


        $padres = array();

        /*in_array_multi(obtenerCodigoPadre($cuenta['codigo']), $arbol, array(
            'text' => $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
            'icon' => "fa fa-folder",
            'codigo' => $cuenta['codigo'],
            'nodes' => array()
        ));*/

        (search_in_array(obtenerCodigoPadre($cuenta['codigo']), $arbol, array(
            'text' => $cuenta['codigo'] . ' - ' . $cuenta['nombre'],
            'icon' => "fas fa-stream",
            'codigo' => $cuenta['codigo'],
            'nodes' => array()
        )));



}
//
//Excepcion::json($arbol);


function search_in_array($srchvalue, &$array, $data)
{
    if (is_array($array) && count($array) > 0)
    {
        $foundkey = array_search($srchvalue, $array);
        if ($foundkey === FALSE)
        {
            foreach ($array as $key => &$value)
            {
                if (is_array($value) && count($value) > 0)
                {
                    $foundkey = search_in_array($srchvalue, $value, $data);
                    if ($foundkey != FALSE)

                        return $foundkey;
                }
            }
        }
        else
            $array['nodes'][] = $data;
            return $foundkey;
    }

}

function eliminarVacios(&$arreglo){
    foreach($arreglo as $key => &$posicion){
        if(count($posicion['nodes'])>0){
            eliminarVacios($posicion['nodes']);
        }else{
            unset($arreglo[$key]['nodes']);
        }
    }
}


function obtenerCodigoPadre($codigo_hijo)
{
    if (strlen($codigo_hijo) > 0) {
        $codigo_hijo = strtoupper($codigo_hijo);
        $codigo_guardar = str_replace('R', '', $codigo_hijo);
        $tam_hijo = strlen($codigo_hijo);
        $size = strlen($codigo_hijo);
        $padre = '';

        //se busca la R para corrroborar que sea cuenta R
        $cuentaR = (strpos($codigo_hijo, "R"));

        //cantidad de indices a eliminar
        $indices_eliminar = 0;

        //si es cuenta R entonces se especifica que indices se eliminar o no para dejar solo
        //el codigo de las cuentas a acumular saldos
        if ($cuentaR > 0) {
            $indices_eliminar = $size - 3;
        } else {
            $indices_eliminar = $size - 2;
        }

        //se hace la eliminacion de los ultimos 2 o 3 indices para dejar solo
        //las cuentas de mayor

        if ($size > 3) {
            $codigo_hijo = substr($codigo_hijo, 0, $indices_eliminar);
        } else if ($size == 3) {
            $codigo_hijo = substr($codigo_hijo, 0, $size - 2);
        } else if ($size == 2 && $cuentaR > 0) {
            $codigo_hijo = substr($codigo_hijo, 0, $size - 1);
        } else {
            $codigo_hijo = $codigo_hijo[0];
        }

        $size = strlen($codigo_hijo);

        //se comprueba que el codigo sea valido en cuanto a tamaño
        if (($size > 1 && $size % 2 !== 0 && $cuentaR === false)) {
            return '';
        }

        $mayores = array();

        //se recorrera el codigo
        if ($size > 1) {
            for ($i = 0; $i < $size; $i++) {
                $padre .= $codigo_hijo[$i];

            }
        } else if ($size == 1 && strlen($codigo_guardar) == 2) {
            $padre .= $codigo_hijo[0];
        }
        //1201R -> 12R
        /* if($tam_hijo>4 && $cuentaR>0){
        $padre.='R';
        } */

        if ($cuentaR > 0) {
            $tam_hijo--;
            if ($tam_hijo > 4) {
                $padre .= 'R';
            }

        }

        return $padre;
    }

    return '';
}

eliminarVacios($arbol);
//Excepcion::json($arbol); 

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/all.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/select2.min.css" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/custom.css" />
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/components.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/bstreeview.css">
    <title>Document</title>
</head>
<body>
<div id="tree"></div>

<script src="<?=URL_BASE?>/public/assets/js/plugins/jquery-3.4.1.min.js"></script>
<script src="<?=URL_BASE?>/public/assets/js/plugins/bootstrap.min.js"></script>
<script src="<?=URL_BASE?>/public/assets/js/plugins/bstreeview.js"></script>
<script>
    function getTree() {
        console.log(<?= json_encode($arbol)?>);
        return <?= json_encode($arbol)?>;
    }

    $('#tree').bstreeview({
        data: getTree(),
        expandIcon: 'fa fa-angle-down fa-fw',
        collapseIcon: 'fa fa-angle-right fa-fw',
        indent: 1.25,
        parentsMarginLeft: '1.25rem',
        openNodeLinkOnNewTab: true
    });

</script>
</body>
</html>
