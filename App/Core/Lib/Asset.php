<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Core\Lib;
use App\Core\Application\Config;

/**
 * Description of Asset
 *
 * @author miroka
 */
class Asset 
{
    private static $config;
    private static $web_path;
    
    public function __construct() 
    {
        $cfg = new Config();
        $this->config = $cfg->getVar();
        
        self::$web_path = $this->config["WEB_ADDRESS"];
    }
    
    
    public static function asset($path)
    {
        return self::$web_path."/public/".$path;
    }
    
    /**
     * 
     * @param string $path
     * @param string $module
     * @return string
     */
    public static function modulePath(string $path, string $module = ""): String
    {
        if($module == "")
        {
            $module = $_SERVER["REQUEST_URI"];
            $explode = explode("/", $module);

            $module = str_replace(["/", "-"], "", $explode[1]);
            
        }

        $module_path = "/App/Modules/". ucfirst($module)."Module/";

        if(file_exists($module_path."public/".$path))
        {
            $full_path = $module_path."public/".$path;
            return $full_path;
        }
        
        else if(file_exists($module_path."resources/".$path))
        {
            $full_path = $module_path."resources/".$path;
            return $full_path;
        }
        else
        {
            return $module_path . "public/" . $path;
        }

    }
}
