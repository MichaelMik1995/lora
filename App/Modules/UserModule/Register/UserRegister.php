<?php

use App\Modules\UserModule\Controller\UserController;
/**
 * Description of UserRegister
 * Route (with url filter) convention:   
 *      <b>user</b> = original route name
 *      <b>.</b> = end of URL name, 
 *      <b>show</b> = calling method in controller
 *      <b>@</b> = end of defining path to calling method
 *      <b>get</b> = own HTTP method for identific operation
 * @author miroka
 */
class UserRegister 
{
   public function register()
   {
       
        /**
         * Controller class to call with defined method
         * @var App\Modules\UserModule\Controller\UserController $class
         */
        $class = UserController::class;
        
        /**
         * Specific route name for identify controller
         * @var string $route_name
         */
        $route_name = "user";
        
        /**
         * Original URL name
         * @var string $url_name
         */
        $url_name = "user";

        return [
            [
                "url" => $url_name,
                "controller" => $class,
                "template" => "index",
                "route" => $route_name.".initialize@default",
                "access" => "any"
            ],
            [
                "url" => $url_name."/show/:url",
                "controller" => $class,
                "template" => "show",
                "route" => $route_name.".show@get",
                "classes" => [],
                "access" => "any"
            ],
            [
                "url" => $url_name."./create",
                "controller" => $class,
                "template" => "create",
                "route" => $route_name.".create@default",
                "classes" => [],
                "access" => "admin,editor"
            ],
            [
                "url" => $url_name."/insert",
                "controller" => $class,
                "template" => "",
                "route" => $route_name.".insert@insert",
                "classes" => [],
                "access" => "admin,editor"
            ],
            [
                "url" => $url_name."/edit/:url",
                "controller" => $class,
                "template" => "edit",
                "route" => $route_name.".edit@get",
                "classes" => [],
                "access" => "admin,editor"
            ],
            [
                "url" => $url_name."/update",
                "controller" => $class,
                "template" => "",
                "route" => $route_name.".update@update",
                "classes" => [],
                "access" => "admin,editor"
            ],
            [
                "url" => $url_name."/delete/:url",
                "controller" => $class,
                "template" => "",
                "route" => $route_name.".delete@delete",
                "classes" => [],
                "access" => "admin,editor"
            ],

            //Splitter Settings
            [
                "url" => $url_name."/app/:page",
                "controller" => $class,
                "template" => "index",
                "route" => $route_name.".initialize@mixed",     //Mixed request
                "access" => "any"   //in every method use App\Middleware\Auth->access(array $roles)
            ],
            [
                "url" => $url_name."/app/:page/:param",
                "controller" => $class,
                "template" => "index",
                "route" => $route_name.".initialize@mixed",     //Mixed request
                "access" => "any"   //in every method use App\Middleware\Auth->access(array $roles)
            ],
        ];
   }
}

