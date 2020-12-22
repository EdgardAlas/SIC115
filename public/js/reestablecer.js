function validarDatos() {
    const correo = $('#correo').val(),
        nueva = $('#nueva').val(),
        confirmar = $('#confirmar').val();

    if(correo.length === 0){
        validarCampo('correo', true)
        focusCampo('correo')
        return false
    }

    if(nueva.length < 8){
        validarCampo('nueva', true)
        focusCampo('nueva')
        return false
    }

    if(confirmar.length < 8){
        validarCampo('confirmar', true)
        focusCampo('confirmar')
        return false
    }

    if(confirmar !== nueva){
        Swal.fire({
            title: 'Atención',
            text: 'Contraseña nueva no coincide',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#6777ef',
            confirmButtonText: 'Ok',
        }).then(() => {
            focusCampo('nueva')
            return false
        })
        return false
    }


    return true

}

$(document).ready(() => {
    $(document).on('submit', '#form_reestablecer', function (e) {
        e.preventDefault();
        $("#submit").blur();
        if(validarDatos()){
            console.log('procede')
        }
    });


    $(document).on('keyup', '#correo', function (e) {
        const contra = $(this).val();
        validarCampo('nueva', false)
        if (isEnter(e.keyCode, contra, 0)) {
            focusCampo('confirmar')
        }

        if (contra.length === 0) {
            validarCampo('nueva', true)
        }
    });

    $(document).on('keyup', '#nueva', function (e) {
        const contra = $(this).val();
        validarCampo('nueva', false)
        if (isEnter(e.keyCode, contra, 8)) {
            focusCampo('confirmar')
        }

        if (contra.length < 8) {
            validarCampo('nueva', true)
        }
    });

    $(document).on('keyup', '#confirmar', function (e) {
        const contra = $(this).val();
        validarCampo('confirmar', false)
        if (isEnter(e.keyCode, contra, 8)) {
            $('#form_reestablecer').submit();
        }

        if (contra.length < 8) {
            validarCampo('confirmar', true)
        }
        e.stopPropagation();
    });

});