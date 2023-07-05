<?php
declare (strict_types = 1);

namespace App\Core\DI;
//using all classes for dependency injection

/**
 * Description of DI_Contejner
 *
 * @author michaelmik
 */
class DIContainerBCK 
{
    public $inject = [];
    private $class_array = [];

    private array $services = [];
    
    public function __construct(bool $inject = true) 
    {
        if($inject == true)
        {
            $this->insertToContainer();
            $this->inject();
        }
    }
    
    /**
     * 
     * @param object|string $requested_object
     * @return string|object
     */
    public function returnObject(object|string $requested_object)
    {
        //check if instance,
        if(is_object($requested_object))
        {
            //if is static and has methos instance()
            if(method_exists($requested_object, "instance"))
            {
                
                return "Instance exists";
            }
            else
            {
                
                //create new object

                $new_object = new $requested_object();
                return $new_object;

            }
        }
        else
        {
            //Check if class exists in ClassRegister 

            //$requested_object = ex.: App\Middleware\Auth
            
            if(method_exists($requested_object, "instance"))
            {
                return $requested_object::instance();
            }
            else
            {
                //create new object
                $instance = new $requested_object();
                return $instance;
            }
            //check, if class exists            
        }
    }

    /**
     * 
     */
    private function inject()
    {
        foreach($this->class_array as $key => $value)
        {
            $class = $value.'\\'.$key;
            $load_class = new $class();
            
            $this->inject[$key] = $load_class;
        }
        
        return true;
        
    }
    
    
    /**
     * 
     * @return bool
     */
    public function insertToContainer()
    {
        require ("./config/ClassRegister.php");
        $this->class_array = $classes;
        return true;
    }

    
    
    //put your code here
}
