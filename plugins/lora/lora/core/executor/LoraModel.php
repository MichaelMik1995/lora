<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Executor;

use Lora\Compiler\Templator;
use Lora\Lora\Core\LoraOutput;

class LoraModel 
{
    use Templator;
    use LoraOutput;

    public function __construct()
    {
        
    }

    public static function generateModuleModel(string $model_name, string $module)
    {
        $template_path = "./plugins/lora/lora/templates/module/";
        $get_content = file_get_contents($template_path."model_module.template");

        $module = ucfirst($module);
        $model = ucfirst($model_name);

        $compile_code = Templator::compile($get_content, [
            "{Module_name}" => $module,
            "{Model_name}" => $model,
            "{time}" => DATE("d.m.Y H:i"),
        ]);

        
        $model_file= "App/Modules/$module"."Module/Model/".ucfirst($model_name).".php";
        
        if(!file_exists($model_file))
        {
            $new_file = fopen($model_file, "w+");
            file_put_contents($model_file, $compile_code, LOCK_EX);
            fclose($new_file);
            LoraOutput::output("Model in '$model_file' in module $module created sucessfully!", "success");
        }
        else
        {
            LoraOutput::output("This file '$model_file' in module $module already exists!", "warning");
        }
    }

}