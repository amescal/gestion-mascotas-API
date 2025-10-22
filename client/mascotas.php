<?php
// Iniciamos la sesión o recuperamos la anterior sesión existente
session_start();

require_once __DIR__.'/funciones/mostrarTabla.php';
require __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client;

use function PHPUnit\Framework\isEmpty;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Mesones Calvillo - DWES06 TAREA</title>
    <link rel="stylesheet" href="codeparts/style.css" />
</head>
<body>
    <?php
    include __DIR__.'/codeparts/header.html'; 
    
    //si tenemos token almacenado en la sesion
    if(isset($_SESSION['token'])){
        //recogemos el token almacenado
        $token=$_SESSION['token'];
        $client=new Client(
            [
                'base_uri' => 'https://gestion-mascotas-api-server.onrender.com/api/',
                'http_errors'=>false,
                //añadimos un parámetro para todas las peticiones para que no haga una segunda petición al recibir un error
                'allow_redirects'=>false
            ]
        );
        //enviamos una solicitud http get al servidor
        $response=$client->get('mascotasAMC',[
            'headers'=>['Authorization'=>'Bearer '.$token]
        ]);
        $codigoHTTP=$response->getStatusCode(); //Obtener el código de respuesta HTTP
        $mensaje=json_decode($response->getBody()); //Obtener el cuerpo del mensaje
        //si obtenemos el codigo de respuesta 200
        if($codigoHTTP===200 && !empty($mensaje)){
            //si el mensaje no está vacio por el usuario tiene mascotas
            if(!empty($mensaje)){
                echo '<h1>Listado de Mascotas</h1>';
                //usamos una funcion para mostrar la tabla de mascotas con la informacion recibida en el mensaje de la respuesta
                mostrarTabla($mensaje);
            } else {
                echo '<h3>No hay mascotas para mostrar</h3>';
            }
        } else {
            //por si se recibe otro código
            echo "<h3>Código ".$codigoHTTP.": ".($mensaje->mensaje)."</h3>";
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


