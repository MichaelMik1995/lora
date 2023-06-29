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
                "route" => "admindev.index@default",
                "classes" => [],
            ],
            [
                "url" => "admindev/app/:page",
                "controller" => $class,
                "template" => "index",
                "route" => "admindev.index@mixed",
                "classes" => [],
            ],
            [
                "url" => "admindev/app/:page/:param",
                "controller" => $class,
                "template" => "index",
                "route" => "admindev.index@mixed",
                "classes" => [],
            ],
        ];
   }
}

