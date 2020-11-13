function cargarTablaCuentas(carga = false) {
    if(carga){
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }
    $('#div_tabla_cuentas').load('/cuenta/tabla-cuentas', (data) => {
        tablaPaginacionTodos('tabla_cuentas');
        $('[data-toggle="tooltip"]').tooltip();
        if(carga){
            Swal.close();
        }
    });
}


function encontrarR(valor) {
    for (let i = 0; i < valor.length; i++) {
        if (valor[i] == "R" || valor[i] == "r") {
            return true;
        }
    }
    return false;
}

function buscarCuentaPadre() {
    let codigo = $("#codigo").val();
    $("#validar_padre").load("/cuenta/obtener-datos-cuenta-padre", {
        codigo
    });
}

function focusOnEnter(tecla, valor_input, minimo_text_input, id_foco) {
    if (tecla == 13 && valor_input.length > minimo_text_input) {
        focus(id_foco);
    }
}

function cargarModalGuardar() {
    $('#modal-content-body').load('/cuenta/modal-guardar');
}

function cargarModalEditar(id) {
    $('#modal-content-body').load(`/cuenta/modal-editar/${id}`);
}

function limpiarCampos() {
    $('#modal-content-body').load('/cuenta/modal-guardar', function() {
        focus('codigo');
    });
}

function validarCuentaGuardar() {

    //objeto de cuenta
    let cuenta = {
        codigo: $('#codigo').val(),
        nombre: $('#nombre').val(),
        padre: $('#padre').data('padre'),
        tipo_saldo: $('#tipo_saldo').val()
    }
    log(cuenta);
    // casos de error
    if (cuenta.codigo.length === 0 || cuenta.padre === btoa(-1)) {
        validarCampo('codigo', true);
        focus('codigo');
        return false;
    }

    if (cuenta.nombre.length === 0) {
        validarCampo('nombre', true);
        focus('nombre');
        return false;
    }

    //confirmar guardar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de guardar esta cuenta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            guardarCuenta(cuenta);
        } else {
            focus('codigo');
        }
    })
}

function validarCuentaEditar() {

    //objeto de cuenta
    let cuenta = {
        id: $('#btn_editar').data('cuenta'),
        nombre: $('#nombre').val(),
        tipo_saldo: $('#tipo_saldo').val()
    }
    log(cuenta);
    // casos de error
    if (cuenta.nombre.length === 0) {
        validarCampo('nombre', true);
        focus('nombre');
        return false;
    }

    //confirmar guardar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de editar esta cuenta?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            editarCuenta(cuenta);
        } else {
            focus('nombre');
        }
    })
}

function guardarCuenta(cuenta) {
    $.post('/cuenta/guardar', { cuenta }, function(data) {
        log(data);
        if (!data.error) {
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                limpiarCampos();
                cargarTablaCuentas();
            })
        }else{
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                focus('codigo')
            })
        }
    });
}

function editarCuenta(cuenta) {
    $.post('/cuenta/editar', { cuenta }, function(data) {
        console.log(data)
        if (!data.error) {
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_cuenta').modal('hide');
                cargarTablaCuentas();
            })
        } else {
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_cuenta').modal('hide');
            })
        }
    });
}

function submitFormularioEspecico() {
    let formulario = $("#nombre").closest('form');
    let id = formulario.attr('id'),
        accion = formulario.data('accion');


    if (accion === 'guardar') {
        validarCuentaGuardar();
    } else {
        validarCuentaEditar();
    }
}

/* Inicio */
$(document).ready((event) => {

    titulo('Cuentas');

    /*
     * Eventos
     */

    $('#btn_acciones_cuenta').focus();

    cargarTablaCuentas(true);

    $(document).on('click', '#btn_imprimir', function() {
        $("#btn_imprimir").blur();
        $('#btn_acciones_cuenta').focus();

    });

    //abrir modal guardar
    $('#btn_acciones_cuenta').on('click', function() {
        cargarModalGuardar();
        $('#modal_acciones_cuenta').modal('show');
    })

    //focus codigo al abrir el modal
    $('#modal_acciones_cuenta').on('shown.bs.modal', function() {
        let campo = $('#codigo');
        if (campo.is(':enabled'))
            focus('codigo');
        else
            focus('nombre');
    })

    $(document).on('click', '#btn_editar_cuenta', function() {
        let id = $(this).data('id');
        cargarModalEditar(id);
        $('#modal_acciones_cuenta').modal('show');
    })

    $(document).on("keydown", "#codigo", function(event) {

        if (!(
                event.keyCode == 8 || // backspace
                event.keyCode == 9 || // tab
                event.keyCode == 46 || // delete
                event.keyCode == 13 || //enter
                event.keyCode == 18 || //alt
                event.keyCode == 114 || // R
                event.keyCode == 82 || // r
                event.keyCode == 116 || // f5
                event.keyCode == 16 || // shift
                event.keyCode == 36 || // inicio
                event.keyCode == 123 || // f12, remover en la version final
                (event.keyCode >= 48 && event.keyCode <= 57) || // numeros del teclado
                (event.keyCode >= 96 && event.keyCode <= 105)
            ) // numeros del teclado numerico
        ) {
            event.preventDefault(); //previene que se coloque lo que se escribe
        }
        if (!(
                event.keyCode == 8 ||
                event.keyCode == 46 || // delete
                event.keyCode == 13
            )) {
            if (encontrarR($("#codigo").val())) event.preventDefault();
        }

    });


    $(document).on("keyup", "#codigo", function(e) {
        validarCampo('codigo', false);
        focusOnEnter(
            e.keyCode,
            $(this).val(),
            0,
            'nombre'
        );
        buscarCuentaPadre();
    });

    $(document).on("keyup", "#nombre", function(e) {
        validarCampo('nombre', false);
        if (isEnter(e.keyCode, $(this).val(), 0)) {
            submitFormularioEspecico();
        }
    });

    $(document).on("click", "#btn_guardar", function(e) {
        $('#btn_guardar').blur();
        submitFormularioEspecico();

    });

    $(document).on("click", "#btn_editar", function(e) {
        $('#btn_editar').blur();
        submitFormularioEspecico();
    });

    /*
     * Combinacione de teclas
     */

    shortcut.add("Alt+G", function() {

        submitFormularioEspecico();
    });

    //usar la tecle f8 para cambiar entre el saldo de la cuenta
    shortcut.add("ALT+S", function() {
        var saldo = $("#tipo_saldo").val();
        if (saldo == "Deudor") {
            $("#tipo_saldo").val("Acreedor");
        } else {
            $("#tipo_saldo").val("Deudor");
        }
    }, {
        type: "keydown",
        propagate: true,
        target: document,
    });

    shortcut.add("Alt+N", function() {
        let modal_activo = $('#modal_acciones_cuenta').is(':visible');
        log(modal_activo);
        if (modal_activo)
            focus('nombre');

    });

    shortcut.add("Alt+C", function() {
        let formulario = $("#nombre").closest('form');
        let accion = formulario.data('accion');
        let modal_activo = $('#modal_acciones_cuenta').is(':visible');
        log(modal_activo);
        if (modal_activo)
            if (accion === 'guardar') {
                focus('codigo');
            }

    });
});