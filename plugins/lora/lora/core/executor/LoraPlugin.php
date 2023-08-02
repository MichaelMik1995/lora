<?php
declare(strict_types=1);

namespace Lora\Lora\Core\Executor;

use Lora\Compiler\Templator;
use Lora\Lora\Core\LoraOutput;

class LoraPlugin 
{
    use Templator;
    use LoraOutput;

    private static string $company_name ="";
    private static string $plugin_folder ="./plugins/lora/";

    private static string $plugin_name="";

    public static function createPlugin(string $plugin_name, string $company_name = "", string $important = "0", string $description = "A description of plugin")
    {
        if($company_name != "")
        {
            self::$company_name = $company_name;
            self::$plugin_folder = "./plugins/".$company_name."/";
        }
        else
        {
            $company_name = "lora";
        }

        self::$plugin_name = $plugin_name;

        if(!is_dir(self::$plugin_folder))
        {
            mkdir(self::$plugin_folder);
        }

        $pl_folder = self::$plugin_folder.strtolower(self::$plugin_name);

        //generate main folders
        if(!is_dir($pl_folder))
        {
            mkdir($pl_folder, 0777); //create plugin folder
            mkdir($pl_folder."/bin", 0777); //folder for CLI commander
            mkdir($pl_folder."/core", 0777);  
            mkdir($pl_folder."/src", 0777);
            mkdir($pl_folder."/cache", 0777);
            mkdir($pl_folder."/config", 0777);
            mkdir($pl_folder."/html_loader", 0777);
            
            //Create main PHP Class
            //$this->generateTemplate("plugin/new_plugin", $pl_folder."/src/".ucfirst($plugin_name).".php", $plugin_name);
            $template_new_plugin = file_get_contents("./plugins/lora/lora/templates/plugin/new_plugin.template");
            $compiled_new_plugin_template = Templator::compile($template_new_plugin, 
                    [
                        "{Name}" => ucfirst($plugin_name),
                        "{Company}" => ucfirst($company_name),
                    ]
            );          
            $file_new_plugin = fopen($pl_folder."/". ucfirst($plugin_name).".php", "w+");
            fwrite($file_new_plugin, $compiled_new_plugin_template);
            fclose($file_new_plugin);
            
            
            //create Readme.MD
            $file_readme = fopen($pl_folder."/readme.md", "w+");
            fwrite($file_readme, "## Plugin: $plugin_name by @".$company_name."\n## Created at ".DATE("d.m.Y H:i:s"));
            fclose($file_readme);

            //create config file
            $file_config = fopen($pl_folder."/config/plugin.ini", "w+");
            fwrite($file_config, ""
                    . "COMPANY_NAME=".$company_name
                    ."\nPLUGIN_NAME=$plugin_name"
                    . "\nPLUGIN_VERSION=1.0"
                    . "\nACTIVE=1"
                    . "\nIMPORTANT=$important"
                    . "\nDESCRIPTION=\"$description\""
                    );
            fclose($file_config);

            //create index.phtml in html_loader
            $file_index = fopen($pl_folder."/html_loader/index.phtml", "w+");
            fwrite($file_index, "<!-- HTML Loader for plugin '$plugin_name'. Load this page at index.lo.php at ./resources/views using directivy: @pluginhtml $company_name/$plugin_name @ -->");
            fclose($file_index);
            
            $file_cli = fopen($pl_folder."/bin/$plugin_name.php", "w+");
            $template_cli_content = file_get_contents("./plugins/lora/lora/templates/plugin/commander.template");
            $compiled_template = Templator::compile($template_cli_content, 
                    [
                        "{name}" => $plugin_name, 
                        "{Name}" => ucfirst($plugin_name),
                        "{Company}" => ucfirst($company_name),
                    ]
            );
            fwrite($file_cli, $compiled_template);
            fclose($file_cli);
            
            $file_exec = fopen("./bin/$plugin_name", "w+");
            $template__exec_content = file_get_contents("./plugins/lora/lora/templates/plugin/project_bin_loader.template");
            $compiled_exec_template = Templator::compile($template__exec_content, [
                "{name}"=>$plugin_name,
                "{Name}" => ucfirst($plugin_name),
                "{Company}" => ucfirst($company_name),
                    ]);
            fwrite($file_exec, $compiled_exec_template);
            fclose($file_exec);
            
            LoraOutput::output("Plugin $plugin_name in ./plugins/".$company_name."/ was successfully created", "success");
        }
        else
        {
            LoraOutput::output("Plugin $plugin_name seems already installed!","warning");
        }
    }

    public function deletePlugin()
    {

    }

    public function activePlugin()
    {

    }

    public function closePlugin()
    {

    }

}