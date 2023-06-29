<?php
namespace App\Core;

use App\Core\DI\DIContainer;
use App\Core\Database\Database; //Old version od Database MYSQL -> recommended NOT use
use App\Core\Database\DB;
use App\Middleware\Auth;
use App\Core\Lib\Utils\StringUtils;
use App\Core\Lib\Utils\NumberUtils;
use App\Exception\LoraException;
use App\Core\Application\Config;
use App\Core\Lib\Language;
use App\Core\Lib\Uploader;

/**
 * Description of Model
 *
 * @author michaelmik
 */
class Model 
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

    public function init()
    {
        $di = new DIContainer();
        $injector = $di->inject;
        
        $this->auth = $injector["Auth"];
        $this->easy_text = $injector["Easytext"];
        $this->string_utils = StringUtils::class;
        $this->exception = $injector["LoraException"];
        $this->number_utils = NumberUtils::instance();
        $this->config = $injector["Config"];
        $this->lang = $injector["Language"];
        $this->uploader = new Uploader();
        $this->db = DB::instance();
    }
}
