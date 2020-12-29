function listaPeriodos(carga = false) {
    if (carga) {
        Swal.fire({
            title: 'Cargando...',
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        })
    }
    $('#contenedor-periodo').load('/periodo/lista-periodos', function () {
        tablaPaginacion('tabla-periodos');
        if (carga) {
            Swal.close();
        }
    });
}

function iniciarPeriodo() {

    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de iniciar un nuevo periodo?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {

            Swal.fire({
                title: 'Iniciando Periodo...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

            $.post('/periodo/iniciar-periodo', {}, function (data) {
                if (!data.error) {
                    $('#modal_iniciar_periodo').modal('hide');
                    listaPeriodos(false);
                }
                Swal.close();

                Swal.fire({
                    title: 'Atención',
                    text: data.mensaje,
                    icon: data.icono,
                    showCancelButton: false,
                    confirmButtonColor: '#6777ef',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok',
                })


            });
        }
    })


}

function cargarModalIniciarPerido() {
    $('#modal-content-body').load('/periodo/modal-iniciar-periodo', function (data) {
        $('#modal_iniciar_periodo').modal('show');
    });
}

$(document).ready(() => {
    titulo('Periodos');

    listaPeriodos(true);

    $(document).on('click', '#btn_iniciar_periodo', function () {
        cargarModalIniciarPerido();
    })

    $(document).on('click', '#btn_generar_periodo', function () {
        iniciarPeriodo();
    })
});
