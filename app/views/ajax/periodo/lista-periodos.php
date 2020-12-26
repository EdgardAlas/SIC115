<?php
$periodo_activo = isset($periodo) ? $periodo : null;
$lista_periodos = isset($periodos) ? $periodos : array();
?>

<div class="row">
    <div class="form-group col-12">
        <?php


        if ($periodo_activo['periodo'] === null || $periodo_activo['estado'] === 'CERRADO') {
            ?>
            <button type="button" id='btn_iniciar_periodo' class="btn btn-primary">
                <i class="fas fa-plus-square"></i>
                Iniciar nuevo periodo
            </button>
            <?php
        } else {
            ?>
            <h2 class='text-center h5'>Periodo activo número <b><?= sizeof($lista_periodos) ?></b>.</h2>
            <h3 class='text-center h5'>Año: <b><?= $periodo_activo['anio'] ?></b></h3>
            <?php
        }
        ?>
    </div>
    <div class='table-responsive col-12'>
        <table class='table table-striped table-bordered table-hover' id='tabla-periodos'>
            <thead>
            <th style='width: 30%'>Año</th>
            <th style="width: 15%">Estado</th>
            <th style="width: 55%">Estados Financieros</th>

            </thead>
            <tbody>
            <?php
            foreach ($lista_periodos as $key => $period) {

                ?>
                <tr>
                    <td><?= Utiles::fechaSinFormato(date($period['anio'] . '-01-01')) . ' <b>a</b> ' . Utiles::fechaSinFormato(date($period['anio'] . '-12-31')) ?>
                    </td>
                    <td><?php
                        if ($period['anio'] && $period['estado'] === 'ACTIVO') {
                            ?>
                            <span class="badge badge-success">Activo</span>
                            <?php
                        } else if ($period['estado'] === 'CERRADO') {
                            ?>
                            <span class="badge badge-danger">Cerrado</span>
                            <?php
                        } else {
                            ?>
                            <span class="badge badge-warning">Proceso de cierre</span>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($period['estado']==='CERRADO') {
                            ?>
                            <div class="col-12">
                                <div class="dropdown d-inline">
                                    <button class="btn btn-success dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <i class="fas fa-book"></i>
                                        Balance General
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" id="forma_cuenta"
                                           href="/cierre-contable/balance-forma-cuenta?periodo=<?= $period['id'] ?>&periodo_pasado=true">
                                            Forma de Cuenta
                                        </a>
                                        <a class="dropdown-item" id="forma_reporte"
                                           href="/cierre-contable/balance-forma-reporte?periodo=<?= $period['id'] ?>&periodo_pasado=true">
                                            Forma de Reporte
                                        </a>
                                    </div>
                                </div>

                                <a id="estado_resultados" class="btn btn-success"
                                   href="/cierre-contable/estado-resultados?periodo=<?= $period['id'] ?>&periodo_pasado=true">
                                    <i class="fas fa-book"></i>
                                    Estado
                                    de Resultados</a>
                            </div>
                            <?php
                        }else{
                            echo "<p>No hay estado financiero disponible. <em class='font-weight-bold' style='font-style: inherit'>[Periodo aun activo]</em></p>";
                        }
                        ?>
                    </td>

                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
