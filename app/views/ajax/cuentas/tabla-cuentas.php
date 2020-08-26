<table class="display table table-striped table-hover table-sm" id='tabla_cuentas'>
    <thead>
        <tr>
            <th style='width: 20%;'>Código</th>
            <th style='width: 30%'>Nombre</th>
            <th style='width: 20%'>Saldo</th>
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
                        <td><button type='button' class='btn btn-link btn-primary btn-lg' 
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