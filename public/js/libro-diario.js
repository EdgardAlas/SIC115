let partida = {
        datos_partida: {
            fecha: undefined,
            descripcion: undefined
        },
        detalle_partida: []
    },
    tabla_detalle = [];

const monto = new Cleave('#monto', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand',
    numeralPositiveOnly: true,
    numeralDecimalMark: '.',
    delimiter: ',',
    prefix: '$'
});


function cargarInputSelectCuentas() {
    $('#contenedor_cuentas').load('/cuenta/input-seleccionar-cuenta', function () {
        select('cuenta');
    });
}

function obtenerMonto() {
    let montoInput = $('#monto').val();
    return montoInput = (montoInput.substr(1).replace(/,/g, '')).replace(/\.$/, "");
}

function obtenerNumeroPartida() {
    let montoInput = $('#numero_partida').val();
    return montoInput = (montoInput.substr(0).replace(/,/g, '')).replace(/\.$/, "");
}

function generarDetalle() {

    let saldo = $("#contenedor_cuentas option:selected").data('saldo'),
        codigo = $("#contenedor_cuentas option:selected").data('codigo');
    /* fecha = $('#fecha').val(),
        descripcion = $('#descripcion').val() */

    let detalle = {
        cuenta: $('#cuenta').val(),
        codigo,
        movimiento: $('#movimiento').val(),
        monto: calcularMonto(obtenerMonto(), saldo, $('#movimiento').val(), (codigo))
    };

    let mostrar = {
        codigo,
        movimiento: $('#movimiento').val(),
        monto: $('#monto').val().replace(/\.$/, ""),
        monto_plano: Math.abs(calcularMonto(obtenerMonto(), saldo, $('#movimiento').val(), (codigo)))
    };


    /*
     * Validaciones
     */

    if (detalle.cuenta.length === 0) {
        $("#cuenta").select2('focus');
        return;
    }

    if (detalle.monto.length === 0 || detalle.monto === 0 || detalle.monto.length === '' || detalle.monto == '0') {
        validarCampo('monto', 1);
        focus('monto');
        return;
    }


    /* partida.datos_partida.fecha = fecha;
    partida.datos_partida.descripcion = descripcion; */


    partida.detalle_partida.push(detalle);
    tabla_detalle.push(mostrar);

    ordenarCargosAbonos();
    ordenarDetallePartida();

    limpiarAgregarDetalle();
    tablaDetallePartida();
}

function generarDetalleEditado(indice) {

    let saldo = $("#contenedor_cuentas option:selected").data('saldo'),
        codigo = $("#contenedor_cuentas option:selected").data('codigo');
    /* fecha = $('#fecha').val(),
        descripcion = $('#descripcion').val() */

    let detalle = {
        cuenta: $('#cuenta').val(),
        codigo,
        movimiento: $('#movimiento').val(),
        monto: calcularMonto(obtenerMonto(), saldo, $('#movimiento').val(), (codigo))
    };

    let mostrar = {
        codigo,
        movimiento: $('#movimiento').val(),
        monto: $('#monto').val().replace(/\.$/, ""),
        monto_plano: Math.abs(calcularMonto(obtenerMonto(), saldo, $('#movimiento').val(), (codigo)))
    };


    /*
     * Validaciones
     */

    if (detalle.cuenta.length === 0) {
        $("#cuenta").select2('focus');
        return;
    }

    if (detalle.monto.length === 0 || detalle.monto === 0 || detalle.monto.length === '' || detalle.monto == '0') {
        validarCampo('monto', 1);
        focus('monto');
        return;
    }


    /* partida.datos_partida.fecha = fecha;
    partida.datos_partida.descripcion = descripcion; */


    partida.detalle_partida[indice] = (detalle);
    tabla_detalle[indice] = (mostrar);

    ordenarCargosAbonos();
    ordenarDetallePartida();

    limpiarAgregarDetalle();
    limpiarEditarDetalle();
    tablaDetallePartida();
}

function tablaDetallePartida() {
    $('#contender_tabla_detalle').load('/libro-diario/tabla-detalle', {
        tabla_detalle
    }, function (data) {
        tablaSinPaginacion('tabla_detalle_partida');
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
        imprimirTotales();
    });
}

function imprimirTotales() {
    $('#total_cargo').text($('#cargo').val());
    $('#total_abono').text($('#abono').val());
    $('#dif').text($('#diferencia').val());
}

function calcularMonto(monto, saldo, movimiento, codigo) {
    let saldocuenta = monto;
    if ((saldo === 'Deudor' && codigo[codigo.length - 1] == 'R' && movimiento === 'Cargo') ||
        (saldo === 'Acreedor' && codigo[codigo.length - 1] == 'R' && movimiento === 'Abono') ||
        (saldo === 'Deudor' && codigo[codigo.length - 1] != 'R' && movimiento === 'Abono') ||
        (saldo === 'Acreedor' && codigo[codigo.length - 1] != 'R' && movimiento === 'Cargo')) {
        saldocuenta = -saldocuenta;
    }
    return saldocuenta;
}

function ordenarDetallePartida() {
    partida.detalle_partida.sort(function (a, b) {
        if (a.movimiento > b.movimiento) {
            return -1;
        }
        if (a.movimiento < b.movimiento) {
            return 1;
        }

        return 0;
    });
}

function ordenarCargosAbonos() {
    tabla_detalle.sort(function (a, b) {
        if (a.movimiento > b.movimiento) {
            return -1;
        }
        if (a.movimiento < b.movimiento) {
            return 1;
        }

        return 0;
    });
}

function limpiarAgregarDetalle() {
    $("#cuenta").select2('focus');
    $('#cuenta').val('').trigger('change');
    $('#movimiento').val('Cargo');
    monto.setRawValue();
}

function limpiarEditarDetalle() {
    $('#btn_agregar').html("<i class=\"fas fa-plus-square\"></i> Agregar");
    $('#btn_agregar').attr('data-indice', -1);
    $('#btn_agregar').attr('data-accion', 'agregar');
}

function camposEditar(index) {

    let editar = partida.detalle_partida[index];

    $('#cuenta').val(editar.cuenta).trigger('change');
    $('#movimiento').val(editar.movimiento);
    monto.setRawValue(Math.abs(editar.monto));
    $('#btn_agregar').html("<i class=\"fas fa-edit\"></i> Editar");

    $('#btn_agregar').attr('data-indice', index);
    $('#btn_agregar').attr('data-accion', 'editar');

    focus('monto');
    validarCampo('monto', false);
}

function eliminar(indice) {
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de eliminar este detalle?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            partida.detalle_partida.splice(indice, 1);
            tabla_detalle.splice(indice, 1);

            limpiarAgregarDetalle();
            limpiarEditarDetalle();
            tablaDetallePartida();
        }
    })
}

function validarGuardarPartida() {
    let diferencia = parseFloat($('#validar_diferencia').val());

    if (diferencia > 0) {
        Swal.fire({
            title: 'Atención',
            text: "El cargo y el abono no coinciden",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#6777ef',
            confirmButtonText: 'Ok',

        }).then((result) => {
            $('#cuenta').select2('focus');
        })
        return;
    }

    const fecha = $('#fecha').val(),
        descripcion = $('#descripcion').val();

    if(fecha.length === 0 || fecha === ''){
        validarCampo('fecha', true);
        focusCampo('fecha');
        return;
    }

    if (descripcion.length === 0) {
        validarCampo('descripcion', true);
        focusCampo('descripcion');
        return;
    }

    partida.datos_partida.fecha = fecha;
    partida.datos_partida.descripcion = descripcion;

    if (partida.detalle_partida.length === 0) {
        Swal.fire({
            title: 'Atención',
            text: "No hay movimientos",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#6777ef',
            confirmButtonText: 'Ok',

        }).then((result) => {
            $('#cuenta').select2('focus');
        })
        return;
    }


    guardarPartida();

}

function guardarPartida() {

    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de guardar esta partida?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {


        if (result.value) {
            Swal.fire({
                title: 'Guardando...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })
            $.post('/libro-diario/guardar', {
                partida
            }, function (data) {
                Swal.close();
                if (data.error) {
                    Swal.fire({
                        title: 'Atención',
                        text: data.mensaje,
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#6777ef',
                        confirmButtonText: 'Ok',

                    }).then((result) => {
                        focus('descripcion');
                    })
                } else {
                    Swal.fire({
                        title: 'Atención',
                        text: data.mensaje,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#6777ef',
                        confirmButtonText: 'Ok',

                    }).then((result) => {
                        limpiarPartida();
                        tablaLibroDiario();
                    })
                }
            });
        } else {
            focus('descripcion');
        }
    })
}

function limpiarPartida() {
    $('#cuenta').val('').trigger('change');
    $('#movimiento').val('Cargo');
    $('#descripcion').val('');
    monto.setRawValue();
    validarCampo('monto', false);
    validarCampo('descripcion', false);
    partida = {
        datos_partida: {
            fecha: undefined,
            descripcion: undefined
        },
        detalle_partida: []
    };
    tabla_detalle = [];
    limpiarEditarDetalle();
    tablaDetallePartida();
    focus('descripcion');

}

function tablaLibroDiario(carga = false) {
    if (carga) {
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }
    $('#contendor_partidas').load('/libro-diario/tabla-libro-diario', function () {
        if (carga) {
            Swal.close();
        }
    });
}

function tablaLibroDiarioFechas(carga = false) {
    if (carga) {
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }

//    cambiarFechas($('#periodo').find(':selected').attr('data-anio'));

    let fecha_inicial = $('#fecha_inicial').val(),
        fecha_final = $('#fecha_final').val(),
        numero = $('#numero_partida').val().split(','),
        periodo = $('#periodo').val();

    numero = [...new Set(numero)];

    $('#contendor_partidas').load('/libro-diario/tabla-libro-diario', {
        fecha_inicial,
        fecha_final,
        numero,
        periodo
    }, function () {
        if (carga) {
            Swal.close();
        }
    });

    reporteLibroDiario();
}


function cambiarFechas(anio) {
    let fecha = new Date();
    $('#fecha_inicial').val(`${anio}-01-01`);
    const dia = fecha.getDate();
    $('#fecha_final').val(`${anio}-${fecha.getMonth() + 1}-${dia<10 ? '0' : ''}${dia}`);
}


function reporteLibroDiario() {
    /* Swal.fire({
        title: 'Actualizando...',
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    }) */

    let fecha_inicial = $('#fecha_inicial').val(),
        fecha_final = $('#fecha_final').val(),
        numero = $('#numero_partida').val().split(','),
        periodo = $('#periodo').val();

    numero = [...new Set(numero)];

    $('#btn_imprimir').attr('href', `/libro-diario/reporte-libro-diario?fecha_inicial=${fecha_inicial}&fecha_final=${fecha_final}&numero=${numero}&periodo=${periodo}`);

}

function cargarPeriodos() {
    $('#list_periodos').load('/periodo/input-periodos', function (data) {
        tablaLibroDiarioFechas(true);
    });
}

$(document).ready(() => {

    titulo('Libro Diario');

    cargarInputSelectCuentas();

    tablaSinPaginacion('tabla_detalle_partida');

    cargarPeriodos();

    /* Eventos */

    $(document).on('click', '#btn_partida', function () {
        $('#modal_partida').modal('show');
    });


    $("#modal_partida").on("shown.bs.modal", function (e) {
        focusCampo("descripcion");
    });

    $('#modal_partida').on('hidden.bs.modal', function () {
        limpiarPartida();
    })

    $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    });

    $(document).on('select2:closing', 'select.select2', function (e) {
        $(e.target).data("select2").$selection.one('focus focusin', function (e) {
            e.stopPropagation();
        });
    });

    $(document).on('keyup', '#descripcion', function (e) {

        let descripcion = $(this).val();

        if (isEnter(e.keyCode, descripcion, 0)) {

            $('#cuenta').select2('focus');
            return;
        }

        if (descripcion.length === 0) {

            validarCampo('descripcion', true);
            return;
        }

        validarCampo('descripcion', false);
    });

    $(document).on('click', '#btn_agregar', function () {
        $('#btn_agregar').blur();
        let accion = $(this).attr('data-accion');

        if (accion === 'agregar') {
            generarDetalle();
        } else {
            let index = $(this).attr('data-indice');

            generarDetalleEditado(index);
        }

    });

    $(document).on('click', '#btn_editar_cuenta', function () {
        let index = $(this).data('index');
        $('#btn_editar_cuenta').blur();
        camposEditar(index);
    });

    $(document).on('click', '#btn_eliminar', function () {
        let index = $(this).data('index');
        $('#btn_eliminar').blur();
        eliminar(index);
    });

    $(document).on('click', '[rel="tooltip"]', function () {
        $(this).tooltip('hide')
    });

    $(document).on('keyup', '#monto', function (e) {

        let monto = $(this).val();

        if (isEnter(e.keyCode, monto, 1)) {

            let accion = $('#btn_agregar').attr('data-accion');

            if (accion === 'agregar') {
                generarDetalle();
            } else {
                let index = $('#btn_agregar').attr('data-indice');

                generarDetalleEditado(index);
            }

            return;
        }

        if (monto.length === 1) {

            validarCampo('monto', true);
            return;
        }

        validarCampo('monto', false);
    });

    $(document).on('click', '#btn_guardar_partida', function () {
        $('#btn_guardar_partida').blur();
        validarGuardarPartida();
    });


    /* $(document).on('click', '#btn_actualizar_diario', function() {
        $('#btn_actualizar_diario').blur();

        tablaLibroDiarioFechas();
    }); */


    $(document).on('keyup', '#numero_partida', function () {
        tablaLibroDiarioFechas();
    });

    $(document).on('change', '#fecha_inicial', function () {
        tablaLibroDiarioFechas();
    });

    $(document).on('change', '#fecha', function () {
        validarCampo('fecha', false)
        if($(this).val()===''){
            validarCampo('fecha', true)
        }
    });

    $(document).on('change', '#fecha_final', function () {
        tablaLibroDiarioFechas();
    });

    $(document).on('change', '#periodo', function () {
        cambiarFechas($('#periodo').find(':selected').attr('data-anio'));
        tablaLibroDiarioFechas();
    });

    /*
     * Combinaciones de teclas
     */

    shortcut.add("ALT+S", function () {
        var movimiento = $("#movimiento").val();
        if (movimiento === "Cargo") {
            $("#movimiento").val("Abono");
        } else {
            $("#movimiento").val("Cargo");
        }
    }, {
        type: "keydown",
        propagate: true,
        target: document,
    });

    shortcut.add("ALT+A", function () {
        generarDetalle();
    }, {
        type: "keydown",
        propagate: true,
        target: document,
    });

    shortcut.add("ALT+M", function () {
        focus('monto');
    }, {
        type: "keydown",
        propagate: true,
        target: document,
    });

    shortcut.add("ALT+C", function () {
        $('#cuenta').select2('focus');
    }, {
        type: "keydown",
        propagate: true,
        target: document,
    });

    shortcut.add("ALT+G", function () {
        validarGuardarPartida();
    }, {
        type: "keydown",
        propagate: true,
        target: document,
    });
})
