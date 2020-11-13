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
    $partidas = isset($datos) ? $datos : array();
    $codigo_cuenta = isset($codigo) ? $codigo : array();
    $tam_partidas = sizeof($partidas);
    $contador_detalle = 0;
    $cantidad_detalle = 1;
    $columna1 = 0;
    $columna2 = 0;

    foreach ($partidas as $key => $partida) {
        /* var_dump($partida);
        echo '<br><br>'; */
        if ($contador_detalle === 0) {
            $cantidad_detalle = array_count_values(array_column($partidas, 'numero'))[$partida['numero']];
            ?>
            <tr>
                <td colspan=4 class='h-100'>&nbsp;</td>
            </tr>
            <tr>
                <td class="table-primary text-center font-weight-bold" colspan=4>Partida #<?= $partida['numero'] ?></td>
            </tr>
            <tr>
                <td class="table-light align-top p-3"
                    rowspan=<?= $cantidad_detalle + 1 ?>><?= Utiles::fechaSinFormato($partida['fecha']) ?></td>
                <td class="<?= $codigo_cuenta !== null ? ($codigo_cuenta === $partida['codigo'] ? 'text-danger' : '') : '' ?> table-light" <?= ($partida['movimiento'] === 'Abono') ? "style='padding-left: 8em;'" : "" ?>>
                    <?= $partida['cuenta'] ?></td>
                <td class="<?= $codigo_cuenta !== null ? ($codigo_cuenta === $partida['codigo'] ? 'text-danger' : '') : '' ?> table-light text-right font-weight-bold">
                    <?= ($partida['movimiento'] === 'Cargo') ? Utiles::monto($partida['monto']) : '-' ?></td>
                <td class="<?= $codigo_cuenta !== null ? ($codigo_cuenta === $partida['codigo'] ? 'text-danger' : '') : '' ?> table-light text-right font-weight-bold">
                    <?= ($partida['movimiento'] === 'Abono') ? Utiles::monto($partida['monto']) : '-' ?></td>
            </tr>
            <?php
            $columna1 = $columna1 + $partida['monto'];
            ?>
            <?php
            $contador_detalle++;
            continue;
        }
        if ($contador_detalle < $cantidad_detalle) {
            ?>
            <tr>
                <td class="<?= $codigo_cuenta !== null ? ($codigo_cuenta === $partida['codigo'] ? 'text-danger' : '') : '' ?> table-light" <?= ($partida['movimiento'] === 'Abono') ? "style='padding-left: 8em'" : "" ?>>
                    <?= $partida['cuenta'] ?></td>
                <td class="<?= $codigo_cuenta !== null ? ($codigo_cuenta === $partida['codigo'] ? 'text-danger' : '') : '' ?> table-light text-right font-weight-bold">
                    <?= ($partida['movimiento'] === 'Cargo') ? Utiles::monto($partida['monto']) : '-' ?></td>
                <td class="<?= $codigo_cuenta !== null ? ($codigo_cuenta === $partida['codigo'] ? 'text-danger' : '') : '' ?> table-light text-right font-weight-bold">
                    <?= ($partida['movimiento'] === 'Abono') ? Utiles::monto($partida['monto']) : '-' ?></td>
            </tr>
            <?php
            if ($partida['movimiento'] === 'Cargo') {
                $columna1 = $columna1 + $partida['monto'];
            } else {
                $columna2 = $columna2 + $partida['monto'];
            }
            ?>
            <?php

            $contador_detalle++;
        }

        if ($contador_detalle === $cantidad_detalle) {
            ?>
            <tr>
                <td class='table-light text-right font-weight-bold'>Total:</td>
                <td class='table-light text-right font-weight-bold'><?= Utiles::monto($columna1) ?></td>
                <td class='table-light text-right font-weight-bold'><?= Utiles::monto($columna2) ?></td>
            </tr>
            <tr>
                <td class="table-secondary text-center font-weight-bold" colspan=4><?= $partida['descripcion'] ?></td>
            </tr>
            <?php
            $contador_detalle = 0;
            $columna1 = 0;
            $columna2 = 0;
        }
    }

    if ($tam_partidas === 0) {
        ?>
        <tr>
            <td class="table-light text-center font-weight-bold" colspan=4>Ningún dato disponible en esta tabla</td>
        </tr>
        <?php
    }

    ?>

    </tbody>
</table>