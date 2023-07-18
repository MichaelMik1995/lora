<?php
namespace App\Core;

use App\Core\DI\DIContainer;
use App\Core\Database\Database;
use App\Middleware\Auth;
use App\Core\Lib\Utils\StringUtils;
use App\Core\Lib\Utils\NumberUtils;
use App\Exception\LoraException;
use App\Core\Application\Config;
use App\Core\Lib\Language;
use App\Core\Lib\Uploader;
use Lora\Easytext\Easytext;

/**
 * Description of Model
 *
 * @author michaelmik
 */
abstract class Model 
{    

    protected $container, $database, $auth, $easy_text, $string_utils, $number_utils, $exception, $config, $lang, $uploader;
    
    private function __construct(){}

    public function init(DIContainer $container)
    {
        $this->container = $container;
        
        $this->auth = $container->get(Auth::class);
        $this->easy_text = $container->get(Easytext::class);
        $this->string_utils = $container->get(StringUtils::class);
        $this->exception = $container->get(LoraException::class);
        $this->number_utils = $container->get(NumberUtils::class);
        $this->config = $container->get(Config::class);
        $this->lang = $container->get(Language::class);
        $this->uploader = $container->get(Uploader::class);
        $this->database = $container->get(Database::class);
    }

    /** MAGICAL METHODS **/
    public function __get($name)
    {
        if (array_key_exists($name, $this->model_data)) {
            return $this->model_data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function __unset($name)
    {
        echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }

    public function __call(string $name, array $arguments)
    {
        echo "Calling undefined object method '$name' "
        . implode(', ', $arguments). "\n";
    }

    public static function __callStatic(string $name, array $arguments)
    {
        echo "Calling undefined static object method '$name' "
             . implode(', ', $arguments). "\n";
    }
}
