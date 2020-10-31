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
     $('#div_partidas').load('/cierre-contable/partidas-cierre', {
         estado_resultados
     }, function(data){

     });
 }

function obtenerMonto() {
    let montoInput = $('#inventario_final').val();
    return montoInput = (montoInput.substr(1).replace(/,/g, '')).replace(/\.$/, "");
}

$(document).ready(() => {
    focus('inventario_final');
    titulo('Cierre Contable');

    $(document).on('click', '#btn_calcular_cierre', function () {
        $('#btn_calcular_cierre').blur();
        calcularCierre();

    });
});


