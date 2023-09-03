<?php
declare(strict_types=1);

namespace Lora\Lora\Core;

use Lora\Compiler\Templator;
use Lora\Lora\Core\LoraOutput;

/**
 * Description of FramUI
 *
 * @author michaelmik
 */

trait LoraUI
{

    protected static $plugin_path = "./plugins/lora/lora/";
    protected static $path_to_templates = "./plugins/lora/lora/templates/";
    
    public static function generateAuthViews()
    {
        self::generateFile("auth", "login");
        self::generateFile("auth", "register");
        self::generateFile("auth", "recovery_password");
    }

    public static function generateUiModuleTemplate(string $module, string $template_name)
    {
        $module = ucfirst($module);
        $module_path = "./App/Modules/" . $module . "Module";
        if(is_dir($module_path))
        {
            $get_template = self::$path_to_templates . "ui/ui_base.template";
            $compiled = Templator::compile(file_get_contents($get_template), [
                "{WEB_NAME}" => "LORA 3.0 Alpha",
                "{name}" => $template_name,
                "{time}" => DATE("d.m.Y"),
            ]);

            if(!file_exists($module_path . "/resources/views/$template_name.lo.php"))
            {
                $file = fopen($module_path . "/resources/views/$template_name.lo.php", "w");
                fwrite($file, $compiled);
                fclose($file);
                LoraOutput::output("Lora template $template_name.lo.php created in $module Module", "success");
            }
            else
            {
                LoraOutput::output("Lora template $template_name.lo.php already exists in $module Module! Skipping ...", "warning");
            }
            

        }
        else
        {
            LoraOutput::output("Module $module not exists!","error");
        }
    }

    public static function generateUiModuleCRUDTemplate(string $module, string $template_name)
    {
        $module = ucfirst($module);
        $module_path = "./App/Modules/" . $module . "Module";
        if(is_dir($module_path))
        {
            $get_template = self::$path_to_templates . "ui/ui_base.template";
            $compiled = Templator::compile(file_get_contents($get_template), [
                "{WEB_NAME}" => "LORA 3.0 Alpha",
                "{name}" => $template_name,
                "{time}" => DATE("d.m.Y"),
            ]);

            if(!file_exists($module_path . "/resources/views/$template_name.lo.php"))
            {
                $file = fopen($module_path . "/resources/views/$template_name.lo.php", "w");
                fwrite($file, $compiled);
                fclose($file);
                LoraOutput::output("Lora template $template_name.lo.php created in $module Module", "success");

            }
            else
            {
                LoraOutput::output("Lora template $template_name.lo.php CRUD already exists in $module Module! Skipping ...", "warning");
            }
            

        }
        else
        {
            LoraOutput::output("Module $module not exists!","error");
        }
    }
    
    /**
     * 
     * @param string $model_name <p>Required model name $model_name</p>
     * @param string $template <p>What template is using in /.Loran/templates/model/$template</p>
     * 
     * @return object <p>Returns generating model file in App/Model/$model_name.php</p>
     */
    public static function generateModel(string $model_name, string $template="basic_model")
    {
        return self::generateModelFile($model_name, $template);
    }
    
    public static function generateController($controller_name, $template = "basic_controller")
    {
        self::generateControllerFile($controller_name, $template);
    }
    
    public static function generateCrudViews(string $model_name)
    {
        if(mkdir("./resources/views/".strtolower($model_name), 0777))
        {
            echo "\e[32m Folder for extended controller ".$model_name."Controller sucessfuly created in ./resources/views/".strtolower($model_name)." \n";
                $file_index = fopen("./resources/views/".strtolower($model_name)."/index.lo.php", "w+");
                $file_show = fopen("./resources/views/".strtolower($model_name)."/show.lo.php", "w+");
                $file_create = fopen("./resources/views/".strtolower($model_name)."/create.lo.php", "w+");
                $file_edit = fopen("./resources/views/".strtolower($model_name)."/edit.lo.php", "w+");

                LoraOutput::output("Views in /resources/views/".strtolower($model_name)."/ sucessfuly created in ./views/".strtolower($model_name), "success");
        }
        else
        {
            LoraOutput::output("Folder for extended controller ".$model_name."Controller is not created in ./resources/views/".strtolower($model_name). "error");
        }
    }
    
    /**
     * @var string $help_page
     * @return void
     */
    public static function generateHelp(string $help_page)
    {
        $load_json = file_get_contents(__DIR__."/../cli-pages/help/$help_page.json");
        $template = file_get_contents(__DIR__."/../templates/help.template");
        
        $json_data = json_decode($load_json, true);
        
        $lines = "";
        
        foreach($json_data["lines"] as $key => $value)
        {
            $lines .= "\n\n-------------------";
            foreach($value as $k => $v)
            {
                
                if($k == "cmd")
                {
                    $lines.="\nCOMMAND: {c:green}".$v."\t{c:none}";
                }
                elseif($k == "example")
                {
                    $lines .= "\nEXAMPLE: ".$v."\t";
                }
                elseif($k == "description")
                {
                    $lines .= "\nDESCRIPTION: {c:blue}".$v."\t{c:none}";
                }
                else
                {
                    $lines .= "\n{c:yellow}".strtoupper($k).": ".$v."{c:none}\t";
                }
                
            }
            
            $lines .= "";
        }
        
        //Lines compile
        
        $compiled_content = Templator::compile($template, [
            "{Page}" => ucfirst($help_page),
            "{title}" => $json_data["title"],
            "{PAGE}" => strtoupper($help_page),
            "{lines}" => $lines,
            "{description}" => $json_data["description"],
            "{usage}" => $json_data["usage"],
            "{c:green}" => "\e[1;32;40m",
            "{c:yellow}" => "\033[33m",
            "{c:blue}" => "\033[34m",
            "{c:none}" => "\e[0m",
        ]);
        
        
        echo $compiled_content;
    }
    
    /**
     * 
     * @param string $template_folder
     * @param string $view
     */
    public static function generateView(string $template_folder, string $view = "")
    {
        self::generateFile($template_folder, $view);
    }
    
    public static function generateOwnView(string $template_folder, string $view_path = "")
    {
        //php lora test/about about
        self::createOwnView($template_folder, $view_path);
    }
    
    
    public static function generateMigrationTable(string $table, string $folder = ""): Void
    {
        $table = str_replace(["-"," ",".",","], "_", $table);
        
        $template_file = self::$path_to_templates."database/create_table_database.template";

        if($folder == "")
        {
            $database_dir = "App/Database/Tables/".ucfirst($table);
            $table_dir = "App/Database/Tables/".ucfirst($table)."/Table";
            $data_dir = "App/Database/Tables/".ucfirst($table)."/Data";
            

            //Create TableName/Table, Data in Migration directory -> if not exists!
            if(!is_dir($database_dir))
            {
                mkdir($database_dir);
                mkdir($table_dir);
                mkdir($data_dir);
            }

            $create_file = "App/Database/Tables/".ucfirst($table)."/Table/CreateTable".ucfirst($table).".php";
        }
        else
        {
            $database_dir = "App/Database/Tables/".ucfirst($folder);
            $table_dir = "App/Database/Tables/".ucfirst($folder)."/Table";
            $data_dir = "App/Database/Tables/".ucfirst($folder)."/Data";

            $create_file = "App/Database/Tables/".ucfirst($folder)."/Table/CreateTable".ucfirst($table).".php";
        }

        
        if(!file_exists($create_file))
        {
            $get_content = file_get_contents($template_file);
            $compile_code = self::compileCode($get_content, $table);
            
            $new_file = fopen($create_file, "w+");
            file_put_contents($create_file, $compile_code, LOCK_EX);
            fclose($new_file);
            
            LoraOutput::output("Migration schema: CreateTable".ucfirst($table)." generated successfully!", "success");
        }
        else
        {
            LoraOutput::output("Migration schema: CreateTable".ucfirst($table)." already exists! Skipping ...", "warning");
        }
        
    }
    
    public static function generateMigrationSeed(string $table, string $folder = "")
    {
        $table = str_replace(["-"," ",".",","], "_", $table);
        
        $template_file = self::$path_to_templates."database/create_table_database_seed.template";

        if($folder == "")
        {
            $create_file = "App/Database/Tables/".ucfirst($table)."/Data/CreateTable".ucfirst($table)."Seed.php";
        }
        else
        {
            $create_file = "App/Database/Tables/".ucfirst($folder)."/Data/CreateTable".ucfirst($table)."Seed.php";
        }
        
        
        if(!file_exists($create_file))
        {
            $get_content = file_get_contents($template_file);
            $compile_code = self::compileCode($get_content, $table);
            
            $new_file = fopen($create_file, "w+");
            file_put_contents($create_file, $compile_code, LOCK_EX);
            fclose($new_file);
        
            LoraOutput::output("Migration seed: CreateTable".ucfirst($table)."Seed generated successfully!", "success");
        }
        else
        {
            LoraOutput::output("Migration seed: CreateTable".ucfirst($table)."Seed already exists! Skipping ...", "warning");
        }
    }
    
    private static function generateFile(string $folder_template, string $file_name)
    {
        $template_path = self::$path_to_templates.$folder_template."/";
        
        $get_content_from_template = file_get_contents($template_path.$folder_template.".template");
        
        $compiled_content = self::compileCode($get_content_from_template, "Test");
        $path = "resources/views/".$folder_template;
        
        if(!is_dir($path))
        {
            mkdir($path);
        }
        
        if(!file_exists($path."/".$file_name.".lo.php"))
        {
            $file = fopen($path."/".$file_name.".lo.php", "w+");
                file_put_contents($path."/".$file_name.".lo.php", $compiled_content, LOCK_EX);
            fclose($file);
        }
    }
    
    
    private static function createOwnView(string $template, string $file_name)
    {
        //php lora auth/login testlogin
        
        $view_explode = explode("/", $file_name); //auth, login
        
        $template_path = self::$path_to_templates.$template.".template"; // ./plugins/lora/lora/templates/auth/login.template
        
        $get_content_from_template = file_get_contents($template_path);
        echo $get_content_from_template;
        
        //$compiled_content = $this->compileCode($get_content_from_template, "Test");
        
        if(count($view_explode) == 2) //testlogin
        {
            $path = "./resources/views/".$view_explode[0];  //  resources/views/t
            
            if(!is_dir($path))
            {
                mkdir($path);
            }
            
            if(!file_exists($path."/".$view_explode[1].".lo.php"))
            {
                $file = fopen($path."/".$view_explode[1].".lo.php", "w+");
                    fwrite($file, $get_content_from_template);
                fclose($file);
            }
        }
        else
        {
            $path = "./resources/views/".$file_name.".lo.php";  //  resources/about.lo.php
            if(!file_exists($path))
            {
                $file = fopen($path, "w+");
                    fwrite($file, $get_content_from_template);
                fclose($file);
            }
            
        }
    }
    
    private static function generateModelFile(string $model_name, string $template)
    {
        $template_path = self::$path_to_templates."model/";
        $get_content = file_get_contents($template_path.$template.".template");
        
        $compile_code = self::compileCode($get_content, $model_name);    
        $model_file= "App/Model/".$model_name.".php";
        
        if(!file_exists($model_file))
        {
            $new_file = fopen($model_file, "w+");
            file_put_contents($model_file, $compile_code, LOCK_EX);
            fclose($new_file);
            LoraOutput::output("Model in '$model_file' created sucessfully!", "success");
        }
        else
        {
            LoraOutput::output("This file '$model_file' already exists!", "warning");
        }
        
    }
    
    private static function generateControllerFile(string $controller_name, string $template)
    {
        $template_path = self::$path_to_templates."controller/";
        $get_content = file_get_contents($template_path.$template.".template");
        
        $compile_code = self::compileCode($get_content, $controller_name);    
        $controller_file= "App/Controller/".$controller_name."Controller.php";
        
        if(!file_exists($controller_file))
        {
            $new_file = fopen($controller_file, "w+");
            file_put_contents($controller_file, $compile_code, LOCK_EX);
            fclose($new_file);
            LoraOutput::output("Controller in '$controller_file' created sucessfully!","success");
        }
        else
        {
            LoraOutput::output("This file '$controller_file' already exists!","warning");
        }
    }
    
    private static function compileCode(string $file_content, string $name): String
    {
        if($name != "")
        {
            $vars = [
                "{controller_name}","{Model_name}","{model_name}",
                "{Name}","{name}"
            ];
            $replace_to = [
                $name."Controller",$name, strtolower($name),
                ucfirst($name),strtolower($name)
            ];
            
            return str_replace($vars, $replace_to, $file_content);
        }

    }
}
