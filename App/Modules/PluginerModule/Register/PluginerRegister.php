<?php

use App\Modules\PluginerModule\Controller\PluginerController;
/**
 * Description of PluginerRegister
 *
 * @author miroka
 */
class PluginerRegister 
{
   public function register()
   {
        $class = PluginerController::class;

        return [
            [
                "url" => "pluginer",
                "controller" => $class,
                "template" => "index",
                "route" => "pluginer.index@default",
                "classes" => [],
                "access" => "any"
            ],
            [
                "url" => "pluginer/app/:plugin/:execute",
                "controller" => $class,
                "template" => "index",
                "route" => "pluginer.index@get",
                "classes" => [],
                "access" => "any"
            ],
        ];
   }
}

