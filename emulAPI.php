<?php

/*
 Este script emula las respuestas de la API
 El archivo config.json contiene parametros de configuracion
 como la direcciòn de IP y el port donde trabaja este servidor de API
 -
 El archivo respuestas.json contiene el nombre del archivo json de respuestas a cada 
 URI que se reciba
 -
 
 * 
 */

// Autoload
require 'vendor/autoload.php';

// incluir clases del proyecto
require_once "RecursosVarios.php";
require_once "LogRequest.php";
require_once "ValidaURI.php";
require_once "CrearRespuesta.php";



Try {
    
    // crear event loop
    $loop = React\EventLoop\Factory::create();
    
    // Preparar Helper Class y Cargar configuración
    $recursos = new RecursosVarios($loop);


    // Crear lista de acciones
    $middlewares = array(
        (new LogRequest($recursos)),         // mostrar datos request
        (new ValidaURI($recursos)),          // verifica que si se tiene respuesta
        (new CrearRespuesta($recursos)),     // genera la respuesta basada en el archivo asociado a la URI y metodo
    
    );
    
    //  crear HTTP server
    $httpserver = new React\Http\Server( $middlewares );
    
    // crear socket y conectar con server
    $URL_API = $recursos->getURL_API();

    $socket = new React\Socket\Server($URL_API, $loop);
    $httpserver->listen($socket);
    
    
    // Mostrar arranque en consola
    echo 'Listening on '
        . str_replace('tcp:', 'http:', $socket->getAddress())
        . PHP_EOL;
        
    // start the show
    $loop->run();
        
        
// Trap all errors here
} catch ( Exception $e) {
    echo $e->getMessage();
    echo "Terminado";
}
