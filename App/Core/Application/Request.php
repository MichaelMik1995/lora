<?php

declare(strict_types=1);

namespace App\Core\Application;

use App\Controller\Controller;

use App\Core\Lib\Utils\UrlUtils;
use App\Core\Lib\Utils\ArrayUtils;
use App\Core\View\Template;
use App\Controller\IndexController;
use App\Core\Lib\Logger;
use App\Exception\LoraException;
use App\Core\DI\DIContainer;


/**
 * Description of App
 *
 * @author miroka
 */
class Request extends Controller
{
    public static $route;
    public static $route_options;
    private $url_utils;
    private $template;
    public $container;
    public $web;
    public $controll;
    public $db;
    
    public function __construct(DIContainer $container) 
    {
        $this->url_utils = UrlUtils::instance();
        //$this->template = new Template();

        $this->container = $container;     
    }
    
    public function request($request_controller, string $request_function="index", string|null $template="", string $module ="", $classes = [], bool $is_module=true, $url_data=[])
    {        
        $this->controll = new $request_controller($this->container);

        if($is_module == true)
        {
            $this->controll->module = $module;
        }
        else
        {
            $this->controll->module = "";
        }
        
        $this->controll->u = $url_data;

        $this->deployIndex($request_controller, $template, $request_function, $url_data, $classes);
        
    }
    
    public function get(string $url_request, $request_controller, string $request_function, string|null $template="", $classes = [], $is_module=1)
    {
        $get_domain = $this->url_utils->urlParse();
        $get_request = $this->url_utils->stringToUrl($url_request);
        
        $filtered_domain = array_filter($get_domain, fn($value) => !is_null($value) && $value !== '');
        
        
        $count_domain = count($filtered_domain);
        $count_request = count($get_request);
        
        if(($count_domain == $count_request && $get_domain["controller"] == $get_request["controller"]) && $get_domain["action"] == $get_request["action"])
        {
            $url_data = [];
            $requests = array_values($get_request);
            $domains = array_values($get_domain);

            for($i = 0; $i < $count_domain; $i++)
            {
                if(str_contains($requests[$i], ":"))
                {
                    $delete = str_replace(":","", $requests[$i]);
                    $url_data[$delete] = $domains[$i];
                }
            }


            $this->controll = new $request_controller($this->container);
            $this->controll->u = $url_data;
            
            
            if($is_module == 1)
            {
                $this->controll->module = $get_domain["controller"];
                $this->controll->template = "./App/Modules/". ucfirst($get_domain["controller"]). "Module/resources/views/$template";
            }
            else
            {
                $this->controll->module = "";
                $this->controll->template = $template;
            }
        
            //$this->controll = new $request_controller($this->container);


            if($is_module == 1)
            {
                $this->controll->module = $get_domain["controller"];
            }
            else
            {
                $this->controll->module = "";
            }

            $this->deployIndex($request_controller, $template, $request_function, $url_data, $classes);
        
        }
    }
    
    public function post(string $url_request, $request_controller, string $request_function, string|null $template="", $classes = [], $is_module=1)
    {       
        return $this->get($url_request, $request_controller, $request_function, $template, $classes, $is_module);
    }
    
    /**
     * 
     * @param string $template
     * @param string $request_function
     */
    private function deployIndex($class_name, $template, $request_function, $url_data, $classes = [])
    {
        //Deploy current controller -> function
        $this->controll->view = $template;
        $this->controll->controll= $this->controll;
        $this->controll->u = $url_data;
        $this->controll->container = $this->container;


        if(method_exists($this->controll, $request_function))
        {
            $method_check = new \ReflectionMethod($this->controll, $request_function);
            $parameters = $method_check->getParameters();


            if(!empty($parameters))
            {
                $params = [];
                foreach($parameters as $parameter)
                {
                    $parameter_type = $parameter->getType();
                    $params[] = $this->container->get($parameter_type->getName());
                }
                
                call_user_func_array(array($this->controll, $request_function), $params);

            }
            else
            {
                call_user_func(array($this->controll, $request_function));
            }

            
            //$this->admin_controll->$method($params);
            
        }
        else
        {
            Redirect::instance()->to("error/bad-function");
            throw new LoraException("Method: $request_function in class $class_name does not exist!");
            
        }

        //Call requested function
        //$this->controll->$request_function($classes);

        //If isset Exception Success -> log
        if(isset($_SESSION['message_true']))
        {
            $this->message = $_SESSION['message_true'][0];
            $this->message_type = "SUCCESS";
        }
        
        //If isset Exception Error -> log
        else if(isset($_SESSION['message']))
        {
            $this->message = $_SESSION['message'][0];
            $this->message_type = "FAILED";
        }
        
        else
        {
            $this->message_type = "DEFAULT";
        }
        
        if($this->message != "")
        {
            Logger::instance()->log("IP: ".$_SERVER['REMOTE_ADDR']." CLASS: $class_name -> METHOD: $request_function(); URL: ".$_SERVER['REQUEST_URI']." => ".$this->message_type." -> MESSAGE: ".$this->message, log_file: "./log/app");
        }
        else
        {
            Logger::instance()->log("IP: ".$_SERVER['REMOTE_ADDR']." CLASS: $class_name -> METHOD: $request_function(); URL: ".$_SERVER['REQUEST_URI']." => ".$this->message_type,  log_file: "./log/app");
        }
        
        //Automatic LOG system
        

        $index_controller = new IndexController($this->container);
        $index_controller->index();

        $index_controller->module="";
        $index_controller->view = "index";

        $index_data =
        [
            "WEB_TITLE" => $this->controll->title,
            "WEB_ADDRESS" => env("base_href", false),
            "WEB_DESCRIPTION" => env("web_description", false),
            "LANGUAGE" => env("language", false),
            "page_title" => env("web_name", false),
            "lora_messages" => $this->container->get(LoraException::class)->returnMessage(),
            "lora_messages_true" => $this->container->get(LoraException::class)->returnMessageTrue(),
            "WEB_STATUS" => env("web_status", false),
            "WEB_VERSION" => env("web_version", false),
        ];

        $index_controller->data = array_merge($index_data, $index_controller->data, ["controll"=> $this->controll]);
        $index_controller->loadView();
    }
}
