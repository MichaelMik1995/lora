<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraUI;
use Lora\Lora\Core\Executor\LoraModel;

use App\Core\Lib\Utils\ArrayUtils;

trait ModelCommander
{
    use LoraOutput;

    /*
    public function __construct()
    {
        
    }
    */
    
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