<?php
declare (strict_types=1);

namespace App\Core\Lib;

/**
 * Description of Logger
 *
 * @author michaelmik
 */
class Logger
{
    /**
     * 
     * @var string $log_path <p>Path to log file (ex.: ./log/)</p>
     */
    private static string $log_path = "./log/";
    
    private static string $file_content;
    
    /**
     * 
     * @param string $message
     * @param string $message_type
     */
    public static function log(string $message, string $message_type="message", string $log_file="application")
    {
        $log_path = env("log_folder", false);
        $file = self::$log_path.$log_file.".log";

        if(!is_writable($file))
        {
            echo ("Log file $file is not writtable! Change permission");
        }
        
        $file_open = fopen($file, "a+");
        fwrite($file_open, self::messageConstruct($message, $message_type));
        fclose($file_open);
    }
    
    public static function getLog($log_file="application", int $max_lines = 128)
    {
        $file_path = "./log/";
        $file_ext = ".log";
        
        $log = file($file_path.$log_file.$file_ext);
        
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
    
    private static function messageConstruct(string $message, string $message_type): String
    {
        $date = time();
        $exception = strtoupper($message_type);

        //Construct DATA
        
        //Construct sentence
        //$sentence = "$date." [Type: ".$exception."] -> ".$message. "\n";
        $write_raw = "!?:$date!?:$exception!?:$message\n";
        
        return $write_raw;
    }
    
    
}
