<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;

trait ControllerCommander
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
            case "controller:create":
                //--module --model
                //$loran_ui->generateController($argument, "basic_controller");
                break;

        }
    }
}