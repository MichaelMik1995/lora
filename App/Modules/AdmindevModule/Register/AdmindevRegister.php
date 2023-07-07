<?php

use App\Modules\AdmindevModule\Controller\AdmindevController;

/**
 * Description of AdmindevRegister
 *
 * @author miroka
 */
class AdmindevRegister 
{
   public function register()
   {
        $class = AdmindevController::class;

        return [
            [
                "url" => "admindev",
                "controller" => $class,
                "template" => "index",
                "route" => "admindev.initialize@default",
                "classes" => [],
            ],
            [
                "url" => "admindev/app/:page",
                "controller" => $class,
                "template" => "index",
                "route" => "admindev.initialize@mixed",
                "classes" => [],
            ],
            [
                "url" => "admindev/app/:page/:param",
                "controller" => $class,
                "template" => "index",
                "route" => "admindev.initialize@mixed",
                "classes" => [],
            ],
        ];
   }
}

