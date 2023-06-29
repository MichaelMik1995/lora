<?php

declare(strict_types=1);

namespace App\Core\Register;

use App\Modules\HomepageModule\Controller\HomepageController;
use App\Modules\DocumentationModule\Controller\DocumentationController;

/**
 * Description of Register
 *
 * @author miroka
 */
class Register 
{
    public $registered_url;
    
    public function __construct() 
    {
        $modules = $this->getRegisterModules();
        $this->registered_url = array_merge($modules, $this->register());
    }
    
    public function __return() 
    {
        return $this->registered_url;
    }
    
    private function register()
    {
        
        return [
            [
              "url" => "homepage/show",
              "controller" => HomepageController::class,          //Controller class -> must be in USE above
              "method" => "show",                                //Calling controller method for this URL
              "request" => "default",                         //default|get|post
              "module" => true,                               //is controller in module? true|false
              "template" => "index",
              "route" => "homepage.show",
            ],
            
            //Documentation
            [
                "url" => "documentation",
                "controller" => DocumentationController::class,
                "method" => "index",
                "request" => "default",
                "module" => true,
                "template" => "index",
            ],
            ["url"=>"documentation/create", "controller"=> DocumentationController::class, "method"=>"create", "module"=>true, "template"=>"create"],
            ["url"=>"documentation/insert", "controller"=> DocumentationController::class, "method"=>"insert", "module"=>true, "template"=>""],
            ["url"=>"documentation/edit/:url", "controller"=> DocumentationController::class, "method"=>"edit", "module"=>true, "template"=>"edit", "request"=>"get"],
            ["url"=>"documentation/delete/:url", "controller"=> DocumentationController::class, "method"=>"delete", "module"=>true, "template"=>"", "request"=>"post"],
            ["url" => "documentation/show/:url","controller" => DocumentationController::class,"method" => "show","request" => "get","template" => "show"], 
            ["url" => "documentation/update/:url","controller" => DocumentationController::class,"method" => "update","request" => "post","module" => true,"template" => ""],
            
        ];
    }
    
    private function getRegisterModules()
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
}
