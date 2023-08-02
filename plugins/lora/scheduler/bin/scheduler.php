<?php
namespace Lora\Scheduler\Bin;

use Lora\Lora\Core\loranCore;

/**
 * Description of scheduler
 * {description}
 *
 * @author michaelmik
 */
class scheduler 
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
                    
                    $this->loran_core->output("Plugin: scheduler seem installed successfully", "success");
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}
