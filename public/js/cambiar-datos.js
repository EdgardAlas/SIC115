function modificarUsuario(usuario) {
    $('#usuario').blur();
    $.post("/login/cambiar-usuario", {usuario}, function (data) {
        log(data);

        Swal.fire({
            title: 'Atención',
            text: data.mensaje,
            icon: data.icono,
            showCancelButton: false,
            confirmButtonColor: '#6777ef',
            confirmButtonText: 'Ok',
        }).then((result) => {
            if (!data.error) {
                location.reload()
            }
        })

    })
}

function validarUsuarioExiste(usuario) {
    const input_usuario = document.querySelector('#usuario')

    $.get(`/login/validar-usuario/${usuario}`, function (data) {
        console.log(data)
        if (data.error) {
            validarCampo('usuario', true)
            input_usuario.dataset.ok = 0
        } else {
            input_usuario.dataset.ok = 1
        }

        if (usuario.length === 0) {
            input_usuario.dataset.ok = 0
        }
    })


}

$(document).ready(() => {
    titulo('Usuario y Contraseña')
    focusCampo('usuario');
    $(document).on('submit', '#form_usuario', function (e) {
        e.preventDefault();
        const usuario = $("#usuario").val();
        if (usuario.length === 0 || usuario === '') {
            return;
        }

        if ($("#usuario").attr('data-ok') == 1) {
            modificarUsuario(usuario)
        }

        validarCampo('usuario', true)
        focusCampo('usuario')


    });

    $(document).on('keyup', '#usuario', function (e) {
        const usuario = $(this).val();

        validarCampo('usuario', false)
        validarUsuarioExiste(usuario)

        if (isEnter(e.keyCode, usuario, 0)) {

            if ($(this).attr('data-ok') == 1) {
                modificarUsuario(usuario)
            }
        }
    })

});