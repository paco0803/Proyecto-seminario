<?php
session_start();
require_once('validar_admin.php');
validar_admin();

require_once('../modal.php');
if(isset($_GET['modal'])){
    echo modal("Categoria ya existente", "La categoria ya esta registrada en el sistema", 1, "Volver al panel", "categorias.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Nueva Categoria</title>

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
        const nombre = document.getElementById('nombre_categoria');

        // Limpiar mensajes previos
        document.querySelectorAll('.error-message').forEach(e => e.textContent = '');

        // Validar nombre
        if (!nombre.value.trim()) {
            document.getElementById('nombreError').textContent = 'El nombre de la categoría es obligatorio';
            valido = false;
        }

        return valido;
    }
    </script>
</head>
<body>
    <div class="main-container">
        <div class="volver">
            <a href="categorias.php"  title="Volver a la página principal">
                <i class="fa-solid fa-arrow-left"></i> Volver al panel
            </a>
        </div>
        <div class="white-section">
            <div class="container">
                <h2>Insertar Nueva Categoria</h2>
                <form id="registroForm" action="insertar_categoria.php" method="POST" onsubmit="return validarFormulario()">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                        <div id="emailError" class="error-message"></div>
                    </div>
                    <button type="submit" class="submit_button">Registrar categoria</button>
                </form>
            </div>
        </div>
        <div class="pantalla_verde"></div>
    </div>
</body>
</html>