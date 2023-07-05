<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Executor;

use Lora\Compiler\Templator;
use Lora\Lora\Core\LoraOutput;

class LoraModule 
{
    use Templator;
    use LoraOutput;

    public function __construct()
    {
        
    }

    public static function createModule(string $name, string $readme = "##Welcome to module ")
    {
        $name = strtolower($name);
        
        $uc_name = ucfirst($name);
        $module_dir = "./App/Modules/".$uc_name."Module/";
        
        if(!is_dir($module_dir))
        {
            mkdir($module_dir, 0777); //create module folder
            
            mkdir($module_dir."/config", 0777);
            mkdir($module_dir."/Controller", 0777);
            mkdir($module_dir."/Model", 0777);
            mkdir($module_dir."/Register", 0777);
            mkdir($module_dir."/public", 0777);
            mkdir($module_dir."/public/css", 0777);
            mkdir($module_dir."/public/js", 0777);
            mkdir($module_dir."/public/img", 0777);
            mkdir($module_dir."/resources", 0777);
            mkdir($module_dir."/resources/views", 0777);
            
            //create readme for module
            $file_md = fopen($module_dir."/readme.md", "w+");
            fwrite($file_md, $readme);
            fclose($file_md);
            
            //create controller
            $controller_template = file_get_contents("./plugins/lora/lora/templates/controller/controller_module.template");
            $compiled_controller = Templator::compile($controller_template, ["{Model_name}"=>$uc_name, "{model_name}"=>$name]);
            $file_controller = fopen($module_dir."/Controller/".$uc_name."Controller.php", "w+");
            fwrite($file_controller, $compiled_controller);
            fclose($file_controller);

            //Create Main model
            self::createMainModel($name, $module_dir);

            //Create config file
            self::createConfigFile($name, $module_dir);
            
            //create View index
            $file_index = fopen($module_dir."/resources/views/index.lo.php", "w+");
            fwrite($file_index, "<h3>Module $uc_name installed!</h3>");
            fclose($file_index);
            
            //create register class
            $get_register_temp__content = file_get_contents("./plugins/lora/lora/templates/module/module_register.template");
            $compiled_exec_register_class = Templator::compile($get_register_temp__content, ["{Name}"=>$uc_name, "{name}"=>$name]);
            $file_exec_register_class = fopen($module_dir."/Register/$uc_name"."Register.php", "w+");
            fwrite($file_exec_register_class, $compiled_exec_register_class);
            fclose($file_exec_register_class);
            
            LoraOutput::output("Module $uc_name installed successfully! ", "success");             
        }
        else
        {
            LoraOutput::output("Cannot create new module $name because this module already exists! Skipping ...","warning");
        }
    }


    public static function createMainModel($module_name, $module_dir)
    {
        $uc_name = ucfirst($module_name);


        //create model
        $model_template = file_get_contents("./plugins/lora/lora/templates/module/model_crud_module.template");
        $compiled_model = Templator::compile($model_template, 
            [
                "{module}" => $uc_name,
                "{Model_name}"=>$uc_name, 
                "{model_name}"=>$module_name
            ]
        );

        $model_file = $module_dir."/Model/".$uc_name.".php";
        
        if(!file_exists($model_file))
        {
            $file_model = fopen($model_file, "w+");
            fwrite($file_model, $compiled_model);
            fclose($file_model);

            LoraOutput::output("Main model $model_file created!", "success");
        }
        else
        {
            LoraOutput::output("Main model $model_file exists! Skipping ...", "warning");
        }
        
    }

    public static function createModel($model_name, $module_name, $crud = false)
    {
        $uc_name = ucfirst($module_name);
        $model_name_uc = ucfirst($model_name);
        $module_dir = "./App/Modules/".$uc_name."Module/";

        $model_file = $module_dir . "Model/" . $uc_name . $model_name_uc.".php";

        if (!file_exists($model_file)) {
            //create secondary model

            if($crud == true)
            {
                $model_template = file_get_contents("./plugins/lora/lora/templates/module/model_module_crud_splitter.template");
            }
            else
            {
                $model_template = file_get_contents("./plugins/lora/lora/templates/module/model_module.template");
            }
            
            $compiled_model = Templator::compile($model_template, 
                [
                    "{Module_name}" => $uc_name, 
                    "{Model_name}" => $uc_name.$model_name_uc, 
                    "{time}" => time()
                ]
            );
            $file_model = fopen($model_file, "w+");
            fwrite($file_model, $compiled_model);
            fclose($file_model);
            LoraOutput::output("Model: ".$uc_name.$model_name_uc." in module: ".$uc_name."Module/Model created! ", "success");

        }
        else
        {
            LoraOutput::output("Model: ".$uc_name . $model_name_uc." already exists! Skipping.... ", "warning");
        }
    } 


    public static function createSplitter(string $splitter_name, string $module, bool $templates = false, string $template_names = "")
    {
        $uc_module = ucfirst($module);
        $module_dir = "./App/Modules/$uc_module"."Module";

        //if module exists
        if(!is_dir($module_dir))
        {
            LoraOutput::output("Module $uc_module not exists! Cannot create splitter!","error");
            exit();
        }
        
        if(!is_dir($module_dir."/Controller/Splitter"))
        {
            mkdir($module_dir."/Controller/Splitter");
            LoraOutput::output("Created splitter folder in module: $uc_module");
        }
        
        //if splitter dont exists
        if(file_exists($module_dir."/Controller/Splitter/$splitter_name"."Controller.php"))
        {
            LoraOutput::output("Splitter: $splitter_name already exists in module: $uc_module! Skipping ...","warning");
            exit();
        }
        
        //get template
        $get_template = file_get_contents("./plugins/lora/lora/templates/module/splitter.template");
        $compiled = Templator::compile($get_template, 
                [
                    "{module}" => $module,
                    "{Module}"=>$uc_module, 
                    "{Splitter_name}"=>$uc_module.$splitter_name, 
                    "{splitter_name}"=> strtolower($splitter_name)
                ]
        );
        
        //create splitter
        $file_splitter = fopen($module_dir."/Controller/Splitter/$uc_module".$splitter_name."Controller.php", "w+");
        fwrite($file_splitter, $compiled);
        fclose($file_splitter);

        if ($templates == true) {
            //create view folder in module/resources/views
            if (!is_dir($module_dir . "/resources/views/" . strtolower($template_names))) {
                mkdir($module_dir . "/resources/views/" . strtolower($template_names));
                LoraOutput::output("View folder for $splitter_name in module: $uc_module created!", "success");
            } else {
                LoraOutput::output("View folder for $splitter_name already exists in module: $uc_module! Skipping ... ", "warning");
            }
        }
        
        LoraOutput::output("Splitter: ".$uc_module."".$splitter_name."Controller successfully created in $uc_module module!", "success");
    }

    /**
     * Summary of createConfigFile
     * 
     * @param string $module_name
     * @param string $module_dir
     * @param string $version
     * @param string $category
     * @param string $description
     * @param string $icon
     * @return void
     */
    public static function createConfigFile(
        string $module_name, 
        string $module_dir, 
        string $version = "3.0.0", 
        string $category = "Module", 
        string $description = "Sample Description", 
        string $icon = "fa fa-box"
    )
    {
        $uc_name = ucfirst($module_name);
        //create model
        $template = file_get_contents("./plugins/lora/lora/templates/module/info_ini.template");
        $compiled = Templator::compile($template, 
        [
            "{Module_name}"=>$uc_name, 
            "{module_name}"=>$module_name,
            "{Version}" => $version,
            "{Category}" => $category,
            "{Description}" => $description,
            "{Icon}" => $icon,
        ]);

        $file = fopen($module_dir."/config/config.ini", "w+");
        fwrite($file, $compiled);
        fclose($file);
    }
}