<?php
/**
 * @package miroka/lora
 */

use App\Core\Application\Application;
use App\Core\DI\DIContainer;
use App\Core\Application\DotEnv;


class web
{
    /**
     * @var array $injector <p>Create instances of useffull classes to work around application</p>
     */
    private $injector;
        
    public function initPreload()
    {
        $di = new DIContainer();
        $this->injector = $di->inject;

        $__DotEnvironment = new DotEnv(realpath(".env"));
    }
    
    public function init()
    {
        session_start();
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1); 
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        
        header("Content-Type: text/html; charset=utf-8");
        header("X-Frame-Options: SAMEORIGIN");
        
        mb_internal_encoding("utf-8");
        
        //Autoload
        
        require_once ("App/Core/Autoload/Autoload.php");
        require __DIR__.'/vendor/autoload.php';

        new Autoload();
        
        $this->initPreload();
        
        include_once("App/Core/Lib/EnvFunctions.php");

        $application = new Application();
        $application->constructor($this->injector);
    }
}

$index = new web();
$index->init();
exit();