$(document).ready(function () {
  console.log("Script cargado correctamente");

  const preciosPorPeso = [
    { rango: [0.01, 1], precio: 10.00 },
    { rango: [1.01, 2], precio: 35.00 },
    { rango: [2.01, 3], precio: 50.00 },
    { rango: [3.01, 4], precio: 60.00 },
    { rango: [4.01, 5], precio: 70.00 },
    { rango: [5.01, 6], precio: 80.00 },
    { rango: [6.01, 7], precio: 90.00 },
    { rango: [7.01, 8], precio: 100.00 },
    { rango: [8.01, 9], precio: 110.00 },
    { rango: [9.01, 10], precio: 115.00 },
    { rango: [10.01, 12], precio: 120.00 },
    { rango: [12.01, 15], precio: 135.00 },
    { rango: [15.01, 20], precio: 140.00 },
  ];

  // Referencias a los elementos del formulario
  const pesoInput = $('#pesoPaquete');
  const precioInput = $('#precio');
  const tipoPaqueteSelect = $('#tipoPaquete');

  // Precio base por categoría, será actualizado vía AJAX
  let precioBaseCategoria = 0;

  function obtenerPrecioPorPeso(peso) {
    for (let i = 0; i < preciosPorPeso.length; i++) {
      const rango = preciosPorPeso[i].rango;
      if (peso >= rango[0] && peso <= rango[1]) {
        return preciosPorPeso[i].precio;
      }
    }
    return 0; // Retorna 0 si no se encuentra un rango adecuado
  }

  // Función para actualizar el precio total
  function actualizarPrecio() {

    const peso = parseFloat(pesoInput.val()) || 0;
    let precioFinal = 0;

    // Obtener precio basado en el peso
    precioFinal += obtenerPrecioPorPeso(peso);

    // Sumar el precio base de la categoría (obtenido vía AJAX)
    precioFinal += precioBaseCategoria;

    // Mostrar el precio total en el input
    precioInput.val(precioFinal.toFixed(2));
  }

  // Función para obtener el precio de la categoría vía AJAX usando jQuery
  function obtenerPrecioPorCategoria(idCategoria) {
    if (idCategoria) {
      console.log(`Obteniendo precio de la categoría con id: ${idCategoria}`);

      // Realizamos la llamada AJAX
      $.ajax({
        type: 'POST',
        url: 'ajax/categoria.ajax.php',
        data: { idCategoria: idCategoria },
        dataType: 'json',
        success: function (respuesta) {
          if (respuesta && respuesta.precio) {
            precioBaseCategoria = parseFloat(respuesta.precio);
            console.log(`Precio base de la categoría actualizado a: ${precioBaseCategoria}`);
            actualizarPrecio();
          } else {
            console.log("Error: No se obtuvo el precio de la categoría.");
            precioBaseCategoria = 0;
            actualizarPrecio();
          }
        },
        error: function (xhr, status, error) {
          console.error("Error en la solicitud AJAX: ", error);
        }
      });
    } else {
      precioBaseCategoria = 0;
      actualizarPrecio();
    }
  }

  // Eventos de cambio y entrada de datos
  pesoInput.on('input', actualizarPrecio); // Actualiza el precio cuando se cambia el peso
  tipoPaqueteSelect.on('change', function () {
    var idCategoria = $(this).val();
    obtenerPrecioPorCategoria(idCategoria); // Obtener el precio por categoría cuando cambia la selección
  });

});



$(document).on("click", ".btnEditarPaquete", function () {
  var idPaquete = $(this).attr("idPaquete");

  $.ajax({
    url: "ajax/paquetes.ajax.php",
    method: "POST",
    data: { idPaquete: idPaquete, action: 'get' },
    dataType: "json",

    success: function (response) {
      console.log(response); // Verificar el contenido completo de response
      if (response) {
        // Asegúrate de que el valor de precio está disponible
        var precio = response.precio ? parseFloat(response.precio).toFixed(2) : 0.00;

        var htmlContent = `
          <input type="text" class="form-control" id="precio" value="${precio}" readonly>
          <input type="hidden" id="idPagos" name="idPagos" value="${response.idPagos}">
          <input type="hidden" id="idPaquete" name="idPaquete" value="${response.id}">
          <div class="container">
            <!-- Campos del formulario -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Número de Rastreo:</label>
                <input type="text" class="form-control" id="nro_registro" value="${response.nro_registro}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Estado del Paquete:</label>
                <select class="form-select" id="estadoPaquete">
                  <option value="0" ${response.estadoPaquete == 0 ? 'selected' : ''}>Recepcionado</option>
                  <option value="1" ${response.estadoPaquete == 1 ? 'selected' : ''}>En camino</option>
                  <option value="2" ${response.estadoPaquete == 2 ? 'selected' : ''}>Recepcionado</option>
                  <option value="3" ${response.estadoPaquete == 3 ? 'selected' : ''}>Entregado</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Cantidad:</label>
                <input type="text" class="form-control" id="cantidad" value="${response.cantidad || 1}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Precio:</label>
                <input type="text" class="form-control" id="precio" value="${precio}" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" value="${response.descripcion || 'Sin descripción'}" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Estado del Pago:</label>
                <select class="form-select" id="estadoPago">
                  <option value="0" ${response.estadoPago == 0 ? 'selected' : ''}>Debe</option>
                  <option value="1" ${response.estadoPago == 1 ? 'selected' : ''}>Pagado</option>
                  <option value="2" ${response.estadoPago == 2 ? 'selected' : ''}>Pagado QR</option>
                </select>
              </div>
            </div>
          </div>
        `;
        $("#modal-body-content").html(htmlContent);
      } else {
        console.log("No se pudo recuperar la información del paquete");
      }
    },
    error: function (xhr, status, error) {
      console.log("Error:", error);
    }
  });
});

$(document).on("click", "#update-status-btn", function () {
  var idPaquete = $("#idPaquete").val();
  var estadoPaquete = $("#estadoPaquete").val();
  var estadoPago = $("#estadoPago").val();
  var idPagos = $("#idPagos").val();

  // Si el estado de pago es QR, hacemos la petición para generar el QR primero
  if (estadoPago == 2) { // 2 es el valor de "Pagado QR"

    Swal.fire({
      title: 'Generando QR...',
      text: 'Por favor espere mientras obtenemos el monto y generamos el código QR',
      showConfirmButton: false,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    // Hacemos una solicitud AJAX para obtener el precio
    $.ajax({
      url: 'ajax/paquetes.ajax.php',
      method: 'POST',
      data: {
        idPaquete: idPaquete,
        action: 'getPrecio'  // Acción para obtener el precio
      },
      success: function (response) {
        console.log("Respuesta del servidor para obtener el precio: ", response);  // Verificar la respuesta
        var res = JSON.parse(response);

        if (res.status == 'ok') {
          var monto = res.precio;
          console.log("Precio obtenido: ", monto);  // Verificar el monto obtenido

          // Ahora generamos el QR con el monto obtenido
          generarQR(monto, idPaquete, estadoPaquete, estadoPago, idPagos);

        } else {
          Swal.fire({
            title: 'Error',
            text: 'No se pudo obtener el precio del paquete.',
            icon: 'error'
          });
        }
      },
      error: function (xhr, status, error) {
        console.error('Error en la solicitud AJAX para obtener el precio:', error);
        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al obtener el precio.',
          icon: 'error'
        });
      }
    });

  } else {
    // Si no es "Pagado QR", simplemente actualizamos el estado
    actualizarEstadoPaquete(idPaquete, estadoPaquete, estadoPago, idPagos);
  }
});

// Función para generar el QR después de obtener el precio
function generarQR(monto, idPaquete, estadoPaquete, estadoPago, idPagos) {
  console.log("Monto recibido para generar QR:", monto); // Verificar el monto antes de generar el QR
  // Hacemos una solicitud AJAX para generar el QR
  $.ajax({
    url: 'ajax/generar_qr.php', // Archivo PHP que manejará la generación del QR
    method: 'POST',
    data: {
      monto: monto // Enviamos el monto para generar el QR
    },
    success: function (response) {
      console.log("Respuesta de generar_qr.php: ", response);  // Verificar la respuesta del servidor
      var res = JSON.parse(response);
      if (res.Codigo == 0) {
        // Si se generó correctamente, mostramos el QR en un SweetAlert
        var qrImage = 'data:image/png;base64,' + res.Data.qr;
        console.log("QR generado (base64):", qrImage);  // Verificar el QR generado

        Swal.fire({
          title: 'Código QR Generado',
          html: 'Escanea el siguiente QR para realizar el pago.',
          imageUrl: qrImage,
          imageWidth: 300,
          imageHeight: 300,
          showCancelButton: true,
          cancelButtonText: 'Cerrar', // Cambiamos el texto a "Cerrar" para mayor claridad
          showConfirmButton: false,   // No mostrar botón de confirmación
        });

      } else {
        Swal.fire({
          title: 'Error',
          text: res.Mensaje || 'No se pudo generar el código QR.',
          icon: 'error'
        });
      }
    },
    error: function (xhr, status, error) {
      console.error('Error en la solicitud AJAX:', error);
      Swal.fire({
        title: 'Error',
        text: 'Ocurrió un error al generar el código QR.',
        icon: 'error'
      });
    }
  });
}


// Función para actualizar el estado del paquete
function actualizarEstadoPaquete(idPaquete, estadoPaquete, estadoPago, idPagos) {
  console.log("Actualizando el estado del paquete. ID:", idPaquete);  // Verificar el ID del paquete
  $.ajax({
    url: 'ajax/paquetes.ajax.php',
    method: 'POST',
    data: {
      idPaquete: idPaquete,
      estadoPaquete: estadoPaquete,
      estadoPago: estadoPago,
      idPagos: idPagos,
      action: 'updateStatus'
    },
    dataType: "json",
    success: function (response) {
      if (response.status === 'ok') {
        Swal.fire({
          title: 'Actualización Exitosa',
          text: response.message,
          icon: 'success'
        }).then(() => {
          location.reload(); // Recargar la página después de la actualización
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: response.message || 'No se pudo actualizar el estado.',
          icon: 'error'
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud Ajax:", error);
      Swal.fire({
        title: 'Error',
        text: 'Ocurrió un error al intentar actualizar el estado.',
        icon: 'error'
      });
    }
  });
}






$(document).ready(function () {
  $('input[name="cedula_enviador"]').on('blur', function () {
    var cedula = $(this).val();
    if (cedula) {
      $.ajax({
        type: 'POST',
        url: 'ajax/cliente.ajax.php',
        data: { cedula: cedula, tipo: 1 }, // tipo 1 para remitente
        success: function (response) {
          var data = JSON.parse(response);
          if (data.existe) {
            var cliente = data.cliente;
            $('input[name="nombre_enviador"]').val(cliente.nombre);
            $('input[name="telefono_enviador"]').val(cliente.telefono);
            $('input[name="direccion_enviador"]').val(cliente.direccion);
            $('#mensajeClienteEnviador').remove();
          } else {
            if (!$('#mensajeClienteEnviador').length) {
              $('input[name="cedula_enviador"]').after('<span id="mensajeClienteEnviador" class="text-dark">Cliente no registrado, se registrará este cliente.</span>');
            }
            $('input[name="nombre_enviador"]').val('');
            $('input[name="telefono_enviador"]').val('');
            $('input[name="direccion_enviador"]').val('');
          }
        }
      });
    }
  });

  $('input[name="cedula_remitente"]').on('blur', function () {
    var cedula = $(this).val();
    if (cedula) {
      $.ajax({
        type: 'POST',
        url: 'ajax/cliente.ajax.php',
        data: { cedula: cedula, tipo: 2 }, // tipo 2 para destinatario
        success: function (response) {
          var data = JSON.parse(response);
          if (data.existe) {
            var cliente = data.cliente;
            $('input[name="nombre_remitente"]').val(cliente.nombre);
            $('input[name="telefono_remitente"]').val(cliente.telefono);
            $('input[name="direccion_remitente"]').val(cliente.direccion);
            $('#mensajeClienteRemitente').remove();
          } else {
            if (!$('#mensajeClienteRemitente').length) {
              $('input[name="cedula_remitente"]').after('<span id="mensajeClienteRemitente" class="text-dark">Cliente no registrado, se registrará este cliente.</span>');
            }
            $('input[name="nombre_remitente"]').val('');
            $('input[name="telefono_remitente"]').val('');
            $('input[name="direccion_remitente"]').val('');
          }
        }
      });
    }
  });
});





$(document).on("click", ".btnImprimirPaquete", function () {
  var idPaquete = $(this).attr("idPaquete");
  $.ajax({
    url: "ajax/paquetes.ajax.php",
    method: "POST",
    data: { idPaquete: idPaquete, action: 'generatePDF' },
    success: function (response) {
      var res = JSON.parse(response);
      if (res.status == 'ok') {
        var pdfWindow = window.open("");
        pdfWindow.document.write(
          "<iframe width='100%' height='100%' src='data:application/pdf;base64," + encodeURI(res.pdfData) + "'></iframe>"
        );
      } else {
        alert("Error al generar el PDF: " + res.message);
      }
    },
    error: function (error) {
      console.log("Error:", error);
      alert("Error al procesar la solicitud");
    }
  });
});


