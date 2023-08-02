class GUIDIALOG
{
    constructor()
    {
        Application.writeLog("GUIDialog module Loaded");
    }
    
    /**
     * 
     * @param {string} string
     * @param {array} variables
     * @returns {Boolean}
     */
    dialogInfo(string, variables = null)
    {   
        this.generateDialog(string+"<div class='mgy-2'><button id='dialog_ok' class='button button-basic'>OK</button></div>", "Informace", variables);
        $("#dialog_ok").click(function(){
           $("#dialog_close").trigger("click"); 
        });
        return 1;
    }

    /**
     * Open confirm dialog = if user confirms -> do callback() else only hide dialog
     * @param string string
     * @param function callback
     * @param array variables [confirm_text, noconfirm_text]
     * @returns callback|null
     */
    dialogConfirm(string, callback = null, variables = null)
    {
        var confirm_button_text = "OK";
        var no_confirm_button_text = "Zavřít";

        if(variables !== null)
        {
            for (const [key, value] of Object.entries(variables)) 
            {
                switch(`${key}`)
                {                    
                    case "confirm_text":
                        confirm_button_text = `${value}`;
                        break;

                    case "noconfirm_text":
                        no_confirm_button_text = `${value}`;
                        break;

                }
            }
        }

        var dialog_content = "<div class='pdx-1 pdy-2 header-6'>"+string+"</div><button id='dialog_confirm_close' class='button button-warning mgx-1 bd-round-1'>"+no_confirm_button_text+"</button>"+
                        "<button type='submit' id='dialog_confirm_true' class='button button-basic bd-round-1'>"+confirm_button_text+"</button>";

        this.generateDialog(dialog_content, "Vyžádáno potvrzení", variables, callback);

        $("#dialog_confirm_close").click(function()
        {
            $("#dialog_close").trigger("click");
        });
    }


    dialogAntispam(header, callback = null, variables = null)
    {      
        var result;

        if(variables !== null)
        {
            for (const [key, value] of Object.entries(variables)) 
            {
                switch(`${key}`)
                {
                    case "result":
                        result = "`${value}`";
                        break;
                }
            }
        }

        var dialog_content = "<div>"+header+"</div><div class='pdy-1 pdx-1 mgy-1'><input id='antispam_input' type='text' class='bd-basic bd-2 pd-2'><br><span id='error_text' class='display-0 t-error'></span></div>"+
                    "<div class='content-right content-center-sm pd-1 pdy-2'>"+
                        "<button id='dialog_confirm_reset' class='display-0 button button-basic mgx-1 bd-round-1'><i class='fa fa-xmark'></i> Reset</button>"+
                        "<button id='dialog_confirm_true' class='button button-basic bd-round-1'>OK</button>"+
                    "</div>";


        this.generateDialog(dialog_content, "Antispam", variables);

        $("#dialog_confirm_true").click(function()
        {
            console.log(result+$("#antispam_input").val());
            if(result === $("#antispam_input").val())
            {
                callback();
            }
            else
            {
                $("#antispam_input").addClass("bd-error t-error");
                $("#error_text").html("<i class='fa fa-triangle-exclamation'></i> Nesprávný údaj!").slideDown(200);
                $("#dialog_confirm_reset").show(200);
            }
        });

        $("#dialog_confirm_reset").click(function(){
            $("#antispam_input").removeClass("bd-error t-error").val("");
            $("#error_text").slideUp(200, function(){$("#error_text").html("")});
            $(this).hide(200);
        });
    }

    /**
     * 
     * @param {string} content
     * @param {Object} callback
     * @param {string} dialog_header
     * @param {Array} variables
     * @returns {Boolean}
     */
    dialogForm(content, callback, dialog_header = "Formulář", variables = null)
    {
            var html_content = $(content).html();
            this.generateDialog(html_content, dialog_header, variables, callback);

            return 1;
    }


    /**
     * 
     * @param {Element} content
     * @param {String} dialog_header
     * @param {Array} variables
     * @param {Function} callback
     * @returns {Dialog}
     */
    generateDialog(content, dialog_header, variables, callback)
    {

        //$("#dialog").fadeOut("slow", function() { $(this).remove()});

        //Defautl variables
        var dialog_width = "width-30"; //in percent
        var theme = "dark";

        if(variables !== null)
        {
            for (const [key, value] of Object.entries(variables)) 
            {
                switch(`${key}`)
                {
                    default: 
                        console.log("Parameter: "+`${key}`+" - not found in object");
                        break;

                    case "width":
                        dialog_width = `${value}`;
                        break;

                    case "theme":
                        if(`${value}` === "light")
                        {
                            theme = "light";
                        }
                        else
                        {
                            theme = "dark";
                        }
                        break;
                }
            }
        }

        var dialog_classes = dialog_width+" stylize-dialog-panel width-100-xsm mgy-1 bd-round-3 background-"+theme+"-2 bd-2 bd-solid bd-"+theme+"-1";
        var dialog_element = "\
            <div id='dialog' class='display-0 stylize-dialog-info pdy-10'>"+
                "<div class='"+dialog_classes+"'>"+
                    "<div id='info_handler' class='row cursor-move pd-1 pdy-2 header-6 content-left t-bolder'>"+
                        "<div class='column-6'>"+dialog_header+"</div>"+
                        "<div class='column content-right'><button id='dialog_close' class='button-small button-basic mgx-1 bd-round-1'><i class='fa fa-xmark'></i></button></div>"+ 
                    "</div><hr>"+
                    "<div class='pdy-4 pdx-1 header-6 background-"+theme+"-3'>"+content+"</div>"+
                    "<div class='content-right content-center-sm pd-1 pdy-2'>"+
                    "</div>"+
                "</div>"+
            +"</div>";

        $("body").append(dialog_element).delay(200);
        $("#dialog").fadeIn("slow");

        $("#dialog").draggable({handle: "#info_handler"});

        $("#dialog [type='submit']").click(function(){
            callback();
        });

        $("#dialog_close").click(function(){
            $("#dialog").fadeOut("slow", function() { $(this).remove();});
        });
    }

    dialogImage(path = "public/img/user/952988803/images/thumb", variables = null)
    {

        const DImage = new DialogImage(path);
        const storage = new LStorage();

        var csrfgen = storage.getCsrf();
        var theme = "light";
        var offset = "1";
        var screenWidth = $(window.top).width();
        var screenHeight = $(window.top).height();
        var image_content = "";



        var dialog_padding = $(window.top).height()/3;

        $.post("./plugins/lora/stylize/src/ajaxphp/image_gallery.php",
        {
          path: path
        },

        function(data, status)
        {
            const json_data = data;
            const object_data = JSON.parse(json_data);
            image_content = object_data.images;


            if(variables !== null)
            {
                for (const [key, value] of Object.entries(variables)) 
                {
                    switch(`${key}`)
                    {
                        default: 
                            console.log("Parameter: "+`${key}`+" - not found in object");
                            break;

                        case "width":
                            dialog_width = `${value}`;
                            break;

                        case "theme":
                            if(`${value}` === "light")
                            {
                                theme = "light";
                            }
                            else
                            {
                                theme = "dark";
                            }
                            break;
                    }
                }
            }
            //Generate Image UI
            var dialog_classes = "width-100 mg-auto bd-round-3 background-"+theme+"-2 bd-3 bd-solid bd-"+theme+"-1";
            var dialog_element = "\
                <div id='dialog' class='display-0 stylize-dialog-image pd-"+offset+"'>"+
                    "<div class='"+dialog_classes+" height-95' style='max-height: 95%; overflow: auto;'>"+
                        "<div class='row pd-1 pdy-2 header-6 content-left t-bolder'>"+
                            "<div class='column-6'>Dialog: </div>"+
                            "<div class='column content-right'><button id='dialog_close' class='button-small button-basic mgx-1 bd-round-1'><i class='fa fa-xmark'></i></button></div>"+ 
                        "</div><hr>"+
                        "<div class='row pd-1 pdx-1 background-"+theme+"-3 bd-3 bd-"+theme+"-2'>"+
                            "<div class='column-8 column-10-xsm pd-1 bd-3 bd-"+theme+"-2'>"+   //Column1 - Droppable
                                "<form class='' method='post' enctype='multipart/form-data'>"+csrfgen+"<input type='file' id='images' name='images' multiple></form>"+
                                "<div class='row pd-1 cols-5 cols-2-xsm images-view height-auto'>"+
                                    image_content+
                                "</div>"+
                            "</div>"+
                            "<div class='column-2 column-10-xsm pd-1'>"+   //Column1 - Droppable
                                "<div class='header-4'>Podrobnosti: </div><div id='image-description'></div>"+
                            "</div>"+
                        "</div><hr>"+
                        "<div id='form-add-images'>"+

                            "<button id='add-images' class='button button-basic'>Vložit Obrázky</button>"+
                        "</div>"+
                    "</div>"+

                +"</div>";

            $(".images-view").sortable(); 

            $("body").append(dialog_element).ready(function () 
            {
                //element_func.alignCenter("#image-drop", "#image-drop-div");

            });

            $(".image-thumbnail").click(function(){



                $.post("./plugins/lora/stylize/src/ajaxphp/image_description.php",
                {
                  image: $(this).attr("src")
                },
                function(data)
                {
                    const json_data_desc = data;
                    const description_data = JSON.parse(json_data_desc);
                    var description_side = "<div class='content-center'><img class='image-view' src='"+description_data.image+"' style='max-height:128px;'></div>"+
                            "<div class='width-100'>"+
                                "Velikost: "+description_data.filesize+"<br>"+
                                "Rozlišení: "+description_data.width+"x"+description_data.height+"<br>"+
                                "Rozlišení náhledu: "+description_data.thumb_width+"x"+description_data.thumb_height+"<br>"+
                            "</div>";

                    $("#image-description").html(description_side);
                    $(this).attr("src", description_data.path);
                    $(".image-view").attr("src", description_data.path);

                    $(".image-view").click(function(){
                        DImage.openSlider($(this));
                    });
                });
            }); 

            $("#dialog").fadeIn("slow");

            $("#add-images").click(function(){
                $("#form-images").submit();
            });

            $("#dialog [type='submit']").click(function(){
                callback();
            });

            $("#dialog_close").click(function(){
                $("#dialog").fadeOut("slow", function() { $(this).remove();});
            });
        });
    }
    
    dialogNotification(id, title, content)
    {
        var element_notification = "<div id='dialog-notification-"+id+"' class='row mgy-2'>"+
                "<div class='column-2'>"+
                    
                "</div>"+
                "<div class='column column-2-sm'>"+
                    
                "</div>"+
                "<div class='column-2 column-6-sm'>"+
                    "<div class='background-dark-2 bd-round-3 bd-top-basic'>"+
                        "<div class='row background-dark pd-2'>"+
                            "<div class='column-5'>"+
                                title+
                            "</div>"+
                            "<div class='column-5 content-right'>"+
                                "<i onClick=\"$('#dialog-notification-"+id+"').fadeOut(300, () => {$('#test-notification-"+id+"').remove()});\" class='fa fa-window-close'></i>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                    "<div class='pd-2 background-dark-2'>"+
                        content+
                    "</div>"+
                "</div>"+
            "</div>"+
            "<script>setTimeout(() => {$('#test-notification-"+id+"').fadeOut(300, () => {$('#test-notification-"+id+"').remove()});}, 8000)</script>";
    
            return element_notification;
    }
}
