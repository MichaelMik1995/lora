<?php
namespace plugins\Lora\formcreator\bin;
use Lora\Lora\Core\loranCore;

/**
 * Description of formcreator
 * A description of plugin
 *
 * @author michaelmik
 */
class formcreator 
{
    protected $loran_core;
    public function __construct()
    {
        $this->loran_core = new loranCore();
    }
    
    public function sendCommand($command, $argument="", $option1="", $option2="")
    {
        if($command != "")
        {
            switch($command)
            {
                case "testplugin":
                    
                    $this->loran_core->output("Plugin: formcreator seem installed successfully", "success");
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}
