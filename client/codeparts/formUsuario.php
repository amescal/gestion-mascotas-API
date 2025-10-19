<h1>Identificar Usuario</h1>
<?php
//Si el array de errores no está vacío es porque hay errores,los vamos a mostrar
    if(!empty($errores)): ?>
    <h2>Se han encontrado los siguientes errores:</h2>
    <ul>
        <?php foreach($errores as $error): ?>
            <li><?=$error ?></li>
        <?php endforeach; ?>
    </ul>    
    <?php
    endif;
?>
<form method="post" action="">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" value=""><br>
    <label for="password">Contraseña</label>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="Login">
</form>