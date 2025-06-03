<?php
session_start();
require_once('validar_admin.php');
validar_admin();

include ('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM categorias";
$consulta = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Nuevo Producto</title>
    
    <style>
        body {
    background: #f4f6f8;
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    }
    .main-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center; /* Cambia de flex-start a center */
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
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bfc9d1;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 2px;
            background: #f7fafc;
            transition: border 0.2s;
        }
        input[type="text"]:focus, select:focus {
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

        // Obtener campos
        const nombre = document.getElementById('nombre');
        const descripcion = document.getElementById('descripcion');
        const precio = document.getElementById('precio');
        const cantidad = document.getElementById('cantidad');
        const categoria = document.getElementById('categoria');

        // Limpiar mensajes previos
        document.querySelectorAll('.error-message').forEach(e => e.textContent = '');

        // Validar nombre
        if (!nombre.value.trim()) {
            nombre.nextElementSibling.textContent = 'El nombre es obligatorio';
            valido = false;
        }

        // Validar descripción
        if (!descripcion.value.trim()) {
            descripcion.nextElementSibling.textContent = 'La descripción es obligatoria';
            valido = false;
        }

        // Validar precio (número positivo)
        if (!precio.value.trim() || isNaN(precio.value) || Number(precio.value) <= 0) {
            precio.nextElementSibling.textContent = 'Ingrese un precio válido y positivo';
            valido = false;
        }

        // Validar cantidad (entero positivo)
        if (!cantidad.value.trim() || isNaN(cantidad.value) || !Number.isInteger(Number(cantidad.value)) || Number(cantidad.value) < 0) {
            cantidad.nextElementSibling.textContent = 'Ingrese una cantidad válida (entero positivo)';
            valido = false;
        }

        // Validar categoría
        if (!categoria.value) {
            categoria.nextElementSibling.textContent = 'Seleccione una categoría';
            valido = false;
        }

        return valido;
    }
    </script>
</head>
<body>
    <div class="main-container">
        <div class="volver">
            <a href="productos_admin.php" title="Volver a productos">
                <i class="fa-solid fa-arrow-left"></i> Volver a productos
            </a>
        </div>
        <div class="white-section">
            <div class="container">
                <h2>Insertar nuevo producto</h2>
                <form id="registroForm" action="insertar_producto.php" method="POST" onsubmit="return validarFormulario()">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio:</label>
                        <input type="text" id="precio" name="precio" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" id="cantidad" name="cantidad" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría:</label>
                        <select id="categoria" name="categoria" required>
                            <?php 
                            if($consulta && mysqli_num_rows($consulta) > 0) {
                                while($fila = mysqli_fetch_assoc($consulta)){
                                    echo "<option value=\"{$fila['id_categoria']}\">".htmlspecialchars($fila['nombre_categoria'])."</option>";
                                }
                            } else {
                                echo '<option disabled selected>No hay categorías disponibles</option>';
                            }
                            ?>
                        </select>
                        <div class="error-message"></div>
                    </div>
                    <button type="submit" class="submit_button">Registrar producto</button>
                </form>
            </div>
        </div>
        <div class="pantalla_verde"></div>
    </div>
</body>
</html>