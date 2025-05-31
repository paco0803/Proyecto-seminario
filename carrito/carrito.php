<?php
$mensaje = "";

// Conexión a la base de datos
include ('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

//Definicion del id del usuario asignado al carrito
$id_usuario_carrito = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

if($id_usuario_carrito == null){
        header('location: ../landing/index.php');
        exit();
    }

//query para traer toda la informacion sobre el carrito del usuario
$query = "SELECT * FROM producto_carrito pc 
          INNER JOIN carritos_compra cc on pc.id_carrito = cc.id_carrito 
          INNER JOIN usuarios u on cc.id_usuario = u.id_usuario 
          INNER JOIN productos p on pc.id_producto = p.id_producto where cc.id_usuario = '$id_usuario_carrito'";

$consulta_carritos = mysqli_query($conexion, $query);
guardar_carrito_en_sesion($consulta_carritos);
function guardar_carrito_en_sesion($consulta_carritos) {
    $carrito_array = [];
    while($fila = mysqli_fetch_assoc($consulta_carritos)) {
        $carrito_array[] = [
            'ID' => $fila['id_producto'],
            'nombre_producto' => $fila['nombre_producto'],
            'descripcion_producto' => $fila['descripcion_producto'],
            'cantidad' => $fila['cantidad'],
            'precio_producto' => $fila['precio_producto']
        ];
    }
    $_SESSION['CARRITO'] = $carrito_array;
}


if (isset($_POST['btnAccion'])) {
    switch ($_POST['btnAccion']) {
        // Agregar al carrito
        case 'Agregar':
            // Validaciones
            $errores = [];
            if (isset($_POST['id_producto']) && is_numeric($_POST['id_producto'])) {
                $id_producto_carrito = $_POST['id_producto'];
            } 
            else {
                $errores[] = "ID INCORRECTO";
            }
            /*
            if (isset($_POST['nombre_producto']) && is_string($_POST['nombre_producto'])) {
                $nombre_producto_carrito = $_POST['nombre_producto'];
            } else {
                $errores[] = "Nombre de producto INCORRECTO";
            }
            if (isset($_POST['precio_producto']) && is_numeric($_POST['precio_producto'])) {
                $precio_producto_carrito = $_POST['precio_producto'];
            } else {
                $errores[] = "Precio del producto INCORRECTO";
            }
            */
            if (isset($_POST['cantidad_producto']) && is_numeric($_POST['cantidad_producto'])) {
                $cantidad_producto_carrito = $_POST['cantidad_producto'];
            } else {
                $errores[] = "Cantidad del producto INCORRECTO";
            }

            if (!empty($errores)) {
                $mensaje = implode(", ", $errores);
                break;
            }

            // Agregar al carrito en sesión
            if (!isset($_SESSION['CARRITO'])) {
                $_SESSION['CARRITO'] = []; //cambio
            }
            /*
            $producto_existente_carrito = array_column($_SESSION['CARRITO'], 'ID');
            if (in_array($id_producto_carrito, $producto_existente_carrito)) {
                echo "<script>alert('El producto ya ha sido seleccionado.');</script>";
            }
            else {
                $producto_array = array(
                    'ID' => $id_producto_carrito,
                    'NOMBRE' => $nombre_producto_carrito,
                    'CANTIDAD' => $cantidad_producto_carrito,
                    'PRECIO' => $precio_producto_carrito
                );
                $_SESSION['CARRITO'][] = $producto_array;
                $mensaje = "Producto agregado al carrito";
            }
            */

            // Guardar en la base de datos
            //cambio
            $total_producto = $precio_producto_carrito * $cantidad_producto_carrito;
            $sql_carrito_compra = "INSERT INTO carritos_compra (id_producto, id_usuario, cantidad_producto, total_carrito)
                VALUES ('$id_producto_carrito', '$id_usuario_carrito', '$cantidad_producto_carrito', '$total_producto')";
            if (mysqli_query($conexion, $sql_carrito_compra)) {
                $mensaje .= " y guardado en la base de datos";
            } else {
                $mensaje .= " pero no se guardó en la base de datos: " . mysqli_error($conexion);
            }
            break;

        // Eliminar del carrito
        case "Eliminar":
            if (isset($_POST['id_producto']) && is_numeric($_POST['id_producto'])) {
                $id_producto_carrito = $_POST['id_producto'];
                foreach ($_SESSION['CARRITO'] as $indice => $producto_array) {
                    if ($producto_array['ID'] == $id_producto_carrito) {
                        unset($_SESSION['CARRITO'][$indice]);
                        // Eliminar de la base de datos
                        $eliminacion_producto_carrito = "DELETE FROM carritos_compra WHERE id_producto = '$id_producto_carrito' AND id_usuario = '$id_usuario_carrito'";
                        if (mysqli_query($conexion, $eliminacion_producto_carrito)) {
                            $mensaje = "Producto eliminado del carrito";
                        } else {
                            $mensaje = "No se ha podido eliminar el producto de la base de datos";
                        }
                        break;
                    }
                }
            } else {
                $mensaje = "ID de producto para eliminar incorrecto";
            }
            break;

        default:
            $mensaje = "Ups... Producto no agregado correctamente";
            break;
    }
}