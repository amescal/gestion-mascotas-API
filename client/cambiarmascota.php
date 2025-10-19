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
        //si no hemos recibido datos en el post mostramos el formulario
        if(empty($_POST)){
            //mostramos el formulario
            include __DIR__.'/codeparts/formModificar.php';
        //si $_POST no está vacío es porque hemos recibido datos del formulario    
        } else {
            require __DIR__.'/vendor/autoload.php';

            $client=new Client(
                [
                    'http_errors'=>false,
                    //añadimos un parámetro para todas las peticiones para que no haga una segunda petición al recibir un error
                    'allow_redirects'=>false
                ]
            );
            //tal como se dijo en clase se hace una comprobacion mínima de que hay datos
            //usamos el operador de coalescencia para asignar la cadena vacía si no hubiera valores
            //recogemos la id recibida en el formulario
            $id=$_POST['id']??'';
            //recogemos los datos que queremos actualizar
            $datosParaActualizar=[
                'descripcion'=>$_POST['descripcion']??'',
                'publica'=>$_POST['publica']??''
            ];
            //enviamos una solicitud http put al servidor con los datos como json usando la id recogida
            $response=$client->put("http://localhost:8080/api/mascotaAMC/{$id}",[
                'headers'=>['Authorization'=>'Bearer '.$token],
                'json'=>$datosParaActualizar
            ]);
            //recogemos el codigo de estado de la respuesta HTTP
            $codigoHTTP=$response->getStatusCode();
            //recogemos el cuerpo del mensaje como un objeto
            $mensaje=json_decode($response->getBody());
            //mostramos el codigo de estado
            echo '<h2>Código de estado de respuesta HTTP del Servicio Web: '.$codigoHTTP.'</h2>';
            //si el codigo de estado es 400 hay errores de validacion en los datos del formulario
            if($codigoHTTP===400){
                //recogemos el mensaje obtenido
                echo '<h3>'.$mensaje->mensaje.'</h3>';
                //mostramos los errores recibidos
                $errores=($mensaje->errores);
                include __DIR__.'/codeparts/mostrarErrores.php';
            }
            //si el codigo de estado es 404 la mascota que se quiere modificar no existe
            if($codigoHTTP===404){
                //informamos al usuario
                echo '<h3>La mascota que quieres actualizar no existe</h3>';
            }
            //si el codigo de estado es 403 la mascota no pertenece al usuario o los datos no se reciben en json
            if($codigoHTTP===403){
                //informamos al usuario
                echo "<h3>".($mensaje->mensaje)."</h3>";
            }
            //si el codigo de estado es 200 todo ha ido bien y la mascota ha sido modificada 
            if($codigoHTTP===200){
                //informamos al usuario
                echo "<h3>".($mensaje->mensaje)."</h3>";
            }
        }
        //mostramos enlace al listado de mascotas
            echo '<br><br><a href="mascotas.php">Ver el listado de mascotas</a>';
    } else {
        //mostramos un enlace al login y salimos
        echo '<h3>Usuario no identificado</h3><br><br><a href="login.php">Ir al formulario de login</a>';
        die;
    }
    ?>

</body>
</html>






