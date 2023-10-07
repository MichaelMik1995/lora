<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use App\Core\Interface\InstanceInterface;
use App\Core\Lib\Utils\ArrayUtils;
use Lora\Lora\Core\Executor\LoraDatabase;
use Lora\Lora\Core\LoraUI;
use Lora\Lora\Core\LoraOutput;

use App\Database\DatabaseFactory;

class DatabaseCommander implements InstanceInterface
{
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
            case "dbtable:write":
                $database = new DatabaseFactory();

                if($argument != "")
                {
                    LoraDatabase::migrateOwnCaller($database, $argument);
                }
                else
                {
                    LoraOutput::output("Usage: php lora dbtable:write [Caller_name]", "error");
                }
                
                break;

            case "dbtable:create":
                if($argument != "")
                {
                    if(!empty($options))
                    {
                        $option = ArrayUtils::substringInArray("--folder=", $options);
                        
                        if(!empty($option))
                        {
                            $explode = explode("=", $option);
                            $page = $explode[1];
                        }
                        else
                        {
                            $page = "";
                        }

                        if(in_array("--onlytable", $options))
                        {
                            LoraUI::generateDatabaseTable($argument, $page);
                        }

                        if(in_array("--data", $options))
                        {
                            LoraUI::generateDatabaseTable($argument, $page);
                            LoraUI::generateDatabaseSeed($argument, $page);
                        }

                        if(in_array("--onlydata", $options))
                        {
                            LoraUI::generateDatabaseSeed($argument, $page);
                        }


                        if(in_array("--caller", $options))
                        {
                            LoraUI::generateDatabaseTable($argument, $page);
                            LoraDatabase::createCaller($argument, $page);
                        }
                    }
                    else
                    {
                        LoraUI::generateDatabaseTable($argument);
                    }
                    
                }
                else
                {
                    LoraOutput::output("Usage: php lora dbtable:create [new table name] [--data, --onlydata, --onlytable, --caller]", "error");
                }
                break;            
        }
    }
}