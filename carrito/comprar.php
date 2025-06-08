<?php
session_start();
require_once('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!isset($_SESSION['CARRITO']) || empty($_SESSION['CARRITO'])) {
    header("Location: mostrarcarrito.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar compra</title>
    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .confirmar-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(33,118,174,0.10);
            padding: 32px 24px 24px 24px;
        }
        h2 {
            color:rgb(0, 0, 0);
            text-align: center;
            margin-bottom: 24px;
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

            padding: 14px 10px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background:rgb(0, 0, 0);
            color: #fff;
            font-size: 1.1rem;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .btn-confirmar {
             background:rgb(0, 0, 0);
                        color: #c5ff50;

            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 24px 8px 0 8px;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-block;
            text-decoration: none;
        }
        .btn-confirmar:hover {
            background: #357ab8;
        }
        .volver-carrito {
            display: inline-block;
            background: #ffd600;
            color: #2d3e50;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 24px 8px 0 8px;
            transition: background 0.2s;
        }
        .volver-carrito:hover {
            background: #ffe066;
        }
        @media (max-width: 700px) {
            .confirmar-container {
                padding: 10px 2px;
            }
            table, th, td {
                font-size: 0.98rem;
            }
        }
    </style>
</head>
<body>
<div class="confirmar-container">
    <h2>Confirmar compra</h2>
    <table>
        <tr>
            <th width="35%">Nombre</th>
            <th width="15%">Cantidad</th>
            <th width="15%">Precio</th>
            <th width="15%">Total</th>
        </tr>
        <?php
        $total_carrito = 0;
        foreach ($_SESSION['CARRITO'] as $producto) {
            $subtotal = $producto['precio_producto'] * $producto['cantidad'];
            $total_carrito += $subtotal;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
            <td>$<?php echo number_format($producto['precio_producto'],2); ?></td>
            <td>$<?php echo number_format($subtotal,2); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3"><h3>Total</h3></td>
            <td><h3>$<?php echo number_format($total_carrito,2);?></h3></td>
        </tr>
    </table>
    <div style="text-align:center;">
        <a href="mostrarcarrito.php" class="volver-carrito">Volver al carrito</a>
        <form action="finalizar_compra.php" method="post" style="display:inline;">
            <button type="submit" class="btn-confirmar">Confirmar compra</button>
        </form>
    </div>
</div>
</body>
</html>