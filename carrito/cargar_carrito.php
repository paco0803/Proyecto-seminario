<?php
function guardar_carrito_en_sesion() {

    require_once('../conexion.php');
    $conexion = conexionBD();
    mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

    //Definicion del id del usuario asignado al carrito
    $id_usuario_carrito = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

    if($id_usuario_carrito == null){
        header('location: ../landing/index.php');
        exit();
    }
    $query = "SELECT * FROM producto_carrito pc 
          INNER JOIN carritos_compra cc on pc.id_carrito = cc.id_carrito 
          INNER JOIN usuarios u on cc.id_usuario = u.id_usuario 
          INNER JOIN productos p on pc.id_producto = p.id_producto where cc.id_usuario = '$id_usuario_carrito'";

    $consulta_carritos = mysqli_query($conexion, $query);
    $carrito_array = [];
    while($fila = mysqli_fetch_assoc($consulta_carritos)) {
        $carrito_array[] = [
            'ID' => $fila['id_producto'],
            'nombre_producto' => $fila['nombre_producto'],
            'descripcion_producto' => $fila['descripcion_producto'],
            'cantidad' => $fila['cantidad'],
            'precio_producto' => $fila['precio_producto']
        ];
    }
    $_SESSION['CARRITO'] = $carrito_array;
}

?>