<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use App\Core\Register\Register;
use Lora\Lora\Core\LoraOutput;

trait RouteCommander
{
    use LoraOutput;

    /*
    public function __construct()
    {
        
    }
    */
    
    public static function SendCommand(string $command, string|null $argument = "", array $options = []): void
    {
        $register = new Register();

        switch($command)
        {
            
            case "route:list":
                $get_urls = $register->__return();
                    foreach($get_urls as $registered)
                    {
                        if(@$registered["request"] == null)
                        {
                            $registered["request"] = "default";
                        }
                        
                        if(@$registered["module"] == null)
                        {
                            $registered["module"] = "0";
                        }

                        if(@$registered["route"] == null)
                        {
                            $route = "--";
                        }
                        else
                        {
                            $route = $registered["route"];
                        }
                        
                        
                        LoraOutput::output("URL: ". $registered["url"]."\t\t\t\t ROUTE: ".$route."\t IS_MODULE: ".@$registered["module"], "success");
                        LoraOutput::output("----------------------------------------------------------------------------------------------------------------");
                    }
                    
                    LoraOutput::output(count($get_urls)." routes registered!");
                break;
        }
    }
}