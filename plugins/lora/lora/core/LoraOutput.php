<?php
declare(strict_types=1);

namespace Lora\Lora\Core;

trait LoraOutput
{
    /**
     * @param string $message       <p>Message to be displayed</p>
     * @param string $type          <p>Type of message [info|success|warning|error]</p>
     * @return void                 <p>Print output message to CLI</p>
     */
    public static function output(string $message, string $type = "basic"): Void
    {
        switch($type)
        {
            default:
                $color_code = "39";
                break;
            case "info":
                $color_code = "34";
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
        
        print("\033[".$color_code."m ".$message." \033[39m \n");
    }
}