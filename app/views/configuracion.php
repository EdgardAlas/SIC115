<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>INICIO</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                    href="#nav-clasificacion" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Clasificacion de Cuentas</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                    href="#nav-estado-resultados" role="tab" aria-controls="nav-contact"
                                    aria-selected="false">Estado de Resultados</a>
                            </div>
                        </nav>
                        <div class="tab-content border" id="nav-tabContent">
                            <div class="tab-pane fade show active p-3" id="nav-clasificacion" role="tabpanel"
                                aria-labelledby="nav-clasificacion">
                                <h2 class='h3'>Clasficicación de cuentas</h2>
                                <form id='form-clasificacion'>

                                    <!-- activo -->
                                    <div class='row form-group'>
                                        <div class='col-6'>
                                            <label for="activo">Cuentas de Activo</label>
                                            <input type="text" class='form-control buscar-cuenta' maxlength=1 autofocus>
                                        </div>
                                        <div class='col-6' id='div_activo'>
                                            <label for="activo">Cuenta seleccionada</label>
                                            <input type="text" class='form-control configuracion' readonly tabindex=-1
                                                data-titulo='clasificacion' data-descripcion='activo' data-cuenta='-1'>
                                        </div>
                                    </div>

                                    <!-- pasivo  -->
                                    <div class='row form-group'>
                                        <div class='col-6'>
                                            <label for="activo">Cuentas de Pasivo</label>
                                            <input type="text" class='form-control buscar-cuenta' maxlength=1>
                                        </div>
                                        <div class='col-6' id='div_pasivo'>
                                            <label for="activo">Cuenta seleccionada</label>
                                            <input type="text" class='form-control configuracion' readonly tabindex=-1
                                                data-titulo='clasificacion' data-descripcion='pasivo' data-cuenta='-1'>
                                        </div>
                                    </div>

                                    <!-- Patrimonio  -->
                                    <div class='row form-group'>
                                        <div class='col-6'>
                                            <label for="activo">Cuentas de Patrimonio</label>
                                            <input type="text" class='form-control buscar-cuenta' maxlength=1>
                                        </div>
                                        <div class='col-6' id='div_patrimonio'>
                                            <label for="activo">Cuenta seleccionada</label>
                                            <input type="text" class='form-control configuracion' readonly tabindex=-1
                                                data-titulo='clasificacion' data-descripcion='patrimonio' data-cuenta='-1'>
                                        </div>
                                    </div>

                                    <!-- Gastos  -->
                                    <div class='row form-group'>
                                        <div class='col-6'>
                                            <label for="activo">Cuentas de Gastos</label>
                                            <input type="text" class='form-control buscar-cuenta' maxlength=1>
                                        </div>
                                        <div class='col-6' id='div_gastos'>
                                            <label for="activo">Cuenta seleccionada</label>
                                            <input type="text" class='form-control configuracion' readonly tabindex=-1
                                                data-titulo='clasificacion' data-descripcion='gastos' data-cuenta='-1'>
                                        </div>
                                    </div>

                                    <!-- Ingresos  -->
                                    <div class='row form-group'>
                                        <div class='col-6'>
                                            <label for="activo">Cuentas de Ingresos</label>
                                            <input type="text" class='form-control buscar-cuenta' maxlength=1>
                                        </div>
                                        <div class='col-6' id='div_ingresos'>
                                            <label for="activo">Cuenta seleccionada</label>
                                            <input type="text" class='form-control configuracion' readonly tabindex=-1
                                                data-titulo='clasificacion' data-descripcion='ingresos' data-cuenta='-1'>
                                        </div>
                                    </div>

                                    <!-- Perdida y ganancias  -->
                                    <div class='row form-group'>
                                        <div class='col-6'>
                                            <label for="activo">Cuentas de Perdidas y Ganancias</label>
                                            <input type="text" class='form-control buscar-cuenta' maxlength=1>
                                        </div>
                                        <div class='col-6' id='div_pye'>
                                            <label for="activo">Cuenta seleccionada</label>
                                            <input type="text" class='form-control configuracion' readonly tabindex=-1
                                                data-titulo='clasificacion' data-descripcion='pye' data-cuenta='-1'>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane fade p-3" id="nav-estado-resultados" role="tabpanel"
                                aria-labelledby="nav-estado-resultados">
                                2
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</section>
</div>