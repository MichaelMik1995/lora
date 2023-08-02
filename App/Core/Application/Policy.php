<?php
declare(strict_types=1);

namespace App\Core\Application;

use App\Exception\LoraException;

class Policy
{
    public $auth;
    public $language;
    
    public function checkControllerAccess(array|string $access_role): Bool
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
                if($this->auth->isLogged() == true)
                {
                    return true;
                }
                else
                {
                    throw new LoraException($this->language->lang("err_only_logged"));
                }
            }
            else
            {
                return $this->auth->isAuth($exlode_access);
            }
        }
        else
        {
            return $this->auth->isAuth($exlode_access);
        }
    }
}