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
    $('#contenedor_cuentas').load('/cuenta/input-seleccionar-cuenta', function() {
        select('cuenta');
    });
}

function obtenerMonto() {
    let montoInput = $('#monto').val();
    return montoInput = montoInput.substr(1).replace(/,/g, '');
}

function generarDetalle() {

    let saldo = $("#contenedor_cuentas option:selected").data('saldo'),
        codigo = $("#contenedor_cuentas option:selected").data('codigo');
    /* fecha = $('#fecha').val(),
        descripcion = $('#descripcion').val() */

    let detalle = {
        cuenta: $('#cuenta').val(),
        movimiento: $('#movimiento').val(),
        monto: calcularMonto(obtenerMonto(), saldo, $('#movimiento').val())
    };

    let mostrar = {
        codigo,
        movimiento: $('#movimiento').val(),
        monto: $('#monto').val()
    };


    /*
     * Validaciones
     */

    if (detalle.cuenta.length === 0) {
        $("#cuenta").select2('focus');
        return;
    }

    if (detalle.monto.length === 0 || detalle.monto === '0') {
        validarCampo('monto', 1);
        focus('monto');
        return;
    }


    /* partida.datos_partida.fecha = fecha;
    partida.datos_partida.descripcion = descripcion; */


    partida.detalle_partida.push(detalle);
    tabla_detalle.push(mostrar);

    limpiarAgregarDetalle();
}

function calcularMonto(monto, saldo, movimiento) {
    let saldocuenta = monto;
    if ((saldo === 'Deudor' && movimiento === 'Abono') ||
        (saldo === 'Acreedor' && movimiento === 'Cargo')) {
        saldocuenta = -saldocuenta;
    }
    return saldocuenta;
}

function limpiarAgregarDetalle() {
    $("#cuenta").select2('focus');
    $('#cuenta').val('').trigger('change');
    $('#movimiento').val('Cargo');
    monto.setRawValue();
}

$(document).ready(() => {

    titulo('Libro Diario');

    cargarInputSelectCuentas();

    tablaSinPaginacion('tabla');


    /* Eventos */

    $(document).on('click', '#btn_partida', function() {
        $('#modal_partida').modal('show');
    });

    $("#modal_partida").on("shown.bs.modal", function(e) {
        focusCampo("descripcion");
    });

    $(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    });

    $(document).on('select2:closing', 'select.select2', function(e) {
        $(e.target).data("select2").$selection.one('focus focusin', function(e) {
            e.stopPropagation();
        });
    });

    $(document).on('keyup', '#descripcion', function(e) {

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

    $(document).on('click', '#btn_agregar', function() {
        $('#btn_agregar').blur();
        generarDetalle();
    });

    $(document).on('keyup', '#monto', function(e) {

        let monto = $(this).val();

        if (isEnter(e.keyCode, monto, 1)) {

            generarDetalle();
            return;
        }

        if (monto.length === 1) {

            validarCampo('monto', true);
            return;
        }

        validarCampo('monto', false);
    });

    /*
     * Combinaciones de teclas
     */

    shortcut.add("ALT+S", function() {
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
})