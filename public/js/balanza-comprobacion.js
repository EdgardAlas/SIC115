function tablaBalanzaComprobacion(carga = false) {
    const fecha_inicial = $('#fecha_inicial').val();
    const fecha_final = $('#fecha_final').val();
    const nivel = $('#nivel').val();

    if(carga){
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }

    console.log(nivel);
    $('#contenedor-balanza').load('/balanza-comprobacion/tabla-balanza-comprobacion', {
        fecha_inicial,
        fecha_final,
        nivel
    }, function () {
        totales();
        tablaSinPaginacionBuscar('tabla_balanza');
        if(carga){
            Swal.close();
        }
    });

    reporteBalanza();
}

function totales() {
    $('#debe').text($('#total_debe').val());
    $('#haber').text($('#total_haber').val());
    $('#deudor').text($('#total_deudor').val());
    $('#acreedor').text($('#total_acreedor').val());
}

function cargarNiveles() {
    $("#contenedor_niveles").load('/cuenta/input-niveles', function () {
        tablaBalanzaComprobacion(true);
    });
}

function reporteBalanza() {
    /* Swal.fire({
        title: 'Actualizando...',
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    }) */

    let fecha_inicial = $('#fecha_inicial').val(),
        fecha_final = $('#fecha_final').val(),
        nivel = $('#nivel').val();

    $('#btn_imprimir').attr('href', `/balanza-comprobacion/reporte-balanza-comprobacion?fecha_inicial=${fecha_inicial}&fecha_final=${fecha_final}&nivel=${nivel}`);

}

$(document).ready(() => {
    titulo('Balanza de Comprobación');
    cargarNiveles();

    /* 
     *Eventos 
     */

    $(document).on('change', '#fecha_inicial', function(){
        tablaBalanzaComprobacion(false);
    } );

    $(document).on('change', '#fecha_final', function(){
        tablaBalanzaComprobacion(false);
    } );

    $(document).on('change', '#nivel', function(){
        tablaBalanzaComprobacion(false);
    } );
});