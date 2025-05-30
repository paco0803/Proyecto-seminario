<?php
session_start();
require_once('validar_admin.php');
validar_admin();

include ('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$producto_eliminado = $_POST['id'];

$query = "SELECT * FROM productos WHERE id_producto = '$producto_eliminado'";
$consulta = mysqli_query($conexion, $query);

$confirmacion = $consulta->num_rows;

$mensaje = "";
$exito = false;

if($confirmacion == 1){
    $q_eliminacion = "DELETE FROM productos WHERE id_producto = '$producto_eliminado'";
    $eliminacion = mysqli_query($conexion, $q_eliminacion);
    $mensaje = "Usuario eliminado correctamente.";
    $exito = true;
} else {
    $mensaje = "No se ha encontrado el producto.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar producto</title>
    <style>
        body {
            background: #f4f6f8;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
            padding: 36px 32px 28px 32px;
            text-align: center;
        }
        .icono {
            font-size: 48px;
            margin-bottom: 18px;
        }
        .icono.exito {
            color: #4a90e2;
        }
        .icono.error {
            color: #e74c3c;
        }
        .mensaje {
            font-size: 1.2rem;
            margin-bottom: 24px;
            color: #2d3e50;
        }
        .volver-btn {
            text-decoration: none;
            color: #fff;
            background: #4a90e2;
            padding: 12px 32px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.2s;
            display: inline-block;
        }
        .volver-btn:hover {
            background: #357ab8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icono <?php echo $exito ? 'exito' : 'error'; ?>">
            <?php if($exito): ?>
                &#10004;
            <?php else: ?>
                &#10060;
            <?php endif; ?>
        </div>
        <div class="mensaje"><?php echo $mensaje; ?></div>
        <a href="productos_admin.php" class="volver-btn">Volver al panel</a>
    </div>
</body>
</html>
<?php
mysqli_close($conexion);
?>