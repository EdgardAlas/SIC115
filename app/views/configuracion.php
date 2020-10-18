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


                            </div>
                            <div class="tab-pane fade p-3" id="nav-estado-resultados" role="tabpanel"
                                aria-labelledby="nav-estado-resultados">
                                <h2 class='h3'>Clasficicación de cuentas</h2>

                                <!-- Ventas -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Ventas</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_ventas'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='ventas' data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Rebajas sobre ventas -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Rebajas sobre ventas</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_rebajas_ventas'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='rebajas_ventas'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Devoluciones sobre ventas -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Rebajas sobre ventas</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_devoluciones_ventas'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='devoluciones_ventas'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Compras -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Compras</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_compras'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='compras' data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Gastos sobre compras -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Gastos sobre compras</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_gastos_compras'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='gastos_compras'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Rebajas sobre compras -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Rebajas sobre compras</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_rebajas_compras'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='rebajas_compras'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Devoluciones sobre compras -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Rebajas sobre compras</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_devoluciones_compras'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='devoluciones_compras'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Inventario -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Inventario</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_inventario'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='inventario'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Gastos de operacion -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Gastos de operación</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_gastos_operacion'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='gastos_operacion'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Otros productos -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Otros productos</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_otros_productos'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='otros_productos'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Otros gastos -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Otros gastos</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_otros_gastos'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='otros_gastos'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Reserva legal -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Reserva legal</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_reserva_legal'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='reserva_legal'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Impuesto sobre la renta -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Impuesto sobre la renta</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_impuesto_renta'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='impuesto_renta'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Utilidad -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Utilidad</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_utilidad'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='utilidad'
                                            data-cuenta='-1'>
                                    </div>
                                </div>

                                <!-- Perdida -->
                                <div class='row form-group'>
                                    <div class='col-6'>
                                        <label for="activo">Perdida</label>
                                        <input type="text" class='form-control buscar-cuenta' autofocus>
                                    </div>
                                    <div class='col-6' id='div_perdida'>
                                        <label for="activo">Cuenta seleccionada</label>
                                        <input type="text" class='form-control configuracion' readonly tabindex=-1
                                            data-titulo='estado_resultados' data-descripcion='perdida' data-cuenta='-1'>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class='w-100'>
                            <span>&nbsp;</span>
                        </div>

                        <div class='row'>
                            <div class="col-12 text-center">
                                <button type='button' class='btn btn-primary' id='btn_guardar'>
                                    Guardar
                                </button>
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