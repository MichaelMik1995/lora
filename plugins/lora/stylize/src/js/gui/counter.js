/**
 * Description of counter stylize javascript class module
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class counter
{
    constructor()
    {
        Application.writeLog("counter module loaded");
    }
    
    /**
     * 
     * @param {String} area_element Element for counting chars (textarea, input etc..)
     * @param {String} count_view_element   element for printing count chars
     * @param {Integer} max_chars   max allowed chars for area_element
     * @param {String} error_element    element for catching errors
     * @returns {Event}
     */
    counterChars(area_element, count_view_element, max_chars = 256, error_element = "#after-counter")
    {
        var value = $(area_element).val();
        var val_length = value.length;
        
        $(count_view_element).text(val_length);
        if(val_length > max_chars)
        {
            $(area_element).addClass("bd-bottom-error");
            
            if(!($("#counter-error-text").length))
            {
                $(error_element).html("<span id='counter-error-text' class='t-error'>Text nesmí přesáhnout limit!</span>");
            }
        }
        else
        {
            $(area_element).removeClass("bd-bottom-error");
            $("#counter-error-text").remove();
        }
        
    }
}


