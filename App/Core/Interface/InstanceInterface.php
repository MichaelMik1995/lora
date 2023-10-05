<?php
declare(strict_types=1);

namespace App\Core\Interface;

/**
 *
 * @author miroji <miroji@seznam.cz>
 */
interface InstanceInterface 
{
    public static function instance();
    public function getInstanceId();

/*
    private static $_instance;
    private static $_instance_id;

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = uniqid();
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getInstanceId(): String
    {
        return self::$_instance_id;
    }

*/
}
