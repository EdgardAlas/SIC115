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
                                    Reporte Balanza Comprobacion
                                </a>
                            </div>
                        </div>
                        <div class='form-group row'>

                            <div class="col-12 col-sm-12 col-lg-4 form-group">
                                <label for="fecha_inicial">Fecha Inicial (*)</label>
                                <input type="date" class='form-control' value='<?= date('Y-01-01')?>' id='fecha_inicial'
                                    min='<?= date('Y-01-01')?>' max='<?= date('Y-m-d')?>'>
                            </div>

                            <div class="col-12 col-sm-12 col-lg-4 form-group">
                                <label for="fecha_final">Fecha Final (*)</label>
                                <input type="date" class='form-control' value='<?= date('Y-m-d')?>' id='fecha_final'
                                    min='<?= date('Y-01-01')?>' max='<?= date('Y-m-d')?>'>
                            </div>

                            <div class="col-12 col-sm-12 col-lg-4 form-group" id='contenedor_niveles'>
                                <label for="nivel">Nivel</label>
                            </div>
                        </div>
                        <div class='form-group' id='totales'>
                            <h2 class=' text-center h6'>Total Debe: <b id='debe'>$0.00</b> - Total Haber: <b
                                    id='haber'>$0.00</b></h2>
                            <h3 class='text-center h6'>Total Deudor: <b id='deudor'>$0.00</b> - Total Acreedor: <b
                                    id='acreedor'>$0.00</b></h3>
                        </div>

                        <div id='contenedor-balanza' class='table-responsive'></div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>

</div>