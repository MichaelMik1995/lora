<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use App\Core\Interface\InstanceInterface;

class RouteCommander implements InstanceInterface
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
            
            case "route:list":
                /*$get_urls = $register->__return();
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
                    }*/
                    
                    //LoraOutput::output(count($get_urls)." routes registered!");
                break;
        }
    }
}