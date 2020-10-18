"use strict";

function cargarConfiguraciones() {
  Swal.fire({
    title: 'Cargando...',
    onBeforeOpen: function onBeforeOpen() {
      Swal.showLoading();
    }
  });
  $('#nav-tabContent').load('/configuracion/configuraciones', function () {
    Swal.close();
  });
}

function buscarConfiguracion(id, data) {
  $("#".concat(id)).load('/cuenta/buscar-cuenta-configuracion', {
    data: data
  });
}

function guardar() {
  var configuraciones = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
  $.post('/configuracion/guardar', {
    configuraciones: configuraciones
  }, function (data) {
    Swal.fire({
      title: 'Atención',
      text: data.mensaje,
      icon: data.icono,
      showCancelButton: false,
      confirmButtonColor: '#6777ef',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok'
    });
  });
}

function configuraciones() {
  var input_configuraciones = $('.configuracion');
  var configuraciones = [];
  var guardar = true;
  input_configuraciones.each(function (i, config) {
    if (config.dataset.obligatorio == 1 && config.dataset.cuenta == -1) {
      var falta_cuenta = config.parentElement.previousElementSibling.children;
      Swal.fire({
        title: 'Atención',
        text: "Falta " + falta_cuenta[0].textContent,
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
      }).then(function () {
        falta_cuenta[1].focus();
      }); //romper el ciclo

      return false;
    }

    configuraciones.push({
      titulo: config.dataset.titulo,
      descripcion: config.dataset.descripcion,
      cuenta: config.dataset.cuenta
    });

    if (config.dataset.obligatorio == null && config.dataset.cuenta == -1) {
      configuraciones.pop();
    }
  });

  if (guardar) {
    Swal.fire({
      title: 'Atención',
      text: "¿Esta seguro de guardar esta configuración?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#6777ef',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then(function (result) {
      if (result.value) {
        guardar(configuraciones);
      }
    });
  }
}

$(document).ready(function () {
  titulo('Configuración');
  cargarConfiguraciones();
  $(document).on('keyup', '.buscar-cuenta', function () {
    var input_cuenta = $(this);
    var div_actualizar = input_cuenta.parent().next();
    var id_div_actualizar = div_actualizar.attr('id');
    var input_configuracion = div_actualizar.children('.configuracion');
    var data = {
      titulo: input_configuracion.attr('data-titulo'),
      descripcion: input_configuracion.attr('data-descripcion'),
      codigo: input_cuenta.val(),
      obligatorio: input_configuracion.attr('data-obligatorio')
    };
    buscarConfiguracion(id_div_actualizar, data);
  });
  $(document).on('click', '#btn_guardar', function () {
    $('#btn_guardar').blur();
    configuraciones();
  });
});