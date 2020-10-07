const log = (x) => console.log(x);

const focus = (id) => {
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


function tablaSinPaginacion(id) {
    $(`#${id}`).DataTable({
        "order": [],
        "aaSorting": [],
        "paging": false,
        'searching': false,
        "language": language
    });
}

function tablaSinPaginacionBuscar(id) {
    $(`#${id}`).DataTable({
        "order": [],
        "aaSorting": [],
        "paging": false,
        "language": language
    });
}

const tablaPaginacion = (id) => {
    $(`#${id}`).dataTable({
        "order": [],
        "aaSorting": [],
        "language": {
            "url": "/public/js/es.json"
        },
        "lengthMenu": [
            [5, 10, 50, -1],
            [5, 10, 50, "Todos"]
        ],
        "pageLength": 5,
    });
}

const tablaPaginacionTodos = (id) => {
    $(`#${id}`).dataTable({
        "order": [],
        "aaSorting": [],
        "language": {
            "url": "/public/js/es.json"
        },
        "lengthMenu": [
            [5, 10, 50, -1],
            [5, 10, 50, "Todos"]
        ],
        "pageLength": -1,
    });
}

const select = (id) => {
    $(`#${id}`).select2({
        language: {

            noResults: function() {

                return "No hay resultado";
            },
            searching: function() {

                return "Buscando..";
            }
        }
    });
}

const validarCampo = (id, error) => {
    const campo = $(`#${id}`);
    if (error)
        campo.addClass('is-invalid');
    else
        campo.removeClass('is-invalid');
}

const titulo = (titulo) => {
    document.title = titulo;
}

const isEnter = (tecla, valor_input, minimo_text_input) => {
    return (tecla == 13 && valor_input.length > minimo_text_input);

}