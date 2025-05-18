<?php
include('../conexion.php');

$email_nuevo_usuario = $_POST['email_usuario'];
$password_nuevo_usuario = $_POST['password_usuario'];
$nombres_nuevo_usuario = $_POST['nombre_usuario'];
$apellidos_nuevo_usuario = $_POST['apellido_usuario'];
$password_encriptado_nuevo_usuario = md5($password_nuevo_usuario);

$conn = conexionBD();
//Estableciendo caracteres UTF8 para BD, importante para acentos y eñes en MySQL                            
mysqli_set_charset($conn, "utf8");
                              
                              
// Check connection
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}

//Comprobación que la dirección de email no esté registrada

$consulta_email = mysqli_query($conn, "SELECT * FROM usuarios WHERE correo_usuario = '$email_nuevo_usuario'");

if(!$consulta_email){
    echo "No se realizo la consulta";
}else{
    $numResults = $consulta_email->num_rows;
}
if ($numResults != 0) {
    header("Location: email_existente.php?email_usuario=$email_nuevo_usuario");
    exit(); 
    }

$sql = "INSERT INTO usuarios (correo_usuario, clave_usuario, nombre_usuario, apellido_usuario) 
VALUES ('$email_nuevo_usuario', '$password_encriptado_nuevo_usuario', '$nombres_nuevo_usuario', '$apellidos_nuevo_usuario')";

if (mysqli_query($conn, $sql)) {
    header("location: registro_exitoso.php?email=$email_nuevo_usuario");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

exit(); 

?>