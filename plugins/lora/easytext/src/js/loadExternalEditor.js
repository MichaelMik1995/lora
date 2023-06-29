/**
 * 
 * @param {String} name
 * @param {Element} content
 * @param {Element} target_input
 * @param {Array} options
 * @param {Callback} callback
 * @param {Object} variables
 * @returns {undefined}
 */
function easyTextExternal(content, target_input, callback = null, variables = null)
{
    var theme = "dark";
    var dialog_width = "width-100";
    
    if(variables != null)
    {
        for (const [key, value] of Object.entries(variables)) 
        {
            switch(`${key}`)
            {                    
                case "theme":
                    theme = `${value}`;
                    break;
                
                case "width":
                    dialog_width = `${value}`;
                    break;

            }
        }
    }

    var dialog_classes = dialog_width+" stylize-dialog-panel width-100-sm mg-auto mgy-3 mgy-1-sm height-100-sm bd-round-3 background-"+theme+"-2 content-center bd-2 bd-solid bd-"+theme+"-1";
    var dialog_element = "\
        <div id='es_dialog' class='display-0 stylize-dialog-info pdy-5'>"+
            "<div class='"+dialog_classes+"'>"+
                "<div id='es_info_handler' class='row cursor-move pd-1 pdy-2 header-6 content-left t-bolder'>"+
                    "<div class='column-6'>EasyText Editor: </div>"+
                    "<div class='column content-right'><button id='es_dialog_close' class='button-small button-basic mgx-1 bd-round-1'><i class='fa fa-xmark'></i></button></div>"+ 
                "</div><hr>"+
                "<div id='external_dialog_content' class='background-"+theme+"-3'></div>"+
                "<div class='content-right content-center-sm pd-1 pdy-2'>"+
                "<button type='submit' class='button button-basic'>Vložit</button>"+
                "</div>"+
            "</div>"+
        +"</div>";

    $("body").append(dialog_element).delay(200);
    
    $("#external_dialog_content").load("./plugins/lora/easytext/template/form_external.html", function() 
    {   
        if($(content).attr("type") === "text")
        {
            var cnt = $(content).val();
        }
        else
        {
            var cnt = $(content).text();
        }

        var trimmed = cnt.trim();
        $("#ex_content").val(trimmed);
        $("#es_dialog").fadeIn("slow");

        $("#es_dialog").draggable({handle: "#es_info_handler"});

        $("#es_dialog [type='submit']").click(function(){
            var text_content = $("#ex_content").val();

            if($(target_input).attr("type") === "text")
            {
                $(target_input).val("").val(text_content);
            }
            else
            {
                $(target_input).html("").html(text_content);
            }

            $("#es_dialog").fadeOut("slow", function() { $(this).remove();});
            if(callback !== null)
            {
                callback();
            }
        });

        $("#es_dialog_close").click(function(){
            $("#es_dialog").fadeOut("slow", function() { $(this).remove();});
        });
    });
}

