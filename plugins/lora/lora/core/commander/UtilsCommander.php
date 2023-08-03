<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\Executor\LoraUtils;

trait UtilsCommander
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
            case "utils:create":
                if($argument != "")
                {
                    LoraUtils::createUtility($argument);
                }
                else
                {
                    LoraOutput::output("usage: php lora utils:create [utilName]", "warning");
                }
                break;
        }
    }
}