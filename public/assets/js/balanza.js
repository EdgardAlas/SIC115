$(document).ready(function() {
    tablaBalanzaComprobacion();
});

function tablaBalanzaComprobacion() {
    $('#datos').load('/balanza-comprobacion/tablaBalanza', function() {
        sinPaginacion('tabla');
    });
}