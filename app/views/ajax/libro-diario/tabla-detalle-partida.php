<div class='row'>
    <div class="col-4">
        <p class='text-center font-weight-bold'>Cargo <span id='total_cargo'>$0.00</span></p>
    </div>
    <div class="col-4">
        <p class='text-center font-weight-bold'>Abono <span id='total_abono'>$0.00</span></p>
    </div>
    <div class="col-4">
        <p class='text-center font-weight-bold text-danger'>Dif. <span id='dif'>$0.00</span></p>
    </div>
</div>
<table class="table table-bordered table-hover" id='tabla_detalle_partida' style='font-size: 0.725rem;'>
    <thead>
        <tr>
            <th style='width: 25%;'>Código</th>
            <th style='width: 35%'>Cargo</th>
            <th style='width: 35%'>Abono</th>
            <th style='width: 10%'>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $detalles = isset($datos) ? $datos : array();
        
            $total_cargo = 0;
            $total_abono = 0;


            foreach ($detalles as $key => $detalle) {
        ?>
        <tr>
            <td><?= $detalle['codigo']?></td>
            <td class='text-right'><?= ($detalle['movimiento']==='Cargo') ? $detalle['monto'] : '-' ?></td>
            <td class='text-right'><?= ($detalle['movimiento']==='Abono') ? $detalle['monto'] : '-' ?></td>
            <td>
                <button type='button' id='btn_editar_cuenta' class='btn btn-warning btn-sm' data-toggle='tooltip'
                    data-placement='top' data-original-title='Editar' data-index='<?= $key?>'>
                    <i class='fa fa-edit'></i>
                </button>
                <button type='button' id='btn_eliminar' class='btn btn-danger btn-sm' data-toggle='tooltip'
                    data-placement='top' data-original-title='Eliminar' data-index='<?= $key?>'>
                    <i class='fa fa-trash'></i>
                </button>
            </td>
        </tr>
        <?php

                $total_cargo += ($detalle['movimiento']==='Cargo') ? ($detalle['monto_plano']) : 0;
                $total_abono += ($detalle['movimiento']==='Abono') ? ($detalle['monto_plano']) : 0;
        }
        ?>
    </tbody>
</table>

<input type="hidden" id='cargo' value='<?= Utiles::monto($total_cargo)?>'>
<input type="hidden" id='abono' value='<?= Utiles::monto($total_abono)?>'>
<input type="hidden" id='diferencia' value='<?= Utiles::monto(abs($total_abono-$total_cargo))?>'>
<input type="hidden" id='validar_diferencia' value='<?= abs($total_abono-$total_cargo)?>'>