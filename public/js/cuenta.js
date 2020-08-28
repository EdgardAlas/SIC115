function cargarTablaCuentas() {
    $('#div_tabla_cuentas').load('/cuenta/tablaCuentas', (data) => {
        tablaPaginacion('tabla_cuentas');
        $('[data-toggle="tooltip"]').tooltip();
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
    $("#validar_padre").load("/cuenta/obtenerDatosCuentaPadre", {
        codigo
    }, function(data) {
        log(data);
    });
}

/* Inicio */
$(document).ready((event) => {

    /*
     * Eventos
     */

    $('#btn_acciones_cuenta').focus();

    cargarTablaCuentas();

    //abrir modal guardar
    $('#btn_acciones_cuenta').on('click', function() {
        $('#modal-content-body').load('/cuenta/modalGuardar');
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
        $('#modal-content-body').load(`/cuenta/modalEditar/${id}`);
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
        buscarCuentaPadre();
    });


    /*
     * Combinacione de teclas
     */

    shortcut.add("Alt+G", function() {
        /* let id = $("#nombre").closest('form').attr('id');
        $('#' + id).submit(); */
        alert('simular guardar');
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
});