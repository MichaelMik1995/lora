<?php
declare (strict_types = 1);

namespace App\Core\DI;
//using all classes for dependency injection

use App\Core\Interface\InstanceInterface;
use App\Core\Lib\Utils\NumberUtils;


//Vytvořit automatické reflektování a průběžně aktualizovat kontejner

/**
 * Description of DI_Contejner
 *
 * @author michaelmik
 */
class DIContainer implements InstanceInterface
{
    private static $_instance;
    private static int $_instance_id;

    private float $container_size;

    //Object Array variable
    private array $services = [];

    //Mixed values array variables
    private array $data = [];

    private function __construct()
    {
        $this->services = [];
    }

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance_id = rand(000000,999999);
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Returns an instance id
     */
    public function getInstanceId(): Int
    {
        return self::$_instance_id;
    }

    /**
     * Undocumented function
     *
     * @param [type] $class_name
     * @return void|mixed
     */
    public function get(string $class_name)
    {
    
        if (isset($this->services[$class_name])) {
            return $this->services[$class_name]; // Object already in container, get him
        }
    
        // Object is not in container, create new instance
        $object = $this->createObject($class_name);
    
        // Save object to cache
        $this->services[$class_name] = $object;
    
        return $object;
    }

    /**
     * Return if the object exists in the container
     *
     * @param string $class_name
     * @return bool
     */
    public function exists(string $class_name): Bool
    {
        return isset($this->services[$class_name]);
    }


    /**
     * Sets new object to container
     *
     * @param string $class_name    <p>Class name with namespace, if USE if not defined</p>
     * @param array $args           <p>Arguments for constructor</p>
     * @param boolean $override     <p>If true, overrides the existing object with the new one</p>
     * @return object               <p>return instance of object</p>
     */
    public function set(string $class_name, array $args = [], bool $override = false)
    {
        if(isset($this->services[$class_name]))
        {
            if($override == true)
            {
                //Delete old object from container
                unset($this->services[$class_name]);

                //Create new reflection object
                $reflection = new \ReflectionClass($class_name);
                $overrided_object = $reflection->newInstanceArgs($args);
                $this->services[$class_name] = $overrided_object;
                return $overrided_object;
            }
            else
            {
                return $this->services[$class_name];
            }
        }
        else
        {
            //Create new reflection object
            $reflection = new \ReflectionClass($class_name);
            $new_object = $reflection->newInstanceArgs($args);
            $this->services[$class_name] = $new_object;

            return $new_object;
        }
    }


    /**
     * 
     * @param object|string $requested_object
     * @return string|object|null
     */
    public function createObject(object|string|null $requested_object)
    {
        if($requested_object == null || $requested_object == "")
        {
            return null;
        }

        //check if instance,
        if(is_object($requested_object))
        {
            //if is static and has methos instance()
            if(method_exists($requested_object, "instance"))
            {
                return $requested_object::instance();
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
            
            if(method_exists($requested_object, "instance")) //$requested_object = ex.: App\Middleware\Auth
            {
                if(method_exists($requested_object, "__constructor"))
                {
                    $constructor = new \ReflectionMethod($requested_object, "__constructor");
                    $parameters = $constructor->getParameters();

                    $args = [];
                    foreach($parameters as $parameter)
                    {
                        $type = $parameter->getType();
                        $name = $type->getName();

                        $args[] = $this->get($name);
                        
                    }
                    $object = $requested_object::instance();
                    $constructor->invokeArgs($object, $args);

                }

                return $requested_object::instance();
            }
            else
            {
                //create new object
                return $this->reflectionClass($requested_object);

            }          
        }
    }

    /**
     * Returns size of container 
     *
     * @param boolean $in_bytes <p>If is TRUE -> returns size in bytes, if FALSE -> returns count of array</p>
     * @return int|null
     */
    public function getContainerSize(bool $in_bytes = true)
    {
        if($in_bytes == true)
        {
            return $this->get(NumberUtils::class)->real_filesize(memory_get_usage(true));
        }
        else
        {
            return count($this->services);
        }
    }

    public function getClassRegisterData(): Array
    {
        require ("./config/ClassRegister.php");
        foreach($classes as $key => $value)
        {

            $this->services[$key] = $this->createObject($value."\\".$key);
        }
        return $this->services;
    }

    /**
     * Views the container content
     *
     * @return array
     */
    public function viewContainer(): Array
    {
        return $this->services;
    }

    private function reflectionClass(string $class_name)
    {
        $reflection = new \ReflectionClass($class_name);

        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();

        $arguments = [];

        if(!empty($parameters))
        {
            foreach ($parameters as $parameter) 
            {
                if ($parameter->hasType()) 
                {
                    $parameter_type = $parameter->getType();
                    $parameter_name = $parameter_type->getName();
                    $arguments[] = $this->createObject($parameter_name);

                } else 
                {
                    $arguments[] = null;
                }
            }
            return $reflection->newInstanceArgs($arguments);
        }
        else
        {
            return $reflection->newInstance($class_name);
        }
    }

}
