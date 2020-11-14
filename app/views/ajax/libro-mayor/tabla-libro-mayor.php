<table class='table table-striped table-bordered table-hover' style='font-size: 0.80rem;' id='tabla-mayor'>
    <thead>
    <tr>
        <th style='width: 12%;'>Fecha</th>
        <th style='width: 3%;'>Partida</th>
        <th style='width: 25%;'>Descripción</th>
        <th style='width: 20%;'>Cargo</th>
        <th style='width: 20%;'>Abono</th>
        <th style='width: 20%;'>Saldo</th>

        <!--
            12 + 3 = 15 + 25 = 40 + 60 = 100
        -->
    </tr>
    </thead>
    <tbody>
    <?php
    $partidas_cuentas = isset($datosBD) ? $datosBD : array();
    $cantidad_mayor = 0;

    $total_cargo = 0;
    $total_abono = 0;
    $saldo_acumulado = 0;

    foreach ($partidas_cuentas as $i_cuenta => $cuenta) {
        $total_cargo = 0;
        $total_abono = 0;
        $saldo_acumulado = 0;
        if (sizeof($cuenta['partidas']) != 0) {
            $cantidad_mayor++;
            ?>
            <tr>
                <td colspan=6 class='h-100'>&nbsp;</td>
            </tr>
            <tr>
            <td class="table-primary text-center font-weight-bold" colspan=6>
                <?= $cuenta['codigo'] . ' - ' . $cuenta['nombre'] ?>
            </td>
            <?php
            foreach ($cuenta['partidas'] as $i_partida => $partida) {
                ?>
                <tr>
                <td class="table-light align-top p-3">
                    <?= Utiles::fechaSinFormato($partida['fecha']) ?>
                </td>
                <td class="table-light text-right font-weight-bold">
                <span class='numero_partida' data-codigo='<?= base64_encode($partida['codigo']) ?>'
                      data-partida=<?= $partida['numero'] ?>>
                    <?= $partida['numero'] ?>
                </span>
                </td>
                <td class="table-light">
                    <?= $partida['descripcion'] ?>
                </td>
                <td class="table-light text-right">
                    <?= $partida['movimiento'] === 'Cargo' ? Utiles::monto($partida['monto']) : '-' ?>
                </td>
                <td class="table-light text-right">
                    <?= $partida['movimiento'] === 'Abono' ? Utiles::monto($partida['monto']) : '-' ?>
                </td>
                <?php
                $cargo_partida = $partida['movimiento'] === 'Cargo' ? $partida['monto'] : 0;
                $abono_partida = $partida['movimiento'] === 'Abono' ? $partida['monto'] : 0;

                $total_cargo += $cargo_partida;
                $total_abono += $abono_partida;

                if ($cuenta['tipo_saldo'] === 'Deudor') {
                    $abono_partida *= -1;
                } else {
                    $cargo_partida *= -1;
                }

                $saldo_acumulado += $cargo_partida;
                $saldo_acumulado += $abono_partida;

                ?>
                <td class="table-light text-right">
                    <?= Utiles::monto($saldo_acumulado) ?>
                </td>
                <?php
            }
            ?>

            </tr>

            <tr>
                <td class="table-secondary font-weight-bold text-right" colspan=3>
                    Saldo: <b><?= $cuenta['tipo_saldo'] ?></b>
                </td>
                <td class="table-secondary text-right font-weight-bold">
                    <?= Utiles::monto($total_cargo) ?>
                </td>
                <td class="table-secondary text-right font-weight-bold">
                    <?= Utiles::monto($total_abono) ?>
                </td>
                <td class="table-secondary text-right font-weight-bold">
                    <?php
                    $saldo = 0;
                    $saldo = ($cuenta['tipo_saldo'] === 'Deudor' ? $total_cargo - $total_abono : $total_abono - $total_cargo);
                    ?>
                    <?= Utiles::monto($saldo) ?>
                </td>
            </tr>

            <?php
        }
    }
    if ($cantidad_mayor === 0) {
        ?>
        <tr>
            <td class="table-light text-center font-weight-bold" colspan=6>Ningún dato disponible en esta tabla</td>
        </tr>
        <?php
    }

    ?>
    </tbody>
</table>