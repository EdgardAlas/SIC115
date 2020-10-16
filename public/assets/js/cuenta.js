$(document).ready(function() {
    paginacionCuentas();

    $("#btnAgregarCuenta").on("click", function() {
        vistaModalGuardar();
        $("#accionesCuentaModal").modal("show");
    });

    $(document).on("click", '#btnEditarCuenta', function() {
        let id = $(this).data('cuenta');
        vistaModalEditar(id);
        $("#accionesCuentaModal").modal("show");
    });

    //limintar los caracteres
    $(document).on("keydown", "#codigo", function() {
        if (!(
                event.keyCode == 8 || // backspace
                event.keyCode == 46 || // delete
                event.keyCode == 13 || //enter
                event.keyCode == 114 || // R
                event.keyCode == 82 || // r
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

    //poner foco al abrir modalmodal-content-body
    $("#accionesCuentaModal").on("shown.bs.modal", function(e) {
        if ($("#validar").length) $("#codigo").focus();
        else focusCampo("nombre");
    });

    $(document).on("submit", "#formGuardar", function(e) {
        e.preventDefault();
        $("#btnGuardar").blur();
        validarCamposGuardar();
    });

    $(document).on("submit", "#formEditar", function(e) {
        e.preventDefault();
        $("#btnEditar").blur();
        let codigoCuenta = $('#btnEditar').data('cuenta')
        validarCamposEditar(codigoCuenta);
    });

    $(document).on("keyup", "#codigo", function(e) {
        if ($(this).val().length > 0 && atob($('#validar').data('mayor')) != -1) {
            setFoco("nombre", e, $(this).val());
        }
        buscarCuentaPadre();
        validForm("#codigo");
    });

    $(document).on('click', '#btnGuardar', function() {
        $("#formGuardar").submit();
    })

    $(document).on("keyup", "#nombre", function(e) {

        if (e.keyCode === 13) {
            let form = $(this).closest('form');
            console.log({
                form
            });
            form.submit();
        }
        validForm("#nombre");
    });

    shortcut.add("Alt+G", function() {
        let id = $("#nombre").closest('form').attr('id');
        $('#' + id).submit();
    });

    //usar la tecle f8 para cambiar entre el saldo de la cuenta
    shortcut.add("F7", function() {
        var saldo = $("#saldo").val();
        if (saldo == "Deudor") {
            $("#saldo").val("Acreedor");
        } else {
            $("#saldo").val("Deudor");
        }
    }, {
        type: "keydown",
        propagate: true,
        target: document,
    });
});

function vistaModalGuardar() {
    $("#modal-content-body").load("/cuenta/vistaModalGuardar", function() {
        focusCampo("codigo");
    });
}

function vistaModalEditar(id) {
    $("#modal-content-body").load("/cuenta/vistaModalEditar", { id }, function() {
        focusCampo("codigo");
    });
}

function paginacionCuentas() {
    $("#datos").load("/cuenta/tablaCuentas", function() {
        $('[data-toggle="tooltip"]').tooltip();
        paginacion("tabla");
    });
}

function validarCamposGuardar() {
    let cuenta = {
        codigo: $("#codigo").val(),
        padre: $("#validar").data("mayor"),
        nombre: $("#nombre").val(),
        saldo: $("#saldo").val()
    };

    if (cuenta.codigo.length == 0 && cuenta.nombre.length == 0) {
        focusCampo("codigo");
        validForm("#codigo");
        return;
    } else if (atob(cuenta.padre) == -1) {
        focusCampo("codigo");
        validForm("#codigo");
        return;
    } else if (cuenta.codigo.length == 0) {
        focusCampo("codigo");
        validForm("#codigo");
        return;
    } else if (cuenta.nombre.length == 0) {
        focusCampo("nombre");
        validForm("#nombre");
        return;
    }

    Swal.fire({
        title: "Advertencia",
        text: "¿Esta seguro de guardar esta cuenta?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6777ef",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
    }).then((result) => {
        if (result.value) {
            guardarCuenta(cuenta);
        }
    });
}

function validarCamposEditar(codigoCuenta) {
    let cuenta = {
        codigo: codigoCuenta,
        nombre: $("#nombre").val(),
        saldo: $("#saldo").val()
    };

    if (cuenta.nombre.length == 0) {
        focusCampo("nombre");
        validForm("#nombre");
        return;
    }

    Swal.fire({
        title: "Advertencia",
        text: "¿Esta seguro de editar esta cuenta?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6777ef",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
    }).then((result) => {
        if (result.value) {
            editarCuenta(cuenta);
        }
    });
}

function guardarCuenta(cuenta) {
    $.post("cuenta/guardar", cuenta, function(data) {
        console.log(data);
        if (!data.error) {
            alertaConAcciones("success", "Exito", data.mensaje, "codigo", "limpiar");
        }
    });
}

function editarCuenta(cuenta) {
    $.post("cuenta/editar", cuenta, function(data) {
        console.log(data);
        if (!data.error) {
            $("#accionesCuentaModal").modal("hide");
            paginacionCuentas();
            alerta("Exito", data.mensaje, "success");
        }
    });
}

function limpiar() {
    paginacionCuentas();
    vistaModalGuardar();
}

function alertaConAcciones(icono, titulo, text, foco) {
    Swal.fire({
        icon: icono,
        title: titulo,
        text: text,
        onClose: () => {
            focusCampo(foco);
        },
    }).then((result) => {
        limpiar();
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
    codigo = $("#codigo").val();
    $("#validarMayor").load("cuenta/obtenerDatosCuentaPadre", {
        codigo,
    });
}