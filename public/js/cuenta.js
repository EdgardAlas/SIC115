function cargarTablaCuentas() {
    $('#div_tabla_cuentas').load('/cuenta/tablaCuentas', (data) => {
        tablaPaginacion('tabla_cuentas');
        $('[data-toggle="tooltip"]').tooltip();
    });
}

document.addEventListener("DOMContentLoaded", function(event) {
    document.querySelector('#btn_agregar_cuenta').focus();
    cargarTablaCuentas();
});