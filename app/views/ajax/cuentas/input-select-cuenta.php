<?php
    $cuentas = isset($datosBD) ? $datosBD : array(); 
?>
<label for="cuenta">Cuenta</label>
<select class="form-control" id="cuenta" name="cuenta" >
    <option value='' >Seleccione</option>
    </option>
    <?php
    foreach ($cuentas as $key => $cuenta) {
        echo "<option value='" . base64_encode($cuenta['codigo'])."' data-saldo = '".$cuenta['saldo']."'>" . 
                $cuenta['codigo'] . " - " . $cuenta['nombre'] . "</option>";
    }
    ?>
</select>