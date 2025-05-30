<?php
require_once('./carrito.php');
require_once('../landing/categorias.php');
require_once('../landing/busqueda.php');
require_once('../landing/texto.php');
?>
<br>
<h3>Lista del Carrito</h3>
<?php if(empty($_SESSION['CARRITO'])) {?>
<table>
    <tbody>     
    <tr>
      <th width="40%">Descripción</th>
      <th width="15%" class="text-center">Cantidad</th>
      <th width="20%" class="text-center">Precio</th>
      <th width="20%" class="text-center">Total</th>
      <th width="20%">--</th>
    </tr>
    <?php $total=0; ?>
    <?php foreach ($SESSION['CARRITO'] as $indice=>$producto_array) {?>
    <tr>
      <td width="40%"><?php echo $producto_array['NOMBRE']?></td>
      <td width="15%" class="text-center"><?php echo $producto_array['CANTIDAD']?></td>
      <td width="20%" class="text-center"><?php echo $producto_array['PRECIO']?></td>
      <td width="20%" class="text-center"><?php echo number_format($producto_array['PRECIO']*$producto_array['CANTIDAD'],2)?></td>

      <form action="" method="POST">
        <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $producto_array['ID'] ?>">
        <button
        type="Submit"
        name="btnAccion"
        value="Eliminar"
        >Eliminar</button>
      </form>

      <td width="5%"><button class="btn btn-danger" type="button">Eliminar</button></td>
    </tr>
   
   <?php }?>
    <tr>
        <td colspan="3"><h3>Total</h3></td>
        <td><h3>$<?php echo number_format($total_carrito,2);?></h3></td>
        <td></td>
    </tr>
</tbody>
</table>
<?php }else{?>
    <div>
        <h2>no hay productos en el carrito</h2>
    </div>
<?php }?>