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
            //this.openPopUpWindow(button, "href");   
            var linkElement = $('<a/>', {
                'text': document.getSelection(),
            }).addClass("etext-href").attr('href', document.getSelection()).attr('target', '_blank').prop('outerHTML');

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
            this.focusOnEditor();
            //var img = "<img class='width-"+ $("#etext-image-data-scale").val() +"' src='" + $("#image-url-input").val() + "'>";
            var imageElement = $('<img>', {
                'src': button.siblings("#image-url-input").val(),
                'rel': 'easySlider',
                'alt': 'etext-image-content-'+button.siblings("#image-url-input").val()
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

    buttonInsertRow(button_id) 
    {
        var button = $(`div[id=${this.editor_id}]  > div > div > div > div > button[id=${button_id}]`);
        button.on("click", () => {
            this.focusOnEditor();
            var rows = button.siblings("#etext-rows-input").val();
            var cols = button.siblings("#etext-cols-input").val();
            var style = button.siblings("#etext-table-style").val();
            var row_width = button.siblings("#etext-table-width").val();    // 50

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
            var new_row = $('<div/>').addClass("row cols-"+cols+" row-style-"+style+" width-"+row_width).attr("id", randomInt(1111,9999));
            //var new_col = $('<div/>').text("Vložte obsah").addClass("column-shrink pd-1 bd-dark bd-1");

            // Cols
            for (var i = 0; i < parseInt(rows)*parseInt(cols); i++) 
            {
                if (i < 100) 
                {
                    new_row.append($('<div/>').text("#").addClass("column-shrink"));
                }
            }

            console.log(new_row);
            table = "<br>"+new_row.prop("outerHTML")+"<br>";

    
            // Use execCommand to insert the generated HTML
            document.execCommand("insertHTML", false, table);
            //Generate new LINE
            var editor_content = $(".e-editor[target=editor-"+this.editor_id+"]").html();
            $(".e-editor[target=editor-"+this.editor_id+"]").html(editor_content+ "<div><br></div>");
        });
    }

    buttonChangeStyle(button_id) {
        var button = $(`div[id=${this.editor_id}] > div > div > div > div > button[id=${button_id}]`);
    
        button.on("click", () => {
            this.focusOnEditor();
    
            var editor_content = $(`.e-editor[target=editor-${this.editor_id}]`);
            var select_element = button.siblings("#etext-styles-input");
            var selected_option = select_element.val();
    
            var split_value = selected_option.split(":");  // 0 - block|span -> 1 - style
            var etext_class = `etext-${split_value[0]}-style-${split_value[1]}`;
    
            var selectedText = document.getSelection();
            var new_element;
            
            if (split_value[0] === "block") {
                if (split_value[1] === "code") {
                    // Pokud je vybraný HTML obsah, zkopírujeme ho uvnitř bloku
                    if (selectedText.rangeCount > 0) {
                        var range = selectedText.getRangeAt(0);
                        var clonedContent = range.cloneContents();
                        new_element = $('<pre/>').addClass(etext_class);
                        new_element.append(clonedContent);
                        highlightCode(new_element);
                    } else {
                        new_element = $('<pre/>', {
                            'html': selectedText.toString().replace(/\n/g, '<br>')
                        }).addClass(etext_class);
                        highlightCode(new_element);
                    }
                } else {
                    // Pokud je vybraný HTML obsah, zkopírujeme ho uvnitř bloku
                    if (selectedText.rangeCount > 0) {
                        var range = selectedText.getRangeAt(0);
                        var clonedContent = range.cloneContents();
                        new_element = $('<div/>').addClass(etext_class);
                        new_element.append(clonedContent);
                    } else {
                        new_element = $('<div/>', {
                            'html': selectedText.toString().replace(/\n/g, '<br>')
                        }).addClass(etext_class);
                    }
                }
            } else if (split_value[0] === "span") {
                // Pokud je vybraný HTML obsah, zkopírujeme ho uvnitř spanu
                if (selectedText.rangeCount > 0) {
                    var range = selectedText.getRangeAt(0);
                    var clonedContent = range.cloneContents();
                    new_element = $('<span/>').addClass(etext_class);
                    new_element.append(clonedContent);
                } else {
                    new_element = $('<span/>', {
                        'html': selectedText.toString().replace(/\n/g, '<br>')
                    }).addClass(etext_class);
                }
            } else {
                new_element = $('<span/>', {
                    'text': selectedText
                }).addClass(etext_class).prop('outerHTML');
            }
    
            document.execCommand('insertHTML', false, "<br>"+new_element.prop('outerHTML')+"<br>");

    
            // this.focusOnEditor();  // Zda-li je tato řádka potřebná, záleží na celkovém chování aplikace
        });
    
        function highlightCode(element) {
            // Regulární výrazy pro zvýraznění syntaxe
            var keywordsRegex = /\b(var|function|if|else|for|while|return|const|let|php|lora|help|dbtable|dbtable:create|plugin:create)\b/g;    // index &K
            var commentsRegex = /\/\*[\s\S]*?\*\/|\/\/.*/g;                         // index &c
            var functionsRegex = /\bfunction\b\s+([A-Za-z_][A-Za-z0-9_]*)/g;        //index &F
            var classesRegex = /\bclass\b\s+([A-Za-z_][A-Za-z0-9_]*)/g;             // index &C
            var selectorsRegex = /[#.][A-Za-z_][A-Za-z0-9_\-]*/g;                   // index &s
            var stringRegex = /"([^"\\]*(\\.[^"\\]*)*)"|'([^'\\]*(\\.[^'\\]*)*)'/g; // index &S
            var numberRegex = /\b(\d+\.\d+|\d+)\b/g; // Zvýraznění čísel            // index &I
            
            // Nahradit klíčová slova začínající a končící <span> tagy pro zvýraznění
            element.html(function (index, oldHtml) {
                // Klíčová slova
                oldHtml = oldHtml.replace(keywordsRegex, '<span class="t-info">$&</span>');
                // Komentáře
                //oldHtml = oldHtml.replace(commentsRegex, '<span class="t-success">$&</span>');
                // Funkce
                oldHtml = oldHtml.replace(functionsRegex, '<span class="t-basic">$&</span>');
                // Třídy
                oldHtml = oldHtml.replace(classesRegex, '<span class="t-yellow">$&</span>');
                // Selektory
                oldHtml = oldHtml.replace(selectorsRegex, '<span class="t-red">$&</span>');

                return oldHtml;
            });
        }
    }

    buttonInsertIcon(button_id)
    {
        var button = $(`div[id=${this.editor_id}] > div > div > div > div > button[id=${button_id}]`);
    
        button.on("click", () => {
            this.focusOnEditor();

            var icon_input = button.siblings("#etext-icon-input").val();

            
            var iconElement = $('<i/>', {
                class: icon_input, // Třída ikony (např. "fas fa-star")
              }).prop('outerHTML');
              
              
              document.execCommand('insertHTML', false, iconElement);
        });
    }

    /**    POPUP Buttons     */
    popupHref(button_id)
    {
        $(button_id).on("click", () => {
            this.focusOnEditor();
            if(document.getSelection() !== undefined)
            {
                var linkElement = $('<a/>', {
                    'text': document.getSelection(),
                }).addClass("etext-href").attr('href', document.getSelection()).attr('target', '_blank').prop('outerHTML');

                // TODO:
                document.execCommand("insertHTML", false, linkElement);
            }
            else
            {
                alert("Nelze");
                return 0;
            }
        });
        
    }
}
