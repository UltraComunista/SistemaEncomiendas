<?php

class CallbackController
{
    // Método para manejar los datos del callback
    public static function handleCallback()
    {
        // Recibe datos enviados por POST en formato JSON
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        if ($data) {
            // Aquí puedes procesar los datos recibidos
            // Por ejemplo, puedes verificar el estado de pago y actualizar en tu sistema
            error_log("Datos recibidos en el callback: " . print_r($data, true));

            // Lógica para manejar los datos, por ejemplo, actualizar estado de pagos
            $movimiento_id = $data['movimiento_id'];
            $estado = $data['estado'];
            $monto = $data['monto'];

            // Puedes agregar una actualización a la base de datos aquí usando el modelo correspondiente
            // Ejemplo:
            // ModeloPagos::mdlActualizarEstadoPago($movimiento_id, $estado, $monto);

            // Responder a la petición para confirmar recepción
            JsonResponse::sendResponse(200, ['message' => 'Callback recibido exitosamente.']);
        } else {
            // Si no llegan datos o es incorrecto
            JsonResponse::sendResponse(400, ['message' => 'No se recibieron datos válidos.']);
        }
    }
}
