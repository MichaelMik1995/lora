<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraUI;

trait HelpCommander
{
    public static function SendCommand(string $command, string|null $argument = "", array $options = []): void
    {
        switch($command)
        {
            case "help":
                if($argument != "")
                {
                    $page = LoraUI::generateHelp($argument);
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
                break;
        }
    }
}