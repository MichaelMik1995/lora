<?php

declare (strict_types=1);

namespace App\Core\Lib\Utils;

class ArrayUtils
{
    private static $_instance;
    private static int $_instance_id;

    public function __construct(){}

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
    public static function getInstanceId(): Int
    {
        return self::$_instance_id;
    }

    public function setLowerCaseVars(&$global_var) 
    {
        foreach ($global_var as $key => &$value) 
        {
            if (!isset($global_var[strtolower($key)])) 
            {
                $global_var[strtolower($key)] = $value;
            }
        }
        return $global_var;
    }
    

    /**
     * Summary of inArrayMultiple
     * @param array $needles
     * @param array $haystack
     * @return bool
     */
    public static function inArrayMultiple(array $needles, array $haystack) 
    {
        return empty(array_diff($needles, $haystack));
    }


    /**
     * Find a substring in single array (Ex.: needle = "--code=", array["--user", "--code=test"] => return string "--code=test", if multiple results -> returns array)
     * 
     * @param string $needle
     * @param array $array
     * @return string|array|null
     */
    public static function substringInArray(string $needle, array $array, $count_results = 1): String|Array|Null
    {
        $result = [];


        if(!empty($array) && $needle != "")
        {

            //unzip array and find item, which cotains $needle -> result zip to array $result
            foreach($array as $item)
            {
                if(str_contains($item, $needle))
                {
                    $result[] = $item;
                }
                
            }

            //If array $result contains only one item -> return string, else return whole array
            if(empty($result))
            {
                return "";
            }
            else if(count($result) == 1 || $count_results == 1)
            {
                return $result[0];
            }
            else
            {
                return array_slice($result, 0, $count_results);
            }
            
        }else
        {
            return [];
        }
    }

    /**
     * Find a substring in array (Ex.: needle = "--code=", array["--user", "--code=test"] => return string "--code=test", if multiple results -> returns array)
     * 
     * @param string $needle
     * @param array $array
     * @return string|array
     */
    public static function substringInArrayAssoc(string $needle, array $array): String|Array
    {
        if(!empty($array) && $needle != "")
        {
            foreach($array as $item)
            {
                
            }
            return [];
        }else
        {
            return [];
        }
    }

    /**
     * Summary of charStringToArray
     * @param string $string
     * @param string $character
     * @return array
     */
    public static function charStringToArray(string $string, string $character = ",", bool $debug = false)
    {
        if($string != "")
        {
            $returnArray = [];

            $explode_string = explode($character, $string);
            if($debug == true)
            {
                $returnArray = [
                    "count" => count($explode_string),
                    "length" => mb_strlen($string),
                    "separator" => $character,
                    "array" => $explode_string,
                ];
            }
            else
            {
                $returnArray = $explode_string;
            }

            return $returnArray;
        }
        else
        {
            return [];
        }
    }
}
