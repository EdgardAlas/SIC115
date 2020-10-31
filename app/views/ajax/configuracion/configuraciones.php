<?php
    $configuraciones = isset($datos) ? $datos : array();
    
?>


<div class="tab-pane fade show active p-3" id="nav-clasificacion" role="tabpanel" aria-labelledby="nav-clasificacion">
    <h2 class='h3'>Clasficicación de cuentas</h2>

    <!-- activo -->
    <?php
        $cuenta = Utiles::buscar('activo', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="activo">Cuentas de Activo</label>
            <input type="text" class='form-control buscar-cuenta' maxlength=1 autofocus
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_activo'>
            <label for="activo">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='clasificacion'
                data-descripcion='activo' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : ''?>'>
        </div>
    </div>

    <!-- pasivo  -->
    <?php
        $cuenta = Utiles::buscar('pasivo', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuentas de Pasivo</label>
            <input type="text" class='form-control buscar-cuenta' maxlength=1
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_pasivo'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='clasificacion'
                data-descripcion='pasivo' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Patrimonio  -->
    <?php
        $cuenta = Utiles::buscar('patrimonio', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuentas de Patrimonio</label>
            <input type="text" class='form-control buscar-cuenta' maxlength=1
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_patrimonio'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='clasificacion'
                data-descripcion='patrimonio' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Gastos  -->
    <?php
        $cuenta = Utiles::buscar('gastos', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuentas de Gastos</label>
            <input type="text" class='form-control buscar-cuenta' maxlength=1
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_gastos'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='clasificacion'
                data-descripcion='gastos' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Ingresos  -->
    <?php
        $cuenta = Utiles::buscar('ingresos', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuentas de Ingresos</label>
            <input type="text" class='form-control buscar-cuenta' maxlength=1
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_ingresos'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='clasificacion'
                data-descripcion='ingresos' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Perdida y ganancias  -->
    <?php
        $cuenta = Utiles::buscar('pye', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuentas de Perdidas y Ganancias</label>
            <input type="text" class='form-control buscar-cuenta' maxlength=1
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_pye'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='cierre'
                data-descripcion='pye' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- IVA CREDITO FISCAL  -->
    <?php
    $cuenta = Utiles::buscar('iva_credito', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuenta de IVA Credito Fiscal</label>
            <input type="text" class='form-control buscar-cuenta'
                   value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_iva_credito'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='cierre'
                   data-descripcion='iva_credito' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                   data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- IVA DEBITO FISCAL  -->
    <?php
    $cuenta = Utiles::buscar('iva_debito', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuenta de IVA Debito Fiscal</label>
            <input type="text" class='form-control buscar-cuenta'
                   value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_iva_debito'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='cierre'
                   data-descripcion='iva_debito' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                   data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Impuesto iva por pagar  -->
    <?php
    $cuenta = Utiles::buscar('impuest_iva', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Cuenta de Impuesto por pagar IVA</label>
            <input type="text" class='form-control buscar-cuenta'
                   value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_impuest_iva'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='cierre'
                   data-descripcion='impuest_iva' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                   data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>


</div>
<div class="tab-pane fade p-3" id="nav-estado-resultados" role="tabpanel" aria-labelledby="nav-estado-resultados">
    <h2 class='h3'>Clasficicación de cuentas</h2>

    <!-- Ventas -->
    <?php
        $cuenta = Utiles::buscar('ventas', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Ventas</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_ventas'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='ventas' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Rebajas sobre ventas -->
    <?php
        $cuenta = Utiles::buscar('rebajas_ventas', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Rebajas sobre ventas</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_rebajas_ventas'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='rebajas_ventas'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Devoluciones sobre ventas -->
    <?php
        $cuenta = Utiles::buscar('devoluciones_ventas', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Devoluciones sobre ventas</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_devoluciones_ventas'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='devoluciones_ventas'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Compras -->
    <?php
        $cuenta = Utiles::buscar('compras', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Compras</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_compras'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='compras' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Gastos sobre compras -->
    <?php
        $cuenta = Utiles::buscar('gastos_compras', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Gastos sobre compras</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_gastos_compras'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='gastos_compras'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Rebajas sobre compras -->
    <?php
        $cuenta = Utiles::buscar('rebajas_compras', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Rebajas sobre compras</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_rebajas_compras'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='rebajas_compras'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Devoluciones sobre compras -->
    <?php
        $cuenta = Utiles::buscar('devoluciones_compras', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Devoluciones sobre compras</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_devoluciones_compras'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='devoluciones_compras'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Inventario -->
    <?php
        $cuenta = Utiles::buscar('inventario', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Inventario</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_inventario'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='inventario' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Gastos de operacion -->
    <?php
        $cuenta = Utiles::buscar('gastos_operacion', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Gastos de operación</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_gastos_operacion'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='gastos_operacion'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Otros productos -->
    <?php
        $cuenta = Utiles::buscar('otros_productos', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Otros productos</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_otros_productos'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='otros_productos'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Otros gastos -->
    <?php
        $cuenta = Utiles::buscar('otros_gastos', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Otros gastos</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_otros_gastos'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='otros_gastos' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Reserva legal -->
    <?php
        $cuenta = Utiles::buscar('reserva_legal', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Reserva legal</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_reserva_legal'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='reserva_legal'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>' data-obligatorio=1
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Impuesto sobre la renta -->
    <?php
        $cuenta = Utiles::buscar('impuesto_renta', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Impuesto sobre la renta</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_impuesto_renta'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='impuesto_renta'
                data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>' data-obligatorio=1
                value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Utilidad -->
    <?php
        $cuenta = Utiles::buscar('utilidad', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Utilidad</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_utilidad'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='utilidad' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

    <!-- Perdida -->
    <?php
        $cuenta = Utiles::buscar('perdida', 'descripcion' , $configuraciones);
    ?>
    <div class='row form-group'>
        <div class='col-6'>
            <label for="">Perdida</label>
            <input type="text" class='form-control buscar-cuenta'
                value='<?= !empty($cuenta) ? $cuenta['codigo'] : '' ?>'>
        </div>
        <div class='col-6' id='div_perdida'>
            <label for="">Cuenta seleccionada</label>
            <input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='estado_resultados'
                data-descripcion='perdida' data-cuenta='<?= !empty($cuenta) ? base64_encode($cuenta['id']) : -1 ?>'
                data-obligatorio=1 value='<?= !empty($cuenta) ? $cuenta['nombre'] : '' ?>'>
        </div>
    </div>

</div>