<?php

require_once "conexion.php";

class ModeloPagos
{
    /*=============================================
    MOSTRAR PAGOS
    =============================================*/
    static public function mdlMostrarPagos($tabla, $item = null, $valor = null)
    {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();
        $stmt = null;
    }
    // Función para crear un nuevo pago
    static public function mdlCrearPago($tabla, $datos)
    {
        $db = Conexion::conectar();
        try {
            // Preparar la consulta SQL para insertar un nuevo pago
            $stmt = $db->prepare("INSERT INTO $tabla (idTransaccion, metodoPago, estadoPago, monto) 
                                  VALUES (:idTransaccion, :metodoPago, :estadoPago, :monto)");

            // Bind de los parámetros
            $stmt->bindParam(":idTransaccion", $datos["idTransaccion"], PDO::PARAM_INT);
            $stmt->bindParam(":metodoPago", $datos["metodoPago"], PDO::PARAM_INT);
            $stmt->bindParam(":estadoPago", $datos["estadoPago"], PDO::PARAM_INT);
            $stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return $db->lastInsertId(); // Devolver el ID del último pago insertado
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            error_log("Error al insertar el pago: " . $e->getMessage());
            return "error";
        }
    }
    static public function mdlActualizarEstadoPago($idPagos, $estadoPago)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE pagos SET estadoPago = :estadoPago WHERE id = :idPagos");

        $stmt->bindParam(":estadoPago", $estadoPago, PDO::PARAM_INT);
        $stmt->bindParam(":idPagos", $idPagos, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
}
