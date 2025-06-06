<?php
function imprimir_productos($producto){
    return '
        <form method="post" action="detalle_producto?id=' . htmlspecialchars($producto['id_producto']) . '" class="productos">
            <button type="submit" class="boton_producto"></button>
            <div class="imagen">
                <img src="../imagenes/' . htmlspecialchars($producto['imagen']) . '" alt="Imagen de ' . htmlspecialchars($producto['nombre_producto']) . '" style="max-width:100%;max-height:120px;">
            </div>
            <div>
                <h2>'.htmlspecialchars($producto['nombre_producto']).'</h2>
                <p>'.htmlspecialchars($producto['precio_producto']).'</p>
            </div>
        </form>';
}