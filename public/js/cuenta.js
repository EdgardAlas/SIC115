function cargarTablaCuentas() {
    $('#div_tabla_cuentas').load('/cuenta/tablaCuentas', (data) => {
        tablaPaginacion('tabla_cuentas');
        $('[data-toggle="tooltip"]').tooltip();
    });
}

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


    /*
     * Combinacione de teclas
     */

    /* shortcut.add("Alt+G", function() {
        let id = $("#nombre").closest('form').attr('id');
        $('#' + id).submit();
    }); */

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