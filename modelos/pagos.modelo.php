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
}
