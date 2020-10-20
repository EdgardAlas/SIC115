<?php
    $datos = isset($data) ? $data : array();
?>

<label for="activo">Cuenta seleccionada</label>

<input type="text" class='form-control configuracion' readonly tabindex=-1 data-titulo='<?=$datos['titulo']?>'
    data-descripcion='<?=$datos['descripcion']?>' data-cuenta='<?=$datos['cuenta']?>'   
    value='<?=$datos['nombre_cuenta']?>' <?= isset($datos['obligatorio']) ? 'data-obligatorio=1' : ''?>>