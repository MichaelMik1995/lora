<?php
declare(strict_types=1);
/**
 * @package miroka/lora
 */

use App\Core\Application\Application;
use App\Core\DI\DIContainer;

final class web
{
    private $container;
        
    public function initPreload()
    {
        $di = DIContainer::instance();
        $this->container = $di;
    }
    
    public function init()
    {
        ini_set("session.gc_maxlifetime", 21600); //6 hours
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
        $application->constructor($this->container);
    }
}

$index = new web();
$index->init();
exit();