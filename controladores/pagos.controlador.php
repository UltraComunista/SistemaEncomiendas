<?php

class ControladorPagos
{
    /*=============================================
    MOSTRAR PAGOS
    =============================================*/
    static public function ctrMostrarPagos($item = null, $valor = null)
    {
        $tabla = "pagos";
        $respuesta = ModeloPagos::mdlMostrarPagos($tabla, $item, $valor);
        return $respuesta;
    }
}
