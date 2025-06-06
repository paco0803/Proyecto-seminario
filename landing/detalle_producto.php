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
    <link rel="stylesheet" href="../estilos/estilos_producto_detalle.css">

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

                <div class="contenedor_producto_detalle">
    <?php 
    require_once("./imprimir_productos.php");
    require_once('../conexion.php');
    
    $conn = conexionBD();
    $id_producto = $_GET['id'] ?? null; 

    if ($id_producto) {
        $id_producto = filter_var($id_producto, FILTER_SANITIZE_NUMBER_INT);
        
        // Consulta corregida (sin typo)
        $sql_producto = "SELECT nombre_producto, precio_producto, id_producto, descripcion_producto, imagen 
                        FROM productos 
                        WHERE id_producto = $id_producto";
        $resultado_producto = mysqli_query($conn, $sql_producto);

        if ($resultado_producto && mysqli_num_rows($resultado_producto) > 0) {
            $producto = mysqli_fetch_assoc($resultado_producto);
            
            // Estructura mejorada para mostrar detalles del producto
            echo '
            <div class="detalle_producto_container">
                <div class="imagen_producto_detalle">
                    <img src="../imagenes/' . htmlspecialchars($producto['imagen']) . '" 
                         alt="' . htmlspecialchars($producto['nombre_producto']) . '">
                </div>
                
                <div class="info_producto_detalle">
                    <h1>' . htmlspecialchars($producto['nombre_producto']) . '</h1>
                    <p class="precio">' . htmlspecialchars("$" . $producto['precio_producto']) . '</p>
                    
                    ' . (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 2 ? '
                    <form method="post" action="../carrito/cargar_carrito.php">
                        <input type="hidden" name="id_producto" value="' . $producto['id_producto'] . '">
                         <input type="hidden" name="precio_unitario" value="'. $producto['precio_producto'].'">
                        <label>Cantidad: 
                            <input type="number" name="cantidad" value="1" min="1">
                        </label>

                        <div>
                        <button type="submit" class="btn_agregar_carrito">Agregar al carrito</button>
                        </div>
                    </form>
                    ' : '
                    <p class="requiere_login">Debes iniciar sesión para comprar</p>
                    ') . '
                    
                    <div class="descripcion_producto">
                        <h2>Datos del producto</h2>
                        <p>' . htmlspecialchars($producto['descripcion_producto'] ?? 'Descripción no disponible') . '</p>
                    </div>
                </div>
            </div>
            ';
        } else {
            echo "<p class='error'>No hay producto disponible</p>";
        }
    } else {
        echo "<p class='error'>No se ha especificado un producto</p>";
    }
    ?>
</div>

</body>
</html>
<?php
