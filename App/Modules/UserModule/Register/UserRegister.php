<?php

use App\Modules\UserModule\Controller\UserController;
use App\Modules\UserModule\Controller\Splitter\UserGalleryController;
/**
 * Description of UserRegister
 *
 * @author miroka
 */
class UserRegister 
{
   public function register()
   {
        $class = UserController::class;
        $gallery = UserGalleryController::class;

        return [
            [
                "url" => "user",
                "controller" => $class,
                "template" => "index",
                "route" => "user.index@default",
                "classes" => [],
            ],
            [
                "url" => "user/gallery",
                "controller" => $gallery,
                "template" => "gallery/index",
                "route" => "user.index@default",
                "classes" => [],
            ],


        ];
   }
}

