<h1>Formulario para modificar una mascota</h1>
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
<form method="post" action="/cambiarmascota.php">
    <label for="id">ID de la mascota:</label>
    <input type="text" id="id" name="id" value=""><br><br>
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" cols="30" rows="2"></textarea><br><br>
    <label for="publica">¿Pública?</label>
        <label><input type="radio" name="publica" value="Si">Si</label>
        <label><input type="radio" name="publica" value="No">No</label>
    <br><br>
    <input type="submit" value="Modificar mascota!">
</form>