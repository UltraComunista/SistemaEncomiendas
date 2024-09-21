<?php

require_once "conexion.php";

class ModeloCategoria
{
    /*=============================================
    MOSTRAR CATEGORIA
    =============================================*/
    static public function mdlMostrarCategoria($tabla, $item = null, $valor = null)
    {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();
        $stmt = null;
    }
    /*=============================================
    INGRESAR CATEGORÍA
    =============================================*/
    static public function mdlIngresarCategoria($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, precio) VALUES (:nombre, :precio)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
}
