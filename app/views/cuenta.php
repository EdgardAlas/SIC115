<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Catálogo de Cuentas</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <small>*Solo se pueden eliminar cuentas que no hayan sido usadas y apartir de cuentas de ultimo nivel</small>
                            </div>
                            <div class="w-100">
                                &nbsp;
                            </div>
                            <div class="col-12">

                                <?php
                                $estado = isset($estado) ? $estado : null;

                                if ($estado !== 'CIERRE') {
                                    ?>
                                    <button type="button" id='btn_acciones_cuenta' class="btn btn-primary">
                                        <i class="fas fa-plus-square"></i>
                                        Agregar Cuenta
                                    </button>
                                    <?php
                                }

                                ?>

                                <a href='<?= URL_BASE ?>/cuenta/reporte-catalogo' id='btn_imprimir'
                                   class="btn btn-success">
                                    <i class="fas fa-file-pdf"></i>
                                    Reporte de cuentas
                                </a>
                            </div>
                        </div>
                        <div id='div_tabla_cuentas' class='table-responsive'>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--Modal Guardar Cuenta-->
<div class="modal fade" id="modal_acciones_cuenta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal-content-body">
        </div>
    </div>
</div>