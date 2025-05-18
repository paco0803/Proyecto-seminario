<?php
session_start();
require_once('../conexion.php');
require_once('./categorias.php');
require_once('./productos.php');
require_once('./texto.php');
$conn = conexionBD();
$idCategoria=null;
if(isset($_POST['id_categoria'])){
    $idCategoria= $_POST['id_categoria'];
}


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
            <a href="index.php">
                 <img src="./logo.png" alt="logo">
            </a>
             
        </div>
        <div class="contendor_buscador">
          
                <input type="text" placeholder="Buscar">
        </div>

        <div class="contenedor_botones">
            <a href="../login/login_index.php">
                <button>Iniciar Sesion</button>
            </a>
            
             <a href="../sign_in/registro_index.php">
                <button>Registrarse</button>
            </a>
        </div>
    </header>
    <nav>
         <?php mostrar_categorias($conn) ?>
        
       
    </nav>

    <section class="texto-principal">
        <?php mostra_texto($conn,$idCategoria) ?>
    </section>

     <section class="section_productos">
        
           <?php mostrar_productos($conn,$idCategoria) ?>
     </section>

     <section class="section_boton">
        <a href="../login/login_index.php">
            <button>Ver mas</button>
        </a>
     </section>
</body>
</html>