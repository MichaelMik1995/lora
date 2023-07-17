<?php
declare(strict_types=1);

namespace App\Core\Application;
use ErrorException;
use App\Core\Interface\InstanceInterface;

class DotEnv implements InstanceInterface
{
    private $path;
    private $tmp_env;


    private static $_instance;

    private static int $_instance_id;
    /**
     * 
     */

    private function __construct()
    {
        $this->constructEnvData(".env");
    }
    public static function instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance_id = rand(000000,999999);
        }
        return self::$_instance;
    }

    public function getInstanceId()
    {
        return self::$_instance_id;
    }

    private function constructEnvData($env_path)
    {
        // Check if .env file path has provided
        if(empty($env_path)){
            throw new ErrorException(".env file path is missing");
        }

        $this->path = $env_path;

        //Check .envenvironment file exists
        if(!is_file(realpath($this->path))){
            throw new ErrorException("Environment File is Missing.");
        }
        //Check .envenvironment file is readable
        if(!is_readable(realpath($this->path))){
            throw new ErrorException("Permission Denied for reading the ".(realpath($this->path)).".");
        }
        $this->tmp_env = [];
        $fopen = fopen(realpath($this->path), 'r');
        if($fopen){
            while (($line = fgets($fopen)) !== false){
                // Check if line is a comment
                $line_is_comment = (substr(trim($line),0 , 1) == '#') ? true: false;
                if($line_is_comment || empty(trim($line)))
                    continue;
 
                $line_no_comment = explode("#", $line, 2)[0];
                $env_ex = preg_split('/(\s?)\=(\s?)/', $line_no_comment);
                $env_name = trim($env_ex[0]);
                $env_value = isset($env_ex[1]) ? trim($env_ex[1]) : "";
                $this->tmp_env[$env_name] = $env_value;
            }
            fclose($fopen);
        }
        $this->load();
    }
 
    /**
     * 
     */
    function load(){
        // Save .env data to Environment Variables
        foreach($this->tmp_env as $name=>$value){
            putenv("{$name}=$value");
            if(is_numeric($value))
            $value = floatval($value);
            if(in_array(strtolower($value),["true","false"]))
            $value = (strtolower($value) == "true") ? true : false;
            $_ENV[$name] = str_replace('"', '', $value);
        }
        
        $parse_ini = parse_ini_file("./config/configuration.ini");
        
        $browser_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        
        $language = match($browser_language) {
            "cs" => "cz",
            "en" => "en",
            default => $parse_ini["LANGUAGE"],
        };
        
        $_ENV["language"] = $language;
    }

    public function getEnvData()
    {
        return $this->tmp_env;
    }

    public function get(string $key)
    {
        return $this->tmp_env[$key];
    }
}
?>