<?php
declare(strict_types=1);

namespace App\Core\Lib;

/**
 * Description of Res
 *
 * @author miroka
 */
class Res 
{
    private $web_path;
    
    public function __construct() 
    {
        $this->web_path = $this->container["Config"]->var("WEB_ADDRESS");
    }
    
    public function asset(string $path): String
    {
        $path_to_public = $this->web_path."/public/";
        
        return $path_to_public.$path;
    }
    
    public function modasset(string $module_name, string $path): String
    {
        $full_path = $this->web_path."/App/Modules/". ucfirst($module_name)."Module/resources/".$path;            
        return str_replace("./public/", "", $full_path);
    }
    
    public function cfg(string $config_key): String
    {
        return $this->container["Config"]->var($config_key);
    }
    
    public function lang(string $lang_key): String
    {
        return $this->container["Language"]->translate($lang_key);
    }
}
