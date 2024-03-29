<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Balanza de Comprobación</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <a href='<?=URL_BASE?>/balanza-comprobacion/reporte-balanza-comprobacion' id='btn_imprimir'
                                    class="btn btn-success">
                                    <i class="fas fa-file-pdf"></i>
                                    Reporte Balanza Comprobacion
                                </a>
                            </div>
                        </div>
                        <div class='form-group row'>

                            <div class="col-12 col-sm-12 col-lg-3 form-group">
                                <label for="fecha_inicial">Fecha Inicial (*)</label>
                                <input type="date" class='form-control' value='<?= date((isset($anio) ? $anio : 'Y').'-01-01') ?>' id='fecha_inicial'>
                            </div>

                            <div class="col-12 col-sm-12 col-lg-3 form-group">
                                <label for="fecha_final">Fecha Final (*)</label>
                                <input type="date" class='form-control' value='<?= date((isset($anio) ? $anio : 'Y').'-12-31') ?>' id='fecha_final' >
                            </div>

                            <div class="col-12 col-sm-12 col-lg-4 form-group" id='contenedor_niveles'>

                            </div>
                        </div>

                        <div id='contenedor-balanza' class='table-responsive'></div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>