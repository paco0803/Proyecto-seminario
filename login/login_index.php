<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/estilos_login.css">
<<<<<<< HEAD
    <style>
        .back-arrow {
            display: inline-block;
            margin-bottom: 16px;
            font-size: 24px;
            text-decoration: none;
            color: #4a90e2;
            transition: color 0.2s;
        }
    </style>
=======
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
>>>>>>> 512f4700a00789609126cf66a7fae57dd4ff4424
</head>
<body>
    <div class="pantalla_verde">
    
    </div>
<<<<<<< HEAD
    <a href="../landing/index.php" class="back-arrow" title="Volver a la página principal">Volver a la página principal</a>
    <div>
        <form id="login_form" action="login.php" method="POST">
=======
    
    <div class="volver">

    <a href="../landing/index.php"  title="Volver a la página principal">

        <i class="fa-solid fa-arrow-left" ></i>
    </a>

     </div>
    <div id="login_form">
        <form  action="login.php" method="POST">
>>>>>>> 512f4700a00789609126cf66a7fae57dd4ff4424
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