<?php
session_start();
require_once('validar_admin.php');
validar_admin();


$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];

include ('../conexion.php');
$conn = conexionBD();
//Estableciendo caracteres UTF8 para BD, importante para acentos y eñes en MySQL                            
mysqli_set_charset($conn, "utf8");
                              
                              
// Check connection
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}

//Comprobación que la dirección de email no esté registrada

$consulta_productos = mysqli_query($conn, "SELECT * FROM productos WHERE nombre_producto = '$nombre'");

if(!$consulta_email){
    echo "No se realizo la consulta";
}else{
    $numResults = $consulta_productos->num_rows;
}
if ($numResults != 0) {
    header("Location: producto_existente.php?nombre=$nombre");
    exit(); 
    }

$sql = "INSERT INTO productos (nombre_producto, precio_producto, descripcion_producto, id_categoria , cantidad_producto) 
VALUES ('$nombre', '$precio', '$descripcion', '$categoria', '$cantidad')";

if (mysqli_query($conn, $sql)) {
   header("location: creacion_exitosa.php?nombre=$nombre");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    
mysqli_close($conn);

exit(); 

?>