<?php
declare (strict_types=1);

namespace Lora\Compiler;

use App\Core\Lib\Logger;
use App\Core\Lib\Utils\NumberUtils;
use Lora\Lora\Core\loranCore;

/**
 * @author MiroJi <miroslav.jirgl@seznam.cz>
 */
class Compiler
{
    
    protected $old_file_size;
    protected $new_file_size;
    protected $loran_core;

    public function __construct() {
        $this->loran_core = new loranCore();
    }

    /**
     * 
     * @param string $content
     * @param array $compile_text
     * @return boolean|string
     */
    public function compile(string $content, array $compile_text = []): String
    {
        if(!empty($compile_text))
        {
            $array_code = [];
            $array_vars = [];

            foreach($compile_text as $key => $value)
            {
                $array_code[] = $key;
                $array_vars[] = $value;
            }

            return str_replace($array_code, $array_vars, $content);
        }
        else
        {
            return $content;
        }
    }
    
    
    public function compileJs(string $path, string $destination_file)
    {
        return $this->compileFile($path, "./public/js/lib/autoload/stylize.js", "js");
    }
    
    public function compileCss(string $path, string $destination_file)
    {
        return $this->compileFile($path, "./public/css/stylize.css", "css");
    }
    
    
    /**
     * 
     * @param string $path <p>Path to folder, where JS projects is</p>
     * @param string $destination_file  <p>Destination file, which will created at $destination_file (ex.: ./public/css/stylize.css)</p>
     * @return boolean
     */
    private function compileFile(string $path, string $destination_file, string $file_extension = "js"): Bool
    {
        $file_content = "";
        
        if(is_dir($path))
        {
            foreach(glob($path."/*") as $folder)
            {
                if(is_dir($folder))
                {
                    foreach(glob($folder."/*.".$file_extension) as $subfolder)
                    {
                        $file_content .= file_get_contents($subfolder)."\n";
                    }
                }
            }
            
            foreach(glob($path."/*.".$file_extension) as $main_files)
            {
                if(!is_dir($main_files))
                {
                    $file_content .= file_get_contents($main_files);
                }
            }
            
            if(file_exists($destination_file))
            {
                $content = file_get_contents($destination_file);
                $md5_content = md5($content);
                $md5_this_content = md5($file_content);

                if($md5_content != $md5_this_content)
                {
                    $logger = new Logger();
                    $this->createFile($destination_file, $file_content);
                    $logger->log("Compiler recorded changes in: $destination_file => Compiling ... (".$this->old_file_size." => ".$this->new_file_size.")", "stylize");
                    $this->old_file_size = null;
                    $this->new_file_size = null;
                }
                else
                {
                    $this->loran_core->output("File has no change! Canceling task ..", "warning");
                    return false;
                }
            }
            else
            {
                $this->loran_core->output("File stylize.js not exists, creatin new one ...", "warning");
                $this->createFile($destination_file, $file_content);
            }
            return true;
        }
        else
        {
            $this->loran_core->output("Cannot find required dir!", "error");
            return false;
        }
    }
    
    private function createFile($filename, $content)
    {
        $number_utils = new NumberUtils();
        
        //Get file size
        $get_old_file_size = filesize($filename);
        $old_file_size = $number_utils->real_filesize($get_old_file_size);
        $this->old_file_size = $old_file_size;
        
        $file = fopen("$filename", "w");
        @fwrite($file, $content);
        fclose($file);
        @chmod($filename, 0777);
        
        $get_new_file_size = filesize($filename);
        $new_file_size = $number_utils->real_filesize($get_new_file_size);
        $this->new_file_size = $new_file_size;
    }
    
}

trait Templator
{
    /**
     * 
     * @param string $content
     * @param array $compile_text
     * @return boolean|string
     */
    public static function compile(string $content, array $compile_text = []): String
    {
        if(!empty($compile_text))
        {
            $array_code = [];
            $array_vars = [];

            foreach($compile_text as $key => $value)
            {
                $array_code[] = $key;
                $array_vars[] = $value;
            }

            return str_replace($array_code, $array_vars, $content);
        }
        else
        {
            return $content;
        }
    }
}
