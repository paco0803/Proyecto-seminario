<?php
function modal($itulo,$texto,$usar=null,$textoboton=null,$url=null) {
    echo '
     <style>
       .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .modal-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-confirm {
             color: #c5ff50;
                background-color: black;
            font-size: 1.1rem;
            cursor: pointer;
            border-radius: 5px;
            padding: 0.5rem 3rem;
            border:2px solid black;
        }
        .btn-cancel {
            background-color: #ecf0f1;
            color: #333;
        }
        a {
            text-decoration: none;
        }
            .modal-container h2{
                    text-align: center;
            }
           
    </style>
     <div class="modal-backdrop">
        <div class="modal-container">
            <h2>'.htmlspecialchars($itulo).'</h2>
            <p>'.htmlspecialchars($texto).'</p>
            <div class="modal-buttons">';
    
    if($usar != null) {
        echo '<a href="'.htmlspecialchars($url).'" class="btn-confirm">'.htmlspecialchars($textoboton).'</a>';
    }
    
    echo '<button class="btn-cancel" onclick="this.closest(\'.modal-backdrop\').remove()">Cancelar</button>
            </div>
        </div>
    </div>';

    
}

/*
titulo
texto
1 y 0(para que se muestre el boton o no)
texto del boton
url 

al llamar a la funcion se le debe pasar $titulo, $texto obligatorio, si quieres ir a otra pantalla y mostar un boton usar todos los prop, (los ultimos tres pueden quedar vacios)


*/ 