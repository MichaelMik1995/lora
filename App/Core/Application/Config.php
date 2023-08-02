<?php

declare(strict_types=1);

namespace App\Core\Application;

/**
 * Description of config
 *
 * @author miroka
 */
class Config 
{
    private array $config_variables = [];
    private array $module_variables = [];
    
    public function __construct() 
    {
        foreach(glob("./config/*.ini") as $cfg)
        {
            $cfg_content = parse_ini_file($cfg);
            $this->config_variables = array_merge($this->config_variables, $cfg_content);
        }


    }
    
    public function getVar()
    {
        return $this->config_variables;
    }
    
    public function var(string $variable)
    {
        return $this->config_variables[$variable];
    }

    /**
     * Get module variable from config files
     *
     * @param string $variable
     * @param string $module
     * @return string|null
     */
    public function mvar(string $variable, string $module): string|null
    {
        if(count($this->module_variables) == 0)
        {
            $config_dir = "./App/Modules/".ucfirst($module)."Module/config";
            if(!is_dir($config_dir))
            {
                return null;
            }
            else
            {
                foreach(glob("./App/Modules/".ucfirst($module)."Module/config/*.ini") as $cfg)
                {
                    $cfg_content = parse_ini_file($cfg);
                    $this->module_variables = array_merge($this->module_variables, $cfg_content);
                }
            }
        }
        return $this->module_variables[$variable];
    }
}
