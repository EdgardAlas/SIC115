<?php
    $cuenta_editar = isset($cuenta) ? $cuenta : array();
?>

<div class="modal-header bg-primary">
    <h5 class="modal-title text-white" id="exampleModalLabel">Editar Cuenta</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id='formEditar'>
    <div class="modal-body">

        <div class="row form-group">
            <div class="col-12">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control"
                        value='<?= !empty($cuenta_editar) ? $cuenta_editar['codigo'] : '' ?>'
                        disabled>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-6">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                        value='<?= !empty($cuenta_editar) ? $cuenta_editar['nombre'] : '' ?>'>
            </div>
            <div class="col-6">
                <label for="tipo_saldo">Tipo de saldo</label>
                <select name="tipo_saldo" id="tipo_saldo" class="form-control">
                    <option value="Deudor"
                    <?= !empty($cuenta_editar) ? ($cuenta_editar['tipo_saldo'] === 'Deudor') ? 'selected' : '' : '' ?> >
                        Deudor
                    </option>
                    <option value="Acreedor"
                    <?= !empty($cuenta_editar) ? ($cuenta_editar['tipo_saldo'] === 'Acreedor') ? 'selected' : '' : '' ?>
                    >
                        Acreedor
                    </option>
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id='btn_editar' data-cuenta = '<?= !empty($cuenta_editar) ? base64_encode($cuenta_editar['id']) : '' ?>'>
            Editar Cuenta
        </button>
    </div>
</form>