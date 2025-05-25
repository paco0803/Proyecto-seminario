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

$email = $_POST['email_usuario'];
$nombre = $_POST['nombre_usuario'];
$apellido = $_POST['apellido_usuario'];
$clave = $_POST['clave_usuario'];
$clave_encriptada = md5($clave);
$tipo = $_POST['tipo_usuario'];

if($clave == ""){
    $query = "UPDATE usuarios SET nombre_usuario = '$nombre', apellido_usuario = '$apellido', tipo_usuario = '$tipo' WHERE correo_usuario = '$email'";
}else{
    $query = "UPDATE usuarios SET nombre_usuario = '$nombre', apellido_usuario = '$apellido', tipo_usuario = '$tipo', clave_usuario = '$clave_encriptada' WHERE correo_usuario = '$email'";
}

if(mysqli_query($conexion, $query)){
    header("location: edicion_exitosa.php?email=$email");
}else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
?>