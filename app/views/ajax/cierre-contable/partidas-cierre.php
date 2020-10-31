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

function imprimirFila($arreglo, $tipo, $saldo = null, $fecha){
    foreach ($arreglo as $key => $cuenta) {
        if ($cuenta['ultimo_nivel']) {
            ?>
            <tr>
                <td class="table-light">
                    <?= $key==0 ? $fecha : '' ?>
                </td>
                <td class="table-light" <?= $tipo==='abono' ? "style='padding-left: 8em;'" : ''?>>
                    <?= $cuenta['codigo'] . ' - ' . $cuenta['nombre'] ?>
                </td>
                <td class="table-light text-right font-weight-bold">
                    <?= $tipo==='cargo' ? Utiles::monto(($saldo!==null ? $saldo : $cuenta['saldo'])) : '-' ?>
                </td>
                <td class="table-light text-right font-weight-bold">
                    <?= $tipo==='abono' ? Utiles::monto(($saldo!==null ? $saldo : $cuenta['saldo'])) : '-' ?>
                </td>
            </tr>

            <?php
        }
    }
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

    <tr>
        <td colspan=4 class='h-100'>&nbsp;</td>
    </tr>
    <tr>
        <td class="table-primary text-center font-weight-bold" colspan=4>Partida #<?= $partida ?></td>
    </tr>

    <?php

    $cargo = 0;
    $abono = 0;

    //liquidar rebajas y devoluciones
    $ventas = buscarSubCuentas('ventas', 'descripcion', $cuentas);
    $rebajas_ventas = buscarSubCuentas('rebajas_ventas', 'descripcion', $cuentas);
    $devoluciones_ventas = buscarSubCuentas('devoluciones_ventas', 'descripcion', $cuentas);
    $rebajas_devoluciones = array_merge($rebajas_ventas, $devoluciones_ventas);

    $total_liquidar = $estado_resultados['rebajas_ventas'] + $estado_resultados['devoluciones_ventas'];
    $estado_resultados['ventas'] -= $total_liquidar;
    $cargo = $total_liquidar;
    $abono = $total_liquidar;

    imprimirFila($ventas, 'cargo', $total_liquidar, $fecha);
    imprimirFila($rebajas_devoluciones, 'abono', null, $fecha);

    ?>
    <tr>
        <td class='table-light text-right font-weight-bold'></td>
        <td class='table-light text-right font-weight-bold'>Total:</td>
        <td class='table-light text-right font-weight-bold'><?= Utiles::monto($cargo) ?></td>
        <td class='table-light text-right font-weight-bold'><?= Utiles::monto($abono) ?></td>
    </tr>
    <tr>
        <td class="table-secondary text-center font-weight-bold" colspan=4>
            Liquidar rebajas y devoluciones sobre ventas y generar ventas totales.
        </td>
    </tr>

    </tbody>
</table>
