<?php
    $cuentas = isset($datosBD) ? $datosBD : array(); 
?>
<label for="cuenta">Cuenta</label>
<select class="form-control" id="cuenta" name="cuenta" >
    <option value='' >Seleccione</option>
    </option>
    <?php
    foreach ($cuentas as $key => $cuenta) {
        echo "<option value='" . base64_encode($cuenta['id'])."' data-saldo = '".$cuenta['tipo_saldo']."'
        data-codigo = '".$cuenta['codigo']."'>" . 
                $cuenta['codigo'] . " - " . $cuenta['nombre'] . "</option>";
    }
    ?>
</select>