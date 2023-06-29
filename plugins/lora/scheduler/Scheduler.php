<?php
/*
    Plugin Scheduler generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
declare (strict_types=1);

namespace Lora\Scheduler;

trait Scheduler
{
    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this, $name], $arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return call_user_func_array([static::class, $name], $arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }      
}
