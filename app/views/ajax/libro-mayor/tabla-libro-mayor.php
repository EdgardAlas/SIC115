<table class='table table-striped table-hover' style='font-size: 0.80rem;' id='tabla-mayor'>
    <thead>
        <tr>
            <th style='width: 15%;'>Fecha</th>
            <th style='width: 5%;'>Partida</th>
            <th style='width: 25%;'>Descripción</th>
            <th style='width: 20%;'>Cargo</th>
            <th style='width: 20%;'>Abono</th>
            <th style='width: 20%;'>Saldo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $partidas_cuentas = isset($datosBD) ? $datosBD : array();
        
        $total_cargo = 0;
        $total_abono = 0;

        foreach ($partidas_cuentas as $i_cuenta => $cuenta) {
            $total_cargo = 0;
            $total_abono = 0;
        ?>
        <tr>
            <td colspan=5 class='h-100'>&nbsp;</td>
        </tr>
        <tr>
            <td class="table-primary text-center font-weight-bold" colspan=6>
                <?= $cuenta['codigo'].' - '.$cuenta['nombre'] ?>
            </td>
            <?php
                foreach ($cuenta['partidas'] as $i_partida => $partida) {
            ?>
            <tr>
                <td class="table-light">
                    <?= Utiles::fecha($partida['fecha']) ?>
                </td>
                <td class="table-light text-right font-weight-bold">
                    <span class='numero_partida' data-codigo='<?=base64_encode($partida['codigo'])?>' data-partida = <?= $partida['numero']?>>
                        <?=$partida['numero']?>
                    </span>
                </td>
                <td class="table-light">
                    <?= $partida['descripcion']?>
                </td>
                <td class="table-light text-right">
                    <?= $partida['movimiento'] === 'Cargo' ? Utiles::monto($partida['monto']) : '-'?>
                </td>
                <td class="table-light text-right">
                    <?= $partida['movimiento'] === 'Abono' ? Utiles::monto($partida['monto']) : '-'?>
                </td>
                <td class="table-light">
                    
                </td>
            </tr>
            <?php

                $total_cargo += $partida['movimiento'] === 'Cargo' ? $partida['monto'] : 0;
                $total_abono+= $partida['movimiento'] === 'Abono' ? $partida['monto'] : 0;

                }
            ?>
            <tr>
                <td class="table-secondary font-weight-bold text-right" colspan=3>
                    Saldo: <b><?= $cuenta['tipo_saldo']?></b>
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
                        $saldo = ($cuenta['tipo_saldo']==='Deudor' ? $total_cargo - $total_abono : $total_abono - $total_cargo);
                    ?>
                    <?= Utiles::monto($saldo)?>
                </td>
            </tr>
        </tr>

        <?php
        }
        ?>
    </tbody>
</table>