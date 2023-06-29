<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;

/**
 * Description of DateUtils
 *
 * @author michaelmik
 */
class DateUtils 
{
    private static $main_config;
    private static $date_config;
    private static $language;
    

    private static $_instance;
    private static int $_instance_id;

    private function __construct(){ 
        self::$main_config = parse_ini_file("./config/public.ini");
        self::$language = self::$main_config["LANGUAGE"]; 
        self::$date_config = parse_ini_file("./lang/".self::$language."/Date.ini");
    }

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
        
    /**
     * 
     * @return type
     */
    public static function getMonths()
    {
        $translated = [
            "Jan" => self::$date_config["Jan"],
            "Feb" => self::$date_config["Feb"],
            "Mar" => self::$date_config["Mar"],
            "Apr" => self::$date_config["Apr"],
            "May" => self::$date_config["May"],
            "Jun" => self::$date_config["Jun"],
            "Jul" => self::$date_config["Jul"],
            "Aug" => self::$date_config["Aug"],
            "Sep" => self::$date_config["Sep"],
            "Oct" => self::$date_config["Oct"],
            "Nov" => self::$date_config["Nov"],
            "Dec" => self::$date_config["Dec"],
        ];
        
        return $translated;
    }
    
    /**
     * 
     * @param type $month
     * @return type
     */
    public function getMonth($month = "Jan")
    {
        return self::$date_config[$month];
    }
    
    /**
     * 
     * @return type
     */
    public function getActualMonth()
    {
        $actual_month = DATE("M");
        return self::$date_config[$actual_month];
    }
    
    /**
     * 
     * @return type
     */
    public function getDays()
    {
        $translated = [
            "Mon" => self::$date_config["Mon"],
            "Tue" => self::$date_config["Tue"],
            "Wed" => self::$date_config["Wed"],
            "Thu" => self::$date_config["Thu"],
            "Fri" => self::$date_config["Fri"],
            "Sat" => self::$date_config["Sat"],
            "Sun" => self::$date_config["Sun"],
        ];
        
        return $translated;
    }
    
    /**
     * 
     * @param type $day
     * @return type
     */
    public function getDay($day = "Mon")
    {
        return self::$date_config[$day];
    }
    
    /**
     * 
     * @return type
     */
    public function getActualDay()
    {
        $actual_day = DATE("D");
        return self::$date_config[$actual_day];
    }

    //Date Functions
    public static function addDay()
    {
        
    }
    
}