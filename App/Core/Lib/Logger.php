<?php
declare (strict_types=1);

namespace App\Core\Lib;
use App\Core\Interface\InstanceInterface;

/**
 * Description of Logger
 *
 * @author michaelmik
 */
class Logger implements InstanceInterface
{
    /**
     * 
     * @var string $default_log_path <p>Path to log file (ex.: ./log/)</p>
     */
    public string $log_file;
    
    private string $file_content;

    private static self $_instance;
    private static int $_instance_id;

    public function __construct()
    {
        $this->log_file = env("default_log_file", false);
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
    
    /**
     * Writes log message to defined log file
     *
     * @param string $message               <p>Message string</p>
     * @param string $message_type          <p>INFO|WARNING|ERROR|SUCCESS</p>
     * @param string $log_file              <p>Filename of log file (without extension)</p>
     * @param string|null $log_path         <p>Defines target Log path (default: ./log/)</p>
     * @param bool $can_create_new_log      If application can create new log file (default: true)
     * @return void
     */
    public function log(string $message, string $message_type="message", string $log_file = null, bool $can_create_new_log = true)
    {
        if($log_file == null) 
        {
            $log = $this->log_file;
        }
        else
        {
            $log = $log_file;
            $this->log_file = $log_file;
        }
        
        $file = $log.".log";

        if($can_create_new_log == false)
        {
            if(!is_writable($file))
            {
                echo ("Log file $file is not writtable! Change permission");
            }

            $file_open = fopen($file, "a+");
        }
        else
        {
            $file_open = fopen($file, "a+");
        }
        
        fwrite($file_open, $this->messageConstruct($message, $message_type));
        fclose($file_open);
    }
    
    /**
     * Get Array of lines from log file (one line = one index of returned array)
     *
     * @param string $log_file          <p>Filename of log file (if empty -> get default log file from .env)</p>
     * @param integer $max_lines        <p>How much lines of log file will gather</p>
     * @return array|null               <p>Returns array of lines with keys: DATE,TYPE,MESSAGE</p>
     */
    public function getLog(string $log_file = null, int $max_lines = 128): Array|Null
    {
        
        if($log_file == null)
        {
            $logger_file = $this->log_file;
        }
        else
        {
            $logger_file = $log_file;
        }

        $file_ext = ".log";
        
        $log = file($logger_file.$file_ext);
        
        $return = [];
        
        for($i = 0; $i < $max_lines; $i++)
        {
            $explode = explode("!?:", $log[$i]);

            $array_line = array_filter($explode);

            if(!empty($array_line))
            {
                $return[$i]["DATE"] = $array_line[1];
                $return[$i]["TYPE"] = $array_line[2];
                $return[$i]["MESSAGE"] = $array_line[3];
            }
        }

        return $return;
    }
    
    /**
     * Construct message via construct convention
     *
     * @param string $message           Message to construct
     * @param string $message_type      Type of message (INFO|WARNING|ERROR|SUCCESS)
     * @return string                   Returns raw message string
     */
    private function messageConstruct(string $message, string $message_type): String
    {
        $date = time();
        $exception = strtoupper($message_type);
        
        //Construct sentence
        $write_raw = "!?:$date!?:$exception!?:$message\n";
        
        return $write_raw;
    }
    
    
}
