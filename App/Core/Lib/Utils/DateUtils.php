<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;
use App\Core\Interface\InstanceInterface;

/**
 * Description of DateUtils
 *
 * @author michaelmik
 */
class DateUtils implements InstanceInterface
{
    private static $main_config;
    private static $date_config;
    private static $language;
    

    private static $_instance;
    private static int $_instance_id;

    public function __construct(){ 
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
    public function getInstanceId()
    {
        return self::$_instance_id;
    }
        
    /**
     * Returns translated months to preferred language
     * @return array
     */
    public function getMonths()
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
     * @param string $month
     * @return string|null
     */
    public function getMonth($month = "Jan"): String|Null
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
     * @return array
     */
    public function getDays(): Array
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
     * @param string $day
     * @return string|null
     */
    public function getDay(string $day = "Mon"): String|Null
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