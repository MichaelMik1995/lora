<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;

class DebugUtils
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
    
    public static function generateStringReport(array $report): String
    {
        ob_start();
        return nl2br(var_export($report, true));
    }
}
