<?php

/**
 * Register classes to automatic injection
 */
$classes = [
    /*Class Name => Namespace (\) */
    
    "Auth" =>           "App\Middleware",
    
    //LIB Classes
    "Config" =>         "App\Core\Application",
    "Language" =>       "App\Core\Lib",
    
    //Usefull
    "Easytext" =>       "Lora\Easytext",
    "LoraException" =>  "App\Exception",
    
    //Models
    
];
