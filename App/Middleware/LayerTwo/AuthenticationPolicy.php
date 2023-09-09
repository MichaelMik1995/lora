<?php
declare(strict_types=1);

namespace App\Middleware\LayerTwo;

use App\Core\Interface\InstanceInterface;

class AuthenticationPolicy implements InstanceInterface
{
    private static $_instance = null;
    private static $_instance_id;

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new self();
            self::$_instance_id = uniqid();
        }
        
        return self::$_instance;
    }

    public function getInstanceId()
    {
        return self::$_instance_id;
    }

    public function initializeHostPolicy()
    {
        //Get host data
        $host_address = $_SERVER["REMOTE_ADDR"];
        $host_port = $_SERVER["REMOTE_PORT"];
        
    }
}