<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\Executor\LoraPlugin;
use Lora\Lora\Core\LoraOutput;

trait PluginCommander
{
    use LoraOutput;

    /*
    public function __construct()
    {
        
    }
    */
    
    public static function SendCommand(string $command, string|null $argument = "", array $options = []): void
    {
        switch($command)
        {
            case "plugin:create":
                if($argument != "")
                {
                    $explode_arg = explode("/", $argument);
                    if(count($explode_arg) == 1)
                    {
                        LoraPlugin::createPlugin($explode_arg[0]);
                    }
                    else
                    {
                        LoraPlugin::createPlugin($explode_arg[1], $explode_arg[0]);
                    }
                    
                }
                else
                {
                    LoraOutput::output("Usage: php lora plugin:create [new plugin name]", "error");
                }
                break;

            case "plugin:delete":
                
                break;
        }
    }
}