<?php

declare (strict_types=1);

/**
 * Registering classes from sandbox & plugins
 *
 * @author michaelmik
 */
class Autoload 
{
   
    public array $search_folders = [
        "App/Core/Lib/Utils/",
        "plugins/",
        "App/Lib/",
    ];


    public function __construct() {
        $this->loadClass();
    }
   public function loadClass()
   {
       spl_autoload_register([$this, "AutoLoader"]);
   }
   
    protected function AutoLoader($className)
    {
        $className = str_replace("_", "\\", $className);
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';

        if ($lastNsPos = strripos($className, '\\'))
        {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        //echo $fileName."<br>";
        if(file_exists($fileName))
        {
            require $fileName;
        }
        else
        {

            $namespace_explode = explode("\\", $namespace);
            $plugin_fldr = "./plugins/";

            foreach($namespace_explode as $folder)
            {
                $plugin_fldr .= strtolower($folder)."/";
            }

            $plugin_class = $plugin_fldr.$className.".php";
            //App\Core\Lib\Utils\
            if(file_exists($plugin_class))
            {
                require($plugin_class);
            }
            else
            {
                foreach($this->search_folders as $folder)
                {
                    if(file_exists($folder.$className.".php"))
                    {
                        require($folder.$className.".php");
                    }
                }
            }
        }
            
    } 
    
}
