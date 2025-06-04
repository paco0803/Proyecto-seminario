<?php
session_start();
require_once('validar_admin.php');
validar_admin();


$nombre = $_POST['nombre'];

include ('../conexion.php');
$conn = conexionBD();
//Estableciendo caracteres UTF8 para BD, importante para acentos y eñes en MySQL                            
mysqli_set_charset($conn, "utf8");
                              
                              
// Check connection
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}

//Comprobación que la dirección de email no esté registrada

$consulta_categorias = mysqli_query($conn, "SELECT * FROM categorias WHERE nombre_categoria = '$nombre'");

if(!$consulta_categoria){
    echo "No se realizo la consulta";
}else{
    $numResults = $consulta_productos->num_rows;
}
if ($numResults != 0) {
    header(header: "location: crear_categoria.php?modal=true");
    exit();
}

$sql = "INSERT INTO categorias (nombre_categoria) VALUES ('$nombre')";

if (mysqli_query($conn, $sql)) {
   header("location: creacion_exitosa.php?nombre_categoria=$nombre");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    
mysqli_close($conn);

exit(); 

?>