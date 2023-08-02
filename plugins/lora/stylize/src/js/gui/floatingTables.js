class GUIFLOATTABLES
{
    constructor()
    {
        Application.writeLog("GUIFloatTables module loaded");
    }
    
    /**
     * Creating floating table element under object: event_object
     * 
     * @param {String} content <p>HTML content to draw into floating table</p>
     * @param {Element} event_object <p>Targeted object (on event OnClick, onMouseOver etc ..)</p>
     * @param {Callback} callback   <p>Callback on draw table</p>
     * @param {Array} options       <p>Posible options: theme='light',minwidth='4em',minheight='10em',classes='pd-2',offsetx='0',offsety='35'</p>
     * @param {String} table_name   <p>ID of new created table (default: testable)</p>
     * @returns {HTML Element}
     */
    tableFloat(content, event_object = $(this), callback = null, options = null, table_name ="testable")
    {
        var theme = "light";
        var width = "4em";
        var height = "10em";
        var classes = "pd-2";
        var offsetX = 0;
        var offsetY = 35;

        if(options !== null)
        {
            for (const [key, value] of Object.entries(options)) 
            {
                switch(`${key}`)
                {                    
                    case "theme":
                        theme = `${value}`;
                        break;

                    case "minwidth":
                        width = `${value}`;
                        break;

                    case "minheight":
                        height = `${value}`;
                        break;

                    case "classes":
                        classes = `${value}`;
                        break;

                    case "offsetx":
                        offsetX = `${value}`;
                        break;

                    case "offsety":
                        offsetY = `${value}`;
                        break;
                }
            }
        }

        var objectPosX = $(event_object).position().left;
        var objectPosY = $(event_object).position().top;

        var tablePosX;
        
        if(offsetX < 0)
        {
            tablePosX = Math.round(objectPosX)-(offsetX*-1);
        }
        else if(offsetX > 0)
        {
            var rounded = Math.round(objectPosX);
            tablePosX = ((rounded*1) + (offsetX*1));
        }
        else
        {
            tablePosX = objectPosX*1;
        }
        
        var tablePosY;
        if(offsetY < 0)
        {
            tablePosY = Math.round(objectPosY)-(offsetY*-1);
        }
        else if(offsetY > 0)
        {
            var rounded = Math.round(objectPosY);
            tablePosY = ((rounded*1) + (offsetY*1));
        }
        else
        {
            tablePosY = objectPosY*1;
        }


        var table = "\
                <div onMouseLeave='$(this).remove()' id='"+table_name+"' class='background-"+theme+"-2 bd-round-2 bd-"+theme+"-1 "+classes+"' style='z-index: auto; position: absolute; left: "+tablePosX+"px; top: "+tablePosY+"px; min-width: "+width+"; min-height: "+height+"'>"+
                         content   
                "</div>";

        if($("#"+table_name).is(":visible"))
        {
            $("#"+table_name).remove();
        }
        else
        {
            $("body").prepend(table);
        }

        if(callback != null)
        {
            callback();
        }
        
        $(event_object).on('click', () => {
            $("#"+table_name).remove();
        });

    }
    
}
