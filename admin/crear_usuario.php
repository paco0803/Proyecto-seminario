<?php
session_start();
require_once('validar_admin.php');
validar_admin();

require_once('../modal.php');
if(isset($_GET['modal'])){
    echo modal("Usuario ya existente", "El usuario ya esta registrado en el sistema", 1, "Volver al panel", "admin.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Nuevo Usuario</title>

    <style>
        body {
            background: #f4f6f8;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .volver {
            width: 100%;
            max-width: 500px;
            margin: 32px 0 0 0;
        }
        .volver a {
            color: #4a90e2;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s;
        }
        .volver a:hover {
            color: #357ab8;
        }
        .white-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
            padding: 36px 32px 28px 32px;
            margin-top: 24px;
            max-width: 500px;
            width: 100%;
        }
        .container h2 {
            color: #2d3e50;
            text-align: center;
            margin-bottom: 28px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #357ab8;
            font-weight: 600;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bfc9d1;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 2px;
            background: #f7fafc;
            transition: border 0.2s;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus {
            border: 1.5px solid #4a90e2;
            outline: none;
        }
        .error-message {
            color: #e74c3c;
            font-size: 13px;
            min-height: 18px;
            margin-top: 2px;
        }
        .submit_button {
            width: 100%;
            background: #4a90e2;
            color: #fff;
            border: none;
            padding: 14px 0;
            border-radius: 6px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .submit_button:hover {
            background: #357ab8;
        }
        @media (max-width: 600px) {
            .white-section {
                padding: 20px 8px;
            }
            .volver, .white-section {
                max-width: 98vw;
            }
        }
    </style>
    <script>
       function validarFormulario() {
            let valido = true;
            const email = document.getElementById('email_usuario');
            const password = document.getElementById('password_usuario');
            const nombres = document.getElementById('nombre_usuario');
            const apellidos = document.getElementById('apellido_usuario');

            // Limpiar mensajes previos
            document.querySelectorAll('.error-message').forEach(e => e.textContent = '');

            // Validar email
            if (!email.value || !email.validity.valid) {
                document.getElementById('emailError').textContent = 'Ingrese un correo válido';
                valido = false;
            }

            // Validar password
            if (!password.value.trim() || password.value.length < 6) {
                document.getElementById('passwordError').textContent = 'La contraseña debe tener al menos 6 caracteres';
                valido = false;
            }

            // Validar nombres
            if (!nombres.value.trim()) {
                document.getElementById('nombreError').textContent = 'El nombre es obligatorio';
                valido = false;
            }

            // Validar apellidos
            if (!apellidos.value.trim()) {
                document.getElementById('apellidoError').textContent = 'El apellido es obligatorio';
                valido = false;
            }
            return valido;
        }
    </script>
</head>
<body>
    <div class="main-container">
        <div class="volver">
            <a href="admin.php"  title="Volver a la página principal">
                <i class="fa-solid fa-arrow-left"></i> Volver al panel
            </a>
        </div>
        <div class="white-section">
            <div class="container">
                <h2>Insertar Nuevo Usuario</h2>
                <form id="registroForm" action="../sign_in/insertar_usuario.php" method="POST" onsubmit="return validarFormulario()">
                    <div class="form-group">
                        <label for="email_usuario">Correo Electrónico:</label>
                        <input type="email" id="email_usuario" name="email_usuario" required>
                        <div id="emailError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="password_usuario">Contraseña:</label>
                        <input type="password" id="password_usuario" name="password_usuario" required>
                        <div id="passwordError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="nombre_usuario">Nombre:</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" required>
                        <div id="nombreError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="apellido_usuario">Apellido:</label>
                        <input type="text" id="apellido_usuario" name="apellido_usuario" required>
                        <div id="apellidoError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_usuario">Rol</label>
                        <select id="tipo_usuario" name="tipo_usuario" required>
                            <option value="1">Administrador</option>
                            <option value="2">Cliente</option>
                        </select>
                    </div>
                    <button type="submit" class="submit_button">Registrar usuario</button>
                </form>
            </div>
        </div>
        <div class="pantalla_verde"></div>
    </div>
</body>
</html>