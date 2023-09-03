<?php
namespace Lora\Gengine\Bin;

use Lora\Lora\Core\loranCore;
use Lora\Gengine\Core\Executor\GengineCompiler;

/**
 * Description of gengine
 * {description}
 *
 * @author michaelmik
 */
class gengine 
{
    protected $loran_core;
    protected $gengine_compiler;
    public function __construct()
    {
        $this->loran_core = new loranCore();
        $this->gengine_compiler = GengineCompiler::instance();
    }

    public function prepareCommand(string $command_line)
    {
        $explode_command = explode(" ", $command_line);
        $command = $explode_command[1];
        $argument = @$explode_command[2];

        $options = array_splice($explode_command, 3);   

        $this->sendCommand($command, $argument, $options);
    }
    
    public function sendCommand($command, $argument="", $options = [])
    {
        if($command != "")
        {
            switch($command)
            {
                case "testplugin":
                    
                    $this->loran_core->output("Plugin: gengine seem installed successfully", "success");
                    break;

                case "compile":
                    $this->gengine_compiler->compileTS();
                    break;

                case "fnclist":
                    
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}
