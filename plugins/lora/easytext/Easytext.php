<?php
declare (strict_types=1);

namespace Lora\Easytext;

use Lora\Easytext\Core\Former;
use App\Core\Interface\InstanceInterface;

class Easytext implements InstanceInterface
{
    protected $form;
    private static $_instance;
    private static $_instance_id;

    public static function instance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self;
            self::$_instance_id = rand(0000000,999999);
        }

        return self::$_instance;
    }

    public function getInstanceId()
    {
        return self::$_instance_id;
    }
    public function __construct()
    {
        $this->form = new Former();
    }

    /**
     * 
     * Generate a new form from easytext
     * @param string $textarea_name string
     * @param string $textarea_content string
     * @param string $textarea_placeholder string
     * @param int $max_words int
     * @param string $submit_text string
     * @param string $width string
     * @param string $height string
     * @return string string (whole form)
     */
    public function form(string $textarea_name="content", string $textarea_content="", array $options = [])
    {
        return $this->form->compileForm($textarea_name, $textarea_content, $options);
    }
    
    public function generateForm()
    {
        
    }
    
    /**
     * 
     * @param string $string
     * @param string $imageWidth
     * @param string $post
     * @return string|null
     */
    public function translateText(string|null $string, $imageWidth="100%"): String|NULL
    {
        if($string == "" || $string == null)
        {
            return NULL;
        }
        else
        {
            $content = htmlspecialchars_decode($string);
            $content = $this->whiteSpaces($content);
            $content = $this->parseCode($content);
            $content = $this->colorTranslate($content);
            $content = $this->imageTranslate($content, $imageWidth);
            $content = $this->translate_tags($content);
            $content = $this->stringToEmoji($content);
            $content = $this->hrefTranslate($content);
            $content = $this->videoYtTranslate($content);
            $content = $this->fontTranslate($content);
            $content = $this->rowTranslate($content);
            $content = $this->rowCenterTranslate($content);
            $content = $this->rowReverseTranslate($content);
            $content = $this->charsDecode($content);
            
            return $content;
        }
    }
    
    public function whiteSpaces($string)
    {
        return str_replace(["\t", "\n"], ["&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp","<br>"], $string);
    }

    public function parseCode($string)
    {
        return preg_replace('~\[Code]\s*(.+?)\s*\[/Code]~is', '<div class="eTcode pdy-3 pdx-4"><pre><code>'.htmlspecialchars('$1').'</code></pre></div>', $string);
    }
    
    public function charsDecode($content)
    {
        return str_replace(["&lt;", "&gt;"], ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"], $content);
    }
    
    public function removeBlocks($string)
    {
        $count_blocks = substr_count($string, "[");
        $get_block_strings = $this->get_string_bettwen($string, "[", "]");
        
    }
    
    /**
     * Translate emoji from database
     * 
     * @param string $string -> content to translate
     * @return string -> return translated string from Database
     */
    protected function stringToEmoji($string)
    {
        return strtr($string, $this->translateEmoji());
    }
    
    protected function imageToString($string)
    {
        $filArray = array_flip($this->translateEmoji());
        return strtr($string, $filArray);
    }
    
    protected function imageTranslate($string, $imageWidth="100%")
    {
        return preg_replace('~\[Img]\s*(.+?)\s*\[/Img]~is', '<img rel="easySlider" src="$1" class="es-image width-100-sm" loading="lazy" alt="$1" width="'.$imageWidth.'">', $string);
    }
    
    protected function videoYtTranslate($string)
    {
        return preg_replace('~\[Video]\s*(.+?)\s*\[/Video]~is', '<iframe height="315" src="$1" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>', $string);
    }
    
    protected function colorTranslate($string)
    {       
        return preg_replace('~\[col:\s*(.+?)\s*\]~is', '<span style="color: $1;">', $string);
    }

    protected function rowTranslate($string)
    {       
        return preg_replace('~\[ROW-\s*(.+?)\s*\]~is', '<div class="row cols-$1 cols-1-xsm cols-2-sm">', $string);
    }

    protected function rowCenterTranslate($string)
    {       
        return preg_replace('~\[ROWC-\s*(.+?)\s*\]~is', '<div class="row-center cols-$1 cols-1-xsm cols-2-sm">', $string);
    }

    protected function rowReverseTranslate($string)
    {       
        return preg_replace('~\[ROWR-\s*(.+?)\s*\]~is', '<div class="row-reverse cols-$1 cols-1-xsm cols-2-sm">', $string);
    }
    
    protected function fontTranslate($string)
    {
        return preg_replace('~\[FONT-\s*(.+?)\s*\]~is', '<i class="fa fa-$1"></i>', $string);
    }
    
    protected function hrefTranslate($string)
    {       
        return preg_replace('~\[Url]\s*(.+?)\s*\[/Url]~is', '<a class="eT_href" title="Otevřít odkaz: $1" href="$1"><i class="fa fa-globe-europe"></i> $1</a>', $string);
    }

     /**
     * 
     * PROTECTED: translate_tags($content) 
     * 
     * @param string $content -> content for replacing text
     * @return string -> translate content to TAG 
     * 
     */
    protected function translate_tags($content, $imageWidth=256) 
    {       
        $varTranslate = [
            "[B]" => "<b>",
            "[/B]" => "</b>",
            "[i]" => "<i>",
            "[/i]" => "</i>",
            "[u]" => "<u>",
            "[/u]" => "</u>",
            "[Str]" => "<strike>",
            "[/Str]" => "</strike>",
            "[Small]" => "<sub>",
            "[/Small]" => "</sub>",
            "[Big]" => "<sup>",
            "[/Big]" => "</sup>",
            "[Qt]" => "<div class=\"quote\"><div style=\"font-size: 10px; margin-bottom: .5em; text-shadow: none;\">Cituji:</div>",
            "[/Qt]" => "</div>",
            "[Code]"=>"<div class=\"eTcode pdy-3 pdx-4\">",
            "[/Code]"=>"</div>",   
            "/*"=>"<div class=\"eTcode_comment\">/*",
            "*/"=>"*/</div>",      
            "[/Img]" => "",
            "[Hidden]" => "<details class=\"esHidden\"><summary class=\"esHiddenSum\"><i class=\"fa fa-eye esHiddenEye\"></i></summary><div class='pdx-4 pdy-1'>",
            "[/Hidden]" => "</div></details>",
            "[*/Color]" => "</span>",
            "[Li]" => "<li>",
            "[/Li]" => "</li>",
            "[Ul circle]" => "<ul class='et_ul' style=\"list-style-type:circle;\">",
            "[Ul square]" => "<ul class='et_ul' style=\"list-style-type:square;\">",
            "[Ul disc]" => "<ul class='et_ul' style=\"list-style-type:disc;\">",
            "[Ul decimal]" => "<ul class='et_ul' style=\"list-style-type:decimal;\">",
            "[/Ul]" => "</ul>",
            "[COLUMN]" => "<div class='column-shrink pd-1'><div class='mg-auto;'>",
            "[/COLUMN]" => "</div></div>",
            "[/ROW]" => "</div>",
            "<img rel=\"easySlider\" src=\"../../../../" => "<img rel=\"easySlider\" src=\"".$_ENV["base_href"]."/",
            
            //Headers
            "[H1]" => "<div class='header-1'>",
            "[/H1]" => "</div>",
            "[H2]" => "<div class='header-2'>",
            "[/H2]" => "</div>",
            "[H3]" => "<div class='header-3'>",
            "[/H3]" => "</div>",
            "[H4]" => "<div class='header-4'>",
            "[/H4]" => "</div>",
            "[H5]" => "<div class='header-5'>",
            "[/H5]" => "</div>",
            "[H6]" => "<div class='header-6'>",
            "[/H6]" => "</div>",
            
            //Text Align
            "[Text-Left]" => "<div class='content-left'>",
            "[/Text-Left]" => "</div>",
            "[content-center]" => "<div class='content-center'>",
            "[/content-center]" => "</div>",
            "[Text-Right]" => "<div class='content-right'>",
            "[/Text-Right]" => "</div>",
            "[Text-Justify]" => "<div class='content-justify'>",
            "[/Text-Justify]" => "</div>",       
            
           //In Codes
           "true" => "<span style=\"color: aqua;\">true</span>",
           "false" => "<span style=\"color: orangered;\">false</span>",
        
            "[/Style]" => "</div>",
            "[/Span]" => "</span>"
           
        ];

        $styles = [];

        $get_styles = file_get_contents("./resources/plugins/easytext/blockstyles/easytext_styles.json");
        $get_json = json_decode($get_styles, true, 4);
            
        $blocks  = $get_json["blocks"];
        $spans = $get_json["spans"];
        $texts = $get_json["texts"];

        foreach($blocks as $block)
        {
            $styles["[Style-block-".$block."]"] = "<div class='easytext-block-style-$block'>";
        }

        foreach($spans as $span)
        {
            $styles["[Style-span-".$span."]"] = "<span class='easytext-span-style-$span'>";
        }

        foreach($texts as $text)
        {
            $styles["[Style-text-".$text."]"] = "<span class='easytext-text-style-$text'>";
        }

        
        $translateContent = strtr($content, array_merge($varTranslate, $styles));
        return $translateContent;
    }
    
    /**
     * 
     * PRIVATE: get_string_bettwen($string, $start, $end)
     * 
     * @param string $string -> get string betwen $start - $end
     * @param string $start -> first position of cutted string
     * @param string $end -> last position of cutted string
     * @return string -> returns cutted string
     */
    protected function get_string_bettwen($string, $start, $end) 
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
    
    
    
    protected function translateEmoji()
    {
        $emoji_asset_path = "./public/img/icon/emoji";
        
        $icon_translate = [
            ":)" => "<img title=\":)\" class=\"easyText_emoji\" src=\"$emoji_asset_path/smile.svg\">",
            ":(" => "<img title=\":(\" class=\"easyText_emoji\" src=\"$emoji_asset_path/sad.svg\">",
            ";/" => "<img title=\";/\" class=\"easyText_emoji\" src=\"$emoji_asset_path/gloomy.svg\">",
            ":D" => "<img title=\":D\" class=\"easyText_emoji\" src=\"$emoji_asset_path/happy.svg\">",
            ":O" => "<img title=\":O\" class=\"easyText_emoji\" src=\"$emoji_asset_path/wonder.svg\">",
            ";D" => "<img title=\";D\" class=\"easyText_emoji\" src=\"$emoji_asset_path/smile_crying.svg\">",
            ":P" => "<img title=\":P\" class=\"easyText_emoji\" src=\"$emoji_asset_path/tong.svg\">",
            ";)" => "<img title=\";)\" class=\"easyText_emoji\" src=\"$emoji_asset_path/flirt.svg\">",
            ":*" => "<img title=\":*\" class=\"easyText_emoji\" src=\"$emoji_asset_path/loving.svg\">",
            ";*" => "<img title=\";*\" class=\"easyText_emoji\" src=\"$emoji_asset_path/snd_heart.svg\">",
            "3:(" => "<img title=\"3:(\" class=\"easyText_emoji\" src=\"$emoji_asset_path/angry.svg\">",
            "3:D" => "<img title=\"3:D\" class=\"easyText_emoji\" src=\"$emoji_asset_path/dvl_smile.svg\">",
            "**frog**" => "<img title=\"**frog**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/frog.svg\">",
            "<3" => "<img title=\"<3\" class=\"easyText_emoji\" src=\"$emoji_asset_path/love.svg\">",
            "**y**" => "<img title=\"**y**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/like.svg\">",
            "**clown**" => "<img title=\"**clown**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/clown.svg\">",
            "**ill**" => "<img title=\"**ill**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/ill.svg\">",
            "**music**" => "<img title=\"**music**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/music.svg\">",
            "**sick**" => "<img title=\"**sick**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/sick.svg\">",
            "**gem**" => "<img title=\"**gem**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/gem.svg\">",
            "**pan**" => "<img title=\"**gem**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/pan.svg\">",
            "**grenade**" => "<img title=\"**gem**\" class=\"easyText_emoji\" src=\"$emoji_asset_path/grenade.svg\">",
        ];
        
        return $icon_translate;
    }
    
    public function shortText($string, $valueCut = 500)
    {
        $get_string = $string;//str_replace(array("[content-center]","[/content-center]"), "", $string);
        $valueCutNumber = intval($valueCut);
        if(strlen($get_string) > $valueCutNumber) 
        {
                $returnCuttedString = substr($get_string, 0, $valueCutNumber)."...";
        }else
        {
            $returnCuttedString = $get_string;
        }
        return $returnCuttedString;       
    }
}
