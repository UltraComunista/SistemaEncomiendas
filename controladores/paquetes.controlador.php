<?php

require __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que esta ruta es correcta
// Asegúrate de que el path sea correcto según tu estructura de carpetas
require_once __DIR__ . '/usuarios.controlador.php';

require_once "/var/www/html/SistemaEncomiendas/modelos/pagos.modelo.php";  // Asegúrate de que esta línea está presente y bien escrita

use Twilio\Rest\Client;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class ControladorPaquetes
{
    public static function ctrObtenerEnviosPorUsuario($idUsuario)
    {
        $tabla = "recepcionEncomienda";
        $envios = ModeloPaquetes::mdlObtenerEnviosPorUsuario($tabla, $idUsuario);

        return $envios;
    }

    /*=============================================
    MOSTRAR PAQUETES
    =============================================*/
    static public function ctrMostrarPaquetes($item, $valor)
    {
        $tabla = "recepcionEncomienda";
        $respuesta = ModeloPaquetes::mdlMostrarPaquetes($tabla, $item, $valor);
        return $respuesta;
    }

    static public function ctrCrearPaquete()
    {
        if (isset($_POST["cedula_enviador"])) {
            // En tu función ctrCrearPaquete o en cualquier parte donde se genere la salida
            ob_start(); // Iniciar el buffer de salida
            error_log("POST request received for package creation");

            // Validación de campos requeridos
            $errores = [];

            // Validamos cada campo que esperamos recibir
            if (!preg_match('/^[0-9]+$/', $_POST["cedula_enviador"])) {
                $errores[] = "Cédula del enviador es inválida.";
            }
            if (empty($_POST["nombre_enviador"])) {
                $errores[] = "El nombre del enviador no puede estar vacío.";
            }

            // Si hay errores, retornamos un JSON con los errores
            if (!empty($errores)) {
                error_log("Validation failed: " . implode(", ", $errores));
                return json_encode(['status' => 'error', 'message' => implode(", ", $errores)]);
            }

            // Si no hay errores, continuar con el proceso de registro
            error_log("Validation passed, proceeding to insert data.");

            $proximoNumeroRegistro = self::ctrObtenerSiguienteNumeroRegistro();
            error_log("Next registration number: $proximoNumeroRegistro");

            $tabla = "recepcionEncomienda";
            $fechaRecepcion = date("Y-m-d H:i:s");
            $sucursalLlegadaNombre = self::ctrObtenerNombreSucursal($_POST["sucursalLlegada"]);
            $idUsuario = $_SESSION['idUsuario'];

            // Preparamos los datos para la inserción
            $datos = array(
                "nro_registro" => (int)$proximoNumeroRegistro,
                "cedula_enviador" => (int)$_POST["cedula_enviador"],
                "nombre_enviador" => $_POST["nombre_enviador"],
                "telefono_enviador" => $_POST["telefono_enviador"],
                "direccion_enviador" => $_POST["direccion_enviador"],
                "cedula_remitente" => (int)$_POST["cedula_remitente"],
                "nombre_remitente" => $_POST["nombre_remitente"],
                "telefono_remitente" => $_POST["telefono_remitente"],
                "direccion_remitente" => $_POST["direccion_remitente"],
                "sucursalPartida" => (int)$_POST["sucursalPartida"],
                "sucursalLlegada" => (int)$_POST["sucursalLlegada"],
                "fechaRecepcion" => $fechaRecepcion,
                "tipoEnvio" => $_POST["tipoPaquete"],  // Siempre "Normal"
                "estadoPaquete" => 0,  // Estado "Recepcionado"
                "descripcion" => $_POST["descripcion"],
                "cantidad" => (int)$_POST["cantidad"],
                "precio" => (float)$_POST["precio"],
                "tipoPaquete" => (int)$_POST["tipoPaquete"],
                "peso" => (float)$_POST["pesoPaquete"],
                "idUsuario" => (int)$idUsuario
            );

            error_log("Datos para insertar: " . json_encode($datos));

            // Insertar los datos del paquete
            $respuesta = ModeloPaquetes::mdlIngresarPaquete($tabla, $datos);

            if ($respuesta == "ok") {
                error_log("Package insertion successful.");

                // Registrar el pago
                $pagoData = array(
                    "idTransaccion" => $proximoNumeroRegistro,
                    "metodoPago" => 0,  // No pagado inicialmente
                    "estadoPago" => 0,  // Por pagar
                    "monto" => (float)$_POST["precio"]
                );
                $idPago = ModeloPagos::mdlCrearPago("pagos", $pagoData);

                error_log("Payment record created with ID: $idPago");

                // Actualizar el paquete con el id del pago
                ModeloPaquetes::mdlActualizarPagoEnPaquete($tabla, $proximoNumeroRegistro, $idPago);

                // Notificación por WhatsApp
                self::enviarNotificacionWhatsApp(
                    $_POST["telefono_remitente"],
                    $_POST["nombre_remitente"],
                    $proximoNumeroRegistro,
                    $sucursalLlegadaNombre
                );
                ob_end_clean(); // Limpiar el buffer de salida antes de devolver la respuesta
                // Devolver la respuesta en formato JSON con el id del paquete creado
                return ['status' => 'ok', 'idPaquete' => $proximoNumeroRegistro];
            } else {
                error_log("Failed to insert package. Data: " . json_encode($datos));
                return ['status' => 'error', 'message' => 'No se pudo registrar el paquete.'];
            }
        } else {
            error_log("No POST data received for package creation.");
            return ['status' => 'error', 'message' => 'No se recibieron los datos necesarios para el registro.'];
        }
    }
    public static function ctrCrearPaqueteAPI($data, $userId)
    {
        try {
            // Generar número de registro u otros datos necesarios
            $proximoNumeroRegistro = self::ctrObtenerSiguienteNumeroRegistro();
            if (!$proximoNumeroRegistro) {
                error_log("Error: No se pudo generar el número de registro.");
                return ['status' => 'error', 'message' => 'No se pudo generar el número de registro.'];
            }

            // Obtener los datos del usuario (empresa) desde el ID
            $usuario = ControladorUsuarios::ctrObtenerUsuarioPorId($userId);
            if (!$usuario) {
                error_log("Error: No se pudo obtener el usuario con ID $userId.");
                return ['status' => 'error', 'message' => 'No se pudo obtener el usuario.'];
            }

            // Calcular el precio basado en el peso
            $precio = self::calcularPrecio($data['pesoPaquete'], $data['tipoPaquete']);
            error_log("Precio calculado: " . $precio);

            $datos = array(
                "nro_registro" => $proximoNumeroRegistro,
                "cedula_remitente" => $data["cedula_remitente"],
                "nombre_remitente" => $data["nombre_remitente"],
                "telefono_remitente" => $data["telefono_remitente"],
                "direccion_remitente" => $data["direccion_remitente"],
                "sucursalPartida" => $data["sucursalPartida"],
                "sucursalLlegada" => $data["sucursalLlegada"],
                "fechaRecepcion" => date("Y-m-d H:i:s"),
                "tipoEnvio" => $data["tipoEnvio"],
                "estadoPago" => 0,
                "estadoPaquete" => 0,
                "descripcion" => $data["descripcion"],
                "cantidad" => $data["cantidad"],
                "precio" => $precio, // Usar el precio calculado
                "tipoPaquete" => $data["tipoPaquete"],
                "idUsuario" => $userId,
                "nombre_enviador" => $usuario['nombre'],
                "cedula_enviador" => $usuario['cedula'],
                "telefono_enviador" => $usuario['telefono'],
                "direccion_enviador" => $usuario['direccion'],
                "peso" => (float)$data["pesoPaquete"]
            );

            // Registrar los datos antes de insertarlos
            error_log("Datos a insertar: " . print_r($datos, true));

            // Insertar en la base de datos usando el modelo
            $respuesta = ModeloPaquetes::mdlIngresarPaqueteAPI("recepcionEncomienda", $datos);

            if ($respuesta == "ok") {
                $idPaquete = ModeloPaquetes::mdlObtenerUltimoId("recepcionEncomienda");

                // Enviar notificación por WhatsApp (si es necesario)
                self::enviarNotificacionWhatsApp(
                    $data["telefono_remitente"],
                    $data["nombre_remitente"],
                    $proximoNumeroRegistro,
                    self::ctrObtenerNombreSucursal($data["sucursalLlegada"])
                );

                return [
                    'status' => 'ok',
                    'id' => $idPaquete,
                    'nro_registro' => $proximoNumeroRegistro,
                    'sucursalLlegada' => self::ctrObtenerNombreSucursal($data["sucursalLlegada"]),
                    'precio' => $precio
                ];
            } else {
                error_log("Error en la inserción del paquete: " . $respuesta);
                return ['status' => 'error', 'message' => 'Error al insertar el paquete en la base de datos.'];
            }
        } catch (Exception $e) {
            error_log("Excepción capturada: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    // Nueva función para calcular el precio basado en el peso y tipo de paquete
    private static function calcularPrecio($peso, $tipoPaquete)
    {
        $preciosPorPeso = [
            [0.01, 1, 35.00],
            [1.01, 2, 60.00],
            [2.01, 3, 70.00],
            [3.01, 4, 80.00],
            [4.01, 5, 90.00],
            [5.01, 6, 110.00],
            [6.01, 7, 110.00],
            [7.01, 8, 120.00],
            [8.01, 9, 130.00],
            [9.01, 10, 140.00],
            [10.01, 12, 160.00],
            [12.01, 15, 190.00],
            [15.01, 20, 240.00],
        ];

        $preciosPorTipo = [
            1 => 15.00, // Electrónico
            2 => 10.00, // Indumentaria
            3 => 30.00, // Juguetes
            4 => 40.00, // Mercaderia
        ];

        $precioPorPeso = 0;
        foreach ($preciosPorPeso as $rango) {
            if ($peso >= $rango[0] && $peso <= $rango[1]) {
                $precioPorPeso = $rango[2];
                break;
            }
        }

        $precioPorTipo = $preciosPorTipo[$tipoPaquete] ?? 0;

        return $precioPorPeso + $precioPorTipo;
    }

    /*=============================================
    OBTENER NOMBRE DE SUCURSAL
    =============================================*/
    static public function ctrObtenerNombreSucursal($idSucursal)
    {
        $tabla = "sucursal";
        $respuesta = ModeloPaquetes::mdlMostrarSucursales($tabla, "id", $idSucursal);
        return $respuesta["nombre"];
    }

    /*=============================================
    ENVIAR NOTIFICACION WHATSAPP
    =============================================*/
    public static function enviarNotificacionWhatsApp($telefonoRemitente, $nombreRemitente, $numeroRegistro, $sucursalLlegada)
    {
        // Las credenciales de Twilio
        $sid = $_ENV['TWILIO_SID'];
        $token = $_ENV['TWILIO_TOKEN'];
        $twilio = new Client($sid, $token);

        // Número de WhatsApp de origen
        $numeroWhatsAppOrigen = $_ENV['TWILIO_WHATSAPP_NUMBER']; // Este es el número de Twilio para WhatsApp

        // Número de WhatsApp de destino
        $numeroWhatsAppDestino = 'whatsapp:' . $telefonoRemitente;

        // Enviar mensaje
        $mensaje = $twilio->messages
            ->create(
                $numeroWhatsAppDestino, // Destino
                array(
                    'from' => $numeroWhatsAppOrigen, // Origen
                    'body' => "Hola $nombreRemitente, tu paquete con número de seguimiento $numeroRegistro ha sido enviado y llegará a la sucursal $sucursalLlegada."
                )
            );

        // Imprimir SID del mensaje para verificar
        echo $mensaje->sid;
    }


    static public function ctrActualizarPaquete($datos)
    {
        $tabla = "recepcionEncomienda"; // Tabla principal

        // Actualizar el estado del paquete
        $respuesta = ModeloPaquetes::mdlActualizarPaquete($tabla, $datos);

        // Si el paquete se actualiza correctamente, actualizar el estado del pago
        if ($respuesta == "ok" && isset($datos["idPagos"])) {
            $estadoPago = $datos["estadoPago"]; // Asegúrate de que el estadoPago se envíe correctamente
            $idPagos = $datos["idPagos"];
            $respuestaPago = ModeloPagos::mdlActualizarEstadoPago($idPagos, $estadoPago);

            if ($respuestaPago == "ok") {
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }


    /*=============================================
    BORRAR SUCURSAL
    =============================================*/
    static public function ctrBorrarSucursal()
    {
        if (isset($_GET["idSucursal"])) {
            $tabla = "recepcionEncomienda";
            $idSucursal = $_GET["idSucursal"];

            $respuesta = ModeloSucursales::mdlBorrarSucursal($tabla, $idSucursal);

            if ($respuesta == "ok") {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.success('El sucursal ha sido eliminada', '¡Éxito!');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
            } else {
                echo "<script>
                window.addEventListener('load', function() {
                    toastr.error('No se pudo eliminar el sucursal.', 'Error');
                    setTimeout(function() {
                        window.location = 'sucursal';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
                </script>";
            }
        }
    }

    /*=============================================
    OBTENER EL SIGUIENTE NÚMERO DE REGISTRO PARA FORMULARIO
    =============================================*/
    static public function ctrObtenerSiguienteNumeroRegistro()
    {
        $tabla = "recepcionEncomienda";
        $ultimoNumeroRegistro = ModeloPaquetes::mdlObtenerUltimoNumeroRegistro($tabla);

        // Incrementar el último número para el siguiente registro
        $proximoNumeroRegistro = (int)$ultimoNumeroRegistro + 1;

        return $proximoNumeroRegistro;
    }
}
