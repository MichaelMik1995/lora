<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use App\Core\Lib\Utils\ArrayUtils;
use Lora\Lora\Core\Executor\LoraDatabase;
use Lora\Lora\Core\LoraUI;
use Lora\Lora\Core\LoraOutput;

use App\Database\DatabaseFactory;

trait DatabaseCommander
{
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
                            LoraUI::generateMigrationTable($argument, $page);
                        }

                        if(in_array("--data", $options))
                        {
                            LoraUI::generateMigrationTable($argument, $page);
                            LoraUI::generateMigrationSeed($argument, $page);
                        }

                        if(in_array("--onlydata", $options))
                        {
                            LoraUI::generateMigrationSeed($argument, $page);
                        }


                        if(in_array("--caller", $options))
                        {
                            LoraDatabase::createCaller($argument, $page);
                        }
                    }
                    else
                    {
                        LoraUI::generateMigrationTable($argument);
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