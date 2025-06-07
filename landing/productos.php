    <?php
    require_once("./imprimir_productos.php");
    function mostrar_productos($conn, $idCategoria = null, $nombreProducto = null)
    {


        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //busqueda condicional
        if ($nombreProducto == null) {

            if ($idCategoria == null) {
                $sql_productos = "SELECT nombre_producto, precio_producto, id_producto, imagen FROM productos";
                $resultado_producto = mysqli_query($conn, $sql_productos);

                $productos = mysqli_fetch_all($resultado_producto, MYSQLI_ASSOC);

                if ($resultado_producto && mysqli_num_rows($resultado_producto) > 0) {
                    $mostrar = 0;
                    foreach ($productos as $producto) {
                        if (isset($_SESSION['tipo']) != 2) {
                            if ($mostrar < 6) {
                                echo   imprimir_productos($producto);
                                $mostrar++;
                            } else {
                                break;
                            }
                        } else {
                            echo   imprimir_productos($producto);
                        }
                    }
                } else {
                    echo "<p>NO hay producto disponibles</p>";
                }
            } else {

                $sql_productos = "SELECT nombre_producto, precio_producto, id_producto, imagen FROM productos WHERE id_categoria=$idCategoria";
                $resultado_producto = mysqli_query($conn, $sql_productos);

                $productos = mysqli_fetch_all($resultado_producto, MYSQLI_ASSOC);

                if ($resultado_producto && mysqli_num_rows($resultado_producto) > 0) {
                    $mostrar = 0;
                    foreach ($productos as $producto) {
                         if (isset($_SESSION['tipo']) != 2) {
                            if ($mostrar < 6) {
                                echo   imprimir_productos($producto);
                                $mostrar++;
                            } else {
                                break;
                            }
                        } else {
                            echo   imprimir_productos($producto);
                        }
                    }
                } else {
                    echo "<p>NO hay producto disponibles</p>";
                }
            }
        } else {
            if ($nombreProducto != null) {

                $trim_nombre_producto = trim($nombreProducto);
                $sql = "SELECT nombre_producto, precio_producto, id_producto,  imagen FROM productos WHERE nombre_producto LIKE '%$trim_nombre_producto%'";
                //uso esta sentencia sql para que la busqueda pueda conseguir todo aquellos productos que contengan la palabra que contenga la variable 
                $resultado = mysqli_query($conn, $sql);
                $busqueda_nombre = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

                if ($busqueda_nombre && mysqli_num_rows($resultado) > 0) {
                    $mostrar = 0;
                    foreach ($busqueda_nombre as $producto) {
                        if (isset($_SESSION['tipo']) != 2) {
                            if ($mostrar < 6) {
                                echo   imprimir_productos($producto);
                                $mostrar++;
                            } else {
                                break;
                            }
                        } else {
                            echo   imprimir_productos($producto);
                        }
                    }
                } else {
                    echo "<p>NO hay producto disponibles</p>";
                }
            }
        }
    }
