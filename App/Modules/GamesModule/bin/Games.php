<?php
declare (strict_types = 1);

namespace App\Modules\GamesModule\bin;

use Lora\Lora\Core\loranCore;

/**
 * Description of php CLI Games
 *
 * @author michaelmik
 */
class Games 
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
                    
                    $this->loran_core->output("Module games installed succesfully", "success");
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}

