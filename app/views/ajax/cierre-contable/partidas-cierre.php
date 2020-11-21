<?php
$estado_resultados = isset($estado_resultados) ? $estado_resultados : array();
$cuentas = isset($cuentas) ? $cuentas : array();
$partida = isset($partida) ? $partida : array();
$empresa = isset($empresa) ? $empresa : array();
$fecha = date('Y-m-d');

$partidas_cierre = array();

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

function calcularMonto($monto, $saldo, $movimiento, $codigo)
{
    $saldocuenta = $monto;
    if (($saldo === 'Deudor' && substr($codigo, strlen($codigo) - 1) == 'R' && $movimiento === 'Cargo') ||
        ($saldo === 'Acreedor' && substr($codigo, strlen($codigo) - 1) == 'R' && $movimiento === 'Abono') ||
        ($saldo === 'Deudor' && substr($codigo, strlen($codigo) - 1) != 'R' && $movimiento === 'Abono') ||
        ($saldo === 'Acreedor' && substr($codigo, strlen($codigo) - 1) != 'R' && $movimiento === 'Cargo')) {
        $saldocuenta = -1*$saldocuenta;
    }
    return $saldocuenta;
}


function generarDetalle($cuentas, $monto = null, $movimiento)
{
    $partidas = array();
    foreach ($cuentas as $key => $cuenta) {

        if ($cuenta['ultimo_nivel']) {

//            var_dump($cuenta['ultimo_nivel'].' - '.$cuenta['nombre'].'<br>');
            $partidas[] =
                array(
                    'cuenta' => $cuenta['id'],
                    'movimiento' => $movimiento,
                    'monto' => calcularMonto(
                        ($monto !== null ? $monto : $cuenta['saldo']),
                        $cuenta['tipo_saldo'],
                        $movimiento,
                        $cuenta['codigo']
                    ),
                    'codigo' => $cuenta['codigo']
                );
        }
    }

    return $partidas;
}

function generarDetalleBalance($cuentas, $monto = null, $movimiento)
{
    $aux_movimiento = $movimiento;
    $partidas = array();
    foreach ($cuentas as $key => $cuenta) {

        if ($cuenta['ultimo_nivel']) {
            if(substr($cuenta['codigo'], strlen($cuenta['codigo'])-1)==='R'){
                $movimiento = ($movimiento === 'Abono') ? 'Cargo' : 'Abono';
            }else{
                $movimiento = $aux_movimiento;
            }


            $partidas[] =
                array(
                    'cuenta' => $cuenta['id'],
                    'movimiento' => $movimiento,
                    'monto' => calcularMonto(
                        ($monto !== null ? $monto : $cuenta['saldo']),
                        $cuenta['tipo_saldo'],
                        $movimiento,
                        $cuenta['codigo']
                    ),
                    'codigo' => $cuenta['codigo']
                );
        }
    }

    return $partidas;
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

    //iva
    $iva_credito = buscarSubCuentas('iva_credito', 'descripcion', $cuentas);
    $iva_debito = buscarSubCuentas('iva_debito', 'descripcion', $cuentas);
    $impuesto_iva = buscarSubCuentas('impuesto_iva', 'descripcion', $cuentas);
    $saldo_iva_credito = $estado_resultados['iva_credito'];
    $saldo_iva_debito = $estado_resultados['iva_debito'];
    $saldo_impuesto_iva = $estado_resultados['impuesto_iva'];

    if ($estado_resultados['situacion_iva'] === 'liquidar_cuentas') {
        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($iva_debito, 'cargo', null, $fecha);
        $abono = imprimirFila($iva_credito, 'abono', null, $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar cuentas de IVA'
        );


        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Liquidar cuentsa de IVA.',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($iva_debito, null, 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($iva_credito, null, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);


    }

    if ($estado_resultados['situacion_iva'] === 'pagar') {
        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($iva_debito, 'cargo', null, $fecha);
        if ($saldo_iva_credito > 0)
            $abono = imprimirFila($iva_credito, 'abono', null, $fecha);
        $abono += imprimirFila($impuesto_iva, 'abono', $saldo_impuesto_iva, $fecha);

        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar cuentas de IVA y asignar impuesto por pagar'
        );


        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Liquidar cuentas de IVA y asignar impuesto por pagar.',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($iva_debito, null, 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($iva_credito, null, 'Abono');
        if (count($detalle) > 0 && $saldo_iva_credito > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($impuesto_iva, $saldo_impuesto_iva, 'Abono');
        if (count($detalle) > 0 && $saldo_iva_credito > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
    }

    if ($estado_resultados['situacion_iva'] === 'liquidar_debito') {
        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($iva_debito, 'cargo', null, $fecha);
        $abono = imprimirFila($iva_credito, 'abono', $saldo_iva_debito, $fecha);

        imprimirPiePartida(
            $cargo,
            $abono,
            'Liquidar cuentas de IVA Debito Fiscal'
        );

        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Liquidar cuentas de IVA Debito Fiscal',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($iva_debito, null, 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($iva_credito, $saldo_iva_debito, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
    }


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

    $partidas_cierre[] = array(
        'partida' => array(
            "numero" => $partida-1,
            "descripcion" => 'Liquidar rebajas y devoluciones sobre ventas y generar ventas totales.',
            'fecha' => date($empresa['anio'] . '-m-d'),
            'partida_cierre' => 1,
            'periodo' => $empresa['periodo']
        ),
    );

    $posicion = count($partidas_cierre) - 1;
    $partidas_cierre[$posicion]['detalle_partida'] = array();
    $detalle = generarDetalle($ventas, $total_liquidar, 'Cargo');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
    $detalle = generarDetalle($rebajas_devoluciones, null, 'Abono');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);


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

    $partidas_cierre[] = array(
        'partida' => array(
            "numero" => $partida-1,
            "descripcion" => 'Liquidar gastos sobre compras y generar compras totales.',
            'fecha' => date($empresa['anio'] . '-m-d'),
            'partida_cierre' => 1,
            'periodo' => $empresa['periodo']
        ),
    );

    $posicion = count($partidas_cierre) - 1;
    $partidas_cierre[$posicion]['detalle_partida'] = array();
    $detalle = generarDetalle($compras, $total_liquidar, 'Cargo');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
    $detalle = generarDetalle($gastos_compras, null, 'Abono');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);


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

    $partidas_cierre[] = array(
        'partida' => array(
            "numero" => $partida-1,
            "descripcion" => 'Liquidar rebajas y devoluciones sobre compras y generar compras netas.',
            'fecha' => date($empresa['anio'] . '-m-d'),
            'partida_cierre' => 1,
            'periodo' => $empresa['periodo']
        ),
    );

    $posicion = count($partidas_cierre) - 1;
    $partidas_cierre[$posicion]['detalle_partida'] = array();
    $detalle = generarDetalle($rebajas_devoluciones, null, 'Cargo');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
    $detalle = generarDetalle($compras, $total_liquidar, 'Abono');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);


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

    $partidas_cierre[] = array(
        'partida' => array(
            "numero" => $partida-1,
            "descripcion" => 'Liquidar inventario y generar mercaderia disponible.',
            'fecha' => date($empresa['anio'] . '-m-d'),
            'partida_cierre' => 1,
            'periodo' => $empresa['periodo']
        ),
    );

    $posicion = count($partidas_cierre) - 1;
    $partidas_cierre[$posicion]['detalle_partida'] = array();
    $detalle = generarDetalle($compras, $total_liquidar, 'Cargo');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
    $detalle = generarDetalle($inventario, null, 'Abono');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

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

        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Calculo del costo de venta.',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($ventas, $total_liquidar, 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($compras, $total_liquidar, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
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

        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Aperturar inventario final.',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($inventario, $total_liquidar, 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($compras, $total_liquidar, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
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
            'Calculo del impuesto sobre la renta.'
        );

        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Calculo del impuesto sobre la renta.',
                'fecha' => date(date($empresa['anio'] . '-m-d')),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($ventas, $saldo_venta, 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

        if ($cargo_abono_perdida_ganancias < 0) {
            $detalle = generarDetalle($perdidas_ganancias, $cargo_perdida_ganancia, 'Cargo');
            if (count($detalle) > 0)
                array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        }

        $detalle = generarDetalle($impuesto_renta, $saldo_impuesto_renta, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

        if ($cargo_abono_perdida_ganancias > 0) {
            $detalle = generarDetalle($perdidas_ganancias, $abono_perdida_ganancia, 'Abono');
            if (count($detalle) > 0)
                array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        }

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
            'Liquidar gastos, productos financieros y determinar reserva legal.'
        );

        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Liquidar gastos, productos financieros y determinar reserva legal.',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($otros_productos, null, 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

        if ($cargo_abono_perdida_ganancias < 0) {
            $detalle = generarDetalle($perdidas_ganancias, $cargo_perdida_ganancia, 'Cargo');;
            if (count($detalle) > 0)
                array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        }

        $detalle = generarDetalle($gastos_operacion, null, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

        $detalle = generarDetalle($otros_gastos, null, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

        $detalle = generarDetalle($reserva_legal, $saldo_reserva_legal, 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

        if ($cargo_abono_perdida_ganancias > 0) {
            $detalle = generarDetalle($perdidas_ganancias, $abono_perdida_ganancia, 'Abono');;
            if (count($detalle) > 0)
                array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        }

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
            'Perdida del ejercicio.'
        );

        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Perdida del ejercicio.',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($perdida, abs($utilidad_perdida), 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($perdidas_ganancias, abs($utilidad_perdida), 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

    } else {
        //ganancia
        $partida = imprimirCabeceraPartida($partida);
        $cargo = imprimirFila($perdidas_ganancias, 'cargo', abs($utilidad_perdida), $fecha);
        $abono = imprimirFila($utiliadad, 'abono', abs($utilidad_perdida), $fecha);
        imprimirPiePartida(
            $cargo,
            $abono,
            'Utilidad del ejercicio'
        );

        $partidas_cierre[] = array(
            'partida' => array(
                "numero" => $partida-1,
                "descripcion" => 'Perdida del ejercicio.',
                'fecha' => date($empresa['anio'] . '-m-d'),
                'partida_cierre' => 1,
                'periodo' => $empresa['periodo']
            ),
        );

        $posicion = count($partidas_cierre) - 1;
        $partidas_cierre[$posicion]['detalle_partida'] = array();
        $detalle = generarDetalle($perdidas_ganancias, abs($utilidad_perdida), 'Cargo');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
        $detalle = generarDetalle($utiliadad, abs($utilidad_perdida), 'Abono');
        if (count($detalle) > 0)
            array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);
    }



    //LIquidicacion de cuentas de balance
    $partida++;
    $activo = buscarSubCuentas('activo', 'descripcion', $cuentas);
    $pasivo = buscarSubCuentas('pasivo', 'descripcion', $cuentas);
    $patrimonio = buscarSubCuentas('patrimonio', 'descripcion', $cuentas);

    $partidas_cierre[] = array(
        'partida' => array(
            "numero" => $partida-1,
            "descripcion" => 'Liquidar cuentas de balance.',
            'fecha' => date($empresa['anio'] . '-m-d'),
            'partida_cierre' => 1,
            'periodo' => $empresa['periodo']
        ),
    );

    $posicion = count($partidas_cierre) - 1;

    $partidas_cierre[$posicion]['detalle_partida'] = array();

    $detalle = generarDetalleBalance($patrimonio, null, 'Cargo');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

    $detalle = generarDetalleBalance($pasivo, null, 'Cargo');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);

    $detalle = generarDetalleBalance($activo, null, 'Abono');
    if (count($detalle) > 0)
        array_push($partidas_cierre[$posicion]['detalle_partida'], $detalle);


    $sesion = new Session();
    //Guardar partidas en sesion para despues guardarlas en la bd
    $sesion->set('partidas', $partidas_cierre);
    $sesion->set('cuentas', $cuentas);

    //print_r($estado_resultados);

    ?>
    </tbody>
</table>

