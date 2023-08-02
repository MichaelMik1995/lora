<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraCli;

trait CLICommander
{
    use LoraOutput;

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