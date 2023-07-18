<?php
namespace App\Model;

use App\Core\Motable\Motable;

class Plugins extends Motable
{
    public function pluginData(string $company, string $plugin_name)
    {
        $plugin_ini = parse_ini_file("./plugins/$company/$plugin_name/config/plugin.ini");
        
        return [
            "COMPANY_NAME" => $plugin_ini["COMPANY_NAME"],
            "PLUGIN_NAME" => $plugin_ini["PLUGIN_NAME"],
            "PLUGIN_VERSION" => $plugin_ini["PLUGIN_VERSION"],
            "ACTIVE" => $plugin_ini["ACTIVE"],
            "IMPORTANT" => $plugin_ini["IMPORTANT"],
            "DESCRIPTION" => $plugin_ini["DESCRIPTION"],
        ];     
    }
    
    public function pluginInfo(string $company, string $plugin_name, string $config_line)
    {
        $to_upper = strtoupper($config_line);
        $plugin_ini = parse_ini_file("./plugins/$company/$plugin_name/config/plugin.ini");
        return $plugin_ini[$to_upper];
    }
}
?>
