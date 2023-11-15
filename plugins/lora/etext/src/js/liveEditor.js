class liveEditor extends editorButtons
{
    constructor()
    {
        super();
        this.editor_id;
    }

    returnEditorId()
    {
        return this.editor_id;
    }

    /**
     * Enter the creation process
     * 
     * @param {*} element_to_replace 
     * @param {*} content 
     */
    constructEditor(element_to_replace, content, options = {}, callback = null)
    {
        this.loadTemplate(element_to_replace, content, options, callback);
    }

    /**
     * Load the template from file and send to process
     */
    loadTemplate(element_to_replace, content, options, callback)
    {
        fetch('/plugins/lora/etext/src/template/editor.html')
        .then(response => response.text()) // getting content from template
        .then(data => {
            this.processTemplate(data, element_to_replace, content, options, callback);
        })
        .catch(error => {
            console.error('Error loading template:', error);
        });
    }

    processTemplate(template_content, element_to_replace, content, options, callback)
    {
        var uid = randomInt(100,999999);
        this.editor_id = uid;
        
        var compiled_content;

        var content_to_block = this.convertTagsToBlocks(content);

        //############### OPTIONS

        //General options
        var option_etext_name = "content";
        var option_debug = "0";

        //buttons
        var option_display_text_color = "1";
        var option_display_background_color = "1";
        var option_display_text_size = "1";
        var option_display_list = "1";
        var option_display_image = "1";
        var option_display_alignment = "1";
        var option_display_table = "1";
        var option_display_style = "1";
        var option_display_icons = "1";

        //Visual settings of the editor
        var option_additional_editor_classes = "";
        var option_editor_width = "100";
        var option_editor_height = "256p";
        var option_editor_background = "#212529";
        var option_editor_panel_background = "#212529";
        var option_editor_border_color = "#1f2f46";
        var option_editor_text_color = "#bfbfbf";
        var option_editor_sec_color = "dark-3";
        var option_editor_content_background = "none";
        var option_editor_content_text = "#bfbfbf";

        // If option not NULL
        if(options !== null)
        {
            for (const [key, value] of Object.entries(options)) 
            {
                switch(`${key}`)
                {       
                    //General settings             
                    case "name":
                        option_etext_name = `${value}`;
                        break;

                    case "debug":
                        if(value == true || value === "true")
                        {
                            option_debug = "1";
                        }
                        else
                        {
                            option_debug = "0";
                        }
                        //option_debug = `${value}`;
                        break;

                    //Visual settings of the editor
                    case "width":
                        option_editor_width = `${value}`;
                    break;

                    case "height":
                        option_editor_height = `${value}`;
                    break;

                    case "editor-background":
                        option_editor_background = `${value}`;
                    break;

                    case "editor-panel-background":
                        option_editor_panel_background = `${value}`;
                    break;

                    case "editor-border":
                        option_editor_border_color = `${value}`;
                    break;

                    case "editor-text":
                        option_editor_text_color = `${value}`;
                    break;

                    case "editor-classes":
                        option_additional_editor_classes = `${value}`;
                    break;

                    case "editor-buttons":
                        option_editor_sec_color = `${value}`;
                    break;

                    case "editor-content-background":
                        option_editor_content_background = `${value}`;
                    break;

                    case "editor-content-text":
                        option_editor_content_text = `${value}`;
                    break;

                    case "button-groups":
                        option_display_text_color = "0";
                        option_display_background_color = "0";
                        option_display_text_size = "0";
                        option_display_list = "0";
                        option_display_image = "0";
                        option_display_alignment = "0";
                        option_display_table = "0";
                        option_display_style = "0";
                        option_display_icons = "0";

                        console.log(value);

                        var options_array = value.replace(" ", "").split(",");

                        if(options_array.includes("text-color")){option_display_text_color = "1";}
                        if(options_array.includes("background-color")){option_display_background_color = "1";}
                        if(options_array.includes("text-size")){option_display_text_size = "1"}
                        if(options_array.includes("list")){option_display_list = "1"}
                        if(options_array.includes("image")){option_display_image = "1"}
                        if(options_array.includes("alignment")){option_display_alignment = "1"}
                        if(options_array.includes("table")){option_display_table = "1"}
                        if(options_array.includes("style")){option_display_style = "1"}
                        if(options_array.includes("icons")){option_display_icons = "1"}
                        else{}
                    break;

                }
            }
        }

        var data = 
        {
            uid: uid,
            content: decodeURIComponent(escape(window.atob(content))),//this.convertBlocktoTags(content),
            blocked_content: content_to_block,
            send_button_text: "Odeslat",
            field_name: option_etext_name,
            debug: option_debug,

            //buttons
            display_text_color: option_display_text_color,
            display_background_color: option_display_background_color,
            display_text_size: option_display_text_size,
            display_list: option_display_list,
            display_image: option_display_image,
            display_alignment: option_display_alignment,
            display_table: option_display_table,
            display_style: option_display_style,
            display_icons: option_display_icons,
            

            //Visual settings of the editor
            editor_width: option_editor_width,
            editor_height: option_editor_height,
            editor_additional_classes: option_additional_editor_classes,
            editor_background: option_editor_background,
            editor_panel_background: option_editor_panel_background,
            editor_border_color: option_editor_border_color,
            editor_text_color: option_editor_text_color,
            editor_sec_color: option_editor_sec_color,
            editor_content_background: option_editor_content_background,
            editor_content_text: option_editor_content_text


        };

        compiled_content = replaceVariables(template_content, data);  
        
        this.returnGeneratedEditor(compiled_content, element_to_replace);

        this.initButtons();

        /*$(".e-editor[target=editor-"+uid+"]").on("keyup", () => {
            this.updateResult(uid);
        });*/

        var editableContent = document.getElementById("editor-"+option_etext_name);

        editableContent.addEventListener('input', (event) => {
                this.updateResult(uid);
          });

        editableContent.addEventListener("paste", (event) => {
            this.handleKeyDown(event);
            this.countChars(event);
            this.updateResult(uid);
          });
        editableContent.addEventListener("keydown", (event) => {
            
            if (event.key === "Tab" && !event.shiftKey) {
                event.preventDefault();

                //document.execCommand("indent", false, null);
                document.execCommand("insertHTML", false, "&emsp;");
                this.countChars(event);
                this.updateResult(uid);
            }

            if (event.key === "Tab" && event.shiftKey) {
                event.preventDefault();
                document.execCommand("outdent", false, null);
                this.countChars(event);
                this.updateResult(uid);
            }
        });

        if(callback != null)
        {
            callback();
        }

        return true;
        
    }

    returnGeneratedEditor(compiled_template, element_to_replace)
    {
        $(element_to_replace).html(compiled_template);
    }

    initButtons() {
        this.buttonBold("bold");
        this.buttonItalic("italic");
        this.buttonStrike("strike");
        this.buttonUnderline("underline");
        this.buttonLink("link");

        this.buttonList("etext-insert-list");
        this.buttonImage("etext-insert-image");
        this.buttonTextSize("resize-text");

        this.buttonAlignLeft("align-left");
        this.buttonAlignCenter("align-center");
        this.buttonAlignRight("align-right");
        this.buttonAlignJustify("align-justify");

        this.buttonChangeColor("dialog-text-color");
        this.buttonChangeBackgroundColor("dialog-text-bcolor");

        this.buttonInsertRow("etext-insert-row");
        this.buttonChangeStyle("etext-change-style");
        this.buttonInsertIcon("etext-icon-button");
        
    }

    initDialogButton()
    {

    }

    /*initPopUpButton()
    {
        this.popupHref("#etext-popup-href-button");
    }*/

    buttonOpenDialog(button, template, header_text = "")
    {
        button.click(() => {
            fetch('/plugins/lora/etext/src/template/dialog/'+template+'.html')
            .then(response => response.text()) // getting content from template
            .then(data => {
                this.openDialog(button, data, header_text);
            })
            .catch(error => {
                console.error('Error loading template:', error);
            });
        });
        
    }

    openDialog(button, dialog_content, header_text = "")
    {
        //Compile content;
        var modified_content = replaceVariables(dialog_content, {header: header_text});


        //get position of button:
        var button_position_top = button.position().top;
        console.log(button_position_top);
        $("#dialog-"+this.editor_id).show(200);
        $("#dialog-"+this.editor_id+">.dialog-header").html(header_text);
        $("#dialog-"+this.editor_id+">.dialog-body").html(modified_content);

        this.initDialogButton();
    }

    openPopUpWindow(button, popup_file)
    {
        button.click(() => {
            fetch('/plugins/lora/etext/src/template/popup/'+popup_file+'.html')
            .then(response => response.text()) // getting content from template
            .then(data => 
                {
                    var modified_content = data;

                    $("#popup-"+this.editor_id).show(200);
                    $("#popup-"+this.editor_id).html(modified_content);

                    //$("input[popup-event=focus]").focus();
                    this.initPopUpButton();
                    //create the popup window and set content
            })
            .catch(error => {
                console.error('Error loading template:', error);
            });
        });
    }

    convertTagsToBlocks(input) 
    {
        var converted_text = input;

        $.ajax({
            url: '/plugins/lora/etext/src/config/replacement.json',
            async: false,
            dataType: 'json',
            success: function (data) {
                for (const item of data.tags_to_blocks) {
                    const regex = new RegExp(item.tag, "gi");
                    converted_text = converted_text.replace(regex, item.block);
                }
            }
        });

        return converted_text;
    }

    convertBlocktoTags(input)
    {
        var converted_text = input;

        $.ajax({
            url: '/plugins/lora/etext/src/config/replacement.json',
            async: false,
            dataType: 'json',
            success: function (data) {
                for (const item of data.blocks_to_tags) {
                    const regex = new RegExp(item.block, "gi");
                    converted_text = converted_text.replace(regex, item.tag);
                }
            }
        });

        return converted_text;
    }

    compileContent(element, is_string)
    {
        if(is_string === false)
        {
            var content = decodeURIComponent(escape(window.atob(element.text())));
            var pre_compile = this.convertTagsToBlocks(content);
            var new_content = this.convertBlocktoTags(pre_compile);
            return element.html(content);
        }
        else
        {
            var content = decodeURIComponent(escape(window.atob(element)));
            var pre_compile = this.convertTagsToBlocks(content);
            var new_content = this.convertBlocktoTags(pre_compile);
            return content;
        }
        
    }

    /**
     * 
     * @param {String} input 
     * @returns 
     */
    sanitize(input) 
    {
        const sanitizedContent = input.replace(/</g, '&lt;').replace(/>/g, '&gt;');

        // Ošetření javascript URL a speciálních znaků
        const safeContent = sanitizedContent.replace(/href="javascript:/gi, 'href="').replace(/&/g, '&amp;').replace(/'/g, '&apos;').replace(/"/g, '&quot;');

        // Ošetření URL adres a použití jen povolených schémů (http a https)
        const validUrlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/gi;
        const secureUrlContent = safeContent.replace(validUrlPattern, function (url) {
        return url.match(/^https?:\/\//) ? url : '';
        });

        return secureUrlContent;
    }


    updateResult(uid, only_content = false) 
    {
        var editorContent = $(".e-editor[target=editor-"+uid+"]").html();

        if (only_content === false)
        {
            var resultElement = $('#result-html[target=editor-'+uid+']');
            var resultBlockElement = $("#result-block[target=editor-"+uid+"]");

            var blockContent = this.convertTagsToBlocks(editorContent);
            var sanitizedContent = this.sanitize(blockContent); 
        }

        //Save to hidden field in editor
        var hiddenFieldContent = $(".editor-content[target=editor-"+uid+"]");
        var block_fieldContent = this.convertTagsToBlocks(editorContent);

        //console.log("SANITIZED: ", sanitizedContent);
        var encode_text = btoa(unescape(encodeURIComponent(editorContent)));
        hiddenFieldContent.text(encode_text);


        var counter_span = $("#count-chars[target=editor-"+uid+"]");
        var counter_span_editor = $("#count-chars-editor[target=editor-"+uid+"]");
        counter_span.text(hiddenFieldContent.text().length);
        counter_span_editor.text($(".e-editor[target=editor-"+uid+"]").text().length)
            
    }

    /**
     * 
     * @param {*} event 
     */
    handleKeyDown(event) {
        // Zachytit Ctrl+V událost
            event.preventDefault(); // Zabránit výchozímu chování (vložení obsahu schránky)
            var clipboard = (event.clipboardData || window.clipboardData);
            var text = clipboard.getData('text/plain');

            document.execCommand('insertText', false, text);

    }
}