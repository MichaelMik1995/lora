<?php

use App\Modules\PhpinfoModule\Controller\PhpinfoController;
/**
 * Description of PhpinfoRegister
 *
 * @author miroka
 */
class PhpinfoRegister 
{
   public function register()
   {
       return [
            [
                "url" => "phpinfo",
                "controller" => PhpinfoController::class,
                "route" => "phpinfo.index@default",
                "template" => "index",
                "request" => "default",
                "access" => "admin,editor,developer"
            ]
       ];
   }
}

