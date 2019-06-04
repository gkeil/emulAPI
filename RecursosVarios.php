<?php

/** 
 * @author 
 * 
 */

// Autoload
require 'vendor/autoload.php';


final class RecursosVarios
{
    // file names and Paths
    private const CONFIG_FILENAME = __DIR__.'/config.json';
    private const PATH_RESPUESTAS = __DIR__.'/respuestas/';
    
    // variables
    private $loop;              // react event loop
    
    private $config;            // array para gurdar opciones configuradas      
                                // en config.json
                                   
    private $respfile_name;     // name of the response file
    
    private $URL_API;           // ip:port del donde corre este simulador
    
        
    /**
     */
    public function __construct( React\EventLoop\LoopInterface $loop )
    {
        $this->loop = $loop;
        
        // leer archivo de configuracion
        $this->leer_configuracion();
        
              
    }   // end contructor

    /**
     * 
     */
    private function leer_configuracion() : void
    {
        
        // leer archivo de configuración
        $config = $this->leer_json(self::CONFIG_FILENAME);
           
          
        // extraer la info del arch. de config
        $this->URL_API = $config['emul_ip_add'].":".$config['emul_port'];
        $this->respfile_name = $config['respfile_name'];
    }
    
    
    /**
     * @return string
     */
    public function getRespfile_name()  : string
    {
        return self::PATH_RESPUESTAS.$this->respfile_name;
    }

    /**
     * @return string
     */
    public function getURL_API()    : string
    {
        return $this->URL_API;
    }

    /**
     * Este método lee un archvo Jason y devuelve el contenido en un array.
     * Genera excepciones si el archivo no existe, hay error de lectura o
     * no se puede convertir en arreglo 
     * 
     */
    public function leer_json( string $filename ) : array
    {
        // verificar si el archivo existe
        if (!file_exists($filename) )
            throw new Exception("Archivo " . basename($filename)." no encontrado\n");

        // Leer archivo de respuestas
        $fromfile = file_get_contents($filename);
        if ($fromfile === false)
            throw new Exception("Error leyendo " . basename($filename). " \n");

        $arreglo = json_decode($fromfile, true);
        if ($arreglo === null)
            throw new Exception("Error convirtiendo " .basename($filename). " \n");

        return $arreglo;
    }
    
    /**
     * Este método retorna el nombre completo del archivo JSON
     * para el body de la respuesta
     * 
     */
    public function full_path_resp_json(string $resp_file) : string
    {
        // crear full path
        return self::PATH_RESPUESTAS.$resp_file;
    }
    
    
}   // end class

