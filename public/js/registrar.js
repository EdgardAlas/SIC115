function validarEmpresa(nombre) {
    const input_empresa = document.querySelector('#nombre')

    $.get(`/login/validar-empresa/${nombre}`, function (data) {

        if (data.error) {
            validarCampo('nombre', true)
            input_empresa.dataset.ok = 0
        } else {
            input_empresa.dataset.ok = 1
        }

        if (nombre.length === 0) {
            input_empresa.dataset.ok = 0
        }
    })


}

function validarUsuario(usuario) {
    const input_usuario = document.querySelector('#usuario')



    $.get(`/login/validar-usuario/${usuario}`, function (data) {

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

function validarGuardar() {
    const input_nombre = document.querySelector('#nombre'),
        input_usuario = document.querySelector('#usuario'),
        input_contrasena = document.querySelector('#contrasena')
    const datos = {
        nombre: input_nombre.value,
        usuario: input_usuario.value,
        contrasena: input_contrasena.value

    }

    if (datos.nombre.length < 8 || input_nombre.dataset.ok == 0) {
        validarCampo('nombre', true)
        focus('nombre')
        return
    }

    if (datos.usuario.length < 8 || input_usuario.dataset.ok == 0) {
        validarCampo('usuario', true)
        focus('usuario')
        return
    }

    if (datos.contrasena.length < 8) {
        validarCampo('contrasena', true)
        focus('contrasena')
        return
    }




    guardar(datos)

}

function guardar(datos) {
    $.post('/login/guardar', datos, function (data) {
        log(data);
        if (!data.error) {
            Swal.fire({
                title: 'Atención',
                text: data.mensaje,
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#6777ef',
                confirmButtonText: 'Ok',
            }).then((result) => {
                location.href = data.redireccion
            })
        }
    })
}

document.addEventListener("DOMContentLoaded", function (event) {

    const nombre = document.querySelector('#nombre')
    const usuario = document.querySelector('#usuario')
    const contrasena = document.querySelector('#contrasena')
    const btn_registrar = document.querySelector('#registrar')


    nombre.addEventListener('keyup', (e) => {

        validarCampo('nombre', false)
        if (isEnter(e.keyCode, nombre.value, 0))
            focus('usuario')


        nombre.value
        validarEmpresa(nombre.value)
    })

    usuario.addEventListener('keyup', (e) => {

        validarCampo('usuario', false)
        if (isEnter(e.keyCode, usuario.value, 0))
            focus('contrasena')


        usuario.value
        validarUsuario(usuario.value)
    })

    contrasena.addEventListener('keyup', (e) => {

        validarCampo('contrasena', false)
        if (isEnter(e.keyCode, contrasena.value, 8))
            validarGuardar();
    })

    btn_registrar.addEventListener('click', (e) => {
        validarGuardar();
    })
});