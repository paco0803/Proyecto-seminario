<?php
session_start();
$mensaje="";
$sql_productos="SELECT nombre_producto, precio_producto, id_producto FROM productos";
$conn=conexionBD();
$confir="cargado corectamente";
 $resultado_carrito_producto= mysqli_query($conn, $sql_productos);
if (isset($_POST['btnAccion'])) {
    
    switch ($_POST['btnAccion']) {
        case 'Agregar':
            if (is_numeric($_POST['id_producto'])||is_numeric($_POST['id_usuario'])) {
                $mensaje= $resultado_carrito_producto && $confir ;
            }else{
                $menjaje="ID INCORRECTO";
            }
            if (!isset($_SESSION['CARRITO'])) {
                $producto_array=array(
                 'ID'=>$resultado_carrito_producto['id_producto'],
                 'NOMBRE'=>$resultado_carrito_producto['nombre_producto'],
                 'CANTIDAD'=>$resultado_carrito_producto['cantidad_producto'],
                 'PRECIO'=>$resultado_carrito_producto['precio_producto'] 
                );
                $_SESSION['CARRITO'][0]=$producto_array;
                $mensaje="Producto Agregado al carrito";

            }else{

                $id_productos_carrito=array_column($_SESSION['CARRITO']);
                if(in_array($id,$id_productos_carrito)){
                    echo "<script>alert('el producto ya ha sido seleccionado..');</script>";
                }else{
                $numero_productos=count($_SESSION['CARRITO']);
                 $producto_array=array(
                 'ID'=>$resultado_carrito_producto['id_producto'],
                 'NOMBRE'=>$resultado_carrito_producto['nombre_producto'],
                 'CANTIDAD'=>$resultado_carrito_producto['cantidad_producto'],
                 'PRECIO'=>$resultado_carrito_producto['precio_producto'] 
                );
                 $_SESSION['CARRITO'][$numero_productos]=$producto_array;
                  $mensaje="Producto Agregado al carrito";
            }
            }
            
            break;
            case "ELiminar":
                if (is_numeric($_POST['id_producto'])) {
                    $id=$_POST['id_producto'];
                    foreach($_SESSION['CARRITO'] as $indice=>$producto_array){
                        if ($producto_array['ID']==$id) {
                           unset($_SESSION['CARRITO'][$indice]);
                           echo "elemento borrado";
                        }

                    }
                }
                break;

        
        default:
            $mensaje="Ups... Producto no agregado correctamente";
            break;
         
}
}