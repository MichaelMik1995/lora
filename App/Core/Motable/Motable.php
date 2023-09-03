<?php

declare(strict_types = 1);

namespace App\Core\Motable;

use App\Core\Database\Database;

class Motable
{
    private static $_instance = null;
    private static $_instance_id;
    private static Database $database;

    public function __construct(){}

    public static function instance(Database $database)
    {
        self::$database = $database;

        if(self::$_instance == null)
        {
            self::$_instance = new self();
            self::$_instance_id = rand(000000,999999);
        }
        
        return self::$_instance;
        
    }
    private $data = array();

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return null; // nebo můžete vyvolat výjimku, pokud požadovaná vlastnost neexistuje
        }
    }
}