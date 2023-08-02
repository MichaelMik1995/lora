<?php

namespace App\Controller;

use App\Core\Application\Redirect;
use App\Core\View\Template;
use App\Core\DI\DIContainer;
use App\Exception\LoraException;
use App\Middleware\Auth;
use App\Core\Lib\Utils\ArrayUtils;
use App\Middleware\Session;
use App\Middleware\FormToken;

/**
 * Main Controller
 */
abstract class Controller
{
    protected $data = [];    
    protected $view = "";
    protected $module = "";
    protected string $title = "";
    protected $message = "";
    protected $message_type="";
    protected $container;

    /**
     * Splitter object for templates
     *
     * @var object
     */
    public object $splitter_controll;

    protected $u;
    protected $model;
    
   // protected array $model = [];

    protected $ip; 

    public $_DI;

    /**
     * Base Controller constructor
     *
     * @param DIContainer $container
     * @param array|null $u
     * @param array|null|object|null $model
     */
    public function __construct(DIContainer $container, array $u = null, array|null|object $model=null) 
    {        
        if($u != null)
        {
            $this->u = $u;
        }

        if($model != null)
        {
            $this->model = $model;
        }


        if($container != null)
        {
            $this->container = $container;
        }

        $this->ip = $_SERVER["REMOTE_ADDR"];
    }
    
    public function loadView() 
    { 
        
        if($this->view) 
        {      
            
            if($this->module == "")
            {
                $file_path = "./resources/views/";
            }
            else
            {
                $file_path = "./App/Modules/". @ucfirst($this->module)."Module/resources/views/";
            }
            
            $this->data[] = ["WEB_TITLE"=> $this->title];
            
            $this->container->get(Session::class);
            $this->container->get(FormToken::class);

            extract($this->data, EXTR_SKIP);
            //echo $file_path . $this->view . ".lo.php";
            $template = new Template(
                $this->container->get(Auth::class), 
                $this->container->get(ArrayUtils::class),
            );
            $file = $template->view($file_path . $this->view . ".lo.php", $this->module);       
            
            require_once($file);
            
        }
    }

    /**
     * Reflections controller|splitter models and defines instance
     * @
     * 
     */
    protected function splitter(string $class_name, array $pages_array, string $title="")
    {
        //fdsf
        
        $page = $this->u["page"];

        if(array_key_exists($page, $pages_array))
        {
            $method = $pages_array[$page];
            $this->splitter_controll = new $class_name($this->container, $this->model);
            $this->splitter_controll->u = $this->u;

            
            if(is_array($method) == true)
            {
                $method_call = $method[0];
                $impl = implode(",", $method[1]);
                $this->splitter_controll->$method_call($impl);
                //call_user_func_array(array($this->admin_controll, $method, ));
            }
            else
            {
                if(method_exists($this->splitter_controll, $method))
                {
                    $method_check = new \ReflectionMethod($this->splitter_controll, $method);
                    $parameters = $method_check->getParameters();
                    if(!empty($parameters))
                    {
                        $params = [];
                        foreach($parameters as $parameter)
                        {
                            $parameter_type = $parameter->getType();
                            $params[] = $this->container->get($parameter_type->getName());
                        }
                        call_user_func_array(array($this->splitter_controll, $method), $params);
                    }
                    else
                    {
                        call_user_func(array($this->splitter_controll, $method));
                    }
                }
                else
                {
                    $this->container->get(Redirect::class)->to("error/bad-function");
                    throw new LoraException("Method: $method in class $class_name does not exist!");
                    
                }
            }

            /** Generate Splitter Title */
            if(!$title == "")
            {
                $this->title = $title;
            }
            else
            {
                $this->title = $this->splitter_controll->splitter_title;
            }
            
        }
    }
}
