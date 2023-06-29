<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;

trait CacheCommander
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
            case "cache:clear":
                $i = 0;
                foreach(glob("temp/cache/*") as $view_file)
                {
                    $i++;
                    echo "$i ".$view_file." Deleted! \n";
                    unlink($view_file); 
                }
                LoraOutput::output("\nAll view files in temp/cache deleted!", "success");
                break;
        }
    }
}