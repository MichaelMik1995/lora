<?php
declare(strict_types=1);

namespace App\Core\Application;
use App\Core\Lib\Utils\UrlUtils;
use App\Exception\LoraException;
use App\Middleware\Middleware;
use App\Core\Application\Route;
use App\Core\Application\Request;

/**
 * Description of Application
 *
 * @author miroka
 */
class Application
{   
    use Redirect;

    protected $injector;
    protected array $url_request;
    protected array $registered_routes;
    protected array $request_data;
    protected $middleware;
    protected $route;

    protected $url_method_request;
    protected string $register_url_request;
    protected array $register_route;

    protected string $register_access;
    

    public function constructor($injector)
    {
        $this->injector = $injector;
        $this->url_request = UrlUtils::urlParse();
        $this->middleware = new Middleware($this->url_request);

        /*$compressed   = gzcompress($this->injector, 9);
        $uncompressed = gzuncompress($compressed);
        echo $uncompressed;*/

        //$string = $this->injector;

       // $encoded = strtr(base64_encode(addslashes(gzcompress(serialize($string),9))), '+/=', '-_,');

        //$string= unserialize(gzuncompress(stripslashes(base64_decode(strtr($encoded, '-_,', '+/=')))));

        //echo $string;

        //If request is empty -> redirect to WEB_HOMEPAGE defined in config/web.ini
        if(empty($this->url_request["controller"]))
        {
            @Redirect::redirect($this->injector["Config"]->var("WEB_HOMEPAGE"));
            exit();
        }

        //Get ONE WAY SEC request method and check Middleware, if FALSE -> exit application
        $this->checkDefaultMiddleware();

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

        //Get SECOND SEC WAY MIDDLEWARE Valid request via Middleware Groups
        $this->checkRequestMiddleware();

        //Create Variable Container
        //$container = new Variable();

        //If Middleware all sets -> execute request
        $this->execute_request();
    }


    private function checkDefaultMiddleware()
    {
        //One WAY Middleware
        if($this->middleware->ResponseOWSec() === false)
        {
            echo "<h1>One Way Secure FAILED!</h1>";
            echo "<h3>Reason: ".$this->middleware->error()."</h3>";
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }

    private function getRegisteredRequest(Route $route)
    {
        return $route->getValidRouteData($this->url_request);
    }

    private function checkRequestMiddleware()
    {
        //Check if user valids access request
        Policy::$auth = $this->injector["Auth"];
        Policy::$language = $this->injector["Language"];

        try{
            
            if(!Policy::checkControllerAccess($this->register_access))
            {
               @redirect::redirect("");
               throw new LoraException("Cannot access to this page!");
            }
        }catch(LoraException $ex)
        {
            
            $this->injector["LoraException"]->errorMessage($ex->getMessage());
            Redirect::previous();
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
            //@Redirect::redirect("error/url-not-registered");
        }
    }

    private function execute_request()
    {
        

        $request = new Request($this->injector);

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

        if(isset($this->request_data["classes"]))
        {
            $classes = array_merge($this->injector, $this->request_data["classes"]);
        }
        else{
            $classes = [$this->injector];
        }
              
        //var_dump($this->request_data);
        if(!empty($_POST))
        {
            $to_lower_case = $_POST["method"];


            if($this->register_url_request != $to_lower_case && $this->register_url_request != "mixed")
            {
                @Redirect::redirect("error/bad-method");
            }
        }

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
