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

// Buscador
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Paginación
$categorias_por_pagina = 6;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$offset = ($pagina - 1) * $categorias_por_pagina;

// Filtro de búsqueda
$where = "";
if ($busqueda !== '') {
    $busqueda_sql = mysqli_real_escape_string($conexion, $busqueda);
    $where = "WHERE nombre_categoria LIKE '%$busqueda_sql%'";
}

// Consulta para traer categorías con paginación y búsqueda
$query = "SELECT * FROM categorias $where LIMIT $categorias_por_pagina OFFSET $offset";
$categorias_p = mysqli_query($conexion, $query);

// Total de categorías y páginas (con filtro)
$query_contar = "SELECT COUNT(*) as contar from categorias $where";
$consulta_contar = mysqli_query($conexion,$query_contar);
$array_contar = mysqli_fetch_array($consulta_contar);
$cantidad_categorias = $array_contar['contar'];
$total_paginas = ceil($cantidad_categorias / $categorias_por_pagina);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorias</title>
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
            gap: 14px;
            background: #eaf1fb;
            border-radius: 10px;
            box-shadow: 0 1px 6px rgba(74,144,226,0.08);
            padding: 16px 0 12px 0;
            margin-bottom: 28px;
            max-width: 320px;
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
            font-size: 2.1rem;
            font-weight: bold;
            color: #357ab8;
            line-height: 1;
        }
        .productos-label {
            font-size: 1rem;
            color: #2d3e50;
            margin-top: 2px;
        }
        .buscador-categorias {
            margin: 0 auto 18px auto;
            max-width: 400px;
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        .buscador-categorias input[type="text"] {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #4a90e2;
            font-size: 1rem;
            width: 220px;
        }
        .buscador-categorias button {
            padding: 8px 18px;
            border-radius: 5px;
            border: none;
            background: #4a90e2;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
        }
        .buscador-categorias button:hover {
            background: #357ab8;
        }
        h1 {
            color: #2d3e50;
            margin-bottom: 18px;
            text-align: center;
            font-size: 1.6rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fafbfc;
            margin-top: 24px;
        }
        th, td {
            padding: 8px 6px;
            text-align: left;
            font-size: 1rem;
        }
        th {
            background: #4a90e2;
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
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
            padding: 5px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.95rem;
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
        .paginacion {
            text-align: center;
            margin-top: 18px;
        }
        .paginacion a, .paginacion strong {
            display: inline-block;
            margin: 0 4px;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: #4a90e2;
            font-weight: 600;
            background: #eaf1fb;
            transition: background 0.2s, color 0.2s;
            font-size: 1rem;
        }
        .paginacion a:hover {
            background: #4a90e2;
            color: #fff;
        }
        .paginacion strong {
            background: #4a90e2;
            color: #fff;
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
            <h2>Categorias</h2>
            <div class="bienvenida">
                <?php echo htmlspecialchars('Administrador: '.$_SESSION['nombre'] ." ". $_SESSION['apellido']); ?>
            </div>
            <a href="crear_categoria.php" class="action-btn">Insertar nueva categoria</a>
            <a href="admin.php" class="action-btn">Usuarios</a>
            <a href="productos_admin.php" class="action-btn">Productos</a>
            <a href="../cerrar_sesion.php" class="action-btn cerrar-sesion">Cerrar sesión</a>
        </div>
        <div class="content">
            <div class="productos-card">
                <div class="icono-producto">
                    <!-- Icono de categorías (tres líneas tipo lista) -->
                    <svg width="40" height="40" fill="#4a90e2" viewBox="0 0 24 24">
                        <rect x="3" y="6" width="18" height="2" rx="1"/>
                        <rect x="3" y="11" width="18" height="2" rx="1"/>
                        <rect x="3" y="16" width="18" height="2" rx="1"/>
                    </svg>
                </div>
                <div class="productos-info">
                    <span class="productos-numero"><?php echo $cantidad_categorias; ?></span>
                    <span class="productos-label">Categorías registradas</span>
                </div>
            </div>

            <!-- Buscador de categorías -->
            <form class="buscador-categorias" method="get" action="categorias.php">
                <input type="text" name="busqueda" placeholder="Buscar categoría..." value="<?php echo htmlspecialchars($busqueda); ?>">
                <button type="submit">Buscar</button>
            </form>

            <h1>Lista de Categorías</h1>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <?php while($fila = mysqli_fetch_assoc($categorias_p)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['nombre_categoria']); ?></td>
                    <td>
                        <form class="action-form" action="editar_categorias.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($fila['id_categoria']); ?>">
                            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($fila['nombre_categoria']); ?>">
                            <button type="submit" class="action-btn-table edit-btn">Editar</button>
                        </form>
                    </td>
                    <td>
                        <?php $modalId = 'eliminar_' . md5($fila['id_categoria']); ?>
                        <button onclick="document.getElementById('<?php echo $modalId; ?>').showModal()" class="action-btn-table delete-btn">Eliminar</button>
                        <dialog id="<?php echo $modalId; ?>">
                            <h2 style="font-size:1.1rem;">Eliminación de categoría</h2>
                            <p style="font-size:1rem;">¿Está seguro de eliminar la categoría  <?php echo htmlspecialchars($fila['nombre_categoria']); ?>?</p>
                            <div style="display: flex; justify-content: center; gap: 16px; margin-top: 18px;">
                                <form action="eliminar_categoria.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($fila['id_categoria']); ?>">
                                    <button type="submit" class="action-btn-table delete-btn" style="font-size:0.95rem;padding:5px 12px;">Eliminar</button>
                                </form>
                                <form method="dialog" style="display:inline;">
                                    <button type="submit" style="font-size:0.95rem;padding:5px 12px;">Cancelar</button>
                                </form>
                            </div>
                        </dialog>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            <div class="paginacion">
                <?php
                // Mantener la búsqueda en la paginación
                $extra = $busqueda !== '' ? '&busqueda=' . urlencode($busqueda) : '';
                ?>
                <?php if ($total_paginas > 1): ?>
                    <?php if ($pagina > 1): ?>
                        <a href="?pagina=<?php echo $pagina-1 . $extra; ?>">&laquo; Anterior</a>
                    <?php endif; ?>
                    <?php
                    for ($i = 1; $i <= $total_paginas; $i++):
                        if ($i == $pagina) {
                            echo "<strong>$i</strong>";
                        } else {
                            echo "<a href='?pagina=$i$extra'>$i</a>";
                        }
                    endfor;
                    ?>
                    <?php if ($pagina < $total_paginas): ?>
                        <a href="?pagina=<?php echo $pagina+1 . $extra; ?>">Siguiente &raquo;</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conexion);
?>