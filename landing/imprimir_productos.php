<?php
function imprimir_productos($producto){
    return '
        
                                             <form method="post" action="link.php?id=' . htmlspecialchars($producto['id_producto']) . '" class="productos" ">
                                                <button type="submit" class="boton_producto"> </button>
                                                 
                                                    <div class="imagen">
                                                        <h1>'.htmlspecialchars("aqui debe ir la imagen").'</h1>
                                                    </div>
                                                        <div>
                                                            <h2>'.htmlspecialchars($producto['nombre_producto']).'</h2>
                                                            <p>'.htmlspecialchars($producto['precio_producto']).'</p>
                                                        </div>
                                                    
                                            </form>';
    
    
}