<?php
session_start();
$mensaje="";
$conn=conexionBD(); //conexion a la base de datos
$id_usuario_carrito=$_SESSION['id_usuario']; // ID del usuario
 //recibe de boton action
if (isset($_POST['btnAccion'])) {
    
    switch ($_POST['btnAccion']) {
        //agregar al carrito
        case 'Agregar':
            if (is_numeric($_POST['id_producto'])) {
                $id_producto_carrito=$_POST['id_producto'];
                $mensaje= $id_producto_carrito."Cargado corectamente" ;
            }else{
                $mensaje="ID INCORRECTO";
            }
             if (is_string($_POST['nombre_producto'])) {
                $nombre_producto_carrito=$_POST['nombre_producto'];
                $mensaje= $nombre_producto_carrito."Cargado corectamente" ;
            }else{
                $mensaje="Nombre de producto INCORRECTO";
            }
             if (is_numeric($_POST['precio_producto'])) {
                $precio_producto_carrito=$_POST['precio_producto'];
                $mensaje= $precio_producto_carrito."Cargado corectamente" ;
            }else{
                $mensaje="precio del producto INCORRECTO";
            }
             if (is_numeric($_POST['cantidad_producto'])) {
                $cantidad_producto_carrito=$_POST['cantidad_producto'];
                $mensaje= $cantidad_producto_carrito."Cargado corectamente" ;
            }else{
                $mensaje="cantidad del producto INCORRECTO";
            }
            if (!isset($_SESSION['CARRITO'])) {
                $producto_array=array(
                 'ID'=> $id_producto_carrito,
                 'NOMBRE'=>$nombre_producto_carrito,
                 'CANTIDAD'=>$cantidad_producto_carrito,
                 'PRECIO'=>$precio_producto_carrito
                );
            $total_carrito=$total_carrito+($precio_producto_carrito * $cantidad_producto_carrito);
                $_SESSION['CARRITO'][0]=$producto_array;
                $mensaje="Producto Agregado al carrito";

            }else{
                //producto existente

                $producto_existente_carrito=array_column($_SESSION['CARRITO']);
                if(in_array($id_producto_carrito,$producto_existente_carrito)){
                    echo "<script>alert('el producto ya ha sido seleccionado..');</script>";
                }else{
                $cantidad_productos_carrito=count($_SESSION['CARRITO']);
                 $producto_array=array(
                  'ID'=> $id_producto_carrito,
                 'NOMBRE'=>$nombre_producto_carrito,
                 'CANTIDAD'=>$cantidad_producto_carrito,
                 'PRECIO'=>$precio_producto_carrito
                );
                 $_SESSION['CARRITO'][$cantidad_productos_carrito]=$producto_array;
                  $mensaje="Producto Agregado al carrito";
            }
            }
        $sql_carrito_compra="INSERT INTO carritos_compra (id_producto,id_usuario, cantidad_producto, total_carrito)
         VALUES ('$id_producto_carrito', '$id_usuario_carrito','$cantidad_productos_carrito','$total_carrito')";

         if(mysqli_query($conn, $sql_carrito_compra)){
            $mensaje="Carrito de compra actualizado correctamente";
         }else {
            echo "Error: " . $sql_carrito_compra . "<br>" . mysqli_error($conn);
     }
            break;
            //Eliminar del carrito
            case "Eliminar":
                if (is_numeric($_POST['id_producto'])) {
                    $id_producto_carrito=$_POST['id_producto'];
                    foreach($_SESSION['CARRITO'] as $indice=>$producto_array){
                        if ($producto_array['ID']==$id_producto_carrito) {
                           unset($_SESSION['CARRITO'][$indice]);
                           
                        }

                    }
                     $producto_eliminado_carrito=array_column($_SESSION['CARRITO'], 'ID');
                $eliminacion_producto_carrito="DELETE FROM carritos_compra WHERE id_producto = '$producto_eliminado_carrito'";
                if(mysqli_query($conn, $eliminacion_producto_carrito)){
                    $mensaje="Producto eliminado del carrito";
                }else{
                    $mensaje="No se ha encontrado el producto en el carrito";
                }
                }
                 
                break;
              

        default:
            $mensaje="Ups... Producto no agregado correctamente";
            break;

}
}