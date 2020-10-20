function listaPeriodos(carga = false){
    if(carga){
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }
    $('#contenedor-periodo').load('/periodo/lista-periodos', function(){
        tablaPaginacion('tabla-periodos');
        if(carga){
            Swal.close();
        }
    });
}

$(document).ready(()=>{
    titulo('Periodos');

    listaPeriodos(true);
});