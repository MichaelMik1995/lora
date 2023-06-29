<?php
declare (strict_types=1);

namespace App\Core\Lib\Utils;

/**
 * Description of UrlUtils
 *
 * @author michaelmik
 */
class UrlUtils 
{
    private static $_instance;
    private static int $_instance_id;

    private function __construct(){}

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

    public static function getPreviousUrl(): String
    {
        
    }
    
    public static function redirectToPreviousUrl()
    {
        
    }
    
    /**
     * Summary of is_page_refreshed
     * @return bool
     */
    public static function is_page_refreshed(): Bool
    {
        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
        return $pageWasRefreshed;
    }
    
    
    /**
     * 
     * PRIVATE: parseUrl($url) 
     * 
     * @param string $url -> url to parse
     * 
     * @return array -> returns parsed url to array
     */
    public static function urlParse(string $url = "") 
    {
        if($url == "")
        {
           $url = $_SERVER["REQUEST_URI"]; 
        }
        
        $url_to_parse = parse_url($url);
        $url_to_parse['path'] = ltrim($url_to_parse['path'], "/");
        $url_to_parse['path'] = trim($url_to_parse['path']);
        $url_explode = explode("/", $url_to_parse['path']);
        
        $routing = [
            "controller" => $url_explode[0],
            "action" => @$url_explode[1],
            "route_param" => @$url_explode[2],
        ];
        
        $options = array_splice($url_explode, 3);

        $options_url = [];

        $i = 1;

        foreach($options as $opt)
        {
            $id = $i++;
            $options_url["route_param".$id] = $opt;
        }

        $merged_arrays = array_merge($routing, $options_url);
        
        return $merged_arrays;
    }
    
    /**
     * 
     * PRIVATE: toUpperCase($url)
     * 
     * @param string $url parsed url to upperCasw
     * 
     * @return string returns Upper cased text
     * @example localhost/admin-home -> AdminHome
     * 
     */
    private static function toUpperCase($url)
    {
        $stringRep = str_replace("-", " ", $url);
        $stringRep = ucwords($stringRep);
        $stringRep = str_replace(" ", "", $stringRep);
        return $stringRep;
    }
    
    /**
     * Summary of stringToUrl
     * @param mixed $url
     * @return array
     */
    public static function stringToUrl($url)
    {
        return self::urlParse($url);
    }
}
