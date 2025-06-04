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
$nombre = $_POST['nombre_categoria'];

$query = "UPDATE categorias SET 
    nombre_categoria = '$nombre'
    WHERE id_categoria = '$id'";


if(mysqli_query($conexion, $query)){
    header("location: edicion_exitosa.php?nombre_categoria=$nombre");
}else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
?>