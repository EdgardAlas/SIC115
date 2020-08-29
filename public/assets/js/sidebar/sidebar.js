$(document).ready(function() {
    activeItem(); //activar la opcion correspondiente
});

function activeItem() {
    
    var url = location.pathname.split('/'); //se separa la direccion para tener solo el nombre del archivo
    var active = '/'+url[url.length-1];  //ya que es un arreglo, el nombre del archivo esta en la ultima posicion
    
    if(active!="restaurar" && active!="crear")
        $('a[href="' + active + '"]').closest('li').addClass('active'); //se activa el li mas cercano
    else{
                
        var activar = $('a[href="' + active + '"]'); //se guarda la etiqueta A que estara activa

        activar.closest('li').addClass('active'); //se activa el li mas cercano
        activar.closest('ul').addClass('active'); //se activa el ul mas cercano
        activar.closest('ul').show(); //se muestra el ul
        activar.closest('ul').closest('li').addClass('active'); //se activa el li mas cecano al ul 
        
    }
    
}