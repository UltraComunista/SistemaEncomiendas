<?php
require_once "../controladores/categoria.controlador.php";
require_once "../modelos/categoria.modelo.php";

class AjaxCategorias
{
    public $idCategoria;

    /*=============================================
    EDITAR CATEGORÍA
    =============================================*/
    public function ajaxEditarCategoria()
    {
        $item = "id";
        $valor = $this->idCategoria;

        // Obtener la respuesta completa de la categoría para editar
        $respuesta = ControladorCategoria::ctrMostrarCategorias($item, $valor);

        echo json_encode($respuesta); // Devolvemos la respuesta como JSON
    }

    /*=============================================
    OBTENER SOLO PRECIO DE CATEGORÍA
    =============================================*/
    public function ajaxObtenerPrecioCategoria()
    {
        $item = "id";
        $valor = $this->idCategoria;

        // Obtener solo el precio de la categoría para los cálculos
        $respuesta = ControladorCategoria::ctrMostrarCategorias($item, $valor);

        // Devolvemos solo el precio en formato JSON
        echo json_encode(['precio' => $respuesta['precio']]);
    }
}

// Verificamos si se solicita editar la categoría o solo obtener el precio
if (isset($_POST["idCategoria"])) {

    // Verificamos si se está solicitando el precio solamente
    if (isset($_POST["soloPrecio"]) && $_POST["soloPrecio"] == "true") {
        $precio = new AjaxCategorias();
        $precio->idCategoria = $_POST["idCategoria"];
        $precio->ajaxObtenerPrecioCategoria();
    }
    // Si no se especifica "soloPrecio", asumimos que se quiere editar la categoría
    else {
        $editar = new AjaxCategorias();
        $editar->idCategoria = $_POST["idCategoria"];
        $editar->ajaxEditarCategoria();
    }
}
