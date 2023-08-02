function setToCenterOfParent(element, parent, ignoreWidth = false, ignoreHeight = false){
        parentWidth = $(parent).width();
        parentHeight = $(parent).height();  
        
        elementWidth = $(element).width();
        elementHeight = $(element).height();
        
        if(!ignoreWidth)
            $(element).css('left', parentWidth/2 - elementWidth/2);
        if(!ignoreHeight)
            $(element).css('top', parentHeight/2 - elementHeight/2);
    }
