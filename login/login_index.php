<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        #login_form {
            background: #fff;
            padding: 30px 40px;
            margin: 80px auto;
            width: 320px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit_button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit_button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <form id="login_form" action="login.php" method="POST">
        <h2 style="text-align:center; margin-bottom: 24px;">Login</h2>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Ingrese su correo electronico"><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Ingrese su clave"><br>

        <button type="submit" class="submit_button">Iniciar sesion</button>
    </form>
</body>
</html>