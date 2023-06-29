<?php
/*
    Plugin Tester generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
declare (strict_types=1);

namespace Lora\Tester;

class Tester
{
    /**
     * 
     */
    protected $class;

    /**
     * 
     */
    protected $method;

    /**
     * 
     */
    protected $data;


    public function __construct()
    {
        
    }

    public function testObject(string $class_name, array $data): bool
    {
        return true;
    }
    
    public function testData(array $data): bool|null
    {
        
        if(!empty($data))
        {
            $array_result = [];
            
            foreach($data as $type => $value)
            {
                switch($type)
                {
                    case "string":
                        
                        break;
                }
            }
        }
        else {
            return null;
        }
    }
}
