<?php

// Autoload
require 'vendor/autoload.php';

// incluir clases del proyecto
require_once "RecursosVarios.php";

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/** 
 * @author Guille
 * 
 */
final class CrearRespuesta
{

    /**
     */
    public function __construct(RecursosVarios $recursos)
    {
        $this->recursos = $recursos;
    }
    
    /**
     *  Este función es usada como callback para el http server
     *
     * @param ServerRequestInterface $request
     * @param callable $next
     * 
     */
    public function __invoke( ServerRequestInterface $request ) 
    {
    try 
    {
        // echo "in CrearRespuesta\n";
        
        // obtener el archivo con JSON de respuesta
        $resp_file = $request->getAttribute('resp_file');
        
        // obtener Json para Body
        //
        $full_path_resp_file = $this->recursos->full_path_resp_json($resp_file);
   
        // verificar si el archivo existe
        if (! file_exists($full_path_resp_file))
             throw new Exception("Archivo " . basename($full_path_resp_file) . " no encontrado\n");

        // Leer archivo JSON para resp body
        $body = file_get_contents($full_path_resp_file);
        if ($body === false)
             throw new Exception("Error leyendo " . basename($full_path_resp_file). " \n");
       
        // mostrar respuesta en consola
        echo " ---------------- Respuesta: -----------------\n";
        echo $body."\n";
        
        
        // Crear respuesta
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            $body
            );
        
    } catch ( Exception $e) {
        
        echo $e->getMessage();
        
        // enviar respuesta con el error encontrado
        return new Response(
            400,
            ['Content-Type' => 'text/plain'],
            $e->getMessage()
            );
    }   // end catch
    
    }   // end __invoke
    
}   // end class

