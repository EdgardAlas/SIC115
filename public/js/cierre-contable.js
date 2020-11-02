const monto = new Cleave('#inventario_final', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand',
    numeralPositiveOnly: true,
    numeralDecimalMark: '.',
    delimiter: ',',
    prefix: '$'
});

 function calcularCierre(){
     const inventario_final = obtenerMonto();

     $.post('/cierre-contable/calcular-cierre', {
         inventario_final
     }, function(data){
         // for (const i in data) {
         //     log(`${i} = ${data[i]}`)
         // }
         cargarPartidas(data);
     })
 }

 function cargarPartidas(estado_resultados){
     Swal.fire({
         title: 'Guardando...',
         onBeforeOpen: () => {
             Swal.showLoading()
         }
     })
     $('#div_partidas').load('/cierre-contable/partidas-cierre', {
         estado_resultados
     }, function(data){
        Swal.close();
     });
 }

function obtenerMonto() {
    let montoInput = $('#inventario_final').val();
    return montoInput = (montoInput.substr(1).replace(/,/g, '')).replace(/\.$/, "");
}

function realizarCierre(){
     $.post('/cierre-contable/realizar-cierre', function (data){
         console.log(data)
         alert('se realizo todo con exito')
     });
}

$(document).ready(() => {
    focus('inventario_final');
    titulo('Cierre Contable');

    $(document).on('click', '#btn_calcular_cierre', function () {
        $('#btn_calcular_cierre').blur();
        calcularCierre();
    });

    $(document).on('keyup', '#inventario_final', function (e){
        const monto = $(this).val();

        if (isEnter(e.keyCode, monto, 1)) {
            calcularCierre();
        }
    })

    $(document).on('click', '#realizar_cierre', function (e){
        realizarCierre();
    })

});


