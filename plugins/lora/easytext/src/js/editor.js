$(document).ready(() => {
    console.log("Plugin module editor.js loaded");
});


function easyText(element_to_replace, content="TEXT", options = null, callback = null)
{
    
    var element = $(element_to_replace);
    
    //If element exists!
    if(element.length)
    {
        console.log("EASYTEXT: TRUE: creating a new easytext form from existing element [ "+element_to_replace+"]");
        var container_id = Math.floor(Math.random() * 999999) + 111111;
        var temp_div = "<div id='temp_"+container_id+"' class='display-0'></div>";
        $("body").append(temp_div);
        
        var temp_div = $("#temp_"+container_id);
        temp_div.load("./plugins/lora/easytext/template/form.template", () => 
        {
             //replace {}
            var html_temp = temp_div.html();

            var width = "width-100";
            var height = "height-256p";
            var max_chars = 4000;
            var button_text = "<i class='fa fa-save'></i>  Odeslat";
            var button_override_classes = "";
            var area_placeholder = "Aa...";
            var required = true;
            var theme = "dark";
            
            
            //Generate options
            if(options !== null)
            {
                for (const [key, value] of Object.entries(options)) 
                {
                    switch(`${key}`)
                    {                    
                        case "width":
                            width = `${value}`;
                            break;

                        case "height":
                            height = `${value}`;
                            break;
                            
                        case "maxchars":
                            max_chars = `${value}`;
                            break;
                            
                        case "buttontext":
                            button_text = `${value}`;
                            break;
                            
                        case "buttonclasses":
                            button_override_classes = `${value}`;
                            break;
                            
                        case "placeholder":
                            area_placeholder = `${value}`;
                            break;
                            
                        case "required":
                            required = `${value}`;
                            break;
                            
                        case "theme":
                            theme = `${value}`;
                            break;

                    }
                }
            }
            
            //Define theme
            var container_color = "dark-3";
            var button_panel_color = "dark";
            var button_panel_text = "light";
            var secondary_color = "dark";
            var secondary_text = "info";
            
            var content_background = "none";
            var content_text = "";
            
            if(theme === "light")
            {
                container_color = "light";
                button_panel_color = "light-3";
                button_panel_text = "dark";
                secondary_color = "light-2";
                secondary_text = "info";

                content_background = "light-2";
                content_text = "dark";
            }
            
            //Compile and prepare content for fill
            html_temp = mreplace(html_temp, "{textarea_content}", content);
            html_temp = mreplace(html_temp, "{container_id}", container_id);
            html_temp = mreplace(html_temp, "{max_chars}", max_chars);
            html_temp = mreplace(html_temp, "{width}", width);
            html_temp = mreplace(html_temp, "{content_text}", content_text);
            html_temp = mreplace(html_temp, "{height}", height);
            html_temp = mreplace(html_temp, "{placeholder}", area_placeholder);
            html_temp = mreplace(html_temp, "{button_override_classes}", button_override_classes);
            html_temp = mreplace(html_temp, "{content}", content);
            html_temp = mreplace(html_temp, "{required}", required);
                //Theme
            html_temp = mreplace(html_temp, "{container_color}", container_color);
            html_temp = mreplace(html_temp, "{button_panel_color}", button_panel_color);
            html_temp = mreplace(html_temp, "{button_panel_text}", button_panel_text);
            html_temp = mreplace(html_temp, "{secondary_color}", secondary_color);
            html_temp = mreplace(html_temp, "{secondary_text}", secondary_text);
            html_temp = mreplace(html_temp, "{content_background}", content_background);
            html_temp = mreplace(html_temp, "{button_text}", button_text);

            //Fill content to element DIV
            element.html(html_temp);
            
            //#### Generated EASYTEXT form
            //Set tabulator
            

            try 
            {
                $(".area-"+container_id).on('keydown', function(e) {
                if (e.key === 'Tab') {
                  e.preventDefault();
                  document.execCommand('insertText', false, '\t');
                }
              });
            } catch (error) {
              console.error(error);
            }
            
            
            temp_div = $("#temp_"+container_id).remove();
           
            //replaceSelectedText(container_id, "easytext-b-bold", "<b>","</b>");
            /*replaceText("#ex_easyText_italic", "ex_easyText_textarea", "[i]","[/i]");
            replaceText("#ex_easyText_underline", "ex_easyText_textarea", "[u]","[/u]");
            replaceText("#ex_easyText_strike", "ex_easyText_textarea", "[Str]","[/Str]");
            replaceText("#ex_easyText_big", "ex_easyText_textarea", "[Big]","[/Big]");
            replaceText("#ex_easyText_small", "ex_easyText_textarea", "[Small]","[/Small]");
            replaceText("#ex_easyText_url", "ex_easyText_textarea", "[Url]","[/Url]");
            replaceText("#ex_easyText_quotes", "ex_easyText_textarea", "[Qt]","[/Qt]");
            replaceText("#ex_easyText_code", "ex_easyText_textarea", "[Code]","[/Code]");
            replaceText("#ex_easyText_video", "ex_easyText_textarea", "[Video]","[/Video]");
            replaceText("#ex_easyText_hiddenblock", "ex_easyText_textarea", "[Hidden]","[/Hidden]");*/
            
            
            
        // ## End of .LOAD

        $(document).ready(() => 
        {
            //Bold Text
            $("div[area-id="+container_id+"]").find("#easytext-b-bold").click(function(e)
            {
                e.preventDefault();
                bbrep(container_id, "<b>", "</b>");
            });

            //Italic
            $("div[area-id="+container_id+"]").find("#easytext-b-italic").click(function(e)
            {
                e.preventDefault();
                bbrep(container_id, "<i>", "</i>");
            });

        });
        });
        

        
        
       
        
        console.log("EASYTEXT: TRUE: Building completed!");
        if(callback != null)
        {
            callback();
        }
        
    }
    else
    {
        console.log("EASYTEXT: FALSE: Cannot create new easytext form from non existing element! [! "+element_to_replace+"]");
    }
}

