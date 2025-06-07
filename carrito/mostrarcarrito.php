<?php
session_start();
require_once('../carrito/cargar_carrito.php');
if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 2){
    guardar_carrito_en_sesion();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        h3 {
            color: #2176ae;
            margin-top: 24px;
            text-align: center;
        }
        .carrito-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(33,118,174,0.10);
            padding: 32px 24px 24px 24px;
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
            background: #4a90e2;
            color: #fff;
            font-size: 1.1rem;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .btn {
            border: none;
            border-radius: 8px;
            padding: 7px 18px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            margin: 0 2px;
        }
        .btn-eliminar {
            background: #e74c3c;
            color: #fff;
        }
        .btn-eliminar:hover {
            background: #c0392b;
        }
        .btn-actualizar {
            background: #ffd600;
            color: #2d3e50;
        }
        .btn-actualizar:hover {
            background: #ffe066;
        }
        .btn-comprar {
            background: #4a90e2;
            color: #fff;
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
        .btn-comprar:hover {
            background: #357ab8;
        }
        .input-cantidad {
            width: 60px;
            padding: 5px;
            border-radius: 6px;
            border: 1px solid #4a90e2;
            text-align: center;
            font-size: 1rem;
        }
        .carrito-vacio {
            text-align: center;
            margin-top: 40px;
            color: #888;
        }
        .volver-tienda {
            display: inline-block;
            margin: 24px auto 0 auto;
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
        @media (max-width: 700px) {
            .carrito-container {
                padding: 10px 2px;
            }
            table, th, td {
                font-size: 0.98rem;
            }
        }
    </style>
</head>
<body>
<div class="carrito-container">
    <h3>Lista del Carrito</h3>
    <?php if(isset($_SESSION['CARRITO']) && !empty($_SESSION['CARRITO'])) { ?>
    <table>
        <tbody>
        <tr>
            <th width="35%">Nombre</th>
            <th width="15%">Cantidad</th>
            <th width="15%">Precio</th>
            <th width="15%">Total</th>
            <th width="20%">Acciones</th>
        </tr>
        <?php 
        $total_carrito = 0;
        foreach ($_SESSION['CARRITO'] as $indice => $producto_array) {
            $subtotal = $producto_array['precio_producto'] * $producto_array['cantidad'];
            $total_carrito += $subtotal;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($producto_array['nombre_producto']); ?></td>
            <td>
                <form action="actualizar_carrito.php" method="get" style="display:inline;">
                    <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto_array['ID']); ?>">
                    <input type="number" name="cantidad" class="input-cantidad" min="1" value="<?php echo htmlspecialchars($producto_array['cantidad']); ?>">
                    <button type="submit" class="btn btn-actualizar">Actualizar</button>
                </form>
            </td>
            <td>$<?php echo number_format($producto_array['precio_producto'],2); ?></td>
            <td>$<?php echo number_format($subtotal,2); ?></td>
            <td>
    <button type="button" class="btn btn-eliminar" onclick="document.getElementById('modal_<?php echo $producto_array['ID']; ?>').showModal();">Eliminar</button>
    <dialog id="modal_<?php echo $producto_array['ID']; ?>">
        <h3>¿Eliminar producto?</h3>
        <p>¿Estás seguro de que deseas eliminar <b><?php echo htmlspecialchars($producto_array['nombre_producto']); ?></b> del carrito?</p>
        <form method="dialog" style="display:inline;">
            <button class="btn btn-actualizar" style="margin-right:8px;">Cancelar</button>
        </form>
        <a href="eliminar_carrito.php?id_producto=<?php echo htmlspecialchars($producto_array['ID']); ?>" class="btn btn-eliminar">Eliminar</a>
    </dialog>
</td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3"><h3>Total</h3></td>
            <td><h3>$<?php echo number_format($total_carrito,2);?></h3></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <div style="text-align:center;">
        <a href="../landing/index.php" class="volver-tienda">Seguir comprando</a>
        <a href="comprar.php" class="btn-comprar">Comprar</a>
    </div>
    <?php } else { ?>
        <div class="carrito-vacio">
            <h2>No hay productos en el carrito</h2>
            <a href="../landing/index.php" class="volver-tienda">Ir a la tienda</a>
        </div>
    <?php } ?>
</div>
</body>
</html>