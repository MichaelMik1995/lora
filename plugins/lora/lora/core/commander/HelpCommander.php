<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraUI;
use App\Core\Interface\InstanceInterface;

class HelpCommander implements InstanceInterface
{
    private static $_instance;
    private static $_instance_id;

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = uniqid();
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getInstanceId(): String
    {
        return self::$_instance_id;
    }

    public function SendCommand(string $command, string|null $argument = "", array $options = []): void
    {
        match($command){
            "help" => $this->generateHelp($argument),
        };
    }

    private function generateHelp(string|null $argument)
    {
        if($argument != "")
        {
            $page = LoraUI::generateHelp($argument);
            LoraOutput::output($page);
        }
        else
        {
            $page = [];
            
            foreach(glob(__DIR__."/../../cli-pages/help/*") as $page_help)
            {
                $replace = str_replace([__DIR__."/../../cli-pages/help/", ".json"], "", $page_help);
                $page[] = $replace;
            }
            $implode = implode("|",$page);
            LoraOutput::output("usage: php lora help [$implode]");
            
        }
    }
}