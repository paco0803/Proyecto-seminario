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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
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
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }
        
        .required-field::after {
            content: " *";
            color: red;
        }
        
        button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #357ab8;
        }
        
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro exitoso</h1>
        <?php 
        if(isset($email)){
            echo '<div class="success-message">El usuario <b>'.$email.'</b> se creo exitosamente.</div>'.'<br>';
        }
        if(isset($nombre)){
            echo '<div class="success-message">El producto <b>'.$nombre.'</b> se creo exitosamente.</div>'.'<br>';
        }
        ?>
         <a href="admin.php">
                <button class="submit_button">Volver al panel administrativo    </button>
            </a>
    </div>

   
</body>
</html>