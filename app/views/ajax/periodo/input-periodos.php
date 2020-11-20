<label for="nivel">Periodos</label>
<select class="form-control" id="periodo" name="periodo">
    <?php
    $periodos = (isset($periodos) ? $periodos : array());
    $periodo_actual = (isset($periodo_actual) ? $periodo_actual : array());

    foreach ($periodos as $key => $periodo) {
        ?>
        <option value="<?= base64_encode($periodo['id']) ?>"
                data-anio= <?= $periodo['anio'] ?> <?= ($periodo['id'] == $periodo_actual ? 'selected' : '') ?>>
            <?= $periodo['anio'] ?>
        </option>
        <?php
    }
    ?>
</select>
