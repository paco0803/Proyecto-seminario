<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/estilos_login.css">
</head>
<body>
    <div class="pantalla_verde">
    
    </div>
    <form id="login_form" action="login.php" method="POST">
        <h2 style="text-align:center; margin-bottom: 24px; ">Login</h2>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Ingrese su correo electronico"><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Ingrese su clave"><br>

        <button type="submit" class="submit_button">Iniciar sesion</button>
    </form>
</body>
</html>