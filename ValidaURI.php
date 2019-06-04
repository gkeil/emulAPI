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
final class ValidaURI
{

    
    private $recursos;      // helper Class
    
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
    public function __invoke( ServerRequestInterface $request, callable $next ) 
    {
    try 
    {
        
       // echo "in validaURI\n";

       // verifica existencia y formato del archivo de lista de respuestas
       $respuestas = $this->verifica_lista_de_respuestas();
              
       // busca respuesta para el pth requerido 
       $resp_file = $this->buscar_respuesta( $request, $respuestas );
       
       // si no hay respuesta enviar error http
       if ($resp_file == "")
       {
           // Not Found response
           echo "Sin Respuesta\n";
           
           return new Response(
               404,
               ['Content-Type' => 'text/plain'],
               '**Sin respuesta para este Request**'
               );
       }
       else
       {
            // enviar el archivo Json con la respuesta
            $new_request = $request->withAttribute('resp_file', $resp_file);
       
            // continue with next Midddleware task
            return $next($new_request);
       }
       
    } catch ( Exception $e) {
        
        // mostrar error en consola
        echo $e->getMessage();
     
        // enviar respuesta con el error encontrado
        return new Response(
            400,
            ['Content-Type' => 'text/plain'],
            $e->getMessage()
            );
        
    }   // end catch
    }   // end __invoque
    
    /**
     * Esta función verifica que el archivo json de lista de respuetas existe, 
     * se puede leer y convertir
     * 
     */
    function verifica_lista_de_respuestas(): array
    {

        // leer archivo de respuestas
        $respuestas = $this->recursos->leer_json($this->recursos->getRespfile_name());
            
        return $respuestas;
        
    }
    
    /**
     * Esta método busca la respuesta al método y path pedidos en el request
     * 
     * 
     */
    function buscar_respuesta(ServerRequestInterface $request, array $respuestas) : string
    {
        $resp_file = "";
        
        // Recorrer el arreglo para  buscar una respuesta para el METHOD y PATH 
        foreach ($respuestas as $resp)
        {
            if ($resp['method'] == $request->getMethod() &&
                $resp['path']   == $request->getUri()->getPath()
                )
                $resp_file = $resp['archivo_resp'];
        }
               
        // retornar nombre archivo json con la respuesta
        return $resp_file;
    }
    
    
}   // end class

