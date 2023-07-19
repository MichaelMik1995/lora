/* 
 * EasyText 2019 MichaelMik9.
 *
 */

$(document).ready(function()
{    
    tabulator(".easyText_textarea");
    
    function countChar(textarea, counterSpan, length=4000)
    { 
        $("."+textarea).keyup(function()
        {
            var AreaLength = $(this).val().length;
            $("#"+counterSpan+" span").text(AreaLength);
            if($(this).val().length > length)
            {
                $("#"+counterSpan+" span").css("color","red");
            }
            if($(this).val().length <= length)
            {
                $("#"+counterSpan+" span").css("color","#BFBFBF");
            }
        });
    }
    
    /**
     * 
     * @author michaelmik <michaelmik@email.cz>
     * 
     * @param {Element} trigger         trigger for start replacing text    
     * @param {Element} area            Element where is text for replace
     * @param {string} replaceStart     Prefix for replaced text
     * @param {string} replaceEnd       Suffix for replaces text 
     * 
     * @returns {string}                return replaceStart+selected-text+replaceEnd
     */
    function replaceText(trigger, area, replaceStart, replaceEnd)
    {
        $(trigger).click(function(){
            var select = $("."+area).selection();
            return $("."+area).selection('replace', {text: replaceStart+select+replaceEnd});
        });
        
    }
    
    /**
     * 
     * @param {element} trigger         trigger for start inserting block
     * @param {element} area            Element where is text for replace
     * @param {string} block            defines block string (ex. [Br])
     * @returns {string}                returns value of textarea + block
     */
    function insertBlock(trigger, area, block)
    {
        $(trigger).click(function(){
            var textArea = $(area).val();
            return $(area).val(textArea+block);
        }); 
    }
    
    $("#dialog-handle").css("cursor", "move");
    $( "#dialogDiv" ).draggable({ handle: "#dialog-handle" });
    //$("#dialogDiv").resizable();
    
    $("#easyText-close").click(function(){
        $("#dialogDiv").hide(200);
        $(".easyText-Dialog").html("");
    });
            
    $("#easyText_view").click(function(){
        var getText = $(".easyText_textarea").val();
        
        var repl = encodeURI(getText);
        document.location = "view/preview-text/"+repl;
        
        writeCookie("es_text", repl, 3);
    });
    
/* ########################### Setting Values for functions ########################### */

    countChar("easyText_textarea","easyText_countChars"); // CountChars for post
    countChar("easyText_textarea","easyText_countChars_256", 256);
    countChar("easyText_textarea","easyText_countChars_400", 400); 
    countChar("easyText_textarea","easyText_countChars_512", 512);
    countChar("easyText_textarea","easyText_countChars_999", 999); 
    countChar("easyText_textarea","easyText_countChars_1024", 1024);
    countChar("easyText_textarea","easyText_countChars_1600", 1600); 
    countChar("easyText_textarea","easyText_countChars_2048", 2048); 
    countChar("easyText_textarea","easyText_countChars_3000", 3000); 
    countChar("easyText_textarea","easyText_countChars_4000", 4000); 
    countChar("easyText_textarea","easyText_countChars_9000", 9000); 
    countChar("easyText_textarea","easyText_countChars_9999", 9999);
    
    
    replaceText("#easyText_bold", "easyText_textarea", "[B]","[/B]");
    replaceText("#easyText_italic", "easyText_textarea", "[i]","[/i]");
    replaceText("#easyText_underline", "easyText_textarea", "[u]","[/u]");
    replaceText("#easyText_strike", "easyText_textarea", "[Str]","[/Str]");
    replaceText("#easyText_big", "easyText_textarea", "[Big]","[/Big]");
    replaceText("#easyText_small", "easyText_textarea", "[Small]","[/Small]");
    replaceText("#easyText_url", "easyText_textarea", "[Url]","[/Url]");
    replaceText("#easyText_quotes", "easyText_textarea", "[Qt]","[/Qt]");
    replaceText("#easyText_code", "easyText_textarea", "[Code]","[/Code]");
    replaceText("#easyText_video", "easyText_textarea", "[Video]","[/Video]");
    replaceText("#easyText_hiddenblock", "easyText_textarea", "[Hidden]","[/Hidden]");
    
    loadDialog("easyText_color", "colorChooser");
    loadDialog("easyText_grid", "grid");
    loadDialog("easyText_image", "image");
    loadDialog("easyText_comm_image", "comm_image");
    loadDialog("easyText_smile", "emoticons");
    loadDialog("easyText_header", "header");
    loadDialog("easyText_align", "align");
    loadDialog("easyText_templates", "templates");
    loadDialog("easyText_div_styles", "styles");
    loadDialog("easyText_fontawe", "fontawe");
    loadDialog("easyText_rows", "list_ul");
    
    /* ########################### Setting Values to external functions ########################### */

    countChar("ex_easyText_textarea","ex_easyText_countChars"); // CountChars for post
    countChar("ex_easyText_textarea","ex_easyText_countChars_256", 256);
    countChar("ex_easyText_textarea","ex_easyText_countChars_400", 400); 
    countChar("ex_easyText_textarea","ex_easyText_countChars_512", 512);
    countChar("ex_easyText_textarea","ex_easyText_countChars_999", 999); 
    countChar("ex_easyText_textarea","ex_easyText_countChars_1024", 1024);
    countChar("ex_easyText_textarea","ex_easyText_countChars_1600", 1600); 
    countChar("ex_easyText_textarea","ex_easyText_countChars_2048", 2048); 
    countChar("ex_easyText_textarea","ex_easyText_countChars_3000", 3000); 
    countChar("ex_easyText_textarea","ex_easyText_countChars_4000", 4000); 
    countChar("ex_easyText_textarea","ex_easyText_countChars_9000", 9000); 
    countChar("ex_easyText_textarea","ex_easyText_countChars_9999", 9999);
    
    
    replaceText("#ex_easyText_bold", "ex_easyText_textarea", "[B]","[/B]");
    replaceText("#ex_easyText_italic", "ex_easyText_textarea", "[i]","[/i]");
    replaceText("#ex_easyText_underline", "ex_easyText_textarea", "[u]","[/u]");
    replaceText("#ex_easyText_strike", "ex_easyText_textarea", "[Str]","[/Str]");
    replaceText("#ex_easyText_big", "ex_easyText_textarea", "[Big]","[/Big]");
    replaceText("#ex_easyText_small", "ex_easyText_textarea", "[Small]","[/Small]");
    replaceText("#ex_easyText_url", "ex_easyText_textarea", "[Url]","[/Url]");
    replaceText("#ex_easyText_quotes", "ex_easyText_textarea", "[Qt]","[/Qt]");
    replaceText("#ex_easyText_code", "ex_easyText_textarea", "[Code]","[/Code]");
    replaceText("#ex_easyText_video", "ex_easyText_textarea", "[Video]","[/Video]");
    replaceText("#ex_easyText_hiddenblock", "ex_easyText_textarea", "[Hidden]","[/Hidden]");
    
    loadDialog("ex_easyText_color", "colorChooser", "ex_");
    loadDialog("ex_easyText_grid", "grid", "ex_");
    loadDialog("ex_easyText_image", "image", "ex_");
    loadDialog("ex_easyText_comm_image", "comm_image", "ex_");
    loadDialog("ex_easyText_smile", "emoticons", "ex_");
    loadDialog("ex_easyText_header", "header", "ex_");
    loadDialog("ex_easyText_align", "align", "ex_");
    loadDialog("ex_easyText_div_styles", "styles", "ex_");
    loadDialog("ex_easyText_fontawe", "fontawe", "ex_");
    loadDialog("ex_easyText_rows", "list_ul", "ex_");
    
});



