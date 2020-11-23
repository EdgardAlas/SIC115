const monto = new Cleave('#inventario_final', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand',
    numeralPositiveOnly: true,
    numeralDecimalMark: '.',
    delimiter: ',',
    prefix: '$'
});

function calcularCierre() {
    const inventario_final = obtenerMonto();

    $.post('/cierre-contable/calcular-cierre', {
        inventario_final
    }, function (data) {
        // for (const i in data) {
        //     log(`${i} = ${data[i]}`)
        // }
        cargarPartidas(data);
    })
    urlBalanceReporte(inventario_final);
    urlBalanceCuenta(inventario_final);
    urlEstadoResultadosReporte(inventario_final);
    $('#reportes').removeClass('d-none')
}

function urlBalanceReporte(inventario_final){
    $('#forma_reporte').attr('href', `/cierre-contable/balance-forma-reporte?inventario_final=${inventario_final}`);
}

function urlBalanceCuenta(inventario_final){
    $('#forma_cuenta').attr('href', `/cierre-contable/balance-forma-cuenta?inventario_final=${inventario_final}`);
}

function urlEstadoResultadosReporte(inventario_final){
    $('#estado_resultados').attr('href', `/cierre-contable/estado-resultados?inventario_final=${inventario_final}`);
}


function cargarPartidas(estado_resultados) {
    Swal.fire({
        title: 'Guardando...',
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    })
    $('#div_partidas').load('/cierre-contable/partidas-cierre', {
        estado_resultados
    }, function (data) {
        Swal.close();
    });
}

function obtenerMonto() {
    let montoInput = $('#inventario_final').val();
    return montoInput = (montoInput.substr(1).replace(/,/g, '')).replace(/\.$/, "");
}

function realizarCierre() {

    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de realizar el cierre contable?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: 'Guardando...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })
            $.post('/cierre-contable/realizar-cierre', function (data) {
                console.log(data)
                Swal.close();

                if (!data.error) {
                    Swal.fire({
                        title: 'Exito',
                        text: data.mensaje,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        location.href = data.redireccion
                    })
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.mensaje,
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        focus('inventario_final')
                    })
                }

            });
        } else {
            focus('inventario_final');
        }
    })


}

$(document).ready(() => {
    focus('inventario_final');
    titulo('Cierre Contable');

    $(document).on('click', '#btn_calcular_cierre', function () {
        $('#btn_calcular_cierre').blur();
        const monto = $("#inventario_final").val();
        console.log(monto);
        if (monto.length > 1)
            calcularCierre();
        else
            focus('inventario_final')

    });

    $(document).on('keyup', '#inventario_final', function (e) {
        const monto = $(this).val();

        if (isEnter(e.keyCode, monto, 1)) {
            calcularCierre();
        }
    })

    $(document).on('click', '#realizar_cierre', function (e) {
        $('#realizar_cierre').blur();
        realizarCierre();
    })



});


