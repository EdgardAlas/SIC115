$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip()
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // subir hacia 0
    $('#back-to-top').click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });

});

const language = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad"
    }
};

function cerrarSesion() {
    $.post("../ajax/login/cerrarSesion.php", function(data) {
        if (data == 1) {
            location.href = "login"
        }
    });
}

function alerta(titulo, cuerpo, tipo) {
    Swal.fire(
        titulo,
        cuerpo,
        tipo
    );
}

function focusCampo(id) {
    var inputField = document.getElementById(id);
    if (inputField != null && inputField.value.length != 0) {
        if (inputField.createTextRange) {
            var FieldRange = inputField.createTextRange();
            FieldRange.moveStart('character', inputField.value.length);
            FieldRange.collapse();
            FieldRange.select();
        } else if (inputField.selectionStart || inputField.selectionStart == '0') {
            var elemLen = inputField.value.length;
            inputField.selectionStart = elemLen;
            inputField.selectionEnd = elemLen;
            inputField.focus();
        }
    } else {
        inputField.focus();
    }
}


function setFoco(id, evt, valor) {
    if (valor.length > 0) {
        if (evt.keyCode == 13) $("#" + id).focus();
    }
}

function paginacion(id) {
    $("#" + id).DataTable({
        "search": {
            "caseInsensitive": true
        },
        "language": language
    });
}

function sinPaginacion(id) {
    $("#" + id).DataTable({
        "paging": false,
        'searching': false,
        "language": language
    });
}

function validForm(id) {
    val = $(id).val();
    if (val.length == 0) $(id).addClass("is-invalid");
    else $(id).removeClass("is-invalid");
}