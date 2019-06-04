# emulAPI
Emulador de API con respuesta en formato JSON

# Instalación: #
1. Crear carpeta y copiar los .php del proyecto
1. Instalar react http: `composer require react/http`
1. Crear carpeta ./respuestas

El archivo config.json debe editarse para indicar la IP y port donde corre el emulador.
También se configura el nombre del archivo json con la lista de respuesta. EL nombre del archivo es sin el path. Por ejemplo "master.json"

# Archivos de respuestas #
Los archivos de respuesta se ubican la carpeta `./respuestas.

El archivo de lista de respuestas es una lista (arreglo de objetos JSON ) donde se indica:

- path
- metodo
- archivo json de respuesta


ejemplo:

    [
    { "path" : "/uno", "method": "GET"  ,  "archivo_resp": "unoget.json" },
    { "path" : "/uno", "method": "POST" ,  "archivo_resp": "unopost.json" },
    { "path" : "/dos", "method": "GET"  ,  "archivo_resp": "dosget.json" }
    ]
Los archivos JSON indicados en la lista de respuesta se usan para conformar el body de la respuesta
