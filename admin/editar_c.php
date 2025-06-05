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

$confirmacion = strtolower(trim($nombre));

$query_confirmacion= "SELECT id_categoria FROM categorias 
    WHERE id_categoria != '$id' AND LOWER(TRIM(nombre_categoria)) = '$confirmacion'";
    
$consulta_confirmacion= mysqli_query($conexion, $query_confirmacion);

if(mysqli_num_rows($consulta_confirmacion) > 0){
    header('location: editar_categorias.php?modal=true');
    exit();
}

$query = "UPDATE categorias SET 
    nombre_categoria = '$nombre'
    WHERE id_categoria = '$id'";


if(mysqli_query($conexion, $query)){
    header("location: edicion_exitosa.php?nombre_categoria=$nombre");
}else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
?>