<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Libro Mayor</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class='form-group row'>
                            <div class="col-12 col-sm-12 col-lg-3 form-group">
                                <label for="fecha_inicial">Fecha Inicial (*)</label>
                                <input type="date" class='form-control' value='<?= date('Y-01-01')?>' id='fecha_inicial'
                                    min='<?= date('Y-01-01')?>' max='<?= date('Y-m-d')?>'>
                            </div>

                            <div class="col-12 col-sm-12 col-lg-3 form-group">
                                <label for="fecha_final">Fecha Final (*)</label>
                                <input type="date" class='form-control' value='<?= date('Y-m-d')?>' id='fecha_final'
                                    min='<?= date('Y-01-01')?>' max='<?= date('Y-m-d')?>'>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-3 form-group" id='contenedor_niveles'>
                                <label for="nivel">Nivel</label>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-3 form-group">
                                <label for="cuenta">Cuenta</label>
                                <input type="text" class='form-control' id='cuenta'>
                            </div>
                            <!-- <div class=" col-12 d-block d-sm-block d-md-none">&nbsp;</div>

                            <div class="col-12  form-group">
                                <button type="button" id='btn_actualizar_diario' class="btn btn-warning" autofocus>
                                    Actualizar Tabla
                                </button>
                            </div> -->
                        </div>
                        <div class='col-12 table-responsive' id='contenedor_mayor'>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</section>
</div>

<!--Modal parida especifica-->
<div class="modal fade" id="modal_partida" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal-content-body">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Partida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row desbordamiento" id='partida_especifica'>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>