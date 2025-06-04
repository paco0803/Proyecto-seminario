<?php
session_start();
require_once('validar_admin.php');
validar_admin();

if(isset ($_GET['email']) ){
    $email = $_GET['email'];
}

if(isset($_GET['nombre'])){
    $nombre = $_GET['nombre'];
}

if(isset($_GET['nombre_categoria'])){
    $nombre_categoria = $_GET['nombre_categoria'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición Exitosa</title>
    <link rel="stylesheet" href="../estilos/estilos_login.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .success-message {
            color: #4a90e2;
            font-size: 1.2rem;
            margin-bottom: 24px;
        }
        .volver-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .volver-btn:hover {
            background-color: #357ab8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edición exitosa</h1>
        <?php 
        if(isset($email)){
            echo '<div class="success-message">El usuario con correo electrónico <b>'.$email.'</b> se modificó exitosamente.</div>';
            echo '<a href="admin.php" class="volver-btn">Volver al panel administrativo</a>';
        }
        if(isset($nombre)){
            echo '<div class="success-message">El producto <b>'.$nombre.'</b> se modificó exitosamente.</div>';
            echo '<a href="productos_admin.php" class="volver-btn">Volver al panel administrativo</a>';
        }
        if(isset($nombre_categoria)){
            echo '<div class="success-message">La categoria <b>'.$nombre_categoria.'</b> se modificó exitosamente.</div>';
            echo '<a href="categorias.php" class="volver-btn">Volver al panel administrativo</a>';
        }
        ?>
        
    </div>
</body>
</html>