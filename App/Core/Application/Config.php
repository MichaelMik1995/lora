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
    private $config_variables = [];
    
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
}
