<?php

require_once "conexion.php";

class ModeloCategoria
{
    /*=============================================
    MOSTRAR CATEGORIA
    =============================================*/
    static public function mdlMostrarCategoria($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(); // Solo devolvemos una fila
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();

            return $stmt->fetchAll(); // Devolvemos todas las categorías
        }

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
    /*=============================================
    EDITAR CATEGORÍA
    =============================================*/
    static public function mdlEditarCategoria($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, precio = :precio WHERE id = :id");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR); // Usamos PARAM_STR para DECIMAL
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
}
