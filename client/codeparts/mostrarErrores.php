<?php
//Si el array de errores no está vacío es porque hay errores,los vamos a mostrar
if(!empty($errores)): ?>
    <h4>Se han encontrado los siguientes errores:</h4>
        <ul>
            <?php foreach($errores as $error): ?>
                <li><?=$error ?></li>
            <?php endforeach; ?>
        </ul>    
    <?php
endif;