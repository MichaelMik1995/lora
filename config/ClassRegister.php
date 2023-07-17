<?php

/**
 * Register classes to automatic injection
 */
$classes = [
    /*Class Name => Namespace (\) */
    
    "Auth" =>           "App\Middleware",
    "DotEnv" =>         "App\Core\Application",
    
    //LIB Classes
    "Config" =>         "App\Core\Application",
    "Language" =>       "App\Core\Lib",
    
    //Usefull
    "Easytext" =>       "Lora\Easytext",
    "LoraException" =>  "App\Exception",
    
    //Models
    
];
