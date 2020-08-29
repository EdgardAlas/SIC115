let detalles = [],
    tabla = [],
    partida = undefined;

const cleave = new Cleave('#monto', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand',
    numeralPositiveOnly: true,
    numeralDecimalMark: '.',
    delimiter: ',',
    prefix: '$'
});

$(document).ready(function() {

    $("#btnPartida").on("click", function() {
        $("#partidas").modal("show");
        cuentaSelect();
        tablaDetalle();
    });

    $("#partidas").on("shown.bs.modal", function(e) {
        focusCampo("descripcion");
    });

    $(document).on('click', '#btnAgregar', function(e) {
        //e.preventDefault();

        agregarDetalle();
    });

    $(document).on('click', '#btnGuardarPartida', function(e) {
        //e.preventDefault();
        $('#btnGuardarPartida').blur();
        if (!validarGuardarPartida()) {
            guardarDetalle();
        }

    });

    shortcut.add("Alt+G", function() {
        if ($('#partidas').is(':visible'))
            if (!validarGuardarPartida()) {
                guardarDetalle();
            }
    });

    //usar la tecle f8 para cambiar entre el saldo de la cuenta
    shortcut.add("F7", function() {
        var saldo = $("#movimiento").val();
        if (saldo == "Cargo") {
            $("#movimiento").val("Abono");
        } else {
            $("#movimiento").val("Cargo");
        }
    }, {
        "type": "keydown",
        "propagate": true,
        "target": document
    });

    $("#descripcion").on('keyup', function(e) {
        validForm("#descripcion", 0);
        if ($(this).val().length > 0 && e.keyCode == 13) {
            $("#codigoCuenta").select2('focus');
        }
    });


    $(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    });

    $(document).on('select2:closing', 'select.select2', function(e) {
        $(e.target).data("select2").$selection.one('focus focusin', function(e) {
            e.stopPropagation();
        });
    });

    $(document).on("focusout", "#descripcion", function() {
        validForm("#descripcion", 0);
    });

    $(document).on("focusout", "#monto", function() {
        validForm("#monto", 1);
    });

    $(document).on("keyup", "#monto", function(e) {
        validForm("#monto", 1);
        if ($(this).val().length > 1 && e.keyCode == 13) {
            agregarDetalle();
        }
    });


    $(document).on("select2:close", "#codigoCuenta", function() {
        let val = atob($("#codigoCuenta").val().split(' ')[0]);

        if (val == -1)
            $("#cuentaSelect").addClass('has-error');
        else
            $("#cuentaSelect").removeClass('has-error');
    });
});

function validForm(id, validacion) {
    let val = $(id).val();
    if (val.length == validacion)
        $(id).addClass('is-invalid');
    else
        $(id).removeClass('is-invalid');
}

function cuentaSelect() {
    $('#cuentaSelect').load('/libro-diario/registrarPartidaModal', function(data) {
        $('#codigoCuenta').select2();
    });
}

function generarDetalle() {
    let montoInput = $('#monto').val();
    montoInput = montoInput.substr(1).replace(/,/g, '');
    let cuenta = $("#codigoCuenta").val().split(' ');
    let saldo = $("#cuentaSelect option:selected").data('saldo');

    let datosPartida = {
        descripcion: $('#descripcion').val(),
        fecha: $("#fecha").val(),
        partida_cierre: 0
    };

    let detalle = {
        cuenta: cuenta[0],
        codigo: cuenta[1],
        monto: calcularMonto(montoInput, saldo, $("#movimiento").val()),
        movimiento: $("#movimiento").val()
    };

    let mostrar = {
        codigo: atob(cuenta[1]),
        movimiento: $("#movimiento").val(),
        monto: montoInput
    };

    partida = datosPartida;
    detalles.push(detalle);
    tabla.push(mostrar);

    tablaDetalle();
}

function calcularMonto(monto, saldo, movimiento) {
    let saldocuenta = monto;
    if ((saldo === 'Deudor' && movimiento === 'Abono') ||
        (saldo === 'Acreedor' && movimiento === 'Cargo')) {
        saldocuenta = -saldocuenta;
    }
    return saldocuenta;
}

function tablaDetalle() {
    $("#tabladetalle").load('/libro-diario/tablaDetalle', { tabla }, function(data) {
        sinPaginacion('tabla');
        totalCargoAbono();
    });
}

function totalCargoAbono() {
    let cargo = $('#totalCargo').val(),
        abono = $('#totalAbono').val();

    $('#cargoAbono').text('Cargo: ' + cargo + ' - Abono: ' + abono);
}

function validarCamposDetalle() {
    let cuenta = $('#codigoCuenta').val(),
        movimiento = $("#movimiento").val(),
        montoInput = $('#monto').val();
    console.log(cuenta.length);
    if (cuenta.length === 0) {
        $("#cuentaSelect").addClass('has-error');
        $("#codigoCuenta").select2('focus');
        return false;
    }

    montoInput = montoInput.substr(1).replace(/,/g, '');

    if (montoInput <= 0) {
        validForm("#monto", 1);
        $("#monto").focus();
        return false;
    }

    return true;
}

function limpiarCamposDetalle() {
    $("#codigoCuenta").select2('focus');
    $('#codigoCuenta').val('').trigger('change');
    cleave.setRawValue();
}

function agregarDetalle() {
    if (validarCamposDetalle()) {
        generarDetalle();
        limpiarCamposDetalle();
    }
}


function guardarDetalle() {
    $.post('/libro-diario/guardar', { partida, detalles }, function(data) {
        console.log(data);
        if (!data.error) {
            alerta("Exito", data.mensaje, "success");
            Swal.fire({
                icon: 'success',
                title: 'Exito',
                text: data.mensaje,
                onClose: () => {
                    focusCampo('descripcion');
                },
            }).then((result) => {
                limpiarAgregarPartidaModal();
                $('#descripcion').removeClass('is-invalid');
            });
        }
    });
}

function limpiarAgregarPartidaModal() {
    $('#descripcion').val('');
    $('#codigoCuenta').val('').trigger('change');
    cleave.setRawValue();
    $('#monto').removeClass('is-invalid');
    $('#movimiento').val('Cargo');
    detalles = [];
    tabla = [];
    partida = undefined;
    tablaDetalle();
}

function validarGuardarPartida() {
    let descripcion = $('#descripcion').val(),
        cargo = $('#totalCargo').val(),
        abono = $('#totalAbono').val(),
        diferencia = $('#diferencia').val();

    if (descripcion.length === 0) {
        focusCampo("descripcion");
        validForm('descripcion', 0);

        return true;
    }

    if (cargo !== abono) {
        Swal.fire({
            title: "Advertencia",
            text: "Cargo y Abono no son iguales por " + diferencia,
            icon: "warning",
            showCancelButton: false,
            confirmButtonColor: "#6777ef",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK",
            onClose: () => {
                $("#codigoCuenta").select2('focus');
                $('#codigoCuenta').val('').trigger('change');
            }
        });

        return true;
    }

    if (detalles.length === 0) {
        Swal.fire({
            title: "Advertencia",
            text: "No hay detalles registrados",
            icon: "warning",
            showCancelButton: false,
            confirmButtonColor: "#6777ef",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK",
            onClose: () => {
                $("#codigoCuenta").select2('focus');
                $('#codigoCuenta').val('').trigger('change');
            }
        });

        return true;
    }

    return false;
}