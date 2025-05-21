    <?php
  
    function mostrar_productos($conn, $idCategoria = null, $nombreProducto=null) {

    
    if(!$conn){
                  die("Connection failed: ". mysqli_connect_error()); 
            }
           
            //busqueda condicional
                if($nombreProducto==null){

                    if($idCategoria==null ){
                        $sql_productos="SELECT nombre_producto, precio_producto, id_producto FROM productos";
                    $resultado_producto= mysqli_query($conn, $sql_productos);

                    $productos= mysqli_fetch_all($resultado_producto, MYSQLI_ASSOC);

                    if($resultado_producto && mysqli_num_rows($resultado_producto)>0){
                        $mostrar=0;
                            foreach($productos as $producto ){
                                
                                if($mostrar<6){
                                        echo '
                                <div class="productos">
                                <div class="imagen">
                                    <h1>'.htmlspecialchars("aqui debe ir la imagen").'</h1>
                                </div>
                                    <div>
                                        <h2>'.htmlspecialchars($producto['nombre_producto']).'</h2>
                                        <p>'.htmlspecialchars($producto['precio_producto']).'</p>
                                    </div>
                                </div>';
                                $mostrar=$mostrar+1;
                                }else{
                                    break;
                                }
                            
                            }
                    } else{
                        echo"<p>NO hay producto disponibles</p>";
                    }
                    } 
            else{
                 
                $sql_productos="SELECT nombre_producto, precio_producto, id_producto FROM productos WHERE id_categoria=$idCategoria";
                   $resultado_producto= mysqli_query($conn, $sql_productos);

                     $productos= mysqli_fetch_all($resultado_producto, MYSQLI_ASSOC);

                      if($resultado_producto && mysqli_num_rows($resultado_producto)>0){
                    foreach($productos as $producto ){
                        echo '
                        <div class="productos">
                        <div class="imagen">
                            <h1>'.htmlspecialchars("aqui debe ir la imagen").'</h1>
                        </div>
                            <div>
                                <h2>'.htmlspecialchars($producto['nombre_producto']).'</h2>
                                <p>'.htmlspecialchars($producto['precio_producto']).'</p>
                            </div>
                        </div>';
                    }
            }else{
                echo"<p>NO hay producto disponibles</p>";
            }
            }
        }
        else{
                if($nombreProducto!=null ){
              
                    $trim_nombre_producto= trim($nombreProducto);
                $sql="SELECT nombre_producto, precio_producto, id_producto FROM productos WHERE nombre_producto LIKE '%$trim_nombre_producto%'"; 
                //uso esta sentencia sql para que la busqueda pueda conseguir todo aquellos productos que contengan la palabra que contenga la variable 
                $resultado= mysqli_query($conn,$sql);
                $busqueda_nombre= mysqli_fetch_all($resultado,MYSQLI_ASSOC);
                
                if($busqueda_nombre && mysqli_num_rows($resultado)>0){
                foreach($busqueda_nombre as $producto){
                     echo '
                        <div class="productos">
                        <div class="imagen">
                            <h1>'.htmlspecialchars("aqui debe ir la imagen").'</h1>
                        </div>
                            <div>
                                <h2>'.htmlspecialchars($producto['nombre_producto']).'</h2>
                                <p>'.htmlspecialchars($producto['precio_producto']).'</p>
                            </div>
                        </div>';
                }}else{
                     echo"<p>NO hay producto disponibles</p>";
                }
            }


                }

            
            
           
            } 