class DialogImage
{
    constructor()
    {
        this.image_path;
    }
    
    dropImage()
    {
        
    }
    
    getImageInfo()
    {
        
    }
    
    openSlider(image_element)
    {
        var imageSrc = $(image_element).attr("src");
        var open_image = imageSrc.replace("/thumb","");
        
        //Get Resolution PC
        var resX = $(window.top).width();
        var resY = $(window.top).height();
        
        image_element.hover(function()
        {
            $(this).css({"opacity":"0.5", "cursor":"pointer"});
        }, function(){
            $(this).css({"opacity":"1", "cursor":"default"});
        });
        
        var createDiv = "<div id=\"eS_imageViewer\" class=\"eS_imageViewer\"></div>";
        
        
        var imageViewerHeader = "\
                <div class=\"row background-basic pd-2\">"+
                "<div class='column'>"
                +open_image+
                "</div>"+
                "<div class='column content-right'>"+
                
                    "<button id='eS_close' class='button button-error'><i class='fa fa-window-close'></i></button>"+
                 "</div>"+
                "</div>";
        
        var image_size;
        
        if(resX > resY)
        {
            image_size = "width-auto height-90";
        }
        else
        {
           image_size = "height-auto width-90";
        }
        
        var image = "<div class='width-100 content-center'><img style='z-index: 99;' rel=\"easySlider\" id=\"image_es\" class='display-flex als-center "+image_size+"' src=\""+open_image+"\"></div>"; 
        
        
        
        $("html").prepend(createDiv).delay(300);
        $("#eS_imageViewer").fadeIn(400);
        $("#eS_imageViewer").html(imageViewerHeader+image);
        
        $("#eS_close").click(function()
        {
            $("#eS_imageViewer").fadeOut(400).delay(100).html();
        });
    }
    
}


