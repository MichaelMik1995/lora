<?php
declare (strict_types=1);

namespace App\Core\Application;

use Lora\Lora\Core\loranCore;
use App\Core\Register\Register;

/**
 * Description of AppCli
 *
 * @author miroka
 */
class AppCli 
{
    protected $loran_core;
    protected $register;
    
    
    public function __construct()
    {
        $this->loran_core = new loranCore();
        $this->register = new Register();
    }
    
    public function sendCommand($command, $argument="", $option1="", $option2="")
    {
        if($command != "")
        {
            switch($command)
            {
                case "register":
                    
                   
                    break;
                
                case "register-list":
                    $get_urls = $this->register->__return();
                    foreach($get_urls as $registered)
                    {
                        if(@$registered["request"] == null)
                        {
                            $registered["request"] = "default";
                        }
                        
                        if(@$registered["module"] == null)
                        {
                            $registered["module"] = "0";
                        }
                        
                        
                        $this->loran_core->output("URL: ". $registered["url"]."\t\t METHOD: ".$registered["request"]."\t IS_MODULE: ".@$registered["module"], "success");
                    }
                    
                    $this->loran_core->output(count($get_urls)." URL addresses registered!");
                    
                    
                    break;
            }
        }
        else
        {
            $this->loran_core->output("Command must be a valid!", "error");
        }
    }
}
