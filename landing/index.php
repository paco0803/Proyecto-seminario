<?php
session_start();
require_once('../conexion.php');
require_once('./categorias.php');
require_once('./productos.php');
$conn = conexionBD();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/estilos_landig.css">
</head>
<body>
    <header>
        <div class="contenedor_logo">
              <img src="" alt="logo">
        </div>
        <div class="contendor_buscador">
          
                <input type="text" placeholder="Buscar">
        </div>

        <div class="contenedor_botones">
            <button>Iniciar Secion</button>
            <button>Registro</button> 
        </div>
    </header>
    <nav>
         <?php mostrar_categorias($conn) ?>
        
       
    </nav>

     <section class="section_productos">
           <?php mostrar_productos($conn) ?>
            
            
        </section>
</body>
</html>