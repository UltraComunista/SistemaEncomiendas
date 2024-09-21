
<?php

require_once "controladores/controlador.plantilla.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/sucursales.controlador.php";
require_once "controladores/paquetes.controlador.php";
require_once "controladores/cliente.controlador.php";
require_once "controladores/categoria.controlador.php";
require_once "controladores/pagos.controlador.php";


require_once "api/controladores/apienvios.controller.php";
require_once "api/controladores/auth.controller.php";

require_once "api/routes/routes.php";

require_once "modelos/cliente.modelo.php";
require_once "modelos/categoria.modelo.php";
require_once "modelos/sucursal.modelo.php";
require_once "modelos/paquetes.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/pagos.modelo.php";


$plantilla = new ControladorPlantilla();
$plantilla->ctrControlador();
