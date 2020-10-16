function tablaLibroMayorEspecifico(carga){
    const fecha_inicial = $("#fecha_inicial").val();
    const fecha_final = $("#fecha_final").val();
    const nivel = $("#nivel").val();
    const cuentas = $("#cuenta").val().split(',');  
    const cuenta = [...new Set(cuentas)];


    if(carga){
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }

    $('#contenedor_mayor').load('/libro-mayor/tabla-libro-mayor',{
        fecha_inicial,
        fecha_final,
        cuenta,
        nivel
    } ,function(data){
        if(carga){
            Swal.close();
        }
    });
}

function cargarNiveles() {
    $("#contenedor_niveles").load('/cuenta/input-niveles', function () {
        tablaLibroMayorEspecifico(true);
    });
}

function tablaLibroMayor(){

    $('#contenedor_mayor').load('/libro-mayor/tabla-libro-mayor', function(){

    });
}

function tablaLibroDiarioEspecifico(numero, codigo) {
    /* Swal.fire({
        title: 'Actualizando...',
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    }) */

    let fecha_inicial = $('#fecha_inicial').val(),
        fecha_final = $('#fecha_final').val();

    $('#partida_especifica').load('/libro-diario/tabla-libro-diario', { fecha_inicial, fecha_final, numero, codigo }, function() {
        /* Swal.close(); */
    });
}

$(document).ready(()=>{
    titulo('Libro Mayor');
    cargarNiveles();
    

    $(document).on('click', '.numero_partida', function() {

        const numero = $(this).data('partida');
        const codigo = $(this).data('codigo');
        log({numero, codigo});
        tablaLibroDiarioEspecifico([numero], codigo);
        $('#modal_partida').modal('show');
    });

    $(document).on('change', '#fecha_inicial', function(){
        tablaLibroMayorEspecifico();
    } );

    $(document).on('change', '#fecha_final', function(){
        tablaLibroMayorEspecifico();
    } );

    $(document).on('change', '#nivel', function(){
        tablaLibroMayorEspecifico();
    } );

    $(document).on('keyup', '#cuenta', function(){
        tablaLibroMayorEspecifico();
    } );
});