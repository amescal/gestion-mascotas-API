<?php
// Iniciamos la sesión o recuperamos la anterior sesión existente
session_start();

require __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Mesones Calvillo - DWES06 TAREA</title>
    <link rel="stylesheet" href="codeparts/style.css"/>
</head>
<body>
    <?php
    include __DIR__.'/codeparts/header.html'; 

    //si tenemos token almacenado en la sesion
    if(isset($_SESSION['token'])) {
        //recogemos el token almacenado
        $token=$_SESSION['token'];
        $client=new Client(
            [
                'http_errors'=>false,
                //añadimos un parámetro para todas las peticiones para que no haga una segunda petición al recibir un error
                'allow_redirects'=>false
            ]
        );
        //enviamos una solicitud http post al servidor
        $response=$client->post('http://localhost:8080/api/logout',[
                'headers'=>['Authorization'=>'Bearer '.$token]
        ]);
        $codigoHTTP=$response->getStatusCode(); //Obtener el código de respuesta HTTP
        $mensaje=json_decode($response->getBody()); //Obtener el cuerpo del mensaje
        if($codigoHTTP===200){
            //quitamos el token de la sesion 
            unset($_SESSION['token']);
            //informamos al usuario
            echo "<h3>Código ".$codigoHTTP.": ".($mensaje->mensaje)."</h3>";
            ?>
            <br><br>
            <a href="http://localhost:9000/login.php">Volver a hacer login</a>
            <?php
        } else {
            //por si se recibe otro código
            echo "<h3>Código ".$codigoHTTP.": ".($mensaje->mensaje)."</h3>";
        }
    //si no tenemos un token almacenado en la sesion informamos pero no hacemos nada    
    } else {
        echo '<h3>El usuario no estaba identificado</h3>';
        ?>
            <br><br>
            <a href="http://localhost:9000/login.php">Login</a>
        <?php
    }
    ?>
</body>
</html>

