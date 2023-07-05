<?php 
declare(strict_types=1);

namespace App\Core\DI;

class Container 
{
    private static $instance;
    private static $_instance_id;
    private $services = [];

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($name, $callback) {
        $this->services[$name] = $callback;
    }

    public function get($name) {
        if (isset($this->services[$name])) {
            $callback = $this->services[$name];
            return $callback($this);
        }

        return null;
    }
}