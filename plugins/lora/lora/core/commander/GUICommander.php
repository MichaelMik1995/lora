<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraCore;
use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraUI;
use App\Core\Interface\InstanceInterface;

class GUICommander implements InstanceInterface
{
    use LoraOutput;
    use LoraUI;
    use LoraCore;

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
            case "ui:create":
                if($argument != "")
                {
                    LoraCore::$options = $options;

                    switch($argument)
                    {
                        case "auth":
                            LoraUI::generateAuthViews();
                            break;

                        case "contact":
                            LoraUI::generateView("views", "contact");
                            break;
                    }
                }
                else
                {
                    LoraOutput::output("Usage: php lora ui:create [ui_name] (options:)");
                }
                break;

            case "mui:create":
                if($argument != "")
                {
                    if(!empty($options))
                    {
                        $name = $options[0];
                        if(in_array("--crud", $options))
                        {
                            LoraUi::generateUiModuleCRUDTemplate($argument, $name);
                        }
                        else
                        {
                            LoraUi::generateUiModuleTemplate($argument, $name);
                        }
                    }
                    else
                    {
                        $name = "ui_".rand(111111,999999);
                        LoraUi::generateUiModuleTemplate($argument, $name);
                    }
                    
                }
                else
                {
                    LoraOutput::output("Usage: php lora mui:create [Module_name] (options: --base)");
                }
                break;
        }
    }
}