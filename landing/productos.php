    <?php
    require_once("./imprimir_productos.php");
    function mostrar_productos($conn, $idCategoria = null, $nombreProducto = null)
    {
                //codigo para paginacion
                $productos_por_pagina = 6;
                $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                if ($pagina < 1) $pagina = 1;
                $offset = ($pagina - 1) * $productos_por_pagina;

                //consult apara busqueda
                $where = "";
                $query = "SELECT * FROM usuarios $where LIMIT $productos_por_pagina OFFSET $offset";
                $usuarios = mysqli_query($conn, $query);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //busqueda condicional
        if ($nombreProducto == null) {

            //para que muestre todos los productos sin haber filtrado por categorias
            if ($idCategoria == null) {
                $sql_productos = "SELECT nombre_producto, precio_producto, id_producto, imagen, cantidad_producto FROM productos";
                $resultado_producto = mysqli_query($conn, $sql_productos);

                $productos = mysqli_fetch_all($resultado_producto, MYSQLI_ASSOC);

                if ($resultado_producto && mysqli_num_rows($resultado_producto) > 0) {
                    $mostrar = 0;
                    foreach ($productos as $producto) {
                        //validacion para ver si iniciamos sesion o estamos en la landig
                        if (isset($_SESSION['tipo']) != 2) {
                            if ($mostrar < 6) {
                                //para mostar solo los productos que tengan stock
                               if($producto['cantidad_producto']>0){
                                    echo   imprimir_productos($producto);
                               }
                                
                                $mostrar++;
                            } else {
                                break;
                            }
                        } else {
                             //para mostar solo los productos que tengan stock
                               if($producto['cantidad_producto']>0){
                                    echo   imprimir_productos($producto);
                               }
                        }
                    }
                } else {
                    echo "<p>NO hay producto disponibles</p>";
                }
                //para buscar por filtrado de categoria
            } else {

                $sql_productos = "SELECT nombre_producto, precio_producto, id_producto, imagen, cantidad_producto FROM productos WHERE id_categoria=$idCategoria";
                $resultado_producto = mysqli_query($conn, $sql_productos);

                $productos = mysqli_fetch_all($resultado_producto, MYSQLI_ASSOC);

                if ($resultado_producto && mysqli_num_rows($resultado_producto) > 0) {
                    $mostrar = 0;
                    foreach ($productos as $producto) {
                        //validacion para ver si iniciamos sesion o estamos en la landig

                         if (isset($_SESSION['tipo']) != 2) {
                            if ($mostrar < 6) {
                                //para mostar solo los productos que tengan stock

                                 if($producto['cantidad_producto']>0){
                                    echo   imprimir_productos($producto);
                               }else{
                                     echo "<p>NO hay producto disponibles</p>";

                               }
                                
                                $mostrar++;
                            } else {
                                break;
                            }
                        } else {
                            //para mostar solo los productos que tengan stock
                               if($producto['cantidad_producto']>0){
                                    echo   imprimir_productos($producto);
                               }else{
                                     echo "<p>NO hay producto disponibles</p>";
                               }
                            
                        }
                    }
                } else {
                    echo "<p>NO hay producto disponibles</p>";
                }
            }
        } else {
            //aqui mostramos los productos buscados por la barra de busqueda
            if ($nombreProducto != null) {

                $trim_nombre_producto = trim($nombreProducto);
                $sql = "SELECT nombre_producto, precio_producto, id_producto,  imagen, cantidad_producto FROM productos WHERE nombre_producto LIKE '%$trim_nombre_producto%'";
                //uso esta sentencia sql para que la busqueda pueda conseguir todo aquellos productos que contengan la palabra que contenga la variable 
                $resultado = mysqli_query($conn, $sql);
                $busqueda_nombre = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

                if ($busqueda_nombre && mysqli_num_rows($resultado) > 0) {
                    $mostrar = 0;
                    foreach ($busqueda_nombre as $producto) {
                          //validacion para ver si iniciamos sesion o estamos en la landig
                        if (isset($_SESSION['tipo']) != 2) {
                            if ($mostrar < 6) {
                               //para mostar solo los productos que tengan stock
                                 if($producto['cantidad_producto']>0){
                                    echo   imprimir_productos($producto);
                               }
                                
                                $mostrar++;
                            } else {
                                break;
                            }
                        } else {
                           //para mostar solo los productos que tengan stock
                                 if($producto['cantidad_producto']>0){
                                    echo   imprimir_productos($producto);
                               }else{
                                     echo "<p>NO hay producto disponibles</p>";
                               }
                        }
                    }
                } else {
                    echo "<p>NO hay producto disponibles</p>";
                }
            }
        }
    }
