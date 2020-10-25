<div class="modal-header bg-primary">
    <h5 class="modal-title text-white" id="exampleModalLabel">Iniciar nuevo periodo</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id='form_guardar' data-accion = 'guardar'>
    <div class="modal-body">

        <div class="row form-group">
            <div class="col-6">
                <label for="fecha_inicial">Fecha de inicio</label>
                <input type="date" value='<?= date(($anio===null ? 'Y' : $anio+1).'-01-01')?>' class='form-control' disabled>
            </div>
            <div class="col-6">
                <label for="fecha_inicial">Fecha de fin</label>
                <input type="date" value='<?= date(($anio===null ? 'Y' : $anio+1).'-12-31')?>' class='form-control' disabled>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id='btn_generar_periodo'>Iniciar Periodo</button>
    </div>
</form>