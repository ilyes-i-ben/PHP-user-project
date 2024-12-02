<?php

spl_autoload_register("myAutoloader");
function myAutoloader(string $class){
    $pathClass = "../".str_ireplace(["App\\", "\\"], ["","/"], $class).".php";
    if(file_exists($pathClass)){
        include $pathClass;
    } else {
        throw new Exception("Class $class not found at $pathClass");
    }
}

use App\Core\Router;

$router = new Router('./../routes.yaml');
$router->handleRequest();
