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
    /**
     * @var Database
     */
    protected $database;
    
    protected $db;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var EasyText
     */
    protected $easy_text;

    /**
     * @var StringUtils
     */
    protected $string_utils;

    /**
     * @var NumberUtils
     */
    protected $number_utils;

    /**
     * @var LoraException
     */
    protected $exception;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Language
     */
    protected $lang;

    /**
     * @var Uploader
     */
    protected Uploader $uploader;

    protected $container;

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
}
