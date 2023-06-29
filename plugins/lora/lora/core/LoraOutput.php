<?php
declare(strict_types=1);

namespace Lora\Lora\Core;

trait LoraOutput
{
    public static function output(string $message, string $type = "basic")
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