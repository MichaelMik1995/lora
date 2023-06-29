<?php
declare (strict_types = 1);

namespace App\Modules\TutorialModule\bin;

use Lora\Lora\Core\loranCore;

/**
 * Description of php CLI Tutorial
 *
 * @author michaelmik
 */
class Tutorial 
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
                case "testmodule":
                    
                    $this->loran_core->output("Module tutorial installed succesfully", "success");
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}

