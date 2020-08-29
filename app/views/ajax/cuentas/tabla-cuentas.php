<table class="table table-striped table-bordered table-hover" id='tabla_cuentas'>
    <thead>
        <tr>
            <th style='width: 20%;'>Código</th>
            <th style='width: 30%'>Nombre</th>
            <th style='width: 20%'>Tipo de saldo</th>
            <th style='width: 10%'>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $cuentas = isset($datos) ? $datos : array();

            foreach ($cuentas as $key => $cuenta) {
                echo "
                    <tr>
                        <td>".$cuenta['codigo']."</td>
                        <td>".$cuenta['nombre']."</td>
                        <td>".$cuenta['tipo_saldo']."</td>
                        <td><button type='button' id ='btn_editar_cuenta' class='btn btn-warning' 
                        data-toggle='tooltip' data-placement='top'
                        title='' data-original-title='Editar' data-id = '".
                            base64_encode($cuenta['id'])
                        ."'>
                        <i class='fa fa-edit'></i>
                    </button></td>
                    </tr>
                ";
            }
        ?>
    </tbody>
</table>