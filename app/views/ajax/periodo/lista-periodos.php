<?php
    $periodo_activo = ($periodo) ? $periodo : null;
    $lista_periodos = ($periodos) ? $periodos : array();
?>

<div class="row">
    <div class="form-group col-12">
        <?php

    

            if($periodo_activo['periodo']===null || $periodo_activo['estado']==='CERRADO'){
                ?>
        <button type="button" id='btn_iniciar_periodo' class="btn btn-primary">
            Iniciar nuevo periodo
        </button>
        <?php
            }else{
                ?>
        <h2 class='text-center h5'>Periodo activo número <b><?= sizeof($lista_periodos)?></b>.</h2>
        <h3 class='text-center h5'>Año: <b><?=date('Y')?></b></h3>
        <?php
            }
        ?>
    </div>
    <div class='table-responsive col-12'>
        <table class='table table-striped table-bordered table-hover' id='tabla-periodos'>
            <thead>
                <th style='width: 70%'>Año</th>
                <th>Estado</th>
            </thead>
            <tbody>
                <?php
                    foreach ($lista_periodos as $key => $period) {
                        
                        ?>
                <tr>
                    <td><?= Utiles::fecha(date($period['anio'].'-01-01')).' <b>a</b> '.Utiles::fecha(date($period['anio'].'-12-31'))?>
                    </td>
                    <td><?php
                                if($period['anio'] && $period['estado']==='ACTIVO'){
                                    ?>
                        <div class="badge badge-success">Activo</div>
                        <?php
                                }else if($period['estado']==='CERRADO'){
                                    ?>
                        <div class="badge badge-danger">Cerrado</div>
                        <?php
                                }else{
                                    ?>
                        <div class="badge badge-warning">Proceso de cierre</div>
                        <?php       
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
