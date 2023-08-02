<?php


namespace App\Core\Lib;

/**
 * Description of Language
 *
 * @author miroka
 */
class Language 
{
    private static $lang = [];
    
    private static string $language = "";
    //put your code here
    
    public function __construct() 
    {
        $this->getLanguageVariables(self::$language);
    }
    
    public static function getLang()
    {
        return self::$lang;
    }
    
    /*public static function translate(string $sentence_line)
    {
        return self::$lang[$sentence_line];
    }*/

    public static function lang(string $sentence_line)
    {
        self::getLanguageVariables($_ENV["language"]);
        
        return self::$lang[$sentence_line];
    }
    
    private static function getLanguageVariables(string $lang)
    {
        foreach(glob("./lang/$lang/*") as $lang_folder)
        {
            if(is_dir($lang_folder))
            {
                foreach(glob($lang_folder."/*") as $lang_file)
                {
                    if (str_contains($lang_file, ".ini")) 
                    {
                        $get_lang_file = parse_ini_file($lang_file);
                        self::$lang = array_merge(self::$lang, $get_lang_file);
                    }
                }
            }
            elseif (str_contains($lang_folder, ".ini")) 
            {
                $get_lang_folder = parse_ini_file($lang_folder);
                self::$lang = array_merge(self::$lang, $get_lang_folder);
            }
            else
            {
                
            }
        }
    }
}
