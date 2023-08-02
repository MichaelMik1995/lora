<?php
namespace Lora\Stylize\Bin;

use Lora\Lora\Core\loranCore;
use Lora\Stylize\Stylize;

/**
 * Description of stylize
 * {description}
 *
 * @author michaelmik
 */
class StylizeBin
{
    protected $loran_core;
    protected $_stylize;
    
    public function __construct()
    {
        $this->loran_core = new loranCore();
        $this->_stylize = new Stylize();
    }
    
    public function sendCommand($command, $argument="", $option1="", $option2="")
    {
        if($command != "")
        {
            switch($command)
            {
                case "testplugin":
                    
                    $this->loran_core->output("Plugin: stylize seem installed successfully", "success");
                    break;
                
                case "compile":
                    $this->_stylize->compileJavascriptFile();
                    //$this->_stylize->compileCssFile();
                    break;
                
                case "create:css":
                    
                    if($argument != "")
                    {
                        $this->_stylize->createCssFile($argument, $option1);
                    }
                    else
                    {
                        $this->loran_core->output("Usage: php bin/stylize create:css (css name) [all|xsm|sm|md|lrg|xlrg]", "error");
                    }
                    break;
                
                case "create:js":
                    
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}
