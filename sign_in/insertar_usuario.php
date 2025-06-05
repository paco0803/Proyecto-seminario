<?php
include('../conexion.php');
session_start();

$email_nuevo_usuario = $_POST['email_usuario'];
$password_nuevo_usuario = $_POST['password_usuario'];
$nombres_nuevo_usuario = $_POST['nombre_usuario'];
$apellidos_nuevo_usuario = $_POST['apellido_usuario'];
if(isset($_POST['tipo_usuario'])){
     $tipo_nuevo_usuario = $_POST['tipo_usuario'];
}else{
   $tipo_nuevo_usuario = 2;
}
echo  $tipo_nuevo_usuario;
$password_encriptado_nuevo_usuario = md5($password_nuevo_usuario);

$nombre_confirmacion = strtolower(string: trim($nombre));

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
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1){
        header("location: ../admin/crear_usuario.php?modal=true");
        exit();
    }else{
        header("Location: registro_index.php?modal=true");
        exit(); 
    }
    
    }

$sql = "INSERT INTO usuarios (correo_usuario, clave_usuario, nombre_usuario, apellido_usuario, tipo_usuario) 
VALUES ('$email_nuevo_usuario', '$password_encriptado_nuevo_usuario', '$nombres_nuevo_usuario', '$apellidos_nuevo_usuario', '$tipo_nuevo_usuario')";

if (mysqli_query($conn, $sql)) {
    if($_SESSION['tipo'] == 1){
        header("location: ../admin/creacion_exitosa.php?email=$email_nuevo_usuario");
    }else{
        header("location: registro_exitoso.php?email=$email_nuevo_usuario");  
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
    
mysqli_close($conn);

exit(); 

?>