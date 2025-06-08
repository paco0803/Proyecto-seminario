<?php
session_start();
require_once('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d');

// 1. Obtener todos los productos del carrito de este usuario
$sql_carrito = "SELECT * FROM producto_carrito WHERE id_usuario = '$id_usuario'";
$res_carrito = mysqli_query($conexion, $sql_carrito);

if (mysqli_num_rows($res_carrito) == 0) {
    echo "<h2>No hay productos en el carrito.</h2>";
    exit;
}

$errores = [];
while ($row = mysqli_fetch_assoc($res_carrito)) {
    $id_pc = $row['id_pc'];
    $id_producto = $row['id_producto'];
    $cantidad = $row['cantidad'];

    // 2. Descontar stock
    $sql_update_stock = "UPDATE productos SET cantidad_producto = cantidad_producto - $cantidad WHERE id_producto = '$id_producto'";
    if (!mysqli_query($conexion, $sql_update_stock)) {
        $errores[] = "Error al actualizar stock del producto $id_producto";
        continue;
    }

    // 3. Registrar la compra (una fila por producto en el carrito)
    $sql_compra = "INSERT INTO compras (id_usuario, fecha_compra, id_producto, cantidad) VALUES ('$id_usuario', '$fecha', '$id_producto', '$cantidad')";
    if (!mysqli_query($conexion, $sql_compra)) {
        $errores[] = "Error al registrar la compra del producto $id_producto";
        continue;
    }
}

// 4. Eliminar todos los productos del carrito de la base de datos para este usuario
$sql_delete_carrito = "DELETE FROM producto_carrito WHERE id_usuario = '$id_usuario'";
mysqli_query($conexion, $sql_delete_carrito);

// 5. Vaciar el carrito de la sesión
unset($_SESSION['CARRITO']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Compra realizada!</title>
    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .confirmacion-container {
            max-width: 500px;
            margin: 80px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(33,118,174,0.10);
            padding: 40px 32px;
            text-align: center;
        }
        .icono-check {
            font-size: 4rem;
            color: #4a90e2;
            margin-bottom: 18px;
        }
        h1 {
            color: #2176ae;
            margin-bottom: 16px;
        }
        p {
            color: #444;
            font-size: 1.1rem;
            margin-bottom: 28px;
        }
        .volver-tienda {
            display: inline-block;
            background: #4a90e2;
            color: #fff;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: background 0.2s;
        }
        .volver-tienda:hover {
            background: #357ab8;
        }
    </style>
</head>
<body>
    <div class="confirmacion-container">
        <div class="icono-check">✔️</div>
        <h1>¡Compra realizada con éxito!</h1>
        <?php if (empty($errores)) { ?>
            <p>Gracias por tu compra. Pronto recibirás un correo con los detalles de tu pedido.</p>
        <?php } else { ?>
            <p>La compra se realizó, pero hubo errores:<br><?php echo implode('<br>', $errores); ?></p>
        <?php } ?>
        <a href="../landing/index.php" class="volver-tienda">Volver a la tienda</a>
    </div>
</body>
</html>