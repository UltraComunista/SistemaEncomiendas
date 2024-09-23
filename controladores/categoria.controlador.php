<?php

class ControladorCategoria
{
    /*=============================================
    MOSTRAR CATEGORIAS
    =============================================*/
    static public function ctrMostrarCategorias($item, $valor)
    {
        $tabla = "categoria";

        if ($item != null) {
            return ModeloCategoria::mdlMostrarCategoria($tabla, $item, $valor);  // Devuelve una categoría específica
        } else {
            return ModeloCategoria::mdlMostrarCategoria($tabla, null, null);  // Devuelve todas las categorías
        }
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
    /*=============================================
    EDITAR CATEGORÍA
    =============================================*/
    static public function ctrEditarCategoria()
    {
        if (isset($_POST["idCategoria"])) {
            // Validaciones básicas
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                is_numeric($_POST["editarPrecio"])
            ) {
                $tabla = "categoria";

                $datos = array(
                    "id" => $_POST["idCategoria"],
                    "nombre" => $_POST["editarNombre"],
                    "precio" => $_POST["editarPrecio"]
                );

                $respuesta = ModeloCategoria::mdlEditarCategoria($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.success('La categoría ha sido actualizada correctamente', '¡Éxito!');
                            setTimeout(function() {
                                window.location = 'categoria';
                            }, 2000);
                        });
                    </script>";
                } else {
                    echo "<script>
                        window.addEventListener('load', function() {
                            toastr.error('No se pudo actualizar la categoría.', 'Error');
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
