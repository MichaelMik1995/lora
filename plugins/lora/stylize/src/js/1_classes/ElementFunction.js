class ElementFunction
{
    constructor()
    {
        Application.writeLog("Function module Loaded");
    }
    
    /**
     * 
     * @param {Element} element
     * @param {Element} parent_element
     * @param {String} type
     * @returns {CSS}
     */
    alignCenter(element, parent, type="both")
    {
        //Element geometry
        var elementWidth = $(element).width();
        var elementHeight = $(element).height();
        
        //parent geometry
        var parentWidth = $(parent).width();
        var parentHeight = $(parent).height();
        
        var marginVertical = (parentHeight-elementHeight)/2;
        
        switch(type)
        {
            case "both":
                $(element).css({marginTop: marginVertical+"px", marginBottom: marginVertical+"px", textAlign: "center"});
                break;
        }
        
        console.log(parentHeight+"-"+elementHeight);
    }
    
    imgAlt(alt_image_url, img_element = $(this))
    {
        var image_element_src = $(img_element).attr('src'); //
        
        $.ajax({
            url: image_element_src,
            type: 'HEAD',
            error: function () {
                //file not exists
                $(img_element).attr('src', alt_image_url);

            },
            success: function () 
            {
                //file exists
            }
        });
    }
}


