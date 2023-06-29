<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use App\Core\Lib\Utils\ArrayUtils;
use Lora\Lora\Core\LoraMigrate;
use Lora\Lora\Core\LoraUI;
use Lora\Lora\Core\LoraOutput;

use App\Database\MigrationFactory;

trait MigrationCommander
{
    public static function SendCommand(string $command, string|null $argument = "", array $options = []): void
    {
        switch($command)
        {
            case "migrate":
                $migration = new MigrationFactory();

                if($argument != "")
                {
                    LoraMigrate::migrateOwnCaller($migration, $argument);
                }
                else
                {
                    LoraOutput::output("Usage: php lora migration [Caller_name]", "error");
                }
                
                break;

            case "migrate:create":
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

                        if(in_array("--table", $options))
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
                            LoraMigrate::createCaller($argument, $page);
                        }
                    }
                    else
                    {
                        LoraUI::generateMigrationTable($argument);
                    }
                    
                }
                else
                {
                    LoraOutput::output("Usage: php lora migration:create [new table name] [--data, --caller]", "error");
                }
                break;

            case "migrate:createdata":
                if($argument != "")
                {
                    LoraUI::generateMigrationSeed($argument);
                }
                else
                {
                    LoraOutput::output("Usage: php lora migration:createdata [table name]", "error");
                }
                break;

            case "migrate:data":
                $migration = new MigrationFactory();
                LoraMigrate::migrateSeed($migration);
                break;

            case "migrate:clear":
                $migration = new MigrationFactory();
                LoraMigrate::migrate($migration, clear_migration: true);
                break;
            
        }
    }
}