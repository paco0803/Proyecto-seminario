<?php
session_start();
require_once('../conexion.php');
require_once('./categorias.php');
require_once('./productos.php');
require_once('./texto.php');
require_once('./busqueda.php');
require_once('../modal.php');
require_once('../carrito/cargar_carrito.php');
//para conectar a la base de datos
$conn = conexionBD();
//creamos variables y asignamos valor a la varible para poder filtrar por categoria
$idCategoria=null;
if(isset($_POST['id_categoria'])){
    $idCategoria= $_POST['id_categoria'];
}
//creamos variables y asignamos valor a la varible para poder buscar por nombre
$nombreProducto=null;
if(isset($_POST['nombre_producto'])){
    $nombreProducto=$_POST['nombre_producto'];
}
 //para abrir modal y cerrar la sesion 
if (isset($_POST['abrir_modal'])) {
    echo modal($titulo="Cerrar Sesion", $texto="¿Estás seguro de que deseas cerrar tu sesión?",$usar=1,$textoboton="Cerrar Sesion",$url="../cerrar_sesion.php"); // Ejecutamos la función   
}

if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 2){
    guardar_carrito_en_sesion();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/estilos_landig.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <header>
        <div class="contenedor_logo">
            <a href="index.php">
                 <img src="./logo.png" alt="logo">
            </a>
             
        </div>

        <div class="contendor_buscador">
          <?php 
            busqueda();
          ?>
               
        </div>


<div class="contenedor_botones">
<?php
// Validación para mostrar dos botones si la variable de sesión es diferente a 2 (cliente)
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 2) {
    ?>
    <a href="../login/login_index.php">
        <button>Iniciar Sesion</button>    
    </a>
    <a href="../sign_in/registro_index.php">
        <button>Registrarse</button>
    </a>
<?php } else { ?>
    <form method="post">
        <button type="submit" name="abrir_modal">Cerrar Sesion</button>
    </form>
    <form action="../carrito/mostrarcarrito.php" method="post"  style="display:inline;">
        <input type="hidden" name="ver_carrito" value="1">
        <button type="submit" class="boton_carrito" title="Ver carrito" style="position: relative; display: inline-block;">
            <i class="fa-solid fa-cart-shopping" id="carrito"></i>
            <?php if(isset($_SESSION['CARRITO']) && count($_SESSION['CARRITO']) > 0): ?>
                <span class="carrito-contador">
                    <?php echo count($_SESSION['CARRITO']); ?>
                </span>
            <?php endif; ?>
        </button>
    </form>
<?php } ?>
</div>
          
            
        </div>
    </header>
    <nav>
         <?php mostrar_categorias($conn) ?>
        
       
    </nav>

    <section class="texto-principal">
        <?php mostra_texto($conn,$idCategoria) ?>
    </section>

     <section class="section_productos">
        
           <?php mostrar_productos($conn,$idCategoria,$nombreProducto) ?>
     </section>

     <section class="section_boton">
    
          <?php
          //validacion para mostar el boton de ver mas si estas en la landing 
          if(isset($_SESSION['tipo']) != 2){   ?>
               
        <a href="../login/login_index.php">
            <button>Ver mas</button>
        </a>
          <?php  }  ?>
     </section>
     <footer>
        Proyecto universitario
     </footer>
</body>
</html>
<?php
