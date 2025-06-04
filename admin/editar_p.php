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
$imagen = $_FILES['imagen'];

$nombre_imagen_final = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['name'] != "") {
    $tipo_archivo = $_FILES['imagen']['type'];
    $tamano = $_FILES['imagen']['size'];
    $temp = $_FILES['imagen']['tmp_name'];

    if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png")) && ($tamano < 2000000))) {
        echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
        - Se permiten archivos .gif, .jpg, .png. y de 2 MB como máximo.</b></div>';
        exit();
    } else {
        $nombre_imagen_final = uniqid() . "_" . basename($_FILES['imagen']['name']);
        if (move_uploaded_file($temp, '../imagenes/' . $nombre_imagen_final)) {
            chmod('imagenes/' . $nombre_imagen_final, 0777);
        } else {
            echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
            exit();
        }
    }
}

if ($nombre_imagen_final) {
    $query = "UPDATE productos SET 
        cantidad_producto = '$cantidad',
        nombre_producto = '$nombre',
        precio_producto = '$precio',
        descripcion_producto = '$descripcion',
        id_categoria = '$categoria',
        imagen = '$nombre_imagen_final'
        WHERE id_producto = '$id'";
} else {
    $query = "UPDATE productos SET 
        cantidad_producto = '$cantidad',
        nombre_producto = '$nombre',
        precio_producto = '$precio',
        descripcion_producto = '$descripcion',
        id_categoria = '$categoria'
        WHERE id_producto = '$id'";
}

if(mysqli_query($conexion, $query)){
    header("location: edicion_exitosa.php?nombre=$nombre");
}else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
?>