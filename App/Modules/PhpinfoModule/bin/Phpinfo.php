<?php
declare (strict_types = 1);

namespace App\Modules\PhpinfoModule\bin;

use Lora\Lora\Core\loranCore;

/**
 * Description of php CLI Phpinfo
 *
 * @author michaelmik
 */
class Phpinfo 
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
                    
                    $this->loran_core->output("Module phpinfo installed succesfully", "success");
                    break;

                case "print":
                    echo phpinfo();
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}

