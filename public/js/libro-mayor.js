function tablaLibroMayorEspecifico(carga) {

    cambiarFechas($('#periodo').find(':selected').attr('data-anio'));
    const fecha_inicial = $("#fecha_inicial").val();
    const fecha_final = $("#fecha_final").val();
    const nivel = $("#nivel").val();
    const cuentas = $("#cuenta").val().split(',');

    const periodo = $('#periodo').val();

    const cuenta = [...new Set(cuentas)];


    if (carga) {
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }

    $('#contenedor_mayor').load('/libro-mayor/tabla-libro-mayor', {
        fecha_inicial,
        fecha_final,
        cuenta,
        nivel,
        periodo
    }, function (data) {
        if (carga) {
            Swal.close();
        }
    });

    reporteLibroMayor();
}

function cambiarFechas(anio) {
    let fecha = new Date();
    $('#fecha_inicial').val(`${anio}-01-01`);
    const dia = fecha.getDate();
    $('#fecha_final').val(`${anio}-${fecha.getMonth() + 1}-${dia<10 ? '0' : ''}${dia}`);
}

function cargarNiveles() {

    const periodo = $('#periodo').val();

    $("#contenedor_niveles").load('/cuenta/input-niveles',{
        periodo
    }, function () {
        tablaLibroMayorEspecifico(true);
    });
}


function cargarPeriodos() {
    $('#list_periodos').load('/periodo/input-periodos', function (data) {
        console.log(data)
        cargarNiveles();
    });
}

function tablaLibroMayor() {

    $('#contenedor_mayor').load('/libro-mayor/tabla-libro-mayor', function () {

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

    $('#partida_especifica').load('/libro-diario/tabla-libro-diario', {
        fecha_inicial,
        fecha_final,
        numero,
        codigo
    }, function () {
        /* Swal.close(); */
    });
}

function reporteLibroMayor() {

    let fecha_inicial = $('#fecha_inicial').val(),
        fecha_final = $('#fecha_final').val(),
        nivel = $('#nivel').val(),
        cuenta = $('#cuenta').val().split(','),
        periodo = $('#periodo').val();

    cuenta = [...new Set(cuenta)];

    $('#btn_imprimir').attr('href', `/libro-mayor/reporte-libro-mayor?fecha_inicial=${fecha_inicial}&fecha_final=${fecha_final}&nivel=${nivel}&cuenta=${cuenta}&periodo=${periodo}`);

}

$(document).ready(() => {
    titulo('Libro Mayor');
    cargarPeriodos();


    $(document).on('click', '.numero_partida', function () {

        const numero = $(this).data('partida');
        const codigo = $(this).data('codigo');
        log({
            numero,
            codigo
        });
        tablaLibroDiarioEspecifico([numero], codigo);
        $('#modal_partida').modal('show');
    });

    $(document).on('change', '#fecha_inicial', function () {
        tablaLibroMayorEspecifico();
    });

    $(document).on('change', '#fecha_final', function () {
        tablaLibroMayorEspecifico();
    });

    $(document).on('change', '#nivel', function () {
        tablaLibroMayorEspecifico();
    });

    $(document).on('keyup', '#cuenta', function () {
        tablaLibroMayorEspecifico();
    });

    $(document).on('change', '#periodo', function () {
        tablaLibroMayorEspecifico();
    });
});