<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Model;

/**
*   Using main module Model
*/
use App\Modules\AdmindevModule\Model\Admindev;
use App\Exception\LoraException;
use Lora\Compiler\Templator;
use App\Core\DI\DIContainer;

class AdmindevModule extends Admindev
{
    use Templator;
    public array $output = [];

    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }

    /**
     * Summary of getModules
     * @return array
     */
    public function getModules(): Array
    {
        $result = [];

        foreach(glob("./App/Modules/*") as $module_file)
        {
            $full_path = $module_file;
            $remove_path = str_replace("./App/Modules/", "", $module_file);
            $module_name = str_replace("Module", "", $remove_path);
            
            if($module_name != "bin")
            {
                $key = strtolower($module_name);
                $result[$key] = [
                    "path" => $full_path,
                    "name" => $module_name,
                ];
            }
        }

        return $result;
    }

    public function getModuleRoutes()
    {

    }


    public function createModule(string $name)
    {
        //check if module exists
        $module_name = ucfirst($name);
        $module_folder = "./App/Modules/".$module_name."Module";
        if(!is_dir($module_folder))
        {
            return shell_exec("php lora module:create ".$module_name);  //Works
        }
        else
        {
            throw new LoraException("Modul již existuje! Nelze duplikovat");
        }
    }

    public function createSplitters(string $module_name, array|null $splitters = [], string $template_names="")
    {
        if(!empty($splitters))
        {
            foreach($splitters as $splitter)
            {
                $this->createSplitter($module_name, $splitter["name"], intval($splitter["templates"]), $template_names);
            }
        }
        else
        {
            return null;
        }
    }

    public function createModels(string $module_name, array|null $models = [])
    {
        if(!empty($models))
        {
            foreach($models as $model)
            {
                $this->createModel($module_name, $model["name"], $model["database"]);
            }
        }
        else
        {
            return null;
        }
    }

    public function databaseFiles(string $module_name, int $database_table, int $database_data)
    {


        $table = strtolower($module_name);
        if($database_table == 1)
        {
            if($database_data == 1)
            {
                $this->output[] = shell_exec("php lora migrate:create $table --data --caller");
            }
            else
            {
                $this->output[] = shell_exec("php lora migrate:create $table --caller");
            }
            
        }

        

    }

    public function createConfigFile(
        string $module_name, 
        string $version = "3.0.0", 
        string $category = "Module", 
        string $description = "Sample Description", 
        string $icon = "fa fa-box"
    )
    {

        $uc_name = ucfirst($module_name);
        $config_dir = "./App/Modules/" . $uc_name . "Module/config/config.ini";

        if(file_exists($config_dir))
        {
            unlink($config_dir);
        }

        //get ini
        $template = file_get_contents("./plugins/lora/lora/templates/module/info_ini.template");
        $compiled = @Templator::compile($template, 
        [
            "{Module_name}"=>$uc_name, 
            "{module_name}"=>$module_name,
            "{Version}" => $version,
            "{Category}" => $category,
            "{Description}" => $description,
            "{Icon}" => $icon,
        ]);

        $file = fopen($config_dir, "w+");
        fwrite($file, $compiled);
        fclose($file);
    }

    public function createReadmeFile(string $module_name, string $content)
    {
        $uc_name = ucfirst($module_name);
        $config_dir = "./App/Modules/" . $uc_name . "Module/readme.md";

        if(file_exists($config_dir))
        {
            unlink($config_dir);
        }

        $file = fopen($config_dir, "w+");
        fwrite($file, $content);
        fclose($file);
    }

    private function createModel(string $module_name, string $name, $crud = 0)
    {
        $model_name = ucfirst($name);
        $module = ucfirst($module_name);

        if($crud == 1)
        {
            $this->output[] =  shell_exec("php lora module:create $module --model=$model_name --crud");
        }
        else
        {
            $this->output[] =  shell_exec("php lora module:create $module --model=$model_name");
        }
        
    }

    private function createSplitter(string $module, string $splitter, int $crud_templates = 0, string $template_name = "")
    {
        $splitter_name = ucfirst($module) . $splitter;

        if($crud_templates == "0")
        {
            $this->output[] =  shell_exec("php lora splitter:create $splitter_name --module=". ucfirst($module));
        }
        else
        {
            $this->output[] =  shell_exec("php lora splitter:create $splitter_name --module=". ucfirst($module). " --templates=$splitter");
        }
        
    }

    public function deteleModule(string $name)
    {
        $module_name = ucfirst($name);
        $this->output[] =  shell_exec("rm -rf ./App/Modules/".$module_name."Module");
    }

    public function result()
    {
        return $this->output;
    }
} 

