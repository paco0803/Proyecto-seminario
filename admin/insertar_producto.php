<?php
session_start();
require_once('validar_admin.php');
validar_admin();


$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];
$imagen = $_FILES['imagen']['name'];

$nombre_confirmacion = strtolower(string: trim($nombre));


include ('../conexion.php');
$conn = conexionBD();
//Estableciendo caracteres UTF8 para BD, importante para acentos y eñes en MySQL                            
mysqli_set_charset($conn, "utf8");
                              
                              
// Check connection
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}

//Comprobación que la dirección de email no esté registrada

$consulta_productos = mysqli_query($conn, "SELECT * FROM productos WHERE LOWER(TRIM(nombre_producto)) = '$nombre_confirmacion'");

if(!$consulta_productos){
    echo "No se realizo la consulta";
    exit();
} else {
    $numResults = $consulta_productos->num_rows;
}

if ($numResults != 0) {
    header("Location: crear_producto.php?modal=true");
    exit();
}

if (isset($imagen) && $imagen != "") {

      $tipo_archivo = $_FILES['imagen']['type'];
      $tamano = $_FILES['imagen']['size'];
      $temp = $_FILES['imagen']['tmp_name'];

     if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png")) && ($tamano < 2000000))) {
      echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
      - Se permiten archivos .gif, .jpg, .png. y de 2000 kb como máximo.</b></div>';
   }
   else {
     $nombre_imagen_final = uniqid() . "_" . basename($imagen);
      if (move_uploaded_file($temp, 'imagenes/'.$nombre_imagen_final)) {
          chmod('imagenes/'.$nombre_imagen_final, 0777);

      }
      else {
         echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
      }
    }
}

$sql = "INSERT INTO productos (nombre_producto, precio_producto, descripcion_producto, id_categoria , cantidad_producto, imagen) 
VALUES ('$nombre', '$precio', '$descripcion', '$categoria', '$cantidad', '$nombre_imagen_fina'l)";

if (mysqli_query($conn, $sql)) {
   header("location: creacion_exitosa.php?nombre=$nombre");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    
mysqli_close($conn);

exit(); 

?>