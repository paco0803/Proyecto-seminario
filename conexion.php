<?php
function conexionBD(){
    #Variables de sesion para la base de datos
    $server = "localhost";
    $username = "root";
    $password = "";
    $data_base = "proyectoseminario";

    #conexion a base de datos
    $conexion = mysqli_connect("localhost", "root", "", "proyectoseminario") or die("Error de conexion con la base de datos");

    return $conexion;
}

function disconexionBD($conexion){
    $desconexion = mysqli_close($conexion) or die("Erro al desconectar de la base de datos");
    return $desconexion;
}
?>

