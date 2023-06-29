<?php
declare(strict_types=1);

namespace Lora\Lora\Core;

trait LoraCore 
{

    public static array $options;

    public function __construct()
    {
        
    }

    public static function option($option, $callback)
    {
        if(in_array($option, self::$options))
        {
            return $callback();
        }
        else
        {
            return false;
        }
    }

}