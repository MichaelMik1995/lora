<?php
declare(strict_types=1);

namespace App\Middleware;

use Route\Middleware\MiddlewareGroup;

/**
 * Description of Middleware
 *
 * @author MiroJi @2022
 */
class Middleware 
{
    //Must same as in App/Core/Constants.php
    const 
        DEFAULT = 0,
        GET = 1,
        INSERT = 2,
        UPDATE = 3,
        DELETE = 4;

    protected $url_request;
    /**
     * Middlewares groups to call stored in 
     */
    protected $middleware_request;
    protected bool $middleware_request_response;

    public string $errors = "";

    public function __construct(array $url_request)
    {
        $this->url_request = $url_request;
        
    }


    /**
     * Response One Way SECure -> Check URL input
     * First Middleware check, returns boolean value (TRUE: one way sec responses without errors)
     * 
     * @return bool
     */
    public function ResponseOWSec(): Bool
    {
        return $this->getResponseMiddlewareGroups("default");
    }

    /**
     * Response Second Way Secure -> check HEADERS
     * Second Middleware check, returns boolean value (TRUE: one way sec responses without errors)
     * 
     * @return bool
     */
    public function ResponseSWSec(string $register_request): Bool
    {
        return $this->checkRequest($register_request);
    }

    //Middleware Requests
    private function checkRequest(string $register_request)
    {    
        //URL Request
        if(!empty($_POST))
        {
            //POST, UPDATE, DELETE
            //If method is defined
            return $this->getResponseMiddlewareGroups($_POST["method"]);

        }
        else
        {
            //REQUEST, GET

            $value = preg_grep('/^:/', $this->url_request);
            if(count($value) > 0)
            {
                //GET
                return $this->getResponseMiddlewareGroups("get");
            }
            else
            {
                //DEFAULT
                return $this->getResponseMiddlewareGroups("default");
            }
        }
    }

    private function getResponseMiddlewareGroups(string $url_request): Bool
    {
        @$get_groups = MiddlewareGroup::return();

        $response = [];
        $errors = [];

        foreach($get_groups as $key => $value)
        {
            if($key == $url_request)
            foreach($value as $middleware_class)
            {
                $middleware = str_replace("Route\Middleware", "", $middleware_class);
                $middleware_instance = new $middleware();
                $response[] = $middleware_instance->return(); 
                $errors = $middleware_instance->error();
            }
        }

        if(in_array(false, $response))
        {
            if(!empty($errors))
            {
                $error_message = "";
                foreach ($errors as $error)
                {
                    $error_message .= $error."<br>";
                }

                $this->errors = $error_message;
            }
            
            return false;
        }
        else
        {
            return true;
        }
    }
    
}
