function buscarConfiguracion(id, data){
   $(`#${id}`).load('/cuenta/buscar-cuenta-configuracion', {data} )
}


$(document).ready(() => {
   titulo('Configuración');

   $(document).on('keyup', '.buscar-cuenta', function(){
      
      const input_cuenta = $(this);
      const div_actualizar = input_cuenta.parent().next();
      log(div_actualizar);
      const id_div_actualizar = div_actualizar.attr('id');
      const input_configuracion = div_actualizar.children('.configuracion');

      const data = {
         titulo : input_configuracion.attr('data-titulo'),
         descripcion : input_configuracion.attr('data-descripcion'),
         codigo : input_cuenta.val()
      };

      buscarConfiguracion(id_div_actualizar, data);
   });
});