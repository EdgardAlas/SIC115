function restaurar() {
    var archivo = new FormData(document.getElementById('form_restaurar'));
    // $.post('/backup/leer', {archivo},function(data){
    //     console.log(data)
    // });
}

$(document).ready(() => {
    titulo('Copia de Seguridad')

    $(document).on('change', '#file', function () {
        $(this).next().after().text($(this).val().split('\\').slice(-1)[0])
    })

    $(document).on('submit', '#form_restaurar', function (e) {
        e.preventDefault()

        var form = $('#form_restaurar')[0];

        // Create an FormData object
        var data = new FormData(form);


        Swal.fire({
            title: 'Atención',
            text: "¿Esta seguro de restaurar este backup?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {

                Swal.fire({
                    title: 'Restaurando...',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "/backup/restaurar",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                        Swal.close();

                        Swal.fire({
                            title: 'Atención',
                            text: data.mensaje,
                            icon: data.icono,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (!data.error) {
                                location.href = '/';
                            }
                        })
                    }
                });
            }
        })


    })
});
