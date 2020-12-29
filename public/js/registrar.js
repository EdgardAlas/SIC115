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

function validarCorreo(correo) {
    const input_correo = document.querySelector('#correo')

    $.get(`/login/validar-correo-registro/${correo}`, function (data) {
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

function validarUsuario(usuario) {
    const input_usuario = document.querySelector('#usuario')



    $.get(`/login/validar-usuario-registro/${usuario}`, function (data) {
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
        input_contrasena = document.querySelector('#contrasena'),
        input_contrasenav = document.querySelector('#contrasenav'),
        input_correo = document.querySelector('#correo')


    const datos = {
        correo: input_correo.value,
        nombre: input_nombre.value,
        usuario: input_usuario.value,
        contrasena: input_contrasena.value,
    }

    if (datos.nombre.length < 8 || input_nombre.dataset.ok == 0) {
        validarCampo('nombre', true)
        focusCampo('nombre')
        return
    }

    if (datos.usuario.length < 8 || input_usuario.dataset.ok == 0) {
        validarCampo('usuario', true)
        focusCampo('usuario')
        return
    }

    if (datos.correo.length === 0 || input_correo.dataset.ok == 0) {
        validarCampo('correo', true)
        focusCampo('correo')
        return
    }

    if (datos.contrasena.length < 8) {
        validarCampo('contrasena', true)
        focusCampo('contrasena')
        return
    }

    if (datos.contrasena !== input_contrasenav.value) {
        validarCampo('contrasenav', true)
        focusCampo('contrasenav')
        return
    }

    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de crear la cuenta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            guardar(datos)
        } else {
            focusCampo('empresa')
        }
    })



}

function guardar(datos) {
    $.post('/login/guardar', datos, function (data) {
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
    const contrasenav = document.querySelector('#contrasenav')
    const correo = document.querySelector('#correo')
    const form = document.querySelector('#form_registrar')
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

        validarUsuario(usuario.value)
    })

    correo.addEventListener('keyup', (e) => {

        validarCampo('correo', false)
        if (isEnter(e.keyCode, usuario.value, 0))
            focus('correo')


        validarCorreo(correo.value)
    })

    contrasena.addEventListener('keyup', (e) => {

        validarCampo('contrasena', false)
        if (isEnter(e.keyCode, contrasena.value, 8))
        focus('contrasenav')
    })

    contrasenav.addEventListener('keyup', (e) => {

        validarCampo('contrasenav', false)
        if (isEnter(e.keyCode, contrasenav.value, 8)){
                validarGuardar();
        }
    })

    // btn_registrar.addEventListener('click', (e) => {
    //     validarGuardar();
    // })

    form.addEventListener('submit', (e)=>{
        e.preventDefault();
        btn_registrar.blur()
        validarGuardar()
    })


});
