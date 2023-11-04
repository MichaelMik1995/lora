<?php
declare(strict_types=1);

namespace App\Core\Lib\Utils;

/**
 * Description of VariableUtils
 *
 * @author miroka
 */
class VariableUtils 
{
   private static $_instance;
    private static int $_instance_id;

    public function __construct(){}

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
   
    public function extractor()
    {
       
    }

        
    /**
     * Method similar to var_dump(), better formattings and reading
     * @param mixed $input           Object to dump and format
     * @param int $depth             Depth of loop input content
     * @return void                  echo()
     */
    public function varDumper(mixed $input, string $dumpname = "", bool $extended = false, int $width = 3, int $depth = 0): Void
    {

        $indent = str_repeat("&emsp;", $depth); 
        $mgx = $depth+4;

        $keys_width = $width;
        $value_width = 10-$width;

        if($dumpname == "")
        {
            $dumpname = "dump".DATE("d.m.Y H:i:s");
        }

        if($depth == 0)
        {
            echo "<div class='row bd-dark'><div class='column-10 bgr-dark pd-1'>VAR_DUMPER(<span class='t-info t-bold'>{$dumpname}</span>) Output: </div>";//echo "<pre class='pd-1'>";
            $column = "10 mgx-1";
        }
        else
        {
            $column = "$value_width";
        }

        

        if (is_array($input)) //Is ARRAY
        {
            echo "<div class='column-10'>{$indent}<span style='color: #FF7300;'>Array[".count($input)."]</span></div>";
            foreach ($input as $key => $value) 
            {
                echo "<br><div style='padding-top: 5px;' class='column-{$keys_width} pdx-{$mgx}'>{$indent}<span style='color: #A0B4FF;'>\"{$key}\"</span>:</div>"; //Key
                self::varDumper($value, $dumpname, $extended, $width, $depth + 2);
            }
        } elseif (is_object($input)) 
        {
            echo "<div class='column-10'>{$indent}<span style='color: #00AAF5;'>Object</span> of class: <span style='color: #00AAF5;'>" . get_class($input) . "</span></div>";
            
            foreach (get_object_vars($input) as $key => $value) {
                echo "<div style='padding-top: 5px;' class='column-{$keys_width} pdx-{$mgx}'>{$indent}<span style='color: #A0B4FF;'>\"{$key}\"</span>:</div>";
                self::varDumper($value, $dumpname, $extended, $width, $depth+2);
            }
        } elseif (is_string($input))    //Is STRING
        {
            if($extended == true)
            {
                echo "<div class='column-{$value_width}'><span style='color: #FFCA23;'>\"{$input}\"</span> ( type: <span style='color: #FF00D4;'>string( ".mb_strlen($input)." )</span> )</div>";
            }
            else
            {
                echo "<div class='column-{$value_width}'><span style='color: #FF00D4;'>\"{$input}\"</span></div>";
            }
        } elseif (is_int($input))   //Is INTEGER
        {
            if($extended == true)
            {
                echo "<div class='column-{$value_width}'><span style='color: #FFCA23;'>{$input}</span> ( type: <span style='color: #ACE3AF;'>int( ".mb_strlen(strval($input))." )</span> )</div>";
            }
            else
            {
                echo "<div class='column-{$value_width}'><span style='color: #ACE3AF;'>{$input}</span></div>";
            }
        } elseif (is_float($input))     //Is FLOAT
        {
            if($extended == true)
            {
                echo "<div class='column-{$value_width}'><span style='color: #FFCA23;'>{$input}</span> ( type: <span style='color: #38D500;'>float</span> )</div>";
            }
            else
            {
                echo "<div class='column-{$value_width}'><span style='color: #38D500;'>{$input}</span></div>";
            }
            
        } elseif (is_bool($input)) //Is BOOLEAN
        {
            $boolStr = $input ? "true" : "false";

            if($extended == true)
            {
                echo "<div class='column-{$value_width}'><span style='color: #FFCA23;'>{$boolStr}</span> ( type: <span style='color: #d10000;'>boolean</span> )</div>";
            }
            else
            {
                echo "<div class='column-{$value_width}'><span style='color: #d10000;'>{$boolStr}</span></div>";
            }
            
        } elseif (is_null($input)) 
        {
            echo "<div class='column-{$value_width}'>{$indent}<span style='color: gray;'>null</span> (type: <span style='color: gray;'>null</span>)</div>";
        } else 
        {
            echo "<div class='column-{$value_width}'>{$input} (type: " . gettype($input) . ")</div>";
        }

        if($depth == 0)
        {
            echo "</div> <p class='pdy-2'></p>";//echo "</pre>";
        }

        
    }
}
