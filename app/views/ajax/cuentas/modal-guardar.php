<div class="modal-header bg-primary">
    <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Cuenta</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id='form_guardar' data-accion = 'guardar'>
    <div class="modal-body">

        <div class="row form-group">
            <div class="col-6">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control text-uppercase">
            </div>
            <div class="col-6" id='validar_padre'>
                <label for="padre">Cuenta padre</label>
                <input type="text" name="padre" id="padre" data-mayor=<?=base64_encode(-1)?> class="form-control" readonly tabindex="-1">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-6">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
            <div class="col-6">
                <label for="tipo_saldo">Tipo de saldo</label>
                <select name="tipo_saldo" id="tipo_saldo" class="form-control">
                    <option value="Deudor">Deudor</option>
                    <option value="Acreedor">Acreedor</option>
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        <button type="button" class="btn btn-primary" id='btn_guardar'><i class="fas fa-save"></i> Guardar Cuenta</button>
    </div>
</form>