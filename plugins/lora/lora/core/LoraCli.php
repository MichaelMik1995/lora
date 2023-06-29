<?php
declare(strict_types=1);

namespace Lora\Lora\Core;

use Lora\Compiler\Templator;

class LoraCli 
{
    use Templator;
    use LoraOutput;

    public function __construct()
    {
        
    }

    public static function createCommander(string $name)
    {
        $get_template = __DIR__."/../templates/lora/commander.template";
        $content = \file_get_contents($get_template);

        $compiled_content = Templator::compile($content, [
            "{Commander}" => ucfirst($name),
        ]);

        if(!file_exists(__DIR__."/commander/".ucfirst($name)."Commander.php"))
        {
            $file = fopen(__DIR__."/commander/".ucfirst($name)."Commander.php", "w");
            if(fwrite($file, $compiled_content))
            {
                fclose($file);
                LoraOutput::output("Commander: ".ucfirst($name)."Commander.php in /commander was created successfully","success");
                return true;
            }
            else
            {
                LoraOutput::output("Something went wrong with adding commander file","error");
            }
        }
        else
        {
            LoraOutput::output("This file already exists! Skipping execute...","warning");
        }
    } 

    public static function createExecutor(string $name)
    {
        $name = ucfirst($name);

        $get_template = __DIR__."/../templates/lora/executor.template";
        $content = \file_get_contents($get_template);

        $compiled_content = Templator::compile($content, [
            "{Name}" => $name,
        ]);

        if(!file_exists(__DIR__."/executor/Lora".ucfirst($name).".php"))
        {
            $file = fopen(__DIR__."/executor/Lora".ucfirst($name).".php", "w");
            if(fwrite($file, $compiled_content))
            {
                fclose($file);
                LoraOutput::output("Executor: Lora".ucfirst($name).".php in /executor was created successfully","success");
                return true;
            }
            else
            {
                LoraOutput::output("Something went wrong with adding executor file","error");
            }
        }
        else
        {
            LoraOutput::output("This file already exists! Skipping execute...","warning");
        }


    }
}