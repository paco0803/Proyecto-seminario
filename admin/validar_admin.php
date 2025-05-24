<?php
function validar_admin(){
    #validacion de que el que ingrese a este modulo sea un adminitrador
    if($_SESSION['tipo'] != 1){
        header('location: ../cerrar_sesion.php');
        exit();
    }
}
?>
