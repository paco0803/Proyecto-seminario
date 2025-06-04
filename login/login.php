<?php
session_start();

include("../conexion.php"); #Importacion del fichero conexion
require_once("../modal.php");//para utlilizar el modal en caso de requerirlo
#Variables recibidas por metodo post del login_index
$email = $_POST['email'];
$password = $_POST['password'];
$password_encriptado = md5($password); 

$conexion = conexionBD(); #conexion a base de datos

if($conexion == false){
    die("Error de conexion con base de datos");
}

#Estableciendo caracteres UTF8                           
mysqli_set_charset($conexion, "utf8");

$consulta = "SELECT * from usuarios where correo_usuario = '$email' and clave_usuario = '$password_encriptado'";

$query = mysqli_query($conexion, $consulta); #consulta a base de datos usando la varible $consulta

$fila = mysqli_fetch_array($query); #Creacion de un array con el usuario traido de la consulta

if(mysqli_num_rows($query)>0){ #Verificacion de existencia del usuario con las credenciales introducidas
    #Asignacion a variables de sesion lo que nos trajo la query
    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['tipo'] = $fila['tipo_usuario'];
    $_SESSION['email'] = $email;
    $_SESSION['nombre'] = $fila['nombre_usuario'];
    $_SESSION['apellido'] = $fila['apellido_usuario'];
    $_SESSION['ultimo_acceso'] = date("Y-m-d H:i:s");

    #Determinar si el usuario que inicio sesion es un administrador o un cliente
    switch($_SESSION['tipo']){
        case 1:
            header("location: ../admin/admin.php");
            break;

        case 2:
            header("location: ../landing/index.php");
            break;
    }
     mysqli_close($conexion);
    exit;
}else{
    header("location: login_index.php?modal=true");
     mysqli_close($conexion);
    exit;
}
?>