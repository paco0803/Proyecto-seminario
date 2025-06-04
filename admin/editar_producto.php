<?php
session_start();
require_once('validar_admin.php');
validar_admin();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$categoria = $_POST['categoria'];

include ('../conexion.php');
$conexion = conexionBD();
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM categorias";
$resultado = mysqli_query($conexion, $sql);
$categorias= mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .main-container {
            max-width: 480px;
            margin: 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(33,118,174,0.10);
            padding: 32px 32px 24px 32px;
        }
        .volver {
            margin-bottom: 18px;
        }
        .volver a {
            color: #4a90e2;
            text-decoration: none;
            font-size: 1.2rem;
            transition: color 0.2s;
        }
        .volver a:hover {
            color: #357ab8;
        }
        .form-title {
            text-align: center;
            font-size: 1.5rem;
            color: #2176ae;
            margin-bottom: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .form-group {
            margin-bottom: 22px;
        }
        label {
            display: block;
            margin-bottom: 7px;
            color: #2176ae;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #b3e0ff;
            border-radius: 8px;
            background: #f7fbff;
            font-size: 1rem;
            color: #333;
            transition: border 0.2s;
        }
        input[type="text"]:focus, select:focus {
            border-color: #4a90e2;
            outline: none;
        }
        .error-message {
            color: #e74c3c;
            font-size: 0.95rem;
            margin-top: 4px;
            display: none;
        }
        .submit_button {
            width: 100%;
            padding: 12px 0;
            background: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        .submit_button:hover {
            background: #357ab8;
        }
        .custom-file-input {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .custom-file-input input[type="file"] {
            opacity: 0;
            width: 100%;
            height: 44px;
            position: absolute;
            left: 0;
            top: 0;
            cursor: pointer;
            z-index: 2;
        }
        .file-label {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            background: #eaf1fb;
            border: 1px solid #bfc9d1;
            border-radius: 6px;
            padding: 10px;
            font-size: 16px;
            color: #357ab8;
            cursor: pointer;
            transition: border 0.2s, background 0.2s;
            min-height: 44px;
            z-index: 1;
        }
        .file-label i {
            margin-right: 10px;
            color: #4a90e2;
            font-size: 20px;
        }
        .file-label.selected {
            background: #d0e6fa;
            border: 1.5px solid #4a90e2;
            color: #2d3e50;
        }
        .file-name {
            margin-left: 8px;
            color: #2d3e50;
            font-size: 15px;
            font-style: italic;
            word-break: break-all;
        }
        @media (max-width: 600px) {
            .main-container {
                padding: 18px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="volver">
            <a href="productos_admin.php" title="Volver a la página principal">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
        <div class="form-title">
            Editar producto
        </div>
        <form id="registroForm" action="editar_p.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="form-group">
                <label for="nombre_producto">Nombre</label>
                <input type="text" id="nombre_producto" name="nombre_producto" value="<?php echo htmlspecialchars($nombre); ?>" required>
                <div id="nombreError" class="error-message">El nombre es obligatorio.</div>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="text" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>">
                <div id="cantidadError" class="error-message">La cantidad debe ser un número mayor o igual a 0.</div>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($descripcion); ?>" required>
                <div id="descripcionError" class="error-message">La descripción es obligatoria.</div>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="text" id="precio" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required>
                <div id="precioError" class="error-message">El precio es obligatorio.</div>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <div class="custom-file-input">
                    <label for="imagen" class="file-label" id="fileLabel">
                        <i class="fa-solid fa-image"></i>
                        <span id="fileLabelText">Seleccionar archivo (Se reescribira el ya existente)</span>
                    </label>
                    <input type="file" id="imagen" name="imagen" onchange="mostrarNombreArchivo()">
                </div>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <?php 
                    if($resultado && mysqli_num_rows($resultado) > 0) {
                        foreach($categorias as $fila){
                            echo "<option value=\"{$fila['id_categoria']}\"".($fila['id_categoria'] == $categoria ? " selected" : "").">".htmlspecialchars($fila['nombre_categoria'])."</option>";
                        }
                    }
                    ?>
                </select>
                <div id="categoriaError" class="error-message">Selecciona una categoría.</div>
            </div>
            <button type="submit" class="submit_button">Guardar Cambios</button>
        </form>
    </div>
    <script>
    function validarFormulario() {
        let valido = true;

        // Obtener campos
        const nombre = document.getElementById('nombre_producto');
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

    function mostrarNombreArchivo() {
        const input = document.getElementById('imagen');
        const label = document.getElementById('fileLabel');
        const labelText = document.getElementById('fileLabelText');
        if (input.files && input.files.length > 0) {
            label.classList.add('selected');
            labelText.textContent = input.files[0].name;
        } else {
            label.classList.remove('selected');
            labelText.textContent = "Seleccionar archivo...";
        }
    }
    </script>
</body>
</html>