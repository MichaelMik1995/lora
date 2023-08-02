'use strict';

class FormClass
{
    /**
     * 
     * @param {String} input_element
     * @returns {Event}
     */
    toggleTypePassword(input_element)
    {
       var type = $(input_element).attr("type");
       if(type === "text")
       {
           $(input_element).attr("type", "password");
       }
       else
       {
           $(input_element).attr("type", "text");
       }
    }
}


