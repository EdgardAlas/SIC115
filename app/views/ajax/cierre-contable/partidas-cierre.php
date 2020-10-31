<?php
$estado_resultados = isset($estado_resultados) ? $estado_resultados : array();
$cuentas = isset($cuentas) ? $cuentas : array();
$partida = isset($partida) ? $partida : array();
$fecha = date('Y-m-d');

function buscarSubCuentas($valor, $columna, $arreglo)
{
    $cuenta_auxiliar = Utiles::buscar($valor, $columna, $arreglo);
    return (isset($cuenta_auxiliar['subcuentas'])) ? $cuenta_auxiliar['subcuentas'] : array();
}

function imprimirFila($arreglo, $tipo, $saldo = null, $fecha = null)
{
    $monto_acumulado = 0;
    foreach ($arreglo as $key => $cuenta) {
//        echo $cuenta['nombre'].' - '.$key.'<br>';
        if ($cuenta['ultimo_nivel']) {
            ?>
            <tr>
                <td class="table-light">
                    <?= $fecha != null && $tipo === 'cargo' ? $fecha : '' ?>
                </td>
                <td class="table-light" <?= $tipo === 'abono' ? "style='padding-left: 6em;'" : '' ?>>
                    <?= $cuenta['codigo'] . ' - ' . $cuenta['nombre'] ?>
                </td>
                <td class="table-light text-right font-weight-bold">
                    <?= $tipo === 'cargo' ? Utiles::monto(($saldo !== null ? $saldo : $cuenta['saldo'])) : '-' ?>
                </td>
                <td class="table-light text-right font-weight-bold">
                    <?= $tipo === 'abono' ? Utiles::monto(($saldo !== null ? $saldo : $cuenta['saldo'])) : '-' ?>
                </td>
            </tr>

            <?php
            $monto_acumulado += ($saldo !== null ? $saldo : $cuenta['saldo']);
        }
    }
    return $monto_acumulado;
}

function imprimirCabeceraPartida($partida)
{
    ?>
    <tr>
        <td colspan=4 class='h-100'>&nbsp;</td>
    </tr>
    <tr>
        <td class="table-primary text-center font-weight-bold" colspan=4>Partida #<?= $partida ?></td>
    </tr>
    <?php
    return $partida + 1;
}

function imprimirPiePartida($cargo, $abono, $titulo)
{
    ?>
    <tr>
        <td class='table-light text-right font-weight-bold'></td>
        <td class='table-light text-right font-weight-bold'>Total:</td>
        <td class='table-light text-right font-weight-bold'><?= Utiles::monto($cargo) ?></td>
        <td class='table-light text-right font-weight-bold'><?= Utiles::monto($abono) ?></td>
    </tr>
    <tr>
        <td class="table-secondary text-center font-weight-bold" colspan=4>
            <?= $titulo ?>
        </td>
    </tr>
    <?php
}

function calcularMonto($monto, $saldo, $movimiento, $codigo) {
    $saldocuenta = $monto;
    if (($saldo==='Deudor' && substr($codigo, strlen($codigo)-1)=='R' && $movimiento === 'Cargo') ||
        ($saldo==='Acreedor' && substr($codigo, strlen($codigo)-1)=='R' && $movimiento === 'Abono') ||
        ($saldo === 'Deudor' && substr($codigo, strlen($codigo)-1) !='R' && $movimiento === 'Abono') ||
        ($saldo === 'Acreedor' && substr($codigo, strlen($codigo)-1) !='R' && $movimiento === 'Cargo')) {
        $saldocuenta = -saldocuenta;
    }
    return $saldocuenta;
}

?>
<table class='table table-striped table-bordered table-hover' style='font-size: 0.80rem;'>
    <thead>
    <tr>
        <th style='width: 20%;'>Fecha</th>
        <th style='width: 40%;'>Cuentas</th>
        <th style='width: 20%;'>Debe</th>
        <th style='width: 20%;'>Haber</th>
    </tr>
    </thead>
    <tbody>

    <?php

    $cargo = 0;
    $abono = 0;

    //print_r($estado_resultados);

//    echo '<br><br>';

    //Liquidar Rebajas y Devoluciones

    $ventas = buscarSubCuentas('ventas', 'descripcion', $cuentas);
    $rebajas_ventas = buscarSubCuentas('rebajas_ventas', 'descripcion', $cuentas);
    $devoluciones_ventas = buscarSubCuentas('devoluciones_ventas', 'descripcion', $cuentas);
    $rebajas_devoluciones = array_merge($rebajas_ventas, $devoluciones_ventas);

    $total_liquidar = $estado_resultados['rebajas_ventas'] + $estado_resultados['devoluciones_ventas'];
    if ($total_liquidar > 0) {
        $estado_resultados['ventas'] -= $total_liquidar;
        $estado_resultados['rebajas_ventas'] = 0;
        $estado_resultados['devoluciones_ventas'] = 0;
        $estado_resultados['ventas_netas'] = 0;

        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($ventas, 'cargo', $total_liquidar, $fecha);
        $abono = imprimirFila($rebajas_devoluciones, 'abono', null, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar rebajas y devoluciones sobre ventas y generar ventas totales.'
        );
    }

    //liquidar gastos sobre compras y generar compras totales

    $compras = buscarSubCuentas('compras', 'descripcion', $cuentas);
    $gastos_compras = buscarSubCuentas('gastos_compras', 'descripcion', $cuentas);
    $total_liquidar = $estado_resultados['gastos_compras'];

    if ($total_liquidar > 0) {
        $estado_resultados['compras'] += $total_liquidar;
        $estado_resultados['gastos_compras'] = 0;
        $estado_resultados['compras_totales'] = 0;

        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($compras, 'cargo', $total_liquidar, $fecha);
        $abono = imprimirFila($gastos_compras, 'abono', null, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar gastos sobre compras y generar compras totales.'
        );
    }

    //liquidar rebajas y devoluciones sobre compras y generar compras netas

    $compras = buscarSubCuentas('compras', 'descripcion', $cuentas);
    $rebajas_compras = buscarSubCuentas('rebajas_compras', 'descripcion', $cuentas);
    $devoluciones_compras = buscarSubCuentas('devoluciones_compras', 'descripcion', $cuentas);
    $rebajas_devoluciones = array_merge($rebajas_compras, $devoluciones_compras);

    $total_liquidar = $estado_resultados['rebajas_compras'] + $estado_resultados['devoluciones_compras'];
    if ($total_liquidar > 0) {
        $estado_resultados['compras'] -= $total_liquidar;
        $estado_resultados['rebajas_compras'] = 0;
        $estado_resultados['devoluciones_compras'] = 0;

        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($rebajas_devoluciones, 'cargo', null, $fecha);
        $abono = imprimirFila($compras, 'abono', $total_liquidar, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar rebajas y devoluciones sobre compras y generar compras netas.'
        );
    }

    //liquidar inventario y generar mercaderia disponible
    $inventario = buscarSubCuentas('inventario', 'descripcion', $cuentas);
    $total_liquidar = $estado_resultados['inventario_inicial'];

    if ($total_liquidar > 0) {
        $estado_resultados['compras'] += $total_liquidar;
        $estado_resultados['inventario_inicial'] = 0;

        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($compras, 'cargo', $total_liquidar, $fecha);
        $abono = imprimirFila($inventario, 'abono', null, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar inventario y generar mercaderia disponible.'
        );
    }

    //Aperturar inventario final
    $total_liquidar = $estado_resultados['inventario_final'];

    if ($total_liquidar > 0) {
        $estado_resultados['compras'] -= $total_liquidar;
        $estado_resultados['mercaderia_disponible'] = 0;

        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($inventario, 'cargo', $total_liquidar, $fecha);
        $abono = imprimirFila($compras, 'abono', $total_liquidar, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Aperturar inventario final.'
        );
    }

    //Utilidad bruta
    $total_liquidar = $estado_resultados['costo_venta'];

    if ($total_liquidar > 0) {
        $estado_resultados['ventas'] -= $total_liquidar;
        $estado_resultados['compras'] -= $total_liquidar;
        $estado_resultados['costo_venta'] = 0;
        $estado_resultados['utilidad_bruta'] = 0;

        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($ventas, 'cargo', $total_liquidar, $fecha);
        $abono = imprimirFila($compras, 'abono', $total_liquidar, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Calculo del costo de venta.'
        );
    }

    //liquidar ventas y determinar impuesto sobre la renta

    $impuesto_renta = buscarSubCuentas('impuesto_renta', 'descripcion', $cuentas);
    $perdidas_ganancias = buscarSubCuentas('pye', 'descripcion', $cuentas);

    $saldo_impuesto_renta = $estado_resultados['impuesto_renta'];
    $saldo_venta = $estado_resultados['ventas'];
    $cargo_perdida_ganancia = 0;
    $abono_perdida_ganancia = 0;

    $cargo_abono_perdida_ganancias = $saldo_venta - $saldo_impuesto_renta;

    if ($cargo_abono_perdida_ganancias < 0) {
        $cargo_perdida_ganancia = abs($cargo_abono_perdida_ganancias);
    } else {
        $abono_perdida_ganancia = abs($cargo_abono_perdida_ganancias);
    }


    if ($saldo_venta > 0 && $saldo_impuesto_renta > 0) {
        $estado_resultados['ventas'] = 0;
        $estado_resultados['impuesto_renta'] = 0;
        $estado_resultados['utilidad_antes_impuestos'] = 0;

        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($ventas, 'cargo', $saldo_venta, $fecha);
        if ($cargo_abono_perdida_ganancias < 0)
            $cargo += imprimirFila($perdidas_ganancias, 'cargo', $cargo_perdida_ganancia, null);

        $abono = imprimirFila($impuesto_renta, 'abono', $saldo_impuesto_renta, $fecha);
        if ($cargo_abono_perdida_ganancias > 0)
            $abono += imprimirFila($perdidas_ganancias, 'abono', $abono_perdida_ganancia, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Calculo del costo de venta.'
        );
    }

    //liquidar gastos de administracion, de venta y determinar reserva legal
    $otros_productos = buscarSubCuentas('otros_productos', 'descripcion', $cuentas);
    $gastos_operacion = buscarSubCuentas('gastos_operacion', 'descripcion', $cuentas);
    $otros_gastos = buscarSubCuentas('otros_gastos', 'descripcion', $cuentas);
    $reserva_legal = buscarSubCuentas('reserva_legal', 'descripcion', $cuentas);

    $saldo_otros_productos = $estado_resultados['otros_productos'];
    $saldo_gastos_operacion = $estado_resultados['gastos_operacion'];
    $saldo_otros_gastos = $estado_resultados['otros_gastos'];
    $saldo_reserva_legal = $estado_resultados['reserva_legal'];

    $cargo_abono_perdida_ganancias = $saldo_otros_productos - ($saldo_otros_gastos + $saldo_gastos_operacion + $saldo_reserva_legal);

    if ($cargo_abono_perdida_ganancias < 0) {
        $cargo_perdida_ganancia = abs($cargo_abono_perdida_ganancias);
    } else {
        $abono_perdida_ganancia = abs($cargo_abono_perdida_ganancias);
    }

    if ($cargo_abono_perdida_ganancias != 0) {
        $estado_resultados['otros_productos'] = 0;
        $estado_resultados['gastos_operacion'] = 0;
        $estado_resultados['otros_gastos'] = 0;
        $estado_resultados['reserva_legal'] = 0;
        $estado_resultados['utilidad_antes_impuestos_reserva'] = 0;
        $estado_resultados['utilidad_operacion'] = 0;

        $partida = imprimirCabeceraPartida($partida);

        $cargo = imprimirFila($otros_productos, 'cargo', null, $fecha);
        if ($cargo_abono_perdida_ganancias < 0)
            $cargo += imprimirFila($perdidas_ganancias, 'cargo', $cargo_perdida_ganancia, null);

        $abono = imprimirFila($gastos_operacion, 'abono', null, $fecha);
        $abono += imprimirFila($otros_gastos, 'abono', null, $fecha);
        $abono += imprimirFila($reserva_legal, 'abono', $saldo_reserva_legal, $fecha);

        if ($cargo_abono_perdida_ganancias > 0)
            $abono += imprimirFila($perdidas_ganancias, 'abono', $abono_perdida_ganancia, $fecha);


        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar gastos de administracion, de venta y determinar reserva legal.'
        );
    }

    //Determinar utilidad del ejercicio

    $utiliadad = buscarSubCuentas('utilidad', 'descripcion', $cuentas);
    $perdida = buscarSubCuentas('perdida', 'descripcion', $cuentas);

    $utilidad_perdida = $cargo_perdida_ganancia - $abono_perdida_ganancia;
    $estado_resultados['utilidad_perdida'] = 0;

    if ($utilidad_perdida > 0) {
        //perdida
        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($perdida, 'cargo', abs($utilidad_perdida), $fecha);
        $abono = imprimirFila($perdidas_ganancias, 'abono', abs($utilidad_perdida), $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Perdida del ejercicio'
        );
    }else{
        //ganancia
        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($perdidas_ganancias, 'cargo', abs($utilidad_perdida), $fecha);
        $abono = imprimirFila($utiliadad, 'abono', abs($utilidad_perdida), $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Utilidad del ejercicio'
        );
    }

    //print_r($estado_resultados);

    ?>


    </tbody>
</table>
