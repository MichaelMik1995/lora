<?php

namespace App\Middleware;
use App\Core\Register\Register;
use App\Modules\HomepageModule\Controller\HomepageController;
use App\Controller\AuthController;
use App\Controller\RedirectController;

/**
 * Description of AdressValidator
 *
 * @author miroka
 */
class AddressValidator 
{
    public $address_method_request = "";
    public $request_data = [];
    public $attributes = [];
    
    protected $url_address;
    protected $register;
    protected $request;
    protected $url_controller = "";
    
    
    private $registered_url = [];
    private $string_utils;


    public function __construct($injector) 
    {
        
        $this->string_utils = $injector["StringUtils"];
        
        $this->url_address = $_SERVER["REQUEST_URI"];
        
        $this->register = new Register();
        $fixed_addresses = $this->fixedAddress();
        
        $this->registered_url = array_merge($this->register->__return(), $fixed_addresses);
        
        $this->trimUrl();
        $this->validAdress();
        
        $this->isRegistered();
        
        
    }
    
    public function __return()
    {
        return [
            "method" => $this->address_method_request,
            "url_controller" => $this->url_controller,
            "requested_data" => $this->request_data,
            "attributes" => $this->attributes,
            "classes" => [],
        ];
    }
    
    private function validAdress()
    {
        if(!preg_match('/^([0-9 a-z\s\-]+)$/', $this->url_address))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    private function trimUrl()
    {
        $this->url_address = ltrim($this->url_address, "/");
    }
    
    private function isRegistered()
    {
       
        //Explode requested URL adress from address bar /homepage /show /test
        $split_url = explode("/",$this->url_address);
        
        $requested_url_domain = $split_url[0];
        $this->url_controller = $requested_url_domain;

        
        if(!empty($split_url[0]))
        {
            if(count($split_url) == 1)
            {
               $this->isRequest($requested_url_domain); 
            }
            else
            {                 
                foreach ($this->registered_url as $registered)
                {
                    $url = $registered["url"];
                    
                    $split_reg_url = explode("/", $url);
                           
                    if($this->url_address == $url)
                    {
                        //if count > 1 && url is same as registered -> homapge/show
                        $this->isRequest($url);
                    }
                    else 
                    {
                        $requested_controller = $split_url[0];
                        $requested_action = $split_url[1];     
                      
                        if(($requested_controller == $split_reg_url[0]) && ($requested_action == @$split_reg_url[1]) && count($split_url) == count($split_reg_url))
                        {
                            $url_data = [];
                            
                            $request = count($split_url);
                            
                            
                            
                            $get_values = array_values($split_reg_url);
                            
                            for($i = 0; $i < $request; $i++)
                            {
                                if(str_contains($get_values[$i], ":"))
                                {
                                    $delete = str_replace(":","", $get_values[$i]);
                                    $url_data[$delete] = $split_url[$i];

                                }
                            }

                            if($registered["request"] == "get")
                            {
                                
                                $this->isGet($registered, $url_data);
                            }
                            elseif($registered["request"] == "post")
                            {
                                $this->isPost($registered, $url_data);
                            }
                        }
                      
                    }
                }
            }
            
        }
        else
        {
           $this->isEmpty();
        }
    }
    
    private function isRequest($controller)
    {
        foreach($this->registered_url as $registered)
        {
            if($registered["url"] == $controller)
            {
                if(@$registered["request"] == "default" || empty($registered["request"]))
                {
                    $this->address_method_request = "default";
                    $this->request_data = $registered;
                    
                    $split_url = explode("/", $controller);
                    $this->url_controller = $split_url[0];
                }
            }
        }
        
    }
    
    private function isGet($registered, $url_data)
    {
        $this->address_method_request = "get";
        $this->request_data = $registered;
        $this->attributes = $url_data;
    }
    
    private function isPost($registered, $url_data)
    {
        $this->address_method_request = "get";
        $this->request_data = $registered;
        $this->attributes = $url_data;
    }
    
    private function isEmpty()
    {
        $this->address_method_request = "empty";
    }
    
    private function fixedAddress()
    {
        return [
            ["url" => "error", "controller" => \App\Controller\ErrorController::class, "method" => "index", "module" => false, "template" => "error/error"],   
            ["url" => "error/middleware", "controller" => \App\Controller\ErrorController::class, "method" => "middleware", "module" => false, "template" => "error/middleware"],   
            ["url"=>"auth/login", "controller"=> AuthController::class, "method"=>"login", "module"=>false, "template"=>"auth/login"],
            ["url"=>"auth/logout", "controller"=> AuthController::class, "method"=>"logout", "module"=>false],
            ["url"=>"auth/register", "controller"=> AuthController::class, "method"=>"register", "module"=>false, "template"=>"auth/register"],
            ["url"=>"auth/register/rules", "controller"=> AuthController::class, "method"=>"registerRules", "module"=>false, "template"=>"auth/rules"],
            ["url"=>"auth/do-login", "controller"=> AuthController::class, "method"=>"doLogin", "request"=>"default", "module"=>false],
            ["url"=>"auth/do-register", "controller"=> AuthController::class, "method"=>"doRegister", "request"=>"default", "module"=>false],
            ["url" => "homepage", "controller" => HomepageController::class, "method" => "index", "request" => "default", "module" => true, "template" => "index",],
            ["url" => "about", "controller" => \App\Controller\AboutController::class, "method" => "index", "module" => false, "template" => "about"],   
            ["url" => "redirect/load/:page/:request", "controller" => RedirectController::class, "method" => "index", "request"=>"get", "module" => false, "template" => ""],   
        ];
    }
}
