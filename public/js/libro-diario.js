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

$(document).ready(() => {

    cargarInputSelectCuentas();

    tablaSinPaginacion('tabla');


    /* Eventos */

    $(document).on('click', '#btn_partida', function() {
        $('#modal_partida').modal('show');
    });

    $("#modal_partida").on("shown.bs.modal", function(e) {
        focusCampo("descripcion");
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