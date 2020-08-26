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

const tablaPaginacion = (id) => {
    $(`#${id}`).dataTable({
        "language": {
            "url": "public/js/es.json"
        },
        "lengthMenu": [
            [5, 10, 50, -1],
            [5, 10, 50, "Todos"]
        ],
        "pageLength": 5,
    });
}