<?php

/**
 * Función que sirve para mostrar los datos de un array en una tabla
 * @param array Necesita que se le pase por parámetro un array
 * No devuelve nada pero imprime directamente el HTML
 */

function mostrarTabla(array $array)
{
    if(!empty($array))
    {
        echo '<table border=1px>
            <thead>
                <tr>';
                    /*Añadimos una celda más en la cabecera para las operaciones que se pueden realizar con el producto*/
                    echo '<th>ID</th><th>Nombre</th><th>Descripción</th><th>Tipo</th><th>¿Es una mascota pública?</th><th>Me gustas</th>
                </tr>
            </thead>
            <tbody>';
                foreach($array as $fila)
                {
                    echo '<tr>';
                    foreach($fila as $dato)
                    {
                        /*usamos htmlspecialchars para evitar caracteres que estropeen el html y asignamos con el
                        operador de coalescencia un valor por defecto, que es la cadena vacía, por si nos 
                        encontramos algún valor null, como por ejemplo en las propiedades de los productos*/
                        echo '<td>'.htmlspecialchars($dato??'').'</td>';
                    }
                    
                }
            echo '</tbody>';
        echo '</table>';
    }
}