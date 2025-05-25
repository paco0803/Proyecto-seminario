<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../estilos/estilos_signin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    
    <div class="main-container">
        <div class="volver">
    <a href="../landing/index.php"  title="Volver a la página principal">
        <i class="fa-solid fa-arrow-left" ></i>
    </a>
     </div>
        <div class="white-section">
            

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
            </div>
        </div>
        <div class="pantalla_verde"></div>
    </div>
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


