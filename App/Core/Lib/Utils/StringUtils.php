<?php
declare (strict_types=1);
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Core\Lib\Utils;

/**
 * Description of StringUtils
 *
 * @author michaelmik
 */
class StringUtils 
{
    private static $_instance;
    public static $_instance_id;

    /**
     * @var array $restricted_chars <p>Restricted chars in URL address -> replaced to "-" char</p> 
     */
    public array $restricted_chars = [" ","_",",",".","@","&","|","/","?", "!", "<", ">", "$", "§", "'", "~", "°", "^", "˘", "˛", "`", "˙", "´", "ˇ", "˝", ":", "\\", '"', "(", ")", "{", "}", "[", "]"];

    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new self();
            self::$_instance_id = rand(000000,999999);
        }

        return self::$_instance;
    }

    /**
     * Replaces string to simple word slug
     * @param string $string <p>Input string for replace</p>
     * @return string <p>Returns replaced slug (ex.: Fireball_Exte Nded => fireball-exte-nded)</p>
     */
    public function toSlug(string $string, bool $allow_space = false)
    {
        
        $array_from_chars = $this->restricted_chars;
        
        if($allow_space === true)
        {
            unset($array_from_chars[0]);
        }
        else
        {
            $string = mb_strtolower($string);
        }

        
        
        $diacritics = ["ě","š","č","ř","ž","ý","á","í","é","ú","ů","ó", "ď"];
        $letters = ["e","s","c","r","z","y","a","i","e","u","u","o", "d"];
        
        $replace_chars = str_replace($array_from_chars, "-", $string);
        $replace_diacritics = str_replace($diacritics, $letters, $replace_chars);
        
        return $replace_diacritics;
    }
    
    /**
     * Returns hashed string with defined char size
     * @param int $length <p>Output size of chars (default: 8)</p>
     * @return string <p>Returns final hashed string</p>
     */
    public function genarateHashedString(int $length = 8, bool $complex = false, string $salt = "")
    {
        if($salt == "")
        {
            $hash = md5(hash("SHA256", "MD5".time()));
        }
        else
        {
            $hash = md5(hash("SHA256", "MD5".time().$salt));
        }
       
        $substring = substr($hash, 0, $length+$length);
        
        if($complex === false)
        {
            $_crypt = crypt("SHA256", md5($substring));
        }
        else
        {
            $_crypt = base64_encode(md5($substring));
        }
        
        
        return substr($_crypt, 0, $length);   
    }

    /**
     * Summary of generateHashedPassword
     * @param string $password
     * @return string
     */
    public function generateHashedPassword(string $password, string $salt = "")
    {
        $options = [
          "cost" => 12,  
        ];
        
        if($salt == "")
        {
            $hash = password_hash($password, PASSWORD_BCRYPT, $options);
        }
        else
        {
            $hash = password_hash($password.$salt, PASSWORD_BCRYPT, $options);
        }
        
        return $hash;
    }
    
    /**
     * Summary of generateHashFromString
     * @param string $string
     * @param string $salt
     * @return string
     */
    public function generateHashFromString(string|int|float $string, string $salt = "", int $length = 8)
    {
        $options = [
          "cost" => 12,  
        ];
        
        if($salt == "")
        {
            $hash = hash("SHA256", $string);
        }
        else
        {
            $hash = hash("SHA256", $string.$salt);
        }
        
        return substr($hash, 7, $length); 
    }

    public function cutText(string $string, int $lenght=256)
    {
        
    }
    
    /**
     * Summary of getStringBetween
     * @param mixed $start
     * @param mixed $end
     * @param mixed $string
     * @return string
     */
    public function getStringBetween($start, $end, $string)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    
    /**
     * Replaces all replacements in string -> multireplacement technology
     *
     * @param string $content                               Content to replace
     * @param array|null $replacements                      Array of replacements 
     * @param string $replacement_start_pattern             Replacement pattern -> start (default: "{")
     * @param string $replacement_end_pattern               Replacement pattern -> end (default: "}")
     * @return string
     */
    public function contentReplacer(string $content, array $replacements = [], string $replacement_start_pattern = "{", string $replacement_end_pattern = "}")
    {
        if(!empty($replacements))
        {
            $array_code = [];
            $array_vars = [];

            foreach($replacements as $key => $value)
            {
                $array_code[] = $replacement_start_pattern.$key.$replacement_end_pattern;
                $array_vars[] = $value;
            }

            return str_replace($array_code, $array_vars, $content);
        }
        else
        {
            return $content;
        }
    }

     /**
     * 
     * @param string $content
     * @param array $compile_text
     * @return boolean|string
     */
    public function compile(string $content, array $compile_text = []): String
    {
        if(!empty($compile_text))
        {
            $array_code = [];
            $array_vars = [];

            foreach($compile_text as $key => $value)
            {
                $array_code[] = $key;
                $array_vars[] = $value;
            }

            return str_replace($array_code, $array_vars, $content);
        }
        else
        {
            return $content;
        }
    }
}
