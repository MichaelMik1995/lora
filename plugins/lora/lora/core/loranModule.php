<?php
declare (strict_types=1);

namespace Lora\Lora\Core;

use Lora\Compiler\Compiler;
use Lora\Lora\Core\loranCore;

/**
 * Description of loranModule
 *
 * @author michaelmik
 */
class loranModule 
{
    protected $compiler;
    protected $loran_core;
    
    public function __construct() 
    {
        $this->compiler = new Compiler();
        $this->loran_core = new loranCore();
    }
    
    public function createModule(string $name, string $readme = "##Welcome to module ")
    {
        $name = strtolower($name);
        
        $uc_name = ucfirst($name);
        $module_dir = "./App/Modules/".$uc_name."Module/";
        
        if(!is_dir($module_dir))
        {
            mkdir($module_dir, 0777); //create module folder
            mkdir($module_dir."/bin", 0777);
            mkdir($module_dir."/resources", 0777);
            mkdir($module_dir."/resources/views", 0777);
            mkdir($module_dir."/Controller", 0777);
            mkdir($module_dir."/Model", 0777);
            mkdir($module_dir."/Register", 0777);
            
            //create readme for module
            $file_md = fopen($module_dir."/readme.md", "w+");
            fwrite($file_md, $readme);
            fclose($file_md);
            
            //create controller
            $controller_template = file_get_contents("./plugins/lora/lora/templates/controller/controller_module.template");
            $compiled_controller = $this->compiler->compile($controller_template, ["{Model_name}"=>$uc_name, "{model_name}"=>$name]);
            $file_controller = fopen($module_dir."/Controller/".$uc_name."Controller.php", "w+");
            fwrite($file_controller, $compiled_controller);
            fclose($file_controller);
            
            //create model
            $model_template = file_get_contents("./plugins/lora/lora/templates/model/model_module.template");
            $compiled_model = $this->compiler->compile($model_template, ["{Model_name}"=>$uc_name, "{model_name}"=>$name]);
            $file_model = fopen($module_dir."/Model/".$uc_name.".php", "w+");
            fwrite($file_model, $compiled_model);
            fclose($file_model);
            
            
            //create View index
            $file_index = fopen($module_dir."/resources/views/index.lo.php", "w+");
            fwrite($file_index, "<h3>Module $uc_name installed!</h3>");
            fclose($file_index);
            
            //create bin/{name}
            $get_class_content = file_get_contents("./plugins/lora/lora/templates/module/bin.template");
            $compiled_exec = $this->compiler->compile($get_class_content, ["{Name}"=>$uc_name, "{name}"=>$name]);
            $file_exec = fopen("./bin/mod_$name", "w+");
            fwrite($file_exec, $compiled_exec);
            fclose($file_exec);
            
            //create {Module}/bin/{name}.php
            $get_class_content = file_get_contents("./plugins/lora/lora/templates/module/module_bin.template");
            $compiled_exec_class = $this->compiler->compile($get_class_content, ["{Name}"=>$uc_name, "{name}"=>$name]);
            $file_exec_class = fopen($module_dir."/bin/$uc_name.php", "w+");
            fwrite($file_exec_class, $compiled_exec_class);
            fclose($file_exec_class);
            
            //create register class
            $get_register_temp__content = file_get_contents("./plugins/lora/lora/templates/module/module_register.template");
            $compiled_exec_register_class = $this->compiler->compile($get_register_temp__content, ["{Name}"=>$uc_name, "{name}"=>$name]);
            $file_exec_register_class = fopen($module_dir."/Register/$uc_name"."Register.php", "w+");
            fwrite($file_exec_register_class, $compiled_exec_register_class);
            fclose($file_exec_register_class);
            
            $this->loran_core->output("Module $uc_name installed successfully! ", "success");             
        }
        else
        {
            $this->loran_core->output("Cannot create new module $name because this module already exists!","error");
        }
    }
    
    
    public function updateModule(string $module, string $content)
    {
        $file_open = fopen("./App/Modules/".$module."Module/readme.md", "w");
        fwrite($file_open, $content);
        fclose($file_open);
    }
    
    public function deleteModule(string $module)
    {
        
    }
    
    public function createSplitter(string $splitter_name, string $module)
    {
        $uc_module = ucfirst($module);
        $module_dir = "App/Modules/$uc_module"."Module";
        //if module exists
        if(!is_dir($module_dir))
        {
            $this->loran_core->output("Module $uc_module not exists! Cannot create splitter!","error");
        }
        
        if(!is_dir($module_dir."/Controller/Splitter"))
        {
            mkdir($module_dir."/Controller/Splitter");
            $this->loran_core->output("Created splitter folder in module: $uc_module");
        }
        
        //if splitter dont exists
        if(file_exists($module_dir."/Controller/Splitter/$splitter_name"."Controller.php"))
        {
            $this->loran_core->output("Splitter: $splitter_name already exists in module: $uc_module!","error");
            exit();
        }
        
        //get template
        $get_template = file_get_contents("./plugins/lora/lora/templates/module/splitter.template");
        $compiled = $this->compiler->compile($get_template, 
                [
                    "{module}" => $module,
                    "{Module}"=>$uc_module, 
                    "{Splitter_name}"=>$splitter_name, 
                    "{splitter_name}"=> strtolower($splitter_name)
                ]
        );
        
        //create splitter
        $file_splitter = fopen($module_dir."/Controller/Splitter/".$splitter_name."Controller.php", "w+");
        fwrite($file_splitter, $compiled);
        fclose($file_splitter);
        
        //create view folder in module/resources/views
        if(!is_dir($module_dir."/resources/views/".strtolower($splitter_name)))
        {
            mkdir($module_dir."/resources/views/".strtolower($splitter_name));
            $this->loran_core->output("View folder for $splitter_name in module: $uc_module created!", "success");
        }
        else
        {
            $this->loran_core->output("View folder for $splitter_name already exists in module: $uc_module! Skipping ... ", "warning");
        }
        
        $this->loran_core->output("Splitter: $splitter_name successfully created in $uc_module module!", "success");
    }
    
    /**
     * 
     * @param string $model_name
     * @param string $module_name
     * @param string $option
     */
    public function createModel(string $model_name, string $module_name, string $option = "")
    {
        $template = match($option)
        {
            "crud" => "model_crud_module",
            default => "model_module",
        };
        
        $template_content = file_get_contents(__DIR__. "/../templates/module/".$template.".template");
        
        $compile_content = $this->compiler->compile($template_content, 
                                                    [   "{Model_name}" => ucfirst($model_name), 
                                                        "{model_name}" => strtolower($model_name),
                                                        "{module}" => ucfirst($module_name),
        ]);
        
        $module_path = "App/Modules/". ucfirst($module_name)."Module/Model/". ucfirst($model_name).".php";
        if(file_exists($module_path))
        {
            $this->loran_core->output("Model: ".ucfirst($model_name)." already exists in: App/Modules/".ucfirst($module_name)."Module/Model/", "error");
        
            return false;
        }
        else
        {
            $file = fopen($module_path, "w");
            fwrite($file, $compile_content);
            fclose($file);
            $this->loran_core->output("Model: ".ucfirst($model_name)." successfully created in: App/Modules/".ucfirst($module_name)."Module/Model/", "success");
           
            return true;
        }
    }
}
