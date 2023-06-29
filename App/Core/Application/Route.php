<?php
declare(strict_types=1);

namespace App\Core\Application;
use Route\DefaultRegister;

class Route
{
    use Redirect;
    use DefaultRegister;

    public array $registered_urls;

    public function __construct()
    {
        $this->registered_urls = $this->getRegistered();    
    }


    public function getRegistered()
    {
        return array_merge($this->getRegisteredDefault(), $this->getRegisteredModules());
    }

    /**
     * Gets Valid request data via URL request
     * 
     * @return array $valid_data
     */
    public function getValidRouteData(array $url_request)
    {
        return $this->searchValidRouteData($url_request);
    }

    public function getRegisteredRequest(array $valid_register): Array
    {
        $route_explode = explode("@", $valid_register["route"]);

        $method = $route_explode[1];
        $route_path = explode(".", $route_explode[0]);

        return [
            "request" => $method,
            "route" => $route_path,
        ];
    }


    private function getRegisteredDefault()
    {
        @$default_registers = DefaultRegister::register();
        return $default_registers;
    }

    private function getRegisteredModules()
    {
        $return_registers = [];
        foreach(glob("App/Modules/*") as $module_path)
        {
            if(is_dir($module_path) && $module_path!="App/Modules/bin")
            {
                $module_name = str_replace(["App/Modules/", "Module"], "", $module_path);
                
                $register_file = "./App/Modules/$module_name"."Module/Register/$module_name"."Register.php";
                
                if(file_exists($register_file))
                {
                    require_once($register_file);
                    $controller = $module_name."Register";
                    $get_register = new $controller();
                    
                    $return_registers = array_merge($return_registers, $get_register->register());
                }
                
            }
        }
        
        return $return_registers;
    }

    private function searchValidRouteData(array $url_request): Array
    {
        //Search first pattern via Controller
        $requested_controller = $url_request["controller"];
        $requested_action = $url_request["action"];

        $controller_valid_registered = [];
        $request_same_as_url = [];


        //Select via Controller
        foreach($this->registered_urls as $registered)
        {
            $explode_registered_url = explode("/", $registered["url"]);

            if("/".$registered["url"] === $_SERVER["REQUEST_URI"])
            {
                $request_same_as_url = $registered;
            }
            else
            {
                if($explode_registered_url[0] == $requested_controller)
                {
                    if(count($explode_registered_url) > 1)
                    {
                        if(($explode_registered_url[0] == $requested_controller) && ($explode_registered_url[1] == $requested_action))
                        {
                            $controller_valid_registered[] = array_merge($registered, ["url_explode" => $explode_registered_url]);
                        }
                    }
                    else
                    {
                        $controller_valid_registered[] = array_merge($registered, ["url_explode" => $explode_registered_url]);
                    }

                    
                }
            }
        }
        
        if(empty($request_same_as_url))
        {
            //Select via COUNT
            $count_valid_registered = [];       

            $filter_null_request = array_filter($url_request);
            $count_url_request = count($filter_null_request);

            foreach($controller_valid_registered as $controller_request)
            {
                $count_registered_url_exploding = count($controller_request["url_explode"]);
                if($count_registered_url_exploding == $count_url_request)
                {
                    $count_valid_registered = $controller_request;
                }
            }

            return $count_valid_registered;
        }
        else
        {
            return $request_same_as_url;
        }
    }
}