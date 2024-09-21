<?php

class ControladorCategoria
{
    /*=============================================
    MOSTRAR CATEGORIAS
    =============================================*/
    static public function ctrMostrarCategorias($item = null, $valor = null)
    {
        $tabla = "categoria";
        $respuesta = ModeloCategoria::mdlMostrarCategoria($tabla, $item, $valor);
        return $respuesta;
    }
    /*=============================================
    CREAR CATEGORÍA
    =============================================*/
    static public function ctrCrearCategoria()
    {
        if (isset($_POST["nuevoNombre"])) {
            // Validaciones básicas
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                is_numeric($_POST["nuevoPrecio"])
            ) {
                $tabla = "categoria";

                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "precio" => $_POST["nuevoPrecio"]
                );

                $respuesta = ModeloCategoria::mdlIngresarCategoria($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.success('La categoría ha sido guardada correctamente', '¡Éxito!');
                            setTimeout(function() {
                                window.location = 'categoria';
                            }, 2000);
                        });
                    </script>";
                } else {
                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.error('No se pudo registrar la categoría.', 'Error');
                            setTimeout(function() {
                                window.location = 'categoria';
                            }, 2000);
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    window.addEventListener('load', function() {
                        toastr.error('Datos incorrectos. Por favor, verifica la información ingresada.', 'Error');
                    });
                </script>";
            }
        }
    }
}
