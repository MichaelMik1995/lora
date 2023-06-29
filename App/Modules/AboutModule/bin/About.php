<?php
declare (strict_types = 1);

namespace App\Modules\AboutModule\bin;

use Lora\Lora\Core\loranCore;

/**
 * Description of php CLI About
 *
 * @author michaelmik
 */
class About 
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
                    
                    $this->loran_core->output("Module about installed succesfully", "success");
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}

