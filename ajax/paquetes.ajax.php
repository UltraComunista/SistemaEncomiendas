<?php
require_once "../controladores/paquetes.controlador.php";
require_once "../modelos/paquetes.modelo.php";

// Iniciar la sesión si no se ha iniciado aún
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    error_log("Action received: $action"); // Log para verificar qué acción se recibe

    // Acción para crear un paquete
    if ($action == 'createPaquete') {
        error_log("Calling create package function...");

        // Llama a la función del controlador que maneja la creación del paquete
        $respuesta = ControladorPaquetes::ctrCrearPaquete();

        // Verifica si se creó el paquete correctamente
        if (isset($respuesta['status']) && $respuesta['status'] === 'ok') {
            $idPaquete = $respuesta['idPaquete']; // Obtenemos el id del paquete si es necesario
            echo json_encode(['status' => 'ok', 'idPaquete' => $idPaquete]);
        } else {
            // Si hay error, devolvemos el mensaje de error
            echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar el paquete.']);
        }
    }

    // Acción para obtener los datos de un paquete
    if ($action == 'get') {
        $idPaquete = $_POST['idPaquete'];
        $item = 'id';
        $valor = $idPaquete;
        $respuesta = ControladorPaquetes::ctrMostrarPaquetes($item, $valor);
        echo json_encode($respuesta);
    }

    // Acción para actualizar el estado del paquete y el estado de pago
    if ($action == 'updateStatus') {
        $idPaquete = $_POST['idPaquete'];
        $estadoPaquete = $_POST['estadoPaquete'];
        $estadoPago = $_POST['estadoPago'];  // Esto viene del select en el modal
        $idPagos = $_POST['idPagos']; // Asegúrate de que el idPagos esté en el formulario o lo consigas por AJAX
        $idUsuario = $_SESSION['idUsuario']; // Obtén el idUsuario de la sesión

        $datos = array(
            "id" => $idPaquete,
            "estadoPaquete" => $estadoPaquete,
            "estadoPago" => $estadoPago,
            "idPagos" => $idPagos,  // ID de la tabla pagos para actualizar el estado
            "idUsuario" => $idUsuario
        );

        $respuesta = ControladorPaquetes::ctrActualizarPaquete($datos);

        if ($respuesta == "ok") {
            echo json_encode(['status' => 'ok', 'message' => 'Estado actualizado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el estado.']);
        }
    }
    if ($action == 'getPrecio') {
        $idPaquete = $_POST['idPaquete'];
        $response = ModeloPaquetes::mdlObtenerPrecio($idPaquete);

        if ($response) {
            echo json_encode(['status' => 'ok', 'precio' => $response['monto']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo obtener el precio']);
        }
    }
}
