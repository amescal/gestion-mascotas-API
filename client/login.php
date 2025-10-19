<?php
// Iniciamos la sesión o recuperamos la anterior sesión existente
session_start();

require __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client;

//unset($_SESSION['token']);
//$datosAutenticacion=['email'=>'AMC1@email.AMC', 'password'=>'AMC1'];

$errores=[];
$client=new Client(
    [
        'http_errors'=>false,
        //añadimos un parámetro para todas las peticiones para que no haga una segunda petición al recibir un error
        'allow_redirects'=>false
    ]
);

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
    //si ya tenemos almacenado un token en la sesion
    if(isset($_SESSION['token'])){
        echo '<h1>Usuario ya identificado</h1>';
        ?>
        <br><br>
        <a href="http://localhost:9000/logout.php">Cerrar sesión</a>
        <?php
        //var_dump($_SESSION['token']);
    //si hemos recibido datos en el post    
    } else if(!empty($_POST)) {
        //tal como se dijo en clase se hace una comprobacion mínima de que hay datos
        //usamos el operador de coalescencia para asignar la cadena vacía si no hay valores
        $datosAutenticacion=[
            'email'=>$_POST['email']??'',
            'password'=>$_POST['password']??''
        ];
        //hacemos la peticion enviando los datos del formulario como parametros
        $response=$client->post('http://localhost:8080/api/login', ['form_params'=>$datosAutenticacion]);
        //recogemos el codigo de estado de la respuesta HTTP
        $codigoHTTP=$response->getStatusCode();
        //recogemos el cuerpo del mensaje como un objeto
        $mensaje=json_decode($response->getBody());
        //si el codigo de estado es 200 significa todo ok
        if($codigoHTTP===200){
            //obtenemos el token
            $token=$mensaje->token;
            //añadimos el token a la sesion
            $_SESSION['token']=$token;
            echo "<h3>Código ". $codigoHTTP.":  ".($mensaje->mensaje)."</h3>";
            ?>
            <br><br>
            <a href="http://localhost:9000/mascotas.php">Ver las mascotas del usuario</a>
            <?php
        //si el c'odigo es 401 o 422 son errores conocidos
        } elseif ($codigoHTTP===401 || $codigoHTTP===422){
            //recogemos el mensaje obtenido como error
            //$mensaje es un objeto con la propiedad mensaje
            $errores[]="Código ".$codigoHTTP.": ".($mensaje->mensaje);
            //volvemos a incluir el formulario
            include __DIR__.'/codeparts/formUsuario.php';
        } else {
            //por si nos encontramos otro posible c'odigo de respuesta
            echo "<h3>Código de Respuesta: ". $codigoHTTP." ".($mensaje->mensaje??'')."</h3>";
        }
    //sin token en la sesion y sin datos en el post es la primera vez que entramos en la web     
    } else {
        //mostramos el formulario
        include __DIR__.'/codeparts/formUsuario.php';
    }
    ?>

</body>
</html>

