<?php
namespace Lora\Lora\Core;
/**
 * Description of FramFunctions
 *
 * @author michaelmik
 */
class loranCore
{
    public function output(string $message, string $type = "basic")
    {
        switch($type)
        {
            default:
                $color_code = "39";
                break;
            case "basic":
                $color_code = "39";
                break;
            
            case "success":
                $color_code = "32";
                break;
            
            case "warning":
                $color_code = "33";
                break;
            
            case "error":
                $color_code = "91";
                break;
        }
        
        echo ("\033[".$color_code."m ".$message." \033[39m \n");
    }
    
    public function generateTemplate(string $template_file, string $target_file, string $name = "")
    {
        //Get content from template
        $template = "./plugins/lora/lora/templates/$template_file.template";
        $content = file_get_contents($template);
        
        //create file in SRC
        if(!file_exists($target_file))
        {
            if($name != "")
            {
                $content = $this->compileCode($content, $name); 
            }
            
            $file = fopen($target_file, "w+");
            fwrite($file, $content);
            fclose($file);
        }
        else
        {
            $this->output("Targeted file $target_file already exists!","warning");
        }
        
    }
    
    protected function compileCode(string $file_content, string $name): String
    {
        if($name != "")
        {
            $vars = [
                "{controller_name}",
                "{Model_name}",
                "{model_name}",
                "{Name}",
                "{name}"
            ];
            $replace_to = [
                $name."Controller",
                $name, 
                strtolower($name),
                ucfirst($name),
                strtolower($name)
            ];
            
            return str_replace($vars, $replace_to, $file_content);
        }

    }
}
