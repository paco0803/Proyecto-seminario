    <?php
    function mostrar_productos($conn){

    
    if(!$conn){
                  die("Connection failed: ". mysqli_connect_error()); 
            }
            $sql_productos="SELECT nombre_producto, precio_producto, id_producto FROM productos";
            $resultado_producto= mysqli_query($conn, $sql_productos);

            $productos= mysqli_fetch_all($resultado_producto, MYSQLI_ASSOC);
            if($resultado_producto && mysqli_num_rows($resultado_producto)>0){
                    foreach($productos as $producto ){
                        echo '
                        <div class="productos">>
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