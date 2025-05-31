<?php
session_start();
require_once('carrito.php');

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
        }
        table {
            width: 90%;
            margin: 24px auto;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(33,118,174,0.07);
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
        .btn-danger {
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .carrito-vacio {
            text-align: center;
            margin-top: 40px;
            color: #888;
        }
    </style>
</head>
<body>
<br>
<h3>Lista del Carrito</h3>
<?php if(isset($_SESSION['CARRITO']) && !empty($_SESSION['CARRITO'])) { ?>
<table>
    <tbody>     
    <tr>
      <th width="40%">Nombre</th>
      <th width="15%" class="text-center">Cantidad</th>
      <th width="20%" class="text-center">Precio</th>
      <th width="20%" class="text-center">Total</th>
      <th width="20%">--</th>
    </tr>
    <?php 
    $total_carrito = 0;
    foreach ($_SESSION['CARRITO'] as $indice => $producto_array) {
        $subtotal = $producto_array['precio_producto'] * $producto_array['cantidad'];
        $total_carrito += $subtotal;
    ?>
    <tr>
      <td width="40%"><?php echo $producto_array['nombre_producto']?></td>
      <td width="15%" class="text-center"><?php echo $producto_array['cantidad']?></td>
      <td width="20%" class="text-center"><?php echo $producto_array['precio_producto']?></td>
      <td width="20%" class="text-center"><?php echo number_format($subtotal,2)?></td>
      <td width="5%">
        <form action="" method="POST" style="display:inline;">
            <input type="hidden" name="id_producto" value="<?php echo $producto_array['ID'] ?>">
            <button type="submit" name="btnAccion" value="Eliminar" class="btn btn-danger">Eliminar</button>
        </form>
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
<?php } else { ?>
    <div class="carrito-vacio">
        <h2>No hay productos en el carrito</h2>
    </div>
<?php } ?>
</body>
</html>