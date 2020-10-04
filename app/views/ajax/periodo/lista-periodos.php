<?php
    $periodo_activo = ($periodo) ? $periodo : null;
    $lista_periodos = ($periodos) ? $periodos : array();
?>

<div class="row">
    <div class="col-12">
        <?php
            if($periodo_activo===null){
                ?>
                <button type="button" id='btn_agregaR_periodo' class="btn btn-primary">
                    Activar Periodo
                </button>
                <?php
            }else{
                ?>
                <p class='text-center'>Periodo activo número <b><?= sizeof($lista_periodos)?></b>.</p>
                <p class='text-center'>Año: <b><?=date('Y')?></b></p>
                <?php
            }
        ?>
    </div>
    <div class='table-responsive col-12'>
        <table class='table table-striped table-bordered table-hover' id='tabla-periodos'>
            <thead>
                <th>Año</th>
                <th>Estado</th>
            </thead>
            <tbody>
                <?php
                    foreach ($lista_periodos as $key => $period) {
                        
                        ?>
                        <tr>
                            <td><?= $period['anio']?></td>
                            <td><?php
                                if($period['anio']){
                                    ?>
                                    <div class="badge badge-success">Activo</div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="badge badge-danger">Inactivo</div>
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