<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 0.9em;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        select {
            width: calc(100% - 12px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        select {
            appearance: none;
            background-color: #fff;
            background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position-x: 100%;
            background-position-y: 5px;
            padding-right: 30px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 0.8em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign in</h2>
        <form id="registroForm" action="insertar_usuario.php" method="POST" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email_usuario" name="email_usuario" required>
                <div id="emailError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password_usuario" name="password_usuario" required>
                <div id="passwordError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required>
                <div id="nombreError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido_usuario" name="apellido_usuario" required>
                <div id="apellidoError" class="error-message"></div>
            </div>
            <button type="submit" class="submit_button">Registrarse</button>
        </form>
        <script>
        function validarFormulario() {
            let valido = true;
            const email = document.getElementById('email_usuario');
            const nombres = document.getElementById('nombre_usuario');
            const apellidos = document.getElementById('apellido_usuario');
            
            // Validar email
            if (!email.value || !email.validity.valid) {
                document.getElementById('email_usuario-error').style.display = 'block';
                valido = false;
            } else {
                document.getElementById('email_usuario-error').style.display = 'none';
            }
            
            // Validar nombres
            if (!nombres.value.trim()) {
                document.getElementById('nombre_usuario-error').style.display = 'block';
                valido = false;
            } else {
                document.getElementById('nombre_usuario-error').style.display = 'none';
            }
            
            // Validar apellidos
            if (!apellidos.value.trim()) {
                document.getElementById('apellido_usuario-error').style.display = 'block';
                valido = false;
            } else {
                document.getElementById('apellido_usuario-error').style.display = 'none';
            }
            return valido;
        }
    </script>
    </body>
    </html>  
   