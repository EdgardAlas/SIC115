<?php
    $cuentas = isset($datos) ? $datos : array();
    
    if(sizeof($cuentas)>0){

    
?>

<div class="col-12 col-sm-6 d-flex flex-column align-items-strech justify-content-between">
    <!-- Activo Corriente -->

    <?php
        $cuenta_primer_nivel = Utiles::buscar('activo', 'descripcion', $cuentas);    
        $subcuentas = $cuenta_primer_nivel['subcuentas'];

        $cambio_de_seccion = false;
        $saldo_cuenta_principal = $cuenta_primer_nivel['tipo_saldo'];
        $total_seccion = 0;


        foreach ($subcuentas as $key => $subcuenta) {
            if($subcuenta['nivel']==2){
    ?>
    <?=$key>0 ? '</ul>' : '' ?>
    <ul class="list-group mb-3">
        <li class="list-group-item active d-flex justify-content-between align-items-center">
            <?=$subcuenta['codigo'].' - '.$subcuenta['nombre'] ?>
            <span class="badge badge-info badge-pill"><?= Utiles::monto($subcuenta['saldo'])?></span>
        </li>
        <?php
        continue;
            }

            
                ?>

        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <span style='max-width:100%'>
                <?=$subcuenta['codigo'].' - '.$subcuenta['nombre'] ?>
            </span>
            <span
                class="badge <?= $saldo_cuenta_principal!==$subcuenta['tipo_saldo'] ? 'badge-danger' : 'badge-success' ?> badge-pill"><?= Utiles::monto($subcuenta['saldo'])?></span>
        </li>

        <?php
            $total_seccion += $saldo_cuenta_principal!==$subcuenta['tipo_saldo'] ? -$subcuenta['saldo'] : $subcuenta['saldo'];
        }
    ?>

    </ul>

    <!-- total activo -->
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
            <?= 'Total '.$cuenta_primer_nivel['nombre']?>
            <span class="badge badge-info badge-pill"><?= Utiles::monto($total_seccion) ?></span>
        </li>
    </ul>

</div>
<div class='d-sm-none d-block form-group col-12'>
    <hr class="dashed mt-4 mb-0">
</div>

<div class="col-12 col-sm-6 d-flex flex-column align-items-strech justify-content-between">

    <!-- aca ira pasivo -->
    <?php

        $titulo_total = "Total ";

        $cuenta_primer_nivel = Utiles::buscar('pasivo', 'descripcion', $cuentas);    
        $subcuentas = $cuenta_primer_nivel['subcuentas'];

        $cambio_de_seccion = false;
        $saldo_cuenta_principal = $cuenta_primer_nivel['tipo_saldo'];
        $total_seccion = 0;
        $titulo_total .= $cuenta_primer_nivel['nombre'].' + ';

        foreach ($subcuentas as $key => $subcuenta) {
            if($subcuenta['nivel']==2){
    ?>
    <?=$key>0 ? '</ul>' : '' ?>
    <ul class="list-group mb-3">
        <li class="list-group-item active d-flex justify-content-between align-items-center">
            <?=$subcuenta['codigo'].' - '.$subcuenta['nombre'] ?>
            <span class="badge badge-info badge-pill"><?= Utiles::monto($subcuenta['saldo'])?></span>
        </li>
        <?php
        continue;
            }

            
                ?>

        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <span style='max-width:100%'>
                <?=$subcuenta['codigo'].' - '.$subcuenta['nombre'] ?>
            </span>
            <span
                class="badge <?= $saldo_cuenta_principal!==$subcuenta['tipo_saldo'] ? 'badge-danger' : 'badge-success' ?> badge-pill"><?= Utiles::monto($subcuenta['saldo'])?></span>
        </li>

        <?php
            $total_seccion += $saldo_cuenta_principal!==$subcuenta['tipo_saldo'] ? -$subcuenta['saldo'] : $subcuenta['saldo'];
        }
    ?>

    </ul>

    <!-- Aca ira patrimonio -->
    <?php
        $cuenta_primer_nivel = Utiles::buscar('patrimonio', 'descripcion', $cuentas);    
        $subcuentas = $cuenta_primer_nivel['subcuentas'];

        $cambio_de_seccion = false;
        $saldo_cuenta_principal = $cuenta_primer_nivel['tipo_saldo'];
        $titulo_total .= $cuenta_primer_nivel['nombre'].' ';


        foreach ($subcuentas as $key => $subcuenta) {
            if($subcuenta['nivel']==2){
    ?>
    <?=$key>0 ? '</ul>' : '' ?>
    <ul class="list-group mb-3">
        <li class="list-group-item active d-flex justify-content-between align-items-center">
            <?=$subcuenta['codigo'].' - '.$subcuenta['nombre'] ?>
            <span class="badge badge-info badge-pill"><?= Utiles::monto($subcuenta['saldo'])?></span>
        </li>
        <?php
        continue;
            }

            
                ?>

        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <span style='max-width:100%'>
                <?=$subcuenta['codigo'].' - '.$subcuenta['nombre'] ?>
            </span>
            <span
                class="badge <?= $saldo_cuenta_principal!==$subcuenta['tipo_saldo'] ? 'badge-danger' : 'badge-success' ?> badge-pill"><?= Utiles::monto($subcuenta['saldo'])?></span>
        </li>

        <?php
            $total_seccion += $saldo_cuenta_principal!==$subcuenta['tipo_saldo'] ? -$subcuenta['saldo'] : $subcuenta['saldo'];
        }
    ?>

    </ul>

    <!-- Total Pasivo + Capital -->
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= $titulo_total?>
            <span class="badge badge-info badge-pill"><?=Utiles::monto($total_seccion) ?></span>
        </li>
    </ul>

    <?php
}else{
    echo "<h2 class='text-center'>NO HAY CONFIGURACION DE CUENTAS, POR FAVOR CONFIGURELA <a href='/configuracion'>AQUI</a></h2>";
}
    ?>