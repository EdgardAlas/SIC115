<table class='table table-striped table-bordered table-hover' id='tabla_balanza'>

    <thead id='thead_fixed'>
        <th style='width: 50%;'>Cuenta</th> <!-- codigo + cuenta -->
        <th style='width: 12.5%;'>Debe</th> <!-- total cargo -->
        <th style='width: 12.5%;'>Haber</th> <!-- total abono -->
        <th style='width: 12.5%;'>Deudor</th> <!-- tipo de saldo -->
        <th style='width: 12.5%;'>Acreedor</th>

    </thead>
    <tbody>
        <?php $datos = isset($cuentas) ? $cuentas  : array();?>

        <?php

            $debe = 0;
            $haber = 0;
            $deudor = 0;
            $acreedor = 0;

            $saldo = 0;
            
            foreach ($datos as $key => $cuenta) {
                $aux_debe = isset($cuenta['debe']) ? ($cuenta['debe']) : 0;
                $aux_haber = isset($cuenta['haber']) ? ($cuenta['haber']) : 0;
                $saldo = ($cuenta['tipo_saldo'] === 'Deudor' ? ($aux_debe - $aux_haber ): ($aux_haber- $aux_debe));

                ?>
        <tr>
            <td><?= $cuenta['codigo'].' - '.$cuenta['nombre']?></td>
            <td class='text-right'><?= isset($cuenta['debe']) ? Utiles::monto($cuenta['debe']) : '-' ?></td>
            <td class='text-right'><?= isset($cuenta['haber']) ? Utiles::monto($cuenta['haber']) : '-' ?></td>
            <td class='text-right font-weight-bold <?=   $saldo < 0 ?  'text-danger' :  '' ?>' >
            <?= $cuenta['tipo_saldo']== 'Deudor' ?  ($saldo != 0 ? Utiles::monto(abs($saldo)) : '-') : '-' ?>
			
            </td>
            <td class='text-right font-weight-bold <?=   $saldo < 0 ?  'text-danger' :  '' ?>' >
                <?= $cuenta['tipo_saldo']== 'Acreedor' ?  ($saldo != 0 ? Utiles::monto(abs($saldo)) : '-') : '-' ?>
				
            </td>
        </tr>
        <?php

                $debe += (isset($cuenta['debe']) ? ($cuenta['debe']) : 0);
                $haber += (isset($cuenta['haber']) ? ($cuenta['haber']) : 0);
                $deudor += ($cuenta['tipo_saldo']==='Deudor' ? $saldo : 0);
                $acreedor += ($cuenta['tipo_saldo']==='Acreedor' ? $saldo : 0);
                

            }
        ?>

    </tbody>
    <tfooter>
        <tr>
            <td class='table-light text-right font-weight-bold'>Totales: </td>
            <td class='table-light text-right font-weight-bold'><?= Utiles::monto($debe)?></td>
            <td class='table-light text-right font-weight-bold'><?= Utiles::monto($haber)?></td>
            <td class='table-light text-right font-weight-bold'><?= Utiles::monto($deudor)?></td>
            <td class='table-light text-right font-weight-bold'><?= Utiles::monto($acreedor)?></td>
        </tr>
    </tfooter>
</table>


<!-- <input type="hidden" id='total_debe' value="<?= Utiles::monto($debe)?>">
<input type="hidden" id='total_haber' value="<?= Utiles::monto($haber)?>">
<input type="hidden" id='total_deudor' value="<?= Utiles::monto($deudor)?>">
<input type="hidden" id='total_acreedor' value="<?= Utiles::monto($acreedor)?>">  -->