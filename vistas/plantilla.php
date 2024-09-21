<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <!--  Title -->
  <title>Mordenize</title>
  <!--  Required Meta Tag -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="handheldfriendly" content="true" />
  <meta name="MobileOptimized" content="width" />
  <meta name="description" content="Mordenize" />
  <meta name="author" content="" />
  <meta name="keywords" content="Mordenize" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!--  Favicon -->
  <link rel="shortcut icon" type="image/png" href="vistas/dist/images/logos/favicon.ico" />

  <!-- --------------------------------------------------- -->
  <!-- Prism Js -->
  <!-- --------------------------------------------------- -->
  <link rel="stylesheet" href="vistas/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="vistas/dist/libs/prismjs/themes/prism-okaidia.min.css">

  <link rel="stylesheet" href="vistas/dist/libs/jquery-raty-js/lib/jquery.raty.css">
  <link rel="stylesheet" href="vistas/dist/libs/sweetalert2/dist/sweetalert2.min.css">
  <!-- --------------------------------------------------- -->
  <!-- Datatable -->
  <!-- --------------------------------------------------- -->
  <link rel="stylesheet" href="vistas/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">


  <!-- Core Css -->
  <link id="themeColors" rel="stylesheet" href="vistas/dist/css/style.css" />

  <script src="vistas/dist/js/plugins/toastr-init.js"></script>

  <style>
    .input-group {
      margin-bottom: 20px;
    }

    .dataTables_filter {
      display: none;
      /* Oculta el cuadro de búsqueda predeterminado de DataTables */
    }

    body {
      font-family: 'Roboto', sans-serif;

    }
  </style>
</head>

<body>
  <?php

  echo '<div class="page-wrapper" id="main-wrapper" data-theme="blue_theme"  data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
';

  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

    echo '';
    // Verificar el perfil del usuario
    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 5) {

      include "modulos/empresa/navbar_empresa.php";
      echo '<div class="body-wrapper">';

      include "modulos/empresa/menu_empresa.php";

      /*=============================================
      CONTENIDO
      =============================================*/

      if (isset($_GET["ruta"])) {

        if (
          $_GET["ruta"] == "enviosempresa" ||
          $_GET["ruta"] == "registrarenv" ||
          $_GET["ruta"] == "listaenvios" ||
          $_GET["ruta"] == "pagoexitoso" ||
          $_GET["ruta"] == "cliente" ||
          $_GET["ruta"] == "sucursal" ||
          $_GET["ruta"] == "categoria" ||
          $_GET["ruta"] == "reportesx" ||
          $_GET["ruta"] == "ajustes" ||
          $_GET["ruta"] == "logout"
        ) {
          include "modulos/empresa/" . $_GET["ruta"] . ".php";
          echo '</div>';
        } else {
          include "modulos/404.php";
        }
      } else {
        // Si no se especifica una ruta y el perfil es 5, redirigir automáticamente a "envios_empresa"
        header("Location: index.php?ruta=enviosempresa");
        exit();
      }
    } else {

      /*=============================================
      NAVBAR
      =============================================*/

      include "modulos/navbar.php";

      /*=============================================
      MENU
      =============================================*/
      echo '<div class="body-wrapper">';
      include "modulos/menu.php";

      /*=============================================
      CONTENIDO
      =============================================*/

      if (isset($_GET["ruta"])) {

        if (
          $_GET["ruta"] == "inicio" ||
          $_GET["ruta"] == "registrarenv" ||
          $_GET["ruta"] == "listaenvios" ||
          $_GET["ruta"] == "pagoexitoso" ||
          $_GET["ruta"] == "cliente" ||
          $_GET["ruta"] == "sucursal" ||
          $_GET["ruta"] == "categoria" ||
          $_GET["ruta"] == "pagos" ||
          $_GET["ruta"] == "reportesx" ||
          $_GET["ruta"] == "usuarios" ||
          $_GET["ruta"] == "envios_empresa" ||
          $_GET["ruta"] == "logout"
        ) {
          include "modulos/" . $_GET["ruta"] . ".php";
        } else {
          include "modulos/404.php";
        }
      } else {
        include "modulos/inicio.php";
      }

      include "modulos/footer.php";

      echo '</div>';
    }
  } else {
    include "modulos/login.php";
  }
  ?>



  <!--  Import Js Files -->
  <script src="vistas/dist/libs/jquery/dist/jquery.min.js"></script>

  <script src="vistas/dist/js/dashboard.js"></script>



  <!-- Moment.js -->
  <script src="vistas/dist/libs/moment-js/build/moment.min.js"></script>

  <!-- Owl Carousel -->
  <script src="vistas/dist/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="vistas/dist/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="vistas/dist/libs/apexcharts/dist/apexcharts.min.js"></script>


  <!-- SimpleBar -->
  <script src="vistas/dist/libs/simplebar/dist/simplebar.min.js"></script>

  <!-- Bootstrap Bundle -->
  <script src="vistas/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- PrismJS (for code highlighting) -->
  <script src="vistas/dist/libs/prismjs/prism.js"></script>

  <!-- Core JS Files -->
  <script src="vistas/dist/js/app.min.js"></script>
  <script src="vistas/dist/js/app.init.js"></script>
  <script src="vistas/dist/js/app-style-switcher.js"></script>
  <script src="vistas/dist/js/sidebarmenu.js"></script>

  <!-- Custom JS -->
  <script src="vistas/dist/js/custom.js"></script>

  <!-- Contact JS -->
  <script src="vistas/dist/js/apps/contact.js"></script>

  <!-- Form Wizard and Validation -->
  <script src="vistas/dist/libs/jquery-steps/build/jquery.steps.min.js"></script>
  <script src="vistas/dist/libs/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="vistas/dist/js/forms/form-wizard.js"></script>

  <!-- DataTables -->
  <script src="vistas/dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/dist/js/datatable/datatable-basic.init.js"></script>

  <!-- Sweet Alert -->
  <script src="vistas/dist/js/forms/sweet-alert.init.js"></script>

  <!-- Dashboard and Toastr Init -->
  <script src="vistas/dist/js/dashboard.js"></script>
  <script src="vistas/dist/js/plugins/toastr-init.js"></script>

  <!-- Custom Scripts per page -->
  <script src="vistas/js/plantilla.js"></script>
  <script src="vistas/js/sucursal.js"></script>
  <script src="vistas/js/cliente.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/paquetes.js"></script>



</body>

</html>