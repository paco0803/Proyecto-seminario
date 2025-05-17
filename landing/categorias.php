<?php 

function mostrar_categorias($conn){
      // Verificar conexión
        if(!$conn){
            die("Connection failed: ". mysqli_connect_error());
        }
        
        $sql = "SELECT * FROM categorias";
        $resultado = mysqli_query($conn, $sql);
        //recoge todos los datos y los transforma en un array asociativo;
        $categorias= mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        if($resultado && mysqli_num_rows($resultado) > 0) {
            foreach($categorias as $fila){
                echo '<button>'.htmlspecialchars($fila['nombre_categoria']).'</button>';
            }
          
        } else {
            echo "<p>No hay categorías disponibles</p>";
        }
        
        // Cerrar conexión
}

?>