<?php

function mostra_texto($conn, $idCategoria=null){
        if(!$conn){
                  die("Connection failed: ". mysqli_connect_error()); 
            }
           
            if($idCategoria==null){
              echo '
                  <h1>' . htmlspecialchars("bienvenido a ") . '<span>' . htmlspecialchars("PACOSTORE") . '</span></h1>
                ';
            }else{
                  $sql = "SELECT nombre_categoria FROM categorias WHERE id_categoria=$idCategoria";
                  $resultado = mysqli_query($conn, $sql);
        //recoge todos los datos y los transforma en un array asociativo;
        $categorias= mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        if($resultado && mysqli_num_rows($resultado) > 0) {
            foreach($categorias as $fila){

                echo '<h1>' . htmlspecialchars("Disfruta de nuestro apartado ") . '<span>' . htmlspecialchars($fila['nombre_categoria']) . '</span></h1>';
            

            }
          
        } else {
            echo "<p>No hay categorías disponibles</p>";
        }
            }
}