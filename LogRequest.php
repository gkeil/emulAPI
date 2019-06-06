<?php

// Autoload
require 'vendor/autoload.php';

// incluir clases del proyecto
require_once "RecursosVarios.php";

use Psr\Http\Message\ServerRequestInterface;
//use React\Http\Response;
/** 
 * @author Guille
 * 
 */
final class LogRequest
{

    private $recursos;      // helper Class
    /**
     */
    public function __construct( RecursosVarios $recursos)
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
    public function __invoke( ServerRequestInterface $request, callable $next ) 
    {
        
        // mostrar la info del request
        echo "REQUEST recibido  @min:seg ".date('i:s')."\n";
        echo "METODO: ".$request->getMethod()."    PATH: ".$request->getUri()->getPath()."\n";
        
        echo " ------------- Headers ----------------\n";      
        $headers = $request->getHeaders();
        foreach ($headers as $hdr => $val)
        {
            echo $hdr." : ".implode(",",$val)."\n";
        }
                
        echo " -------------- body ------------------\n";
        $body = $request->getBody()->getContents();
        echo $body."\n";
        
        // continue with next Midddleware task
        return $next($request);     
    }
    
    
}   // end class

