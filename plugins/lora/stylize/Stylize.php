<?php
/*
    Plugin Stylize generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
declare (strict_types=1);

namespace Lora\Stylize;

use Lora\Compiler\Compiler;
use Lora\Lora\Core\loranCore;

class Stylize
{
    protected $resource_path = "./src/js/";
    protected $app = "app.js";
    protected $destination_file = "./public/js/lib/autoload/stylize.js";
    
    protected $loran_core;
    protected $compiler;


    public function __construct() 
    {
        
        $this->loran_core = new loranCore();
        $this->compiler = new Compiler();
        
        
    }
    
    public function compileJavascriptFile()
    {
        $compile = $this->compiler->compileJs(__DIR__."/src/js", "stylize.js");
        if($compile)
        {
            $this->loran_core->output("Javascript file stylize.js in ./public/js/lib/autoload compiled successfully!", "success");
        }
        else
        {
             $this->loran_core->output("Javascript file stylize.js is not compiled!", "error");
        }
    }
    
    public function compileCssFile()
    {
        $compile = $this->compiler->compileCss(__DIR__."/src/css", "stylize.css");
        if($compile)
        {
            //$this->loran_core->output("CSS file stylize.css in ./public/css/stylize compiled successfully!", "success");
        }
        else
        {
             //$this->loran_core->output("CSS file stylize.css is not compiled!", "error");
        }
    }
    
    /**
     * Creating css file with parameters (ex.: xsm_div.css)
     * 
     * @param string $name <p>Name of css part (ex.: block, borders, div, font)</p>
     * @param string $responsive_slug
     * 
     * 
     * @return boolean
     */
    public function createCssFile(string $name, string $responsive_slug = "")
    {
        $template = match($responsive_slug)
        {
            "all" => ["all"],
            "xlrg" => ["xlrg", "1920px", "min"],
            "lrg" => ["lrg", "1920px", "max"],
            "md" => ["md", "1366px", "max"],
            "sm" => ["sm", "1024px", "max"],
            "xsm" => ["xsm", "768px", "max"],
            
            default => [],
        };
        
        if(!empty($template))
        {
            if(count($template) != 1)
            {
                $responsive = $template[0];
                $width = $template[1];
                $type = $template[2];
                $template = file_get_contents(__DIR__ . "/templates/responsive_css.template");
                $css_content = $this->compiler->compile($template, [
                    "{type}" => $type,
                    "{width}" => $width,
                ]);

                $file = fopen(__DIR__ . "/src/css/$responsive/$responsive"."_$name.css", "w");
            }
            else
            {
                //all template responsives create
                $this->createCssFile($name, "xsm");
                $this->createCssFile($name, "sm");
                $this->createCssFile($name, "md");
                $this->createCssFile($name, "lrg");
                $this->createCssFile($name, "xlrg");
                $this->createCssFile($name);
            }
            
        }
        else 
        {
            $css_content = file_get_contents(__DIR__ . "/templates/css_template.template");
            $file = fopen(__DIR__ . "/src/css/$name.css", "w");
        }
        
        @fwrite($file, $css_content);
        @fclose($file);
        $this->loran_core->output("CSS File \"$name\" created!", "success");
        
    }
}
