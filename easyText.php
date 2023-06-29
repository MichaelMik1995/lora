<?php

/* 
 * Copyright 2019 acer15.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class easyText
{
    public function newForm($icons = [], $submit_trigger="sendForm", $textarea_name="eT_area", $max_words=256, $color="#bfbfbf", $textarea_placeholder="", $textarea_content="", $hideSubmit=0, $width="100%", $height="400px")
    {
        
       $easyTextForm = "
            
                <div style='width: $width;' class='easyText-header webstyle_easytext_header'>";
                if(count($icons) == 0)
                {
                    $easyTextForm .= "
                        <div class='easyText_countChars' id='easyText_countChars_$max_words'><span>0</span>/$max_words</div>
                        <div class='es_cell webstyle_easytext_block'>
                            <i title='Tučný text' id='easyText_bold' class='fa fa-bold es_header_icons'></i>
                            <i title='Kurzíva' id='easyText_italic' class='fa fa-italic es_header_icons'></i>
                            <i title='Přeškrtnutý text' id='easyText_underline' class='fa fa-underline es_header_icons'></i>
                            <i title='Přeškrtnutý text' id='easyText_strike' class='fa fa-strikethrough es_header_icons'></i>
                            <i title='Zvětšit text' id='easyText_big' class='fa fa-superscript es_header_icons'></i>
                            <i title='Zmenšit text' id='easyText_small' class='fa fa-subscript es_header_icons'></i>
                        </div>
                        <div class='es_cell webstyle_easytext_block'>
                            <i title='Vložit odkaz' id='easyText_url' class='fa fa-globe-americas es_header_icons'></i>
                            <i title='Vložit citaci' id='easyText_quotes' class='fa fa-quote-right es_header_icons'></i>
                            <i title='Vložit programový kód' id='easyText_code' class='fa fa-code es_header_icons'></i>
                            <i title='Vytvořit skrytý blok' id='easyText_hiddenblock' class='fa fa-eye-slash es_header_icons'></i>
                        </div>
                        
                        <div class='es_cell webstyle_easytext_block'>
                            <i title='Vložit nadpis' id='easyText_header' class='fa fa-heading es_header_icons'></i>
                            <i title='Zarovnat text' id='easyText_align' class='fa fa-align-center es_header_icons'></i>
                            <i title='Vložit odrážky' id='easyText_rows' class='fa fa-list-ul es_header_icons'></i>
                            <i title='Vložit blok' id='easyText_div_styles' class='fa fa-border-style es_header_icons'></i>
                            <i title='Obarvit text' id='easyText_color' class='fa fa-palette es_header_icons'></i>
                        </div>
                        
                        <div class='es_cell webstyle_easytext_block'>
                            <i title='Vložit obrázek' id='easyText_image' class='fa fa-image es_header_icons'></i>
                            <i title='Vložit Youtube Video' id='easyText_video' class='fa fa-video es_header_icons'></i>
                            <i title='Vložit ikonu' id='easyText_fontawe' class='fa fa-icons es_header_icons'></i>                            
                            <i title='Vložit emoji' id='easyText_smile' class='fa fa-smile es_header_icons'></i>
                        </div>
                        

                        
                        ";
                }else
                {
                    foreach($icons as $icon)
                    {
                        $easyTextForm .= "<img id='easyText_$icon' src='../web/img/icon/easyText/panel/$icon.svg' width='20'>";
                    }
                }          
            $easyTextForm .="
                </div>
                <div style='width: $width;'>

                <textarea id='easyText_area' required placeholder='$textarea_placeholder' class='easyText_textarea webstyle_easytext_textarea' style='resize: vertical; min-height: $height' name='$textarea_name'>$textarea_content</textarea>
                <br>
            </div>
                ";
            
                if($hideSubmit == 0)
                {
                   $easyTextForm .= "<input class='btn btn-primary btn-lg' type='submit' value='Uložit příspěvek' name='$submit_trigger'>"; 
                }       

       
       return $easyTextForm;
    }
    
    
    /**
     * 
     * @param type $string
     * @param string $imageWidth
     * @param string $post
     * @return string
     */
    public function translateText($string, $imageWidth="100%")
    {
        return $this->translate_tags(
                $this->stringToEmoji(
                        $this->imageTranslate(
                                $this->colorTranslate(
                                        $this->hrefTranslate(
                                                $this->fontTranslate(
                                                        $string
                                                        )
                                                )
                                        ), $imageWidth)));
    }
    
    /**
     * Translate emoji from database
     * 
     * @param string $string -> content to translate
     * @return string -> return translated string from DB
     */
    public function stringToEmoji($string)
    {
        return strtr($string, $this->translateEmoji());
    }
    
    public function imageToString($string)
    {
        $filArray = array_flip($this->translateEmoji($string));
        return strtr($string, $filArray);
    }
    
    public function imageTranslate($string, $imageWidth="100%")
    {
        $getImages = $this->translateImages($string);
        $imageRep = "";
        $imageArray = "";
        foreach($getImages as $img)
        {
            $imageRep .= "[Img]".$img[0].",";
            $imageArray .= "<img rel=\"easySlider\"  loading=\"auto\" alt=\"".$img[0]."\" title=\"".$img[0]."\" src=\"".$img[0]."\" width=\"$imageWidth\" >,";
        }

        $finalRep = rtrim($imageRep,",");
        $finalArray = rtrim($imageArray,",");
        
        $imageRepExpl = explode(",", $finalRep);
        $imageArrayExpl = explode(",", $finalArray);

        return str_replace($imageRepExpl, $imageArrayExpl, $string);
    }
    
    public function colorTranslate($string)
    {
        $getColor = $this->translateColor($string);
        $colorBlock = "";
        $colorArray = "";
        
        foreach($getColor as $color)
        {
            $colorBlock .= "[*".$color[0]."*],";
            $colorArray .= "<span style=\"color: ".$color[0]."\">,";
        }

        $finalRep = rtrim($colorBlock,",");
        $finalArray = rtrim($colorArray,",");
        
        $hrefRepExpl = explode(",", $finalRep);
        $hrefArrayExpl = explode(",", $finalArray);

        return str_replace($hrefRepExpl, $hrefArrayExpl, $string);
    }
    
    public function fontTranslate($string)
    {
        $getFont = $this->translateFont($string);
        $fontBlock = "";
        $fontArray = "";
        
        foreach($getFont as $font)
        {
            $fontBlock .= "[FONT-".$font[0]."],";
            $fontArray .= "<i class=\"fa fa-".$font[0]."\"></i>,";
        }

        $finalRep = rtrim($fontBlock,",");
        $finalArray = rtrim($fontArray,",");
        
        $hrefRepExpl = explode(",", $finalRep);
        $hrefArrayExpl = explode(",", $finalArray);

        return str_replace($hrefRepExpl, $hrefArrayExpl, $string);  
    }
    
    public function hrefTranslate($string)
    {
        $getHref = $this->translateHref($string);
        $hrefBlock = "";
        $hrefArray = "";
        
        foreach($getHref as $href)
        {
            $hrefBlock .= "[Url]".$href[0].",";
            $hrefArray .= "<a class=\"eT_href\" title=\"Otevřít odkaz: ".$href[0]."\" href=\"".$href[0]."\"><i class=\"fa fa-globe-europe\"></i> ".$href[0].",";
        }

        $finalRep = rtrim($hrefBlock,",");
        $finalArray = rtrim($hrefArray,",");
        
        $hrefRepExpl = explode(",", $finalRep);
        $hrefArrayExpl = explode(",", $finalArray);

        return str_replace($hrefRepExpl, $hrefArrayExpl, $string);
    }

     /**
     * 
     * PROTECTED: translate_tags($content) 
     * 
     * @param string $content -> content for replacing text
     * @return string -> translate content to TAG 
     * 
     */
    public function translate_tags($content, $imageWidth=256) 
    {
        
        $parseUrl = $this->get_string_bettwen($this->imageToString($content), "[Url]", "[/Url]");
        $parseComment = $this->get_string_bettwen($this->imageToString($content), "/*", "*/");
        $parseCommUrl = $this->get_string_bettwen($content, "[cUrl]", "[/cUrl]");
        $parseVideo = $this->get_string_bettwen($content, "[Video]", "[/Video]");
        $parseVideo = str_replace("watch?v=", "embed/", $parseVideo);
        
        $varTranslate = [
            "[B]" => "<b>",
            "[/B]" => "</b>",
            "[i]" => "<i>",
            "[/i]" => "</i>",
            "[u]" => "<u>",
            "[/u]" => "</u>",
            "[Str]" => "<strike>",
            "[/Str]" => "</strike>",
            "[Small]" => "<small>",
            "[/Small]" => "</small>",
            "[Big]" => "<big>",
            "[/Big]" => "</big>",
            "[cUrl]" => "<a href='$parseCommUrl'>",
            "[/cUrl]" => "</a>",
            "[/Url]" => "</a>",
            "[Qt]" => "<div class=\"quote\"><div style=\"font-size: 10px; margin-bottom: .5em; text-shadow: none;\">Cituji:</div>",
            "[/Qt]" => "</div>",
            "[Code]"=>"<div class=\"eTcode\">",
            "[/Code]"=>"</div>",   
            "/*"=>"<div class=\"eTcode_comment\">/*",
            "*/"=>"*/</div>",      
            "[/Img]" => "",
            "[Hidden]" => "<details class=\"esHidden\"><summary class=\"esHiddenSum\"><i class=\"fa fa-eye esHiddenEye\"></i> Zobrazit skrytý blok</summary><div style=\"margin-top: 1.5em;\">",
            "[/Hidden]" => "</div></details>",
            "[*/Color]" => "</span>",
            "[Video]" => "<iframe width=\"100%\" height=\"315\" src=\"$parseVideo\" allow=\"accelerometer; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen>",
            "[/Video]" => "</iframe>",
            "[Li]" => "<li>",
            "[/Li]" => "</li>",
            "[Ul circle]" => "<ul class='et_ul' style=\"list-style-type:circle; line-height: 80%;\">",
            "[Ul square]" => "<ul class='et_ul' style=\"list-style-type:square; line-height: 80%;\">",
            "[Ul disc]" => "<ul class='et_ul' style=\"list-style-type:disc; line-height: 80%;\">",
            "[Ul decimal]" => "<ul class='et_ul' style=\"list-style-type:decimal; line-height: 80%;\">",
            "[/Ul]" => "</ul>",
            "[/Li]" => "</li>",
            
            //Headers
            "[H1]" => "<h1>",
            "[/H1]" => "</h1>",
            "[H2]" => "<h2>",
            "[/H2]" => "</h2>",
            "[H3]" => "<h3>",
            "[/H3]" => "</h3>",
            "[H4]" => "<h4>",
            "[/H4]" => "</h4>",
            "[H5]" => "<h5>",
            "[/H5]" => "</h5>",
            "[H6]" => "<h6>",
            "[/H6]" => "</h6>",
            
            //Text Align
            "[Text-Left]" => "<span style=\"text-align: left;\">",
            "[/Text-Left]" => "</span>",
            "[Text-Center]" => "<center>",
            "[/Text-Center]" => "</center>",
            "[Text-Right]" => "<span style=\"text-align: right;\">",
            "[/Text-Right]" => "</span>",
            "[Text-Justify]" => "<span style=\"text-align: justify;\">",
            "[/Text-Justify]" => "</span>",       
            
           //In Codes
           "true" => "<span style=\"color: aqua;\">true</span>",
           "false" => "<span style=\"color: aqua;\">false</span>",
            
            //Styles
            "[Style-geo_margin5]" => "<div style=\"margin: .5em;\">",
            "[Style-geo_margin1]" => "<div style=\"margin: 1em;\">",
            "[Style-geo_pr_margin5]" => "<div style=\"margin: 5%;\">",
            "[Style-blue]" => "<div class=\"es_style_blue\">",
            "[Style-orange]" => "<div class=\"es_style_orange\">",
            "[Style-green]" => "<div class=\"es_style_green\">",
            "[Style-red]" => "<div class=\"es_style_red\">",
            "[Style-dotted]" => "<div class=\"es_style_dotted\">",
            "[Style-headertext1]" => "<div class=\"es_style_headertext1\">",
            "[Style-tableblue]" => "<div class=\"es_style_tableblue\">",
            "[Style-tablepink]" => "<div class=\"es_style_tablepink\">",
            "[Style-designgreen]" => "<div class=\"es_style_designgreen\">",
            "[Style-designblack]" => "<div class=\"es_style_designblack\">",
            "[Style-black]" => "<div class=\"es_style_black\">",
            "[/Style]" => "</div>",
           
        ];
        
        $translateContent = strtr($content, $varTranslate);
        return $translateContent;
    }
    
    protected function translateImages($string)
    {
        $countImgBlocks = substr_count($string, "[Img]");
        $workedString = $string;
        $returnArray = [];
        $parseImg = [];
        for($i=0; $i < $countImgBlocks; $i++)
        {    
            $parseImg[$i] = $this->get_string_bettwen($workedString, "[Img]", "[/Img]");  
            $removeImg = str_replace("[Img]".$parseImg[$i]."[/Img]", "", $workedString);
            $workedString = $removeImg;
            $returnArray[$i] = array($parseImg[$i]);
        }
        return $returnArray;
    }
    
    protected function translateColor($string)
    {
        $countTextBlocks = substr_count($string, "[*/Color]");
        $workedString = $string;
        $returnArray = [];
        $parseText = [];
        
        for($i=0; $i < $countTextBlocks; $i++)
        {    
            $parseText[$i] = $this->get_string_bettwen($workedString, "[*", "*]");  
            $removeText = str_replace(array("[*".$parseText[$i]."*]", "[*/Color]"), "", $workedString);
            $workedString = $removeText;
            $returnArray[$i] = array($parseText[$i]);
        }
        return $returnArray;
    }
    
        protected function translateFont($string)
    {
        $countTextBlocks = substr_count($string, "[FONT-");
        $workedString = $string;
        $returnArray = [];
        $parseText = [];
        
        for($i=0; $i < $countTextBlocks; $i++)
        {    
            $parseText[$i] = $this->get_string_bettwen($workedString, "[FONT-", "]");  
            $removeText = str_replace(array("[FONT-".$parseText[$i]."]"), "", $workedString);
            $workedString = $removeText;
            $returnArray[$i] = array($parseText[$i]);
        }
        return $returnArray;
    }
    
    protected function translateHref($string)
    {
        $countTextBlocks = substr_count($string, "[Url]");
        $workedString = $string;
        $returnArray = [];
        $parseText = [];
        
        for($i=0; $i < $countTextBlocks; $i++)
        {    
            $parseText[$i] = $this->get_string_bettwen($workedString, "[Url]", "[/Url]");  
            $removeText = str_replace(array("[Url]".$parseText[$i]."[/Url]"), "", $workedString);
            $workedString = $removeText;
            $returnArray[$i] = array($parseText[$i]);
        }
        return $returnArray;
    }
    
    /**
     * 
     * PRIVATE: get_string_bettwen($string, $start, $end)
     * 
     * @param string $string -> get string betwen $start - $end
     * @param type $start -> first position of cutted string
     * @param type $end -> last position of cutted string
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
        $smilePath = "../web/img/icon/emoji";
        $smileTranslate = [
            ":)" => "<img title=\":)\" class=\"easyText_emoji\" src=\"$smilePath/smile.svg\">",
            ":(" => "<img title=\":(\" class=\"easyText_emoji\" src=\"$smilePath/sad.svg\">",
            ";/" => "<img title=\";/\" class=\"easyText_emoji\" src=\"$smilePath/gloomy.svg\">",
            ":D" => "<img title=\":D\" class=\"easyText_emoji\" src=\"$smilePath/happy.svg\">",
            ":O" => "<img title=\":O\" class=\"easyText_emoji\" src=\"$smilePath/wonder.svg\">",
            ";D" => "<img title=\";D\" class=\"easyText_emoji\" src=\"$smilePath/smile_crying.svg\">",
            ":P" => "<img title=\":P\" class=\"easyText_emoji\" src=\"$smilePath/tong.svg\">",
            ";)" => "<img title=\";)\" class=\"easyText_emoji\" src=\"$smilePath/flirt.svg\">",
            ":*" => "<img title=\":*\" class=\"easyText_emoji\" src=\"$smilePath/loving.svg\">",
            ";*" => "<img title=\";*\" class=\"easyText_emoji\" src=\"$smilePath/snd_heart.svg\">",
            "3:(" => "<img title=\"3:(\" class=\"easyText_emoji\" src=\"$smilePath/angry.svg\">",
            "3:D" => "<img title=\"3:D\" class=\"easyText_emoji\" src=\"$smilePath/dvl_smile.svg\">",
            "**frog**" => "<img title=\"**frog**\" class=\"easyText_emoji\" src=\"$smilePath/frog.svg\">",
            "<3" => "<img title=\"<3\" class=\"easyText_emoji\" src=\"$smilePath/love.svg\">",
            "**y**" => "<img title=\"**y**\" class=\"easyText_emoji\" src=\"$smilePath/like.svg\">",
            "**clown**" => "<img title=\"**clown**\" class=\"easyText_emoji\" src=\"$smilePath/clown.svg\">",
            "**ill**" => "<img title=\"**ill**\" class=\"easyText_emoji\" src=\"$smilePath/ill.svg\">",
            "**music**" => "<img title=\"**music**\" class=\"easyText_emoji\" src=\"$smilePath/music.svg\">",
            "**sick**" => "<img title=\"**sick**\" class=\"easyText_emoji\" src=\"$smilePath/sick.svg\">",
            "**gem**" => "<img title=\"**gem**\" class=\"easyText_emoji\" src=\"$smilePath/gem.svg\">",
            "**pan**" => "<img title=\"**gem**\" class=\"easyText_emoji\" src=\"$smilePath/pan.svg\">",
            "**grenade**" => "<img title=\"**gem**\" class=\"easyText_emoji\" src=\"$smilePath/grenade.svg\">",
        ];
        
        return $smileTranslate;
    }
    
    public function shortText($string, $valueCut = 500)
    {
		$getString = str_replace(array("[Text-Center]","[/Text-Center]"), "", $string);
		$valueCutNumber = $valueCut;
		if(strlen($getString) > $valueCutNumber) 
		{
			$returnCuttedString = substr($getString, 0, $valueCutNumber)."...";
		}else
                {
                    $returnCuttedString = $getString;
                }
		return $returnCuttedString;
                
    }
}
