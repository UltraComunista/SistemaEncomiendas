$(document).on("click", ".btnEditarCategoria", function () {
    var idCategoria = $(this).attr("idCategoria");  // Obtener el idCategoria

    if (idCategoria) {
        // Realizar la solicitud AJAX
        $.ajax({
            url: "ajax/categoria.ajax.php",
            method: "POST",
            data: { idCategoria: idCategoria },
            dataType: "json",
            success: function (respuesta) {
                if (Array.isArray(respuesta) && respuesta.length > 0) {
                    // Si es un array, accede al primer objeto
                    respuesta = respuesta[0];
                }

                // Precarga los datos en el modal
                $("#idCategoria").val(respuesta.id);
                $("#editarNombre").val(respuesta.nombre);
                $("#editarPrecio").val(respuesta.precio);
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX: ", error);
            }
        });

    } else {
        console.error("ID de categoría no encontrado.");
    }
});
