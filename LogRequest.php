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
        echo "min:seg ".date('i:s')."\n";
        echo "REQUEST recibido\n";
        echo "METODO: ".$request->getMethod()."\n";
        echo "PATH: ".$request->getUri()->getPath()."\n";
        
        
        // continue with next Midddleware task
        return $next($request);     
    }
    
    
}   // end class

