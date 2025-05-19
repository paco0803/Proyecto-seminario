<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/estilos_login.css">
    <style>
        .back-arrow {
            display: inline-block;
            margin-bottom: 16px;
            font-size: 24px;
            text-decoration: none;
            color: #4a90e2;
            transition: color 0.2s;
        }
        .back-arrow:hover {
            color: #357ab8;
        }
    </style>
</head>
<body>
    <div class="pantalla_verde">
    
    </div>
    <a href="../landing/index.php" class="back-arrow" title="Volver a la página principal">&#8592; Volver a la página principal</a>
    <div>
        <form id="login_form" action="login.php" method="POST">
            <h2 style="text-align:center; margin-bottom: 24px; ">Login</h2>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Ingrese su correo electronico"><br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Ingrese su clave"><br>

            <button type="submit" class="submit_button">Iniciar sesion</button>
        </form>
       <a href="../sign_in/registro_index.php" style="display: block; margin-top: 16px; text-align: center;">
        <button type="button" class="submit_button" style="width: 100%;">Registrarse</button>
    </a>
    </div>
    

</body>
</html>