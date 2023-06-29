<?php

use App\Modules\AdminModule\Controller\AdminController;
/**
 * Description of AdminRegister
 *
 * @author miroka
 */
class AdminRegister 
{
   public function register()
   {
        $class = AdminController::class;

        return [
            [
                "url" => "admin",
                "controller" => $class,
                "template" => "index",
                "route" => "admin.initialize@default",
            ],
            [
                "url" => "admin/app/:page",
                "controller" => $class,
                "template" => "index",
                "route" => "admin.initialize@mixed",
            ],
            [
                "url" => "admin/app/:page/:param",
                "controller" => $class,
                "template" => "index",
                "route" => "admin.initialize@mixed",
            ],
            [
                "url" => "admin/insert/:page",
                "controller" => $class,
                "template" => "index",
                "route" => "admin.initialize@insert",
            ],
            [
                "url" => "admin/update/:page/:param",
                "controller" => $class,
                "template" => "index",
                "route" => "admin.index@update",
            ],
            [
                "url" => "admin/delete/:page/:param",
                "controller" => $class,
                "template" => "index",
                "route" => "admin.index@delete",
            ]
        ];
   }
}

