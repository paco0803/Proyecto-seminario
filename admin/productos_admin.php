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

$query = "SELECT * from productos INNER JOIN categorias on productos.id_categoria = categorias.id_categoria";
$productos= mysqli_query($conexion, $query);
$query_contar = "SELECT COUNT(*) as contar from productos";
$consulta_contar = mysqli_query($conexion,$query_contar);
$array_contar = mysqli_fetch_array($consulta_contar);
$cantidad_productos = $array_contar['contar'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <style>
        body {
            background: #f4f6f8;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-layout {
            display: flex;
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
            min-height: 600px;
        }
        .sidebar {
            width: 260px;
            background: #eaf1fb;
            border-radius: 12px 0 0 12px;
            padding: 36px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
        }
        .sidebar h2 {
            color: #2d3e50;
            margin-bottom: 18px;
            font-size: 22px;
        }
        .sidebar .bienvenida {
            color: #4a90e2;
            font-size: 16px;
            margin-bottom: 18px;
        }
        .sidebar a, .sidebar form {
            width: 100%;
        }
        .sidebar .action-btn {
            display: block;
            width: 100%;
            margin-bottom: 12px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background: #4a90e2;
            padding: 12px 0;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            transition: background 0.2s;
            cursor: pointer;
        }
        .sidebar .action-btn:hover {
            background: #357ab8;
        }
        .sidebar .cerrar-sesion {
            color: #e74c3c;
            background: #fff;
            border: 2px solid #e74c3c;
            margin-top: 24px;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar .cerrar-sesion:hover {
            background: #e74c3c;
            color: #fff;
        }
        .content {
            flex: 1;
            padding: 36px 32px 28px 32px;
        }
        .productos-card {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            background: #eaf1fb;
            border-radius: 10px;
            box-shadow: 0 1px 6px rgba(74,144,226,0.08);
            padding: 22px 0 18px 0;
            margin-bottom: 32px;
            max-width: 350px;
            margin-left: auto;
            margin-right: auto;
        }
        .icono-producto {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .productos-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .productos-numero {
            font-size: 2.6rem;
            font-weight: bold;
            color: #357ab8;
            line-height: 1;
        }
        .productos-label {
            font-size: 1.1rem;
            color: #2d3e50;
            margin-top: 2px;
        }
        h1 {
            color: #2d3e50;
            margin-bottom: 18px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fafbfc;
            margin-top: 32px;
        }
        th, td {
            padding: 12px 8px;
            text-align: left;
        }
        th {
            background: #4a90e2;
            color: #fff;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background: #f0f4f8;
        }
        tr:hover {
            background: #e6f0fa;
        }
        .action-form {
            display: inline;
        }
        .categoria-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 16px;
            background: #4a90e2;
            color: white;
            font-weight: 600;
            font-size: 0.98rem;
            box-shadow: 0 1px 3px rgba(33,118,174,0.07);
            border: 1px solidrgb(245, 245, 245);
            letter-spacing: 0.5px;
        }
        .action-btn-table {
            padding: 6px 16px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            margin: 0 2px;
        }
        .edit-btn {
            background: #ffd600;
            color: #2d3e50;
        }
        .edit-btn:hover {
            background: #ffe066;
        }
        .delete-btn {
            background: #e74c3c;
            color: #fff;
        }
        .delete-btn:hover {
            background: #c0392b;
        }
        @media (max-width: 900px) {
            .main-layout {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-radius: 12px 12px 0 0;
                align-items: center;
            }
            .content {
                padding: 24px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="main-layout">
        <div class="sidebar">
            <h2>Productos</h2>
            <div class="bienvenida">
                <?php echo htmlspecialchars('Administrador: '.$_SESSION['nombre'] ." ". $_SESSION['apellido']); ?>
            </div>
            <a href="crear_producto.php" class="action-btn">Insertar nuevo producto</a>
            <a href="admin.php" class="action-btn">Usuarios</a>
            <a href="../cerrar_sesion.php" class="action-btn cerrar-sesion">Cerrar sesión</a>
        </div>
        <div class="content">
            <div class="productos-card">
                <div class="icono-producto">
                    <svg width="36" height="36" fill="#4a90e2" viewBox="0 0 24 24">
                        <path d="M21 7.16V6a2 2 0 0 0-1.11-1.79l-7-3.11a2 2 0 0 0-1.78 0l-7 3.11A2 2 0 0 0 3 6v1.16A2 2 0 0 0 2 9v9a2 2 0 0 0 1.11 1.79l7 3.11a2 2 0 0 0 1.78 0l7-3.11A2 2 0 0 0 22 18V9a2 2 0 0 0-1-1.84zM12 3.19l7 3.11-7 3.11-7-3.11zm8 14.81a1 1 0 0 1-.56.89l-7 3.11a1 1 0 0 1-.88 0l-7-3.11A1 1 0 0 1 4 18V9.51l7 3.11 7-3.11V18z"/>
                    </svg>
                </div>
                <div class="productos-info">
                    <span class="productos-numero"><?php echo $cantidad_productos; ?></span>
                    <span class="productos-label">Productos registrados</span>
                </div>
            </div>
            <h1>Lista de Productos</h1>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <?php while($fila = mysqli_fetch_assoc($productos)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($fila['cantidad_producto']); ?></td>
                    <td><?php echo htmlspecialchars($fila['descripcion_producto']); ?></td>
                    <td>
                        <span class="categoria-badge">
                            <?php echo htmlspecialchars($fila['nombre_categoria']); ?>
                        </span>
                    </td>
                    <td>
                        <form class="action-form" action="editar_producto.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($fila['id_producto']); ?>">
                            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($fila['nombre_producto']); ?>">
                            <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($fila['cantidad_producto']); ?>">
                            <input type="hidden" name="descripcion" value="<?php echo htmlspecialchars($fila['descripcion_producto']); ?>">
                            <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($fila['nombre_categoria']); ?>">
                            <button type="submit" class="action-btn-table edit-btn">Editar</button>
                        </form>
                    </td>
                    <td>
                        <?php $modalId = 'eliminar_' . md5($fila['id_producto']); ?>
                        <button onclick="document.getElementById('<?php echo $modalId; ?>').showModal()" class="action-btn-table delete-btn">Eliminar</button>
                        <dialog id="<?php echo $modalId; ?>">
                            <h2>Eliminación de producto</h2>
                            <p>¿Está seguro de eliminar al producto  <?php echo htmlspecialchars($fila['nombre_producto']); ?>?</p>
                            <div style="display: flex; justify-content: center; gap: 16px; margin-top: 18px;">
                                <form action="eliminar_producto.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($fila['id_producto']); ?>">
                                    <button type="submit" class="action-btn-table delete-btn">Eliminar</button>
                                </form>
                                <form method="dialog" style="display:inline;">
                                    <button type="submit">Cancelar</button>
                                </form>
                            </div>
                        </dialog>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conexion);
?>