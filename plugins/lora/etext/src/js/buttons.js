class editorButtons
{
    constructor()
    {

    }

    focusOnEditor()
    {
        enableEditing(this.editor_id);
    }
    
    /* ################################# BUTTONS ################################# */

    /**
     * 
     * @param {String} button_id 
     */
    buttonBold(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            //this.insertBlock("t-bolder", "span", "class");
            document.execCommand("bold");

            
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonItalic(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            //this.insertBlock("t-italic", "span", "class");
            document.execCommand("italic");
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonStrike(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            //this.insertBlock("<span class='t-striked'>","</span>");
            //this.insertBlock("[i]","[/i]");
            document.execCommand("strikeThrough");
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonUnderline(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            //this.insertBlock("t-striked", "span", "class");
            document.execCommand("underline");
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonLink(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.on("click", () => {
            
            this.focusOnEditor();
            var linkElement = $('<a/>', {
                'text': document.getSelection()
            }).addClass("t-italic t-basic t-underline").attr('href', document.getSelection()).attr('target', '_blank').prop('outerHTML');

            // TODO:
            document.execCommand("insertHTML", false, linkElement);
            
        });
    }

        /**
     * 
     * @param {String} button_id 
     */
        buttonChangeColor(button_id)
        {
            //var buttons = $(".etext-color");
            var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
    

            button.siblings("#dialog-text-color-input").change(() => {
                button.trigger("click");
            });

            button.on("click", () => {
                this.focusOnEditor();
                var color_hex = button.siblings("#dialog-text-color-input").val(); //#bfbfbf
                document.execCommand('foreColor', false, color_hex);
            });
        }
    
        /**
         * 
         * @param {String} button_id 
         */
        buttonChangeBackgroundColor(button_id)
        {
            //var buttons = $(".etext-color");
            var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
    
            button.siblings("#dialog-text-bcolor-input").change(() => {
                button.trigger("click");
            });

            button.on("click", () => {
                this.focusOnEditor();
                var color_hex = button.siblings("#dialog-text-bcolor-input").val(); //#bfbfbf
                document.execCommand('backColor', false, color_hex);
                
            });
        }

    /**
     * 
     * @param {String} button_id 
     */
    buttonList(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");

        button.on("click", () => {
            var listStyle = button.siblings("#etext-list-selector");
            var splitList = listStyle.val().split(":");
            
            var parent;
            if (splitList[0] === "ul") {
                parent = "ul";
            } else {
                parent = "ol";
            }
    
            var ul = document.createElement(parent);
            var li = document.createElement("li");
            ul.appendChild(li);
    
            ul.style.listStyleType = splitList[1];
    
            var range = window.getSelection().getRangeAt(0);
            range.deleteContents();
            range.insertNode(ul);
    
            // Posunout kurzor k první položce
            var newRange = document.createRange();
            newRange.setStart(li, 0);
            newRange.collapse(true);
            var selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(newRange);
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonImage(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");

        button.on("click", () => {
            //this.focusOnEditor();
            //var img = "<img class='width-"+ $("#etext-image-data-scale").val() +"' src='" + $("#image-url-input").val() + "'>";
            var imageElement = $('<img>', {
                'src': button.siblings("#image-url-input").val()
            }).addClass("width-"+button.siblings("#etext-image-data-scale").val()).prop('outerHTML');
            document.execCommand('insertHTML', false, imageElement);
            
            $("#dialog-"+this.editor_id).hide();
            this.updateResult(this.editor_id);
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonTextSize(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.on("click", () => {

            
            var class_header = button.siblings("#etext-resize-text-input").val();

            var splitter = class_header.split("-");
            this.focusOnEditor($(event.currentTarget));

            // TODO:
            if(splitter[0] === "header")
            {
                var spanString = $('<span/>', {
                    'text': document.getSelection()
                }).addClass('header-'+splitter[1]).prop('outerHTML');

                document.execCommand('insertHTML', false, spanString);
            }
            else if(splitter[0] == "size")
            {
                var spanString = $('<span/>', {
                    'text': document.getSelection()
                }).css('font-size', splitter[1]).prop('outerHTML');
            
                document.execCommand('insertHTML', false, spanString);
            }
            
            //$("#dialog-"+this.editor_id).hide();
            // TODO:
            //this.buttonOpenDialog(button, "resizeText", "Změnit velikost písma");
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonAlignLeft(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.on("click", () => {
            
            this.focusOnEditor();

            // TODO:
            document.execCommand("justifyLeft");
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonAlignCenter(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.on("click", () => {
            
            this.focusOnEditor();
            var new_element = $('<div/>', {
                'text': document.getSelection()
            }).addClass("content-center").prop('outerHTML');

            // TODO:
            document.execCommand("insertHTML", false, new_element);
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonAlignRight(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.on("click", () => {
            
            this.focusOnEditor();

            // TODO:
            document.execCommand("justifyRight");
            
        });
    }

    /**
     * 
     * @param {String} button_id 
     */
    buttonAlignJustify(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.on("click", () => {
            
            this.focusOnEditor();

            // TODO:
            document.execCommand("justifyFull");
            
        });
    }

    buttonInsertRow(button_id) {
        var button = $(`div[id=${this.editor_id}]  > div > div > div > div > button[id=${button_id}]`);
        button.on("click", () => {
            this.focusOnEditor();
            var rows = button.siblings("#etext-rows-input").val();
            var cols = button.siblings("#etext-cols-input").val();

            if(rows == "")
            {
                rows = 2;
            }
            if(cols == "" || (cols <= 0 && cols > 10 ))
            {
                cols = 2;
            }

            var table = "";
            
            // Generate Rows
            var new_row = $('<div/>').addClass("row cols-"+cols);
            //var new_col = $('<div/>').text("Vložte obsah").addClass("column-shrink pd-1 bd-dark bd-1");

            // Cols
            for (var i = 0; i < parseInt(rows)*parseInt(cols); i++) 
            {
                if (i < 100) 
                {
                    new_row.append($('<div/>').text("Vložte obsah").addClass("column-shrink pd-1 bd-dark bd-1"));
                }
            }

            console.log(new_row);
            table = new_row.prop("outerHTML");

    
            // Use execCommand to insert the generated HTML
            document.execCommand("insertHTML", false, table);
            //Generate new LINE
            var editor_content = $(".e-editor[target=editor-"+this.editor_id+"]").html();
            $(".e-editor[target=editor-"+this.editor_id+"]").html(editor_content+ "<div><br></div>");
        });
    }

    buttonChangeStyle(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > div > button[id="+button_id+"]");
        button.on("click", () => {
            this.focusOnEditor();
            var editor_content = $(".e-editor[target=editor-"+this.editor_id+"]").html();
            var select_element = button.siblings("#etext-styles-input");
            var seletcted_option = select_element.val();

            var split_value = seletcted_option.split(":");  //0 - block|span -> 1 - style
            var etext_class = "etext-"+split_value[0]+"-style-"+split_value[1];

            var new_element;
            if(split_value[0] === "block")
            {
                var new_element = $('<div/>', {
                    'text': document.getSelection()
                }).addClass(etext_class).prop('outerHTML');
            }
            else
            {
                var new_element = $('<span/>', {
                    'text': document.getSelection()
                }).addClass(etext_class).prop('outerHTML');
            }

            document.execCommand('insertHTML', false, new_element);

            //Generate new LINE
            var editor_content = $(".e-editor[target=editor-"+this.editor_id+"]").html();
            $(".e-editor[target=editor-"+this.editor_id+"]").html(editor_content+ "<div><br></div>");

            //this.focusOnEditor();
            /*var color_hex = $("#dialog-text-bcolor-input").val(); //#bfbfbf
            document.execCommand('backColor', false, color_hex);*/
            
        });
    }
}