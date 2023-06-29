<?php
declare(strict_types=1);

namespace App\Core\Application;

use App\Exception\LoraException;

class Policy
{
    public static $auth;
    public static $language;
    public function controllerPolicy()
    {
        return $this;
    }

    public static function checkControllerAccess(array|string $access_role): Bool
    {
        $exlode_access = explode(",", $access_role);
        if(count($exlode_access) == 1)
        {
            if($exlode_access[0] == "any")
            {
                return true;
            }
            elseif($exlode_access[0] == "logged")
            {
                if(self::$auth->isLogged() == true)
                {
                    return true;
                }
                else
                {
                    throw new LoraException(self::$language->lang("err_only_logged"));
                }
            }
            else
            {
                return self::$auth->isAuth($exlode_access);
            }
        }
        else
        {
            return self::$auth->isAuth($exlode_access);
        }
    }
}