<?php
declare(strict_types=1);

namespace App\Core\Application;
use App\Core\Lib\Utils\UrlUtils;
use App\Exception\LoraException;
use App\Middleware\Middleware;
use App\Middleware\Auth;
use App\Core\Application\Route;
use App\Core\Application\Request;
use App\Core\Application\Redirect;
use App\Core\Application\Config;
use App\Core\Lib\Language;
use App\Core\DI\DIContainer;

use App\Core\Model;
use App\Modules\AdminModule\Model\AdminScheduler;

/**
 * Description of Application
 *
 * @author miroka
 */
class Application
{   
    protected $container;
    protected array $url_request;
    protected array $registered_routes;
    protected array $request_data;
    protected Middleware $middleware;
    protected $route;

    protected $url_method_request;
    protected string $register_url_request;
    protected array $register_route;

    protected string $register_access;
    

    public function constructor(DIContainer $container)
    {
        $this->container = $container;
        $this->url_request = UrlUtils::urlParse();
        $this->middleware = new Middleware($this->url_request);
        $this->container->get(DotEnv::class);

        $_SESSION["session_storage_key"] = env("session_store_container",false);

        //If request is empty -> redirect to WEB_HOMEPAGE defined in config/web.ini
        if(empty($this->url_request["controller"]))
        {
            
            $default_redirect = env("web_default_url", false);
            $this->container->get(Redirect::class)->to($default_redirect);
            exit();
        }

        //Get ONE WAY SEC request method and check Middleware, if FALSE -> exit application
        $this->layerOne();

        //Get Registered Routes
        $route = new Route();
        $this->registered_routes = $route->registered_urls;

        //GET VALID registered request DATA
        $this->request_data = $this->getRegisteredRequest($route);
        
        $this->checkIfRequestedExists($this->request_data);

        //Get VALID Route Data registered
        $get_route_data = $route->getRegisteredRequest($this->request_data);
        $this->register_url_request = $get_route_data["request"];
        $this->register_route = $get_route_data["route"];

        if(isset($this->request_data["access"]))
        {
            $this->register_access = $this->request_data["access"];
        }
        else
        {
            $this->register_access = "any";
        }

        $this->container->get(AdminScheduler::class)->backupLogs();

        //Get SECOND SEC WAY MIDDLEWARE Valid request via Middleware Groups
        $this->layerTwo();

        //If Middleware all sets -> execute request
        $this->execute_request();
    }


    /**
     * LayerOne checks URL, connection
     *
     * @return void
     */
    private function layerOne()
    {
        //One WAY Middleware
        if($this->middleware->ResponseOWSec() === false)
        {
            echo "<h1>One Way Secure FAILED!</h1>";
            echo "<h3>Reason: ".$this->middleware->errors."</h3>";
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }

    /**
     * LayerTwo check policies
     *
     * @return void
     */
    private function layerTwo()
    {
        $policy = new Policy();
        $this->checkRequestMiddleware($policy);
    }

    private function checkDefaultMiddleware()
    {
        //One WAY Middleware
        if($this->middleware->ResponseOWSec() === false)
        {
            echo "<h1>One Way Secure FAILED!</h1>";
            echo "<h3>Reason: ".$this->middleware->errors."</h3>";
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }

    private function getRegisteredRequest(Route $route)
    {
        return $route->getValidRouteData($this->url_request);
    }

    private function checkRequestMiddleware(Policy $policy)
    {
        //Check if user valids access request
        $policy->auth = $this->container->get(Auth::class);
        $policy->language = $this->container->get(Language::class);

        try{
            
            if(!$policy->checkControllerAccess($this->register_access))
            {
               $this->container->get(Redirect::class)->to();
               throw new LoraException("Cannot access to this page!");
            }
        }catch(LoraException $ex)
        {
            
            $this->container->get(LoraException::class)->errorMessage($ex->getMessage());
            $this->container->get(Redirect::class)->previous();
            exit();
        }
        

        //Second Way middleware
        if($this->middleware->ResponseSWSec($this->register_url_request) === false)
        {
            echo "<h1>Second Way Secure FAILED!</h1>";
            echo "<h3>Reason: ".$this->middleware->error()."</h3>";
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }

    private function checkIfRequestedExists(array $requested_data)
    {
        if(empty($requested_data))
        {
            //var_dump($requested_data);
            //$redirect->to("error/url-not-registered");
        }
    }

    private function execute_request()
    {
        $request = new Request($this->container);

        $url = $this->request_data["url"];
        $controller_class = $this->request_data["controller"];
        $controller = $this->register_route[0];
        $function = $this->register_route[1]; 
        
        if(!isset($_SESSION["expected_request"]))
        {
            $_SESSION["expected_request"] = strtolower($this->register_url_request);
        }
        
        
        $template = $this->request_data["template"];

        if(isset($this->request_data["module"]))
        {
            $module = $this->request_data["module"];
        }
        else
        {
            $module = true;
        }
              
        //var_dump($this->request_data);
        if(!empty($_POST))
        {
            $to_lower_case = $_POST["method"];


            if($this->register_url_request != $to_lower_case && $this->register_url_request != "mixed")
            {
                $this->container->get(Redirect::class)->to("error/bad-method");
            }
        }

        $classes = [];
        switch($this->register_url_request)
        {
            case "default":
                    $request->request($controller_class, $function, $template, $controller, $classes, $module, []);
                break;

            case "get":
                    $request->get($url, $controller_class, $function, $template, $classes, $module);
                break;

            case "insert":
                $request->request($controller_class, $function, $template, $controller, $classes, $module, []);
                break;

            case "update":
                $request->request($controller_class, $function, $template, $controller, $classes, $module, []);
                break;

            case "delete":
                $request->request($controller_class, $function, $template, $controller, $classes, $module, []);
                break;

            case "mixed":
                if(str_contains( $url, ":"))
                {
                    $request->get($url, $controller_class, $function, $template, $classes, $module);
                }
                else
                {
                    $request->request($controller_class, $function, $template, $controller, $classes, $module, []);
                }
                break;
        }
    }
}
