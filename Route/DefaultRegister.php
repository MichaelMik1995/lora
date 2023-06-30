<?php
declare(strict_types = 1);

namespace Route;

use App\Modules\HomepageModule\Controller\HomepageController;
use App\Controller\AuthController;
use App\Controller\ErrorController;
use App\Controller\AboutController;
use App\Modules\DocumentationModule\Controller\DocumentationController;
use App\Controller\RouteController;

/**
 * Description of DefaultRegister
 *
 * @author miroka
 */
trait DefaultRegister 
{
   public static function register(): Array
   {
       return [
            [
                "url" => "homepage",
                "controller" => HomepageController::class,
                "template" => "index",
                "module" => true,
                "route" => "homepage.index@default",
            ],
            [
                "url" => "homepage/:param",
                "controller" => HomepageController::class,
                "template" => "index",
                "module" => true,
                "route" => "homepage.show@get",
            ],
            ["url" => "error", "controller" => ErrorController::class, "method" => "index", "module" => false, "template" => "error/error", "route" => "error.index@default"],   
            ["url" => "error/bad-method", "controller" => ErrorController::class, "module" => false, "template" => "error/badmethod", "route" => "error.badMethod@default"], 
            ["url" => "error/bad-function", "controller" => ErrorController::class, "module" => false, "template" => "error/badfunction", "route" => "error.badFunction@default"],   
            ["url" => "error/url-not-registered", "controller" => ErrorController::class, "module" => false, "template" => "error/urlnotregistered", "route" => "error.urlNotRegistered@default"],   

            ["url"=>"auth/login", "controller"=> AuthController::class, "module"=>false, "template"=>"auth/login", "route" => "auth.login@default"],
            ["url"=>"auth/logout", "controller"=> AuthController::class, "method"=>"logout", "module"=>false, "route" => "auth.logout@default"],
            ["url"=>"auth/register", "controller"=> AuthController::class, "method"=>"register", "module"=>false, "template"=>"auth/register", "route" => "auth.register@default"],
            ["url"=>"auth/register-success", "controller"=> AuthController::class, "module"=>false, "template"=>"auth/register_success", "route" => "auth.registerSuccess@default"],
            ["url"=>"auth/verify/:code/:name", "controller"=> AuthController::class, "module"=>false, "template"=>"", "route" => "auth.verifyUser@get"],
            ["url"=>"auth/verify-success", "controller"=> AuthController::class, "module"=>false, "template"=>"auth/verify_success", "route" => "auth.verifySuccess@default"],
            ["url"=>"auth/verify-error", "controller"=> AuthController::class, "module"=>false, "template"=>"auth/verify_dead", "route" => "auth.verifyError@default"],
            ["url"=>"auth/register-rules", "controller"=> AuthController::class, "module"=>false, "template"=>"auth/rules", "route" => "auth.rules@default"],
            ["url"=>"auth/do-login", "controller"=> AuthController::class, "method"=>"doLogin", "request"=>"default", "template"=>"", "module"=>false, "route" => "auth.doLogin@update"],
            ["url"=>"auth/do-register", "controller"=> AuthController::class, "template" => null, "module"=>false, "route" => "auth.doRegister@default"],
            ["url" => "route/:route/:data", "controller"=>RouteController::class, "module"=>false, "template"=>"", "route"=>"route.getRoute@get"],
            ["url" => "homepage", "controller" => HomepageController::class, "method" => "index", "request" => "default", "module" => true, "template" => "index", "route" => "homepage.index@default"],
            ["url" => "about", "controller" => AboutController::class, "method" => "index", "module" => false, "template" => "about", "route" => "about.index@default"],   
            [
                "url" => "documentation",
                "controller" => DocumentationController::class,
                "route" => "documentation.index@default",
                "template" => "index",
            ],
            [
                "url" => "documentation/create",
                "controller" => DocumentationController::class,
                "route" => "documentation.create@default",
                "template" => "create",
            ],
            [
                "url" => "documentation/show/:param",
                "controller" => DocumentationController::class,
                "route" => "documentation.show@get",
                "template" => "show",
            ],

            [
                "url" => "documentation/edit/:param",
                "controller" => DocumentationController::class,
                "route" => "documentation.edit@get",
                "template" => "edit",
            ],

            [
                "url" => "documentation/update/:param",
                "controller" => DocumentationController::class,
                "route" => "documentation.update@get",
                "template" => "",
            ],
        ];
   }
}

