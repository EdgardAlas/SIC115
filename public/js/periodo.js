function listaPeriodos(){
    $('#contenedor-periodo').load('/periodo/lista-periodos', function(){
        tablaPaginacion('tabla-periodos');
    });
}

$(document).ready(()=>{
    titulo('Periodos');

    listaPeriodos();
});