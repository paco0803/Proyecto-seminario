<?php

session_start();
$mensaje = "";

// Conexión a la base de datos
include('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_SESSION['id_usuario'])){
    $id_usuario_carrito = $_SESSION['id_usuario'];
}

if (isset($_POST['id_producto']) && is_numeric($_POST['id_producto'])) {
    $id_producto_carrito = $_POST['id_producto'];
} else {
    $errores[] = "ID INCORRECTO";
}

if (isset($_POST['cantidad']) && is_numeric($_POST['cantidad'])) {
    $cantidad_producto_carrito = $_POST['cantidad'];
} else {
    $errores[] = "Cantidad del producto INCORRECTO";
}

if (!isset($id_usuario_carrito)) {
    $errores[] = "Usuario no autenticado";
}

// Verificar si ya existe ese producto en el carrito del usuario
$sql_check = "SELECT * FROM producto_carrito WHERE id_producto = '$id_producto_carrito' AND id_usuario = '$id_usuario_carrito'";
$result_check = mysqli_query($conexion, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // Ya existe, actualiza la cantidad
    $sql_update = "UPDATE producto_carrito SET cantidad = cantidad + $cantidad_producto_carrito
                   WHERE id_producto = '$id_producto_carrito' AND id_usuario = '$id_usuario_carrito'";
    mysqli_query($conexion, $sql_update);
        header("location: ../landing/detalle_producto.php?id=$id_producto_carrito&modal=true");
} else {
    // No existe, inserta nuevo
    $sql_carrito_compra = "INSERT INTO producto_carrito (id_producto, id_usuario, cantidad)
        VALUES ('$id_producto_carrito', '$id_usuario_carrito', '$cantidad_producto_carrito')";
    if (mysqli_query($conexion, $sql_carrito_compra)) {
        header("location: ../landing/detalle_producto.php?id=$id_producto_carrito&modal=true");
    } else {
        $mensaje = "Error al agregar: " . mysqli_error($conexion);
    }
}

