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
        
            foreach ($detalles as $key => $detalle) {
        ?>
        <tr>
            <td><?= $detalle['codigo']?></td>
            <td class='text-right'><?= ($detalle['movimiento']==='Cargo') ? $detalle['monto'] : '-' ?></td>
            <td class='text-right'><?= ($detalle['movimiento']==='Abono') ? $detalle['monto'] : '-' ?></td>
            <td>
                <button type='button' id='btn_editar_cuenta' class='btn btn-warning btn-sm' data-toggle='tooltip'
                    data-placement='top' data-original-title='Editar' data-index = '<?= $key?>'>
                    <i class='fa fa-edit'></i>
                </button>
                <button type='button' id='btn_eliminar' class='btn btn-danger btn-sm' data-toggle='tooltip'
                    data-placement='top' data-original-title='Eliminar' data-index = '<?= $key?>'>
                    <i class='fa fa-trash'></i>
                </button>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>