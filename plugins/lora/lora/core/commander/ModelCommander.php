<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use App\Core\Interface\InstanceInterface;
use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraUI;
use Lora\Lora\Core\Executor\LoraModel;

use App\Core\Lib\Utils\ArrayUtils;

class ModelCommander implements InstanceInterface
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
    
    public static function SendCommand(string $command, string|null $argument, array $options = []): void
    {
        switch($command)
        {
            case "model:create":
                $array_utils = new ArrayUtils();
                if($argument != null)
                {
                    if(!empty($options))
                    {
                        if(in_array("--crud", $options))
                        {
                            LoraUI::generateModel($argument, "crud_model");
                        }
                        if(in_array("--controller", $options))
                        {
                            LoraUI::generateController($argument, "basic_controller");
                        }


                        $get_module = $array_utils->substringInArray("--module=", $options);
                        
                        if(!empty($get_module))
                        {
                            $explode = explode("=",$get_module);
                            LoraModel::generateModuleModel($argument, $explode[1]);
                        }
                        
                    }
                    else
                    {
                        LoraUI::generateModel($argument, "basic_model");
                    }
                }
                else
                {
                    LoraOutput::output("Nothing to create!", "error");
                }
                break;
        }
    }
}