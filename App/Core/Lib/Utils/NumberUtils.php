<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Core\Lib\Utils;

/**
 * Description of NumberUtils
 *
 * @author michaelmik
 */
class NumberUtils 
{
    private static $_instance;
    private static int $_instance_id;

    public function __construct(){}

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = rand(000000,999999);
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Returns an instance id
     */
    public static function getInstanceId(): Int
    {
        return self::$_instance_id;
    }

    public function parseNumber($number)
    {
        return number_format($number, 0, ",", " ");
    }
    
    public function real_filesize($bytes, $decimals = 2) 
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
}
