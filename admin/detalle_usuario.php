<?php
require_once('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

// Obtener el email del usuario por GET
if (!isset($_GET['email'])) {
    echo "<h2>No se especificó el usuario.</h2>";
    exit;
}
$email = $_GET['email'];

// Buscar datos del usuario
$sql_usuario = "SELECT * FROM usuarios WHERE correo_usuario = '$email'";
$res_usuario = mysqli_query($conexion, $sql_usuario);
$usuario = mysqli_fetch_assoc($res_usuario);

if (!$usuario) {
    echo "<h2>Usuario no encontrado.</h2>";
    exit;
}

// Paginación
$registros_por_pagina = 6;
$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $registros_por_pagina;

// Total de compras
$id_usuario = $usuario['id_usuario'];
$sql_total = "SELECT COUNT(*) as total FROM compras WHERE id_usuario = '$id_usuario'";
$res_total = mysqli_query($conexion, $sql_total);
$total_compras = mysqli_fetch_assoc($res_total)['total'];
$total_paginas = ceil($total_compras / $registros_por_pagina);

// Buscar compras del usuario con paginación
$sql_compras = "SELECT c.*, p.nombre_producto 
                FROM compras c
                JOIN productos p ON c.id_producto = p.id_producto
                WHERE c.id_usuario = '$id_usuario'
                ORDER BY c.fecha_compra DESC
                LIMIT $inicio, $registros_por_pagina";
$res_compras = mysqli_query($conexion, $sql_compras);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Usuario</title>
    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(33,118,174,0.10);
            padding: 32px 24px 24px 24px;
        }
        h2 {
            color: #2176ae;
            margin-bottom: 18px;
        }
        .user-info {
            margin-bottom: 32px;
        }
        .user-info label {
            font-weight: bold;
            color: #333;
            margin-right: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(33,118,174,0.07);
            overflow: hidden;
        }
        th, td {
            padding: 12px 8px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background: #4a90e2;
            color: #fff;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .volver-btn {
            display: inline-block;
            background: #4a90e2;
            color: #fff;
            padding: 10px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 24px;
            transition: background 0.2s;
        }
        .volver-btn:hover {
            background: #357ab8;
        }
        .paginacion {
            margin: 20px 0 0 0;
            text-align: center;
        }
        .paginacion a, .paginacion strong {
            display: inline-block;
            margin: 0 4px;
            padding: 6px 14px;
            border-radius: 6px;
            background: #eaf1fb;
            color: #2176ae;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
        }
        .paginacion a:hover {
            background: #4a90e2;
            color: #fff;
        }
        .paginacion strong {
            background: #4a90e2;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Datos del Usuario</h2>
        <div class="user-info">
            <p><label>Correo:</label> <?php echo htmlspecialchars($usuario['correo_usuario']); ?></p>
            <p><label>Nombre:</label> <?php echo htmlspecialchars($usuario['nombre_usuario']); ?></p>
            <p><label>Apellido:</label> <?php echo htmlspecialchars($usuario['apellido_usuario']); ?></p>
            <p><label>Rol:</label>
                <?php
                if ($usuario['tipo_usuario'] == 1) {
                    echo 'Administrador';
                } else {
                    echo 'Cliente';
                }
                ?>
            </p>
        </div>

        <h2>Compras realizadas</h2>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
            <?php if (mysqli_num_rows($res_compras) > 0): ?>
                <?php while ($compra = mysqli_fetch_assoc($res_compras)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($compra['fecha_compra']); ?></td>
                        <td><?php echo htmlspecialchars($compra['nombre_producto']); ?></td>
                        <td><?php echo htmlspecialchars($compra['cantidad']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay compras registradas.</td>
                </tr>
            <?php endif; ?>
        </table>
        <!-- Paginación -->
        <?php if ($total_paginas > 1): ?>
        <div class="paginacion">
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <?php if ($i == $pagina): ?>
                    <strong><?php echo $i; ?></strong>
                <?php else: ?>
                    <a href="?email=<?php echo urlencode($email); ?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        <a href="admin.php" class="volver-btn">Volver</a>
    </div>
</body>
</html>