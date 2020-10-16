<?php
    $datos = isset($datosBD) ? $datosBD : null;
?>

<label for="padre">Cuenta padre</label>
<input type="text" name="padre" id="padre" data-padre=
    <?= ($datos!==null) ? 
            (!empty($datos) ? ($datos[0]['id'] > -1) 
                ? base64_encode($datos[0]['id']) 
                    : base64_encode(-1)
                        : base64_encode(-1) ) 
            : base64_encode(-1) ?> 
        class="form-control" readonly 
    value='<?= ($datos!==null) 
    ? (!empty($datos) 
        ? $datos[0]['nombre'] 
            : '' ) 
    : '' ?>'>