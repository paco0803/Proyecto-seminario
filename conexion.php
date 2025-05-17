<?php 
function connectBD(){
   $servername = "localhost";
$database = "proyectoseminario";  
$username = "root";        
$password = "";   
    
    //crear la conexion
    $conn = mysqli_connect($servername, $username,$password,$database)
    or die("ha sucedidio un error en la conexion de la base de datos");
    return $conn;
}

function disconnectBD($conexion){
    $close= mysqli_close($conexion)
    or die ("ha sucedidio un error en la desconexion de la base de datos ");
    return $close;
}


?>