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
     * Adds image element to template (if available in module or ./public directory )
     * Can add image with no extension (ex.: .png) -> then search via allowed extensions
     * 
     * @param  string $path
     * @param  string $module
     * @return string
     */
    public static function image(string $path, string $module = ""): String
    {
        $allowed_images = ["jpg", "png", "gif", "jpeg", "bmp", "webp"];
        $explode = explode(".", $path);

        if(count($explode) > 1) //If EXT is defined
        {
            if(in_array($explode[1], $allowed_images))
            {
                if(file_exists(self::modulePath($path, $module))) //If image exists
                {
                    return "<img src='.".self::modulePath($path, $module)."'>";
                }
                else
                {
                    return "<img src='./public/img/noimage.jpeg'>";
                }
            }
            else //If no allowed extension
            {
                return "<img src='./public/img/noallowedimage.jpeg'>";
            }
        }
        else
        {
            foreach($allowed_images as $ext)
            {
                if(file_exists(".".self::modulePath($explode[0].".".$ext, $module))) //If image exists
                {
                    return "<img src='.".self::modulePath($explode[0].".".$ext, $module)."'>";
                }
            }
            return "<img src='./public/img/noimage.jpeg'>";
        }
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
