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

function modificarCorreo(correo) {
    $('#correo').blur();
    $.post("/login/cambiar-correo", {correo}, function (data) {
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

function validarCorreoExiste(correo) {
    const input_correo = document.querySelector('#correo')

    $.get(`/login/validar-correo/${correo}`, function (data) {
        console.log(data)
        if (data.error) {
            validarCampo('correo', true)
            input_correo.dataset.ok = 0
        } else {
            input_correo.dataset.ok = 1
        }

        if (correo.length === 0) {
            input_correo.dataset.ok = 0
        }
    })
}

function validarContrena() {
    const antigua = $('#antigua').val(),
        nueva = $('#nueva').val(),
        validar_contrasena = $('#validar_nueva').val();

    if (antigua.length < 8) {
        validarCampo('antigua', true)
        focusCampo('antigua')
        return false;
    }

    if (nueva.length < 8) {
        validarCampo('nueva', true)
        focusCampo('nueva')
        return false;
    }

    if (validar_contrasena.length < 8) {
        validarCampo('validar_nueva', true)
        focusCampo('validar_nueva')
        return false;
    }

    if (validar_contrasena !== nueva) {
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


    return true;

}

function modificarContrasena() {
    const antigua = $('#antigua').val(),
        nueva = $('#nueva').val(),
        validar_contrasena = $('#validar_nueva').val();
    $.post("/login/cambiar-contrasena", {antigua, nueva, validar_contrasena}, function (data) {
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

            if (data.error) {
                focusCampo(data.campo)
            }

        })
    })


}

$(document).ready(() => {
    titulo('Usuario y Contraseña')
    focusCampo('correo');
    $(document).on('submit', '#form_usuario', function (e) {
        e.preventDefault();
        $('#usuario').blur();
        $('#submit_usuario').blur();
        const usuario = $("#usuario").val();
        if (usuario.length === 0 || usuario === '' || usuario.length < 8) {
            validarCampo('usuario', true)
            focusCampo('usuario')
            return;
        }

        if ($("#usuario").attr('data-ok') == 1) {
            Swal.fire({
                title: 'Atención',
                text: "¿Esta seguro de modificar el usuario?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    modificarUsuario(usuario)
                } else {
                    focus('usuario');
                }
            })

            return
        }

        validarCampo('usuario', true)
        focusCampo('usuario')


    });

    $(document).on('submit', '#form_correo', function (e) {
        e.preventDefault();
        $('#correo').blur();
        $('#submit_correo').blur();
        const correo = $("#correo").val();
        if (correo.length === 0 || correo === '') {
            validarCampo('correo', true)
            focusCampo('correo')
            return;
        }

        if ($("#correo").attr('data-ok') == 1) {

            Swal.fire({
                title: 'Atención',
                text: "¿Esta seguro de modificar el correo electronico?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    modificarCorreo(correo)
                } else {
                    focus('correo');
                }
            })


            return
        }

        validarCampo('correo', true)
        focusCampo('correo')


    });

    $(document).on('submit', '#form_contasena', function (e) {
        e.preventDefault();
        $('#submit_contra').blur();
        if (validarContrena()) {
            Swal.fire({
                title: 'Atención',
                text: "¿Esta seguro de modificar la contraseña?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    modificarContrasena();
                } else {
                    focus('antigua');
                }
            })
        }
    });

    $(document).on('keyup', '#usuario', function (e) {
        const usuario = $(this).val();

        validarCampo('usuario', false)
        validarUsuarioExiste(usuario)
        if (isEnter(e.keyCode, usuario, 8)) {
            $('#usuario').blur();
            $('#form_usuario').submit();
        }


    })

    $(document).on('keyup', '#correo', function (e) {
        const correo = $(this).val();

        validarCampo('correo', false)
        validarCorreoExiste(correo)
        if (isEnter(e.keyCode, correo, 8)) {
            $('#correo').blur();
            $('#form_correo').submit();
        }


    })

    $(document).on('keyup', '#antigua', function (e) {
        const contrasena_antigua = $(this).val();
        validarCampo('antigua', false)
        if (isEnter(e.keyCode, contrasena_antigua, 8)) {
            focusCampo('nueva')
        }

        if (contrasena_antigua.length < 8) {
            validarCampo('antigua', true)
        }

    })

    $(document).on('keyup', '#nueva', function (e) {
        const contrasena_nueva = $(this).val();
        validarCampo('nueva', false)
        if (isEnter(e.keyCode, contrasena_nueva, 8)) {
            focusCampo('validar_nueva')

        }

        if (contrasena_nueva.length < 8) {
            validarCampo('nueva', true)
        }
    })

    $(document).on('keyup', '#validar_nueva', function (e) {
        const validar_contrasena = $(this).val();
        validarCampo('validar_nueva', false)
        if (isEnter(e.keyCode, validar_contrasena, 8)) {
            $('#form_contasena').submit();
        }
        if (validar_contrasena.length < 8) {
            validarCampo('validar_nueva', true)
        }
    })

    shortcut.add("Alt+U", function () {
        focusCampo('usuario')

    });

    shortcut.add("Alt+C", function () {
        focusCampo('antigua')

    });

});