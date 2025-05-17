<?php
// test_conexion.php
$conn = mysqli_connect('localhost', 'ProyectoSeminario', 'proyectoseminario', 'proyectoseminario');
if ($conn) {
    echo "Conexión exitosa";
} else {
    echo "Error de conexión: " . mysqli_connect_error();
}
?> #0056b3