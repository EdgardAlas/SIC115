function tablaBalanzaComprobacion() {

    $('#contenedor-balanza').load('/balanza-comprobacion/tabla-balanza-comprobacion', function(){
        totales();
        tablaSinPaginacionBuscar('tabla_balanza');
    });

}

function totales(){
    $('#debe').text($('#total_debe').val());
    $('#haber').text($('#total_haber').val());
    $('#deudor').text($('#total_deudor').val());
    $('#acreedor').text($('#total_acreedor').val());
}

$(document).ready(() => {
    titulo('Balanza Comprobacion');

    tablaBalanzaComprobacion();
});