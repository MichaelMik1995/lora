$(document).ready(function(){
    var imageRel = $("*[rel='easySlider']");
    //var marginHorisontal = 1;
    //var marginVertical = 1;
    
    //Get Resolution PC
    var resX = $(this).width();
    var resY = $(this).height();
    
    //var getPositionX = parseInt(resX/100*marginHorisontal); //in px
    //var getPositionY = parseInt(resY/100*marginVertical); //in px
    
    //On image hover
    imageRel.hover(function()
    {
        $(this).css({"opacity":"0.5", "cursor":"pointer"});
    }, function(){
        $(this).css({"opacity":"1", "cursor":"default"});
    });
    
    //var padding = "style=\"padding: "+getPositionY+"px "+getPositionX+"px "+getPositionY+"px "+getPositionX+"px\"";
    //var createDiv = "<div id=\"eS_imageViewer\" class=\"eS_imageViewer\"></div>";
    
    //On image Click
    imageRel.click(function()
    {
        var createDiv = "<div id=\"eS_imageViewer\" class=\"eS_imageViewer\"></div>";
        
        var imageSrc = $(this).attr("src");
        var open_image = imageSrc.replace("/thumb","");
        
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
            image_size = "width-auto height-100";
        }
        else
        {
           image_size = "height-auto";
        }
        
        var image = "<div class='width-100 content-center'><img style='z-index: 99;' rel=\"easySlider\" id=\"image_es\" class='display-flex als-center "+image_size+"' src=\""+open_image+"\"></div>"; 
        
        
        
        $("html").prepend(createDiv).delay(300);
        $("#eS_imageViewer").fadeIn(400);
        $("#eS_imageViewer").html(imageViewerHeader+image);
        
        $("#eS_close").click(function()
        {
            $("#eS_imageViewer").fadeOut(400).delay(100).html();
        });
    });
});

