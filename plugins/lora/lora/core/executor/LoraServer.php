<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Executor;

use Lora\Compiler\Templator;
use Lora\Lora\Core\LoraOutput;

class LoraServer 
{
    use Templator;
    use LoraOutput;

    public function __construct()
    {
        
    }

    public static function serverStart()
    {
        shell_exec("php -S localhost:8080");
    }

}