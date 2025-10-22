<?php
// Iniciamos la sesión o recuperamos la anterior sesión existente
session_start();

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
    if(isset($_SESSION['token'])){
        //recogemos el token almacenado
        $token=$_SESSION['token'];
        //si no hemos recibido datos del formulario lo vamos a mostrar
        if(empty($_POST)){
            //mostramos el formulario
            include __DIR__.'/codeparts/formEliminar.html';
        //si $_POST no está vacío es porque hemos recibido datos del formulario 
        } else {
            require __DIR__.'/vendor/autoload.php';

            $client=new Client(
                [
                    'base_uri' => 'https://gestion-mascotas-api-server.onrender.com/api/',
                    'http_errors'=>false,
                    //añadimos un parámetro para todas las peticiones para que no haga una segunda petición al recibir un error
                    'allow_redirects'=>false
                ]
            );
            //tal como se dijo en clase se hace una comprobacion mínima de que hay datos
            //usamos el operador de coalescencia para asignar la cadena vacía si no hubiera valores
            //recogemos la id recibida en el formulario
            $id=$_POST['id']??'';
            //enviamos una solicitud http delete al servidor usando la id recogida y pasando el token de autenticacion
            $response=$client->delete("mascotaAMC/{$id}",[
                'headers'=>['Authorization'=>'Bearer '.$token]
            ]);
            //recogemos el codigo de estado de la respuesta HTTP
            $codigoHTTP=$response->getStatusCode();
            //recogemos el cuerpo del mensaje como un objeto
            $mensaje=json_decode($response->getBody());
            //mostramos el codigo de estado
            echo '<h2>Código de estado de respuesta HTTP del Servicio Web: '.$codigoHTTP.'<br></h2>';
            if($codigoHTTP===200 || $codigoHTTP===400){
                //mostramos tambien el mensaje
                echo '<h2>'.$mensaje->mensaje.'</h2>';
            }
        }
    //si no tenemos token almacenado en la sesion
    } else {
        //mostramos un enlace al login y salimos
        echo '<h3>Usuario no identificado</h3><br><br><a href="login.php">Ir al formulario de login</a>';
        die;
    }
    ?>

</body>
</html>