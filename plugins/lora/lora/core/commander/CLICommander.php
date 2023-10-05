<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraCli;
use App\Core\Interface\InstanceInterface;

class CLICommander implements InstanceInterface
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
            case "commander:create":
                
                if(!empty($options))
                {
                    if(in_array("--exec", $options))
                    {
                        LoraCli::createCommander($argument);
                        LoraCli::createExecutor($argument);
                    }
                }
                else{
                    LoraCli::createCommander($argument);
                }
                
                break;
        }
    }
}