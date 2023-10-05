<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use App\Core\Interface\InstanceInterface;
use Lora\Lora\Core\LoraOutput;

class CacheCommander implements InstanceInterface
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