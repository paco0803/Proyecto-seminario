<?php
function imprimir_productos($producto){
    return '
    <a href="detalle_producto.php?id=' . htmlspecialchars($producto['id_producto']) . '" 
       class="productos" 
       style="display:block;text-decoration:none;background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);padding:18px 12px;margin:12px 0;transition:box-shadow 0.2s;cursor:pointer;">
        <div class="imagen" style="text-align:center;">
            <img src="../imagenes/' . htmlspecialchars($producto['imagen']) . '" 
                 alt="Imagen de ' . htmlspecialchars($producto['nombre_producto']) . '" 
                 style="max-width:100%;max-height:120px;border-radius:8px;">
        </div>
        <div style="text-align:center;">
            <h2 style="color:#2d3e50;font-size:1.2rem;margin:10px 0 6px 0;">'.htmlspecialchars($producto['nombre_producto']).'</h2>
            <p style="color:#4a90e2;font-weight:bold;font-size:1.1rem;margin:0;">'.htmlspecialchars($producto['precio_producto']).'</p>
        </div>
    </a>';
}