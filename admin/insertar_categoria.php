<?php
$nombre = $_POST['nombre'];
$nombre_confirmacion = strtolower(string: trim($nombre));

include ('../conexion.php');
$conn = conexionBD();
mysqli_set_charset($conn, "utf8");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$consulta_categorias = mysqli_query($conn, "SELECT * FROM categorias WHERE LOWER(TRIM(nombre_categoria)) = '$nombre_confirmacion'");

if(!$consulta_categorias){
    echo "No se realizo la consulta";
    exit();
} else {
    $numResults = $consulta_categorias->num_rows;
}

if ($numResults != 0) {
    header("Location: crear_categoria.php?modal=true");
    exit();
}

$sql = "INSERT INTO categorias (nombre_categoria) VALUES ('$nombre')";

if (mysqli_query($conn, $sql)) {
   header("Location: creacion_exitosa.php?nombre_categoria=$nombre");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
exit();