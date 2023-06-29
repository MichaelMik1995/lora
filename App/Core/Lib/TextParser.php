<?php
declare(strict_types=1);

namespace App\Core\Lib;

class TextParser 
{
    protected string $file_path = "";
    protected array $file_content_array = [];
    private static $_instance;

    public function __construct()
    {
        
    }

    public static function instance()
    {
        if(self::$_instance == null)
        {
            return self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 
     */
    public function parse(string $file_path)
    {
        $this->file_path = $file_path;
        $get_content = file_get_contents($file_path);
        
        // parse to array

        //Each line

        /*
        * 0 [line1=text]
        * 1 [line2=text]
        * 2 [line3=text]
        */
        $explode_lines = explode("\n", $get_content);


        foreach($explode_lines as $line)
        {
            $explode_line = explode("=", $line);
            @$this->file_content_array[$explode_line[0]] = $explode_line[1];
        }
        return $this;
    }

    /**
     * Firstly, you need initialize TextParser -> call method parse(string $file_path)->get(string $parameter)
     * @param string|null $parameter
     */
    public function get(string $parameter): String|null
    {
        return $this->file_content_array[$parameter];
    }

    public function set(string $parameter, string $new_value): Bool
    {
        $new_file_content = "";
        foreach ($this->file_content_array as $key => $value)
        {
            if($key == $parameter)
            {
                //Set new value
                $this->file_content_array[$key] = $new_value;
            }
            $new_file_content .= $key."=".$this->file_content_array[$key]."\n";
        }

        //Create new file
        $file = fopen($this->file_path, "w");
        fwrite($file, $new_file_content);
        fclose($file);

        //Destruct 

        return true;
    }
}
