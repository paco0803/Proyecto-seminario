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

$id = $_POST['id'];
$nombre = $_POST['nombre_producto'];
$cantidad = $_POST['cantidad'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];

$query = "UPDATE productos SET cantidad_producto = '$cantidad ', nombre_producto = '$nombre', precio_producto = '$precio', 
          descripcion_producto = '$descripcion', id_categoria = '$categoria' WHERE id_producto = '$id'";

if(mysqli_query($conexion, $query)){
    header("location: edicion_exitosa.php?nombre=$nombre");
}else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
?>