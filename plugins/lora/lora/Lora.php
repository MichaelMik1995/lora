<?php
namespace Lora\Lora;

use Lora\Lora\Core\Commander\CacheCommander;
use Lora\Lora\Core\Commander\CLICommander;
use Lora\Lora\Core\Commander\ModuleCommander;
use Lora\Lora\Core\Commander\PluginCommander;
use Lora\Lora\Core\loranCore;
use Lora\Lora\Core\loranModule;
use Lora\Lora\Core\Commander\MigrationCommander;
use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\Commander\HelpCommander;
use Lora\Lora\Core\Commander\GUICommander;
use Lora\Lora\Core\Commander\ModelCommander;
use Lora\Lora\Core\Commander\RouteCommander;
use Lora\Lora\Core\Commander\ServerCommander;

class Lora
{
    use LoraOutput;
    use MigrationCommander;
    use HelpCommander;
    use GUICommander;
    use CLICommander;
    use CacheCommander;
    use ModelCommander;
    use RouteCommander;
    use PluginCommander;
    use ModuleCommander;

    public function __construct() 
    {
        //$this->loran_core = new loranCore();
        //$this->loran_module = new loranModule();
    }
    
    public function prepareCommand(string $command_line)
    {
        $explode_command = explode(" ", $command_line);
        $command = $explode_command[1];
        $argument = @$explode_command[2];

        $options = array_splice($explode_command, 3);   
        
        $this->switchCommander($command, $argument, $options);
    }

    public function SendCommand($command, $argument="", $option1, $option2 ): Void//$option1, $option2)
    {       
        
    }

    private function switchCommander(string|null $command, string|null $argument, array $options = [])
    {
        if($command != null)
        {
            MigrationCommander::SendCommand($command, $argument, $options);
            HelpCommander::SendCommand($command, $argument, $options);
            GUICommander::SendCommand($command, $argument, $options);
            CLICommander::SendCommand($command, $argument, $options);
            CacheCommander::SendCommand($command, $argument, $options);
            ModelCommander::SendCommand($command, $argument, $options);
            RouteCommander::SendCommand($command, $argument, $options);
            ServerCommander::SendCommand($command, $argument, $options);
            PluginCommander::SendCommand($command, $argument, $options);
            ModuleCommander::SendCommand($command, $argument, $options);
        }
        else
        {
            //print '### usage: php fram [$command] [$arguments = []]';
            LoraOutput::output('Usage: php lora [$command] [$argumemts = [] ]', "error");
            LoraOutput::output('Usage: php lora [help, -h]', "warning");
            exit();
        }
        
    }
}
?>
