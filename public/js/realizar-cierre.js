function empezarCierre(){
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de empezar con el cierre contable?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if(result.value){
            $.post('/cierre-contable/validar-cierre', {cierre: true}, function (data){
                console.log(data)
                if(!data.error){
                    //location.href = data.url;
                }else{
                    Swal.fire({
                        title: 'Atención',
                        text: data.mensaje,
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#6777ef',
                        confirmButtonText: 'Ok',

                    })
                }
            });
        }
    })
}

$(document).ready(() => {
    titulo('Emepezar Cierre Contable');
    $(document).on('click', '#btn_empezar', function(){
        empezarCierre();
    })
});