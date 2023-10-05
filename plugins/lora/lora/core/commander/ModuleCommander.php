<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\Executor\LoraModule;
use App\Core\Lib\Utils\ArrayUtils;
use App\Core\Interface\InstanceInterface;

class ModuleCommander implements InstanceInterface
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
            case "module:create":
                if($argument != "")
                {
                    $option = ArrayUtils::substringInArray("--model=", $options, 1);

                    if(!empty( $option))
                    {
                        $explode = explode("=", $option);

                        if(in_array("--crud", $options))
                        {
                            LoraModule::createModel($explode[1], $argument, true);
                            LoraOutput::output("Model: ".ucfirst($argument).ucfirst($explode[1])." in module: ".ucfirst($argument)."Module created! ", "success");
                        }
                        else
                        {
                            LoraModule::createModel($explode[1], $argument);
                            LoraOutput::output("Model: ".ucfirst($argument).ucfirst($explode[1])." in module: ".ucfirst($argument)."Module created! ", "success");
                        }
                        
                    }
                    else
                    {
                        LoraModule::createModule($argument);
                    }
                    
                }
                else
                {
                    LoraOutput::output("usage: php lora module:create [ModuleName]", "error");
                }
                break;

            case "module:update":
                if($argument != "")
                {
                    if (!empty($options)) 
                    {
                        $option = ArrayUtils::substringInArray("--addmodel=", $options, 1);

                        if (!empty($option)) {
                            $explode = explode("=", $option);

                            if (in_array("--crud", $options)) {
                                LoraModule::createModel($explode[1], $argument, true);
                            } else {
                                LoraModule::createModel($explode[1], $argument);
                            }
                        }
                    }
                    else
                    {
                        LoraOutput::output("usage: php lora module:update [ModuleName] (--addmodel=Modelname)", "error");
                    }
                }
                else
                {
                    LoraOutput::output("usage: php lora module:create [ModuleName]", "error");
                }
                break;

            case "module:delete":
                if($argument != "")
                {
                    shell_exec("rm -rf ./App/Modules/".ucfirst($argument)."Module");
                    LoraOutput::output("Module ".ucfirst($argument)."Module deleted! ", "success");
                }
                else
                {
                    LoraOutput::output("usage: php lora module:delete [ModuleName]", "error");
                }
                break;

            case "module:list":
                $modules_path = "./App/Modules";
                $i = 0;
                foreach (glob($modules_path . "/*") as $module_path) {
                    if (is_dir($module_path) && $module_path != "./App/Modules/bin") {
                        $i++;
                        LoraOutput::output($module_path, "success");
                    }
                }
                LoraOutput::output("$i Modules installed!");
                break;

            case "splitter:create":
                if($argument != "") 
                {
                    $option = ArrayUtils::substringInArray("--module=", $options, 1);
                    $explode = explode("=", $option);

                    $option_temp = ArrayUtils::substringInArray("--templates=", $options, 1);
                    
                    if($option_temp != "")
                    {
                        $explode_temp = explode("=", $option_temp);

                        LoraModule::createSplitter($argument, $explode[1], true, $explode_temp[1]);
                    }
                    else
                    {
                        LoraModule::createSplitter($argument, $explode[1]);
                    }
                    
                } else {
                    LoraOutput::output("Usage: php bin/module splitter:create [Splitter name] [Module name]!", "error");
                }
                break;

                
        }
    }
}