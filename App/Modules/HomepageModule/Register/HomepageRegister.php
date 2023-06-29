<?php

use App\Modules\HomepageModule\Controller\HomepageController;
/**
 * Description of HomepageRegister
 *
 * @author miroka
 */
class HomepageRegister 
{
   public function register()
   {
        $class = HomepageController::class;

        return [
            [
                "url" => "homepage",
                "controller" => $class,
                "template" => "index",
                "route" => "homepage.index@default",
            ]
        ];
   }
}

