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

            foreach ($datos as $key => $cuenta) {
                ?>
            <tr>
                <td><?= $cuenta['nombre']?></td>
                <td class='text-right'><?= isset($cuenta['debe']) ? $cuenta['debe'] : '-' ?></td>
                <td class='text-right'><?= isset($cuenta['haber']) ? $cuenta['haber'] : '-' ?></td>
                <td class='text-right font-weight-bold'><?= $cuenta['tipo_saldo']=== 'Deudor' ? Utiles::monto($cuenta['saldo']) : '-' ?></td>
                <td class='text-right font-weight-bold'><?= $cuenta['tipo_saldo']=== 'Acreedor' ? Utiles::monto($cuenta['saldo']) : '-' ?></td>
            </tr>
        <?php

                $debe += (isset($cuenta['debe']) ? Utiles::convertirMonto($cuenta['debe']) : 0);
                $haber += (isset($cuenta['debe']) ? Utiles::convertirMonto($cuenta['debe']) : 0);
                $deudor += ($cuenta['tipo_saldo']==='Deudor' ? $cuenta['saldo'] : 0);
                $acreedor += ($cuenta['tipo_saldo']==='Acreedor' ? $cuenta['saldo'] : 0);
                

            }
        ?>

    </tbody>
</table>


<input type="hidden" id='total_debe' value="<?= Utiles::monto($debe)?>">
<input type="hidden" id='total_haber' value="<?= Utiles::monto($haber)?>">
<input type="hidden" id='total_deudor' value="<?= Utiles::monto($deudor)?>">
<input type="hidden" id='total_acreedor' value="<?= Utiles::monto($acreedor)?>">
