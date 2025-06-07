<?php
session_start();
include('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_SESSION['id_usuario'])){
    $id_usuario_carrito = $_SESSION['id_usuario'];
}
if (isset($_GET['id_producto']) && is_numeric($_GET['id_producto'])) {
    $id_producto_carrito = $_GET['id_producto'];
}
if (isset($_GET['cantidad']) && is_numeric($_GET['cantidad'])) {
    $cantidad_producto_carrito = $_GET['cantidad'];
}

if (isset($id_usuario_carrito) && isset($id_producto_carrito) && isset($cantidad_producto_carrito)) {
    $query = "UPDATE producto_carrito SET cantidad = '$cantidad_producto_carrito' WHERE id_usuario = '$id_usuario_carrito' AND id_producto = '$id_producto_carrito'";
    if(mysqli_query($conexion, $query)){
        header("location: mostrarcarrito.php");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
} else {
    echo "Datos incompletos para actualizar el carrito.";
}
?>