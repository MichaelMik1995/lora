<?php
declare (strict_types=1);

namespace App\Modules\bin;

use Lora\Lora\Core\loranCore;
use Lora\Lora\Core\loranModule;
use App\Lib\Styler;

/**
 * Description of module
 *
 * @author michaelmik
 */
class module 
{
    protected $loran_core;
    protected $loran_module;
    
    
    public function __construct()
    {
        $this->loran_core = new loranCore();
        $this->loran_module = new loranModule($this->loran_core);
    }
    
    public function sendCommand($command, $argument="", $option1="", $option2="")
    {
        if($command != "")
        {
            switch($command)
            {
                case "test":
                    $this->loran_core->output("Commander for Module is active!", "success");
                    break;
                
                case "create":
                    if($argument != "")
                    {
                        if($option1 != "")
                        {
                            match($option1)
                            {
                                "--blog" => $this->loran_module->createBlogModule($argument),
                                default => $this->loran_core->output("Usage: php bin/module create $argument [--blog]", "error"),
                            };  
                        }
                        else
                        {
                            $this->loran_module->createModule($argument);
                        }
                        
                    }
                    else
                    {
                        $this->loran_core->output("Argument for module:create must be filled!", "error");
                    }
                    break;
                    
                case "list":
                    $modules_path = "./App/Modules";
                    $i = 0;
                    foreach(glob($modules_path."/*") as $module_path)
                    {
                        if(is_dir($module_path) && $module_path != "./App/Modules/bin")
                        {
                            $i++;
                            $this->loran_core->output($module_path, "success");
                        }
                    }
                    
                    $this->loran_core->output("$i Modules installed!");
                    break;
                
                case "delete":
                    
                    break;
                
                case "splitter:create":
                    //create splitter
                    if($argument != "")
                    {
                        $this->loran_module->createSplitter($argument, $option1);
                    }
                    else
                    {
                        $this->loran_core->output("Usage: php bin/module splitter:create [Splitter name] [Module name]!", "error");
                    }
                    break;
                    
                case "model:create":
                    if($argument != "")
                    {
                        if($option1 != "")
                        {
                            match($option2)
                            {
                                "--crud" => $this->loran_module->createModel($argument, $option1, "crud"),
                                default => $this->loran_module->createModel($argument, $option1),
                            };
                        }
                        else
                        {
                            $this->loran_core->output("Usage: php bin/module model:create $argument [module name] (option)", "error");
                        }
                        
                    }
                    else
                    {
                        $this->loran_core->output("Usage: php bin/module model:create [model name] [module name] (option)", "error");
                    }
                    break;
                
                case "compile-style":
                    $styler = new Styler();
                    $styler->compileModuleStyles();
                    $this->loran_core->output("Module CSS file compiled and writted succesfully!", "success");
                    break;
            }
            
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}
