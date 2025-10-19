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
        //si no tenemos datos del formulario en el post mostramos el formulario
        if(empty($_POST)){
            //mostramos el formulario para la creacion de una nueva mascota
            include __DIR__.'/codeparts/nuevamascota.html';
        //si $_POST no está vacío es porque hemos recibido datos del formulario    
        } else {
            echo '<h1>Resultado de la creación de una nueva mascota</h1>';
            //recogemos los datos recibidos del formulario sin verificar para que lo haga el servidor
            $datosNuevaMascota=[
                'nombre'=>$_POST['nombre'],
                'descripcion'=>$_POST['descripcion'],
                'tipo'=>$_POST['tipo'],
                'publica'=>$_POST['publica']??''
            ];

            $client=new Client(
                [
                    'http_errors'=>false,
                    //añadimos un parámetro para todas las peticiones para que no haga una segunda petición al recibir un error
                    'allow_redirects'=>false
                ]
            );
            //enviamos una solicitud http post al servidor
            $response=$client->post('http://localhost:8080/api/crearmascotaAMC',[
                'headers'=>['Authorization'=>'Bearer '.$token],
                'form_params'=>$datosNuevaMascota
            ]);
            //recogemos el codigo de estado de la respuesta HTTP
            $codigoHTTP=$response->getStatusCode();
            //recogemos el cuerpo del mensaje como un objeto
            $mensaje=json_decode($response->getBody());
            //mostramos el codigo de estado
            echo '<h2>Código de estado de respuesta HTTP del Servicio Web: '.$codigoHTTP.'</h2>';
            //si el codigo de estado es 200 significa todo ok
            if($codigoHTTP===200){
                //informamos al usuario
                echo '<h3>'.$mensaje->implementador. ' ha creado la mascota con id '.$mensaje->id_mascota.'</h3>';
            } elseif ($codigoHTTP===400) {
                //recogemos el mensaje obtenido
                echo '<h3>'.$mensaje->mensaje.'</h3>';
                //mostramos los errores recibidos
                $errores=($mensaje->errores);
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
            } 
            ?>
                <br><br>
                <a href="http://localhost:9000/mascotas.php">Ir al listado de mascotas</a>
            <?php
        }
    //si no hay un token almacenado en la sesion
    } else {
        //mostramos un enlace al login y salimos
        echo '<h3>Usuario no identificado</h3><br><br><a href="login.php">Ir al formulario de login</a>';
        die;
    }
    ?>

</body>
</html>

