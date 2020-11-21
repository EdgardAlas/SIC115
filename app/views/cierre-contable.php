<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Cierre Contable</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-10">
                                <label for="inventario_final">Inventario Final</label>
                                <input type="text" class="form-control" id="inventario_final">
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <button class='btn btn-primary' id="btn_calcular_cierre">Calcular Cierre</button>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12">
                                <div class="dropdown d-inline">
                                    <button class="btn btn-success dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Balance General
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" id="forma_cuenta">Forma de Cuenta</a>
                                        <a class="dropdown-item" id="forma_reporte" href="/cierre-contable/balance-forma-reporte">Forma de Reporte</a>
                                    </div>
                                </div>
                                <button class="btn btn-success" id="estado_resultados">Estado de Resultados</button>
                            </div>
                        </div>
                        <div class="table-responsive" id="div_partidas">
                            <table class='table table-striped table-bordered table-hover' style='font-size: 0.80rem;'>
                                <thead>
                                <tr>
                                    <th style='width: 20%;'>Fecha</th>
                                    <th style='width: 40%;'>Cuentas</th>
                                    <th style='width: 20%;'>Debe</th>
                                    <th style='width: 20%;'>Haber</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="table-light text-center font-weight-bold" colspan=4>Ningún dato
                                        disponible en esta tabla
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12 position-sticky sticky-top sticky-bottom text-center p-3 border">
                            <button class="btn btn-primary" id="realizar_cierre">Realizar Cierre</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

