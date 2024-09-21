$(document).ready(function () {
  // Inicializar DataTable sin mostrar el campo de búsqueda predeterminado
  var table = $('.tablas').DataTable({
    scrollX: true,
    "searching": true, // Mantener la funcionalidad de búsqueda activa
    "language": {
      "lengthMenu": "Mostrar _MENU_ registros por página",
      "zeroRecords": "No se encontraron resultados",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(filtrado de _MAX_ registros totales)",
      "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
      }
    },
    "initComplete": function () {
      console.log('DataTable inicializado correctamente');
    }
  });

  // Asignar evento de búsqueda al input personalizado
  $('#buscar').on('keyup', function () {
    var searchTerm = $(this).val();
    table.search(searchTerm).draw(); // Filtrar la tabla de acuerdo a la búsqueda
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Verificar si hay un tema guardado en localStorage
  const savedTheme = localStorage.getItem('selectedTheme');
  const themeLink = document.getElementById("themeColors");

  // Si existe un tema guardado, aplicarlo antes de mostrar la página
  if (savedTheme) {
    themeLink.href = savedTheme;
  }

  // Mostrar la página una vez que el tema ha sido cargado
  document.body.style.visibility = "visible";

  // Función para cambiar de tema sin recargar la página
  function toggleTheme(themePath) {
    themeLink.href = themePath; // Cambiar el tema
    localStorage.setItem('selectedTheme', themePath); // Guardar el tema en localStorage
  }

  // Asignar eventos a los botones de Light y Dark
  document.getElementById("lightTheme").addEventListener("click", function () {
    toggleTheme('vistas/dist/css/style.min.css'); // Cambiar al tema claro
  });

  document.getElementById("darkTheme").addEventListener("click", function () {
    toggleTheme('vistas/dist/css/style-dark.min.css'); // Cambiar al tema oscuro
  });
});
