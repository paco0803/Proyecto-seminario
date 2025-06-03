<?php
session_start();
require_once('validar_admin.php');
validar_admin();

$email = $_POST['email'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$clave = $_POST['clave'];
$tipo = $_POST['tipo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
            justify-content: center;
        }
        h1 {
            color: #2d3e50;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 0;
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 1px;
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
            color: #357ab8;
            text-align: center;
            margin-bottom: 28px;
            font-size: 1.3rem;
            font-weight: 600;
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
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bfc9d1;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 2px;
            background: #f7fafc;
            transition: border 0.2s;
        }
        input[type="text"]:focus, input[type="email"]:focus, select:focus {
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
            const nombres = document.getElementById('nombre_usuario');
            const apellidos = document.getElementById('apellido_usuario');
            const clave = document.getElementById('clave_usuario');

            document.querySelectorAll('.error-message').forEach(e => e.textContent = '');

            // Validar email
            if (!email.value || !email.validity.valid) {
                document.getElementById('emailError').textContent = 'Ingrese un correo válido';
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
            // Clave puede estar vacía (solo se cambia si se escribe algo)
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
                <h2>Editar usuario </h2>
                <form id="registroForm" action="editar.php" method="POST" onsubmit="return validarFormulario()">
                    <div class="form-group">
                        <label for="email_usuario">Correo Electrónico:</label>
                        <input type="email" id="email_usuario" name="email_usuario" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        <div id="emailError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="nombre_usuario">Nombre:</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($nombre); ?>" required>
                        <div id="nombreError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="clave_usuario">Clave (dejar en blanco para no cambiar):</label>
                        <input type="text" id="clave_usuario" name="clave_usuario" value="">
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="apellido_usuario">Apellido:</label>
                        <input type="text" id="apellido_usuario" name="apellido_usuario" value="<?php echo htmlspecialchars($apellido); ?>" required>
                        <div id="apellidoError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_usuario">Rol</label>
                        <select id="tipo_usuario" name="tipo_usuario" required>
                            <?php 
                            if($tipo == 1) {
                                echo '<option value="1" selected>Administrador</option>
                                      <option value="2">Cliente</option>';
                            } else {
                                echo '<option value="2" selected>Cliente</option>
                                      <option value="1">Administrador</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="submit_button">Editar</button>
                </form>
            </div>
        </div>
        <div class="pantalla_verde"></div>
    </div>
</body>
</html>