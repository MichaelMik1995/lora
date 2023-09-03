<?php
declare(strict_types=1);
namespace App\Core\Lib\Utils;

/**
 * Generated date: 16.08.2023 07:52:41
 * Utility CryptorUtils generated only for framework Lora, copyright by company: MiroKa
 * Description: 
 * @author MiroJi <miroslav.jirgl@seznam.cz>
 */
class CryptorUtils
{
    private static $_instance;
    private static int $_instance_id;
    private array $util_data;

    /**
     * Do not change the __construct method - Keep blank from ARGS!
     */
    public function __construct(){}

    /**
     * Defined arguments will be inserted via DI - Dependency injection is active
     */
    public function __constructor()
    {

    }

    /**
     * Do not change the instance method
     */
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
     * Returns an instance id - do not change getInstanceId() method
     */
    public static function getInstanceId(): Int
    {
        return self::$_instance_id;
    }

    /** UTILITY METHODS **/

    //Place your utility methods


    /** MAGICAL METHODS **/
    public function __set($name, $value) {
        $this->util_data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->util_data[$name])) {
            return $this->util_data[$name];
        }
        return null;
    }
}
