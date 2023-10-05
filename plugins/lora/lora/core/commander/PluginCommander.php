<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use App\Core\Interface\InstanceInterface;
use Lora\Lora\Core\Executor\LoraPlugin;
use Lora\Lora\Core\LoraOutput;

class PluginCommander implements InstanceInterface
{
    use LoraOutput;

    private static $_instance;
    private static $_instance_id;
    /*
    public function __construct()
    {
        
    }
    */

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = rand(000000,999999);
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getInstanceId(): Int
    {
        return self::$_instance_id;
    }
    
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