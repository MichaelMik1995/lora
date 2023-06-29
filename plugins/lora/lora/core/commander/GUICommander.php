<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Commander;

use Lora\Lora\Core\LoraCore;
use Lora\Lora\Core\LoraOutput;
use Lora\Lora\Core\LoraUI;

trait GUICommander
{
    use LoraOutput;
    use LoraUI;
    use LoraCore;

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