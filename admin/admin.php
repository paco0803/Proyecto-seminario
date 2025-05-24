<?php
require_once('validar_admin.php');

validar_admin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administrador</title>
</head>
<body>
    <h1>Panel de administrador</h1>
    
    <p>Bienvenido: <?php echo $_SESSION['nombre'] ." ". $_SESSION['apellido']; ?></p>

    <p><a href="insertar_usuario.php">Insertar nuevo usuario</a></p>

    <p><a href="lista_usuarios.php">Ver usuarios</a></p>
    
    <p><a href="../cerrar_sesion.php">Cerrar sesión</a></p>
</body>
</html>