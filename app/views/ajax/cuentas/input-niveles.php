
<label for="nivel">Nivel</label>
<select class="form-control" id="nivel" name="nivel" >
    <?php
        $niveles = (isset($datosBD) ? $datosBD : array()) ;        
        foreach ($niveles as $key => $nivel) {
            ?>
            <option value="<?=$nivel['nivel']?>" <?= ($nivel['nivel']==3 ? 'selected' : '')?>><?=$nivel['nivel']?></option>
            <?php
        }
    ?>
</select>