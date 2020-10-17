function validarEmpresa(nombre) {
    $.get(`/login/validar-empresa/${nombre}`, function (data) {

        if (data.error) {
            validarCampo('nombre', true)
        }
    })
}

function validarUsuario(usuario) {
    $.get(`/login/validar-usuario/${usuario}`, function (data) {

        if (data.error) {
            validarCampo('usuario', true)
        }
    })
}

function validarGuardar() {
    const datos = {
        nombre: document.querySelector('#nombre').value,
        usuario: document.querySelector('#usuario').value,
        contrasena: document.querySelector('#contrasena').value

    }

    if (datos.nombre.length < 8) {
        validarCampo('nombre', true)

        return
    }

    if (datos.usuario.length < 8) {
        validarCampo('usuario', true)
        return
    }

    if (datos.contrasena.length < 8) {
        validarCampo('contrasena', true)

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
                confirmButtonText: 'Si',
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

        
        if (isEnter(e.keyCode, usuario.value, 8))
        validarGuardar();
    })

    btn_registrar.addEventListener('click', (e) => {
        validarGuardar();
    })
});