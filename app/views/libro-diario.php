<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Libro Diario</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <button type="button" id='btn_partida' class="btn btn-primary" autofocus>
                                    Agregar Partida
                                </button>
                            </div>
                        </div>
                        <div id='contendor_partidas' class='table-responsive'>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<!--Modal partidas-->
<div class="modal fade" id="modal_partida" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="modal-content-body">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Partida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id='formGuardar'>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="row form-group">
                                <div class="col-12 col-sm-6">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" id='fecha' name='fecha' class="form-control"
                                        value='<?php echo date('Y-m-d'); ?>'>
                                </div>
                            </div>
                            <div class='row form-group'>
                                <div class="col-12">
                                    <label for="descripcion">Descripción</label>
                                    <input type="tex" id='descripcion' name='descripcion' class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <hr>
                            </div>

                            <!--Zona de control de partidas-->
                            <div class='row form-group'>
                                <div class="col-12" id="contenedor_cuentas">

                                </div>
                            </div>
                            <div class='row form-group'>
                                <div class="col-6">
                                    <label for="fecha">Movimiento</label>
                                    <select name="movimiento" id="movimiento" class="form-control">
                                        <option value="Cargo">Cargo</option>
                                        <option value="Abono">Abono</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="monto">Monto ($)</label>
                                    <input type="text" id='monto' name='monto' class="form-control">
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-12">
                                    <button type="button" class="btn btn-success w-100" id='btn_agregar'
                                        name='btn_agregar' data-indice=-1 data-accion='agregar'>Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class=" col-12 d-block d-sm-block d-md-none">&nbsp;</div>
                        <div class="col-sm-12 col-md-7 tabl-responsive desbordamiento" id='contender_tabla_detalle'>
                            <div class='row'>
                                <div class="col-4">
                                    <p class='text-center font-weight-bold'>Cargo <span id='total_cargo'>$0.00</span>
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p class='text-center font-weight-bold'>Abono <span id='total_abono'>$0.00</span>
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p class='text-center font-weight-bold text-danger'>Dif. <span id='dif'>$0.00</span>
                                    </p>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover" id='tabla_detalle_partida'
                                style='font-size: 0.725rem;'>
                                <thead>
                                    <tr>
                                        <th style='width: 25%;'>Código</th>
                                        <th style='width: 35%'>Cargo</th>
                                        <th style='width: 35%'>Abono</th>
                                        <th style='width: 10%'>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id='btn_guardar_partida'>Guardar Partida</button>
                </div>
            </form>
        </div>
    </div>
</div>