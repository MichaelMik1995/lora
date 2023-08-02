<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;

use Lora\Lora\Core\Executor\LoraServer;

trait ServerCommander
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
            case "start":
                LoraServer::serverStart();
                break;
        }
    }
}