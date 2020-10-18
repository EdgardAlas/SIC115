function cargarConfiguraciones(){
      Swal.fire({
          title: 'Cargando...',
          onBeforeOpen: () => {
              Swal.showLoading()
          }
      })
  

   $('#nav-tabContent').load('/configuracion/configuraciones', function(){
      Swal.close();
   })
}

function buscarConfiguracion(id, data) {
   $(`#${id}`).load('/cuenta/buscar-cuenta-configuracion', {
      data
   })
}

function configuraciones() {
   const input_configuraciones = $('.configuracion');
   const configuraciones = [];

   input_configuraciones.each((i, config) => {
      if (config.dataset.obligatorio == 1 && config.dataset.cuenta == -1) {
         let falta_cuenta = config.parentElement.previousElementSibling.children;
         
         Swal.fire({
            title: 'Atención',
            text: "Falta " + falta_cuenta[0].textContent,
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
         }).then(()=>{
            falta_cuenta[1].focus();
         })

         //romper el ciclo
         return false;
      }

      configuraciones.push({
         titulo: config.dataset.titulo,
         descripcion: config.dataset.descripcion,
         cuenta: config.dataset.cuenta
      });
      
      if(config.dataset.obligatorio==null && config.dataset.cuenta == -1){
         log('test')
         configuraciones.pop();
      }

      

   })

   log({configuraciones})
}


$(document).ready(() => {
   titulo('Configuración');

   cargarConfiguraciones();

   $(document).on('keyup', '.buscar-cuenta', function () {

      const input_cuenta = $(this);
      const div_actualizar = input_cuenta.parent().next();
      
      const id_div_actualizar = div_actualizar.attr('id');
      const input_configuracion = div_actualizar.children('.configuracion');

      const data = {
         titulo: input_configuracion.attr('data-titulo'),
         descripcion: input_configuracion.attr('data-descripcion'),
         codigo: input_cuenta.val(),
         obligatorio : input_configuracion.attr('data-obligatorio')
      };

      
      buscarConfiguracion(id_div_actualizar, data);
   });

   $(document).on('click', '#btn_guardar', function () {
      $('#btn_guardar').blur();
      configuraciones();
   });

});