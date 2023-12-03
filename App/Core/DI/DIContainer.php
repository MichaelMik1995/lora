<?php
declare(strict_types=1);

namespace App\Core\DI;

class DIContainer
{
    private static ?self $instance = null;
    private static int $instanceId;
    
    private array $services = [];
    
    public function __construct()
    {
    }
    
    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instanceId = rand(000000, 999999);
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function getInstanceId(): int
    {
        return self::$instanceId;
    }

    public function get(string $class_name)
    {
        if (isset($this->services[$class_name])) {
            return $this->services[$class_name];
        }

        if (class_exists($class_name)) {
            $this->services[$class_name] = $this->createObject($class_name);
            return $this->services[$class_name];
        }

        return null;
    }
    
    public function exists(string $class_name): bool
    {
        return isset($this->services[$class_name]);
    }

    public function set(string $class_name, array $args = [], bool $override = false)
    {
        if ($this->exists($class_name)) {
            if ($override) {
                unset($this->services[$class_name]);
            } else {
                return $this->services[$class_name];
            }
        }
        
        $this->services[$class_name] = $this->createObject($class_name, $args);
        return $this->services[$class_name];
    }

    public function createObject(string $class_name, array $args = [])
    {
        if (class_exists($class_name)) {
            $reflection = new \ReflectionClass($class_name);
            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                return $reflection->newInstance();
            }

            $parameters = $constructor->getParameters();
            $resolvedArgs = [];

            foreach ($parameters as $parameter) {
                $type = $parameter->getType();

                if ($type === null) {
                    $resolvedArgs[] = null;
                } else {
                    $resolvedArgs[] = $this->get($type->getName());
                }
            }

            return $reflection->newInstanceArgs($resolvedArgs);
        }

        return null;
    }

    /**
     * Returns size of container 
     *
     * @param boolean $in_bytes <p>If is TRUE -> returns size in bytes, if FALSE -> returns count of array</p>
     * @return int|null
     */
    public function getContainerSize(bool $in_bytes = true)
    {
        if ($in_bytes) {
            return memory_get_usage(true);
        } else {
            return count($this->services);
        }
    }
}