class liveEditor extends editorButtons
{
    constructor()
    {
        super();
        this.editor_id;
    }

    /**
     * Enter the creation process
     * 
     * @param {*} element_to_replace 
     * @param {*} content 
     */
    constructEditor(element_to_replace, content, content_field_name, options = {})
    {
        this.loadTemplate(element_to_replace, content, content_field_name, options);
    }

    /**
     * Load the template from file and send to process
     */
    loadTemplate(element_to_replace, content, content_field_name, options = {})
    {
        fetch('/plugins/lora/etext/src/template/editor.html')
        .then(response => response.text()) // getting content from template
        .then(data => {
            return this.processTemplate(data, element_to_replace, content, content_field_name);
        })
        .catch(error => {
            console.error('Error loading template:', error);
        });
    }

    processTemplate(template_content, element_to_replace, content, content_field_name)
    {
        var uid = randomInt(100,999999);
        this.editor_id = uid;
        
        var compiled_content;


        var block_to_tags = this.convertBlocktoTags(content.replace(/\n/g,"<br>"));

        var data = 
        {
            uid: uid,
            content: block_to_tags,
            send_button_text: "Odeslat",
            button_class: "button button-dark-3",
            field_name: content_field_name,
        };

        compiled_content = replaceVariables(template_content, data);  
        
        this.returnGeneratedEditor(compiled_content, element_to_replace);

        this.initButtons();

        $(".e-editor[target=editor-"+uid+"]").on("keyup", () => {
            this.updateResult(uid);
        });

        return this.editor_id;
        
    }

    returnGeneratedEditor(compiled_template, element_to_replace)
    {
        return $(element_to_replace).html(compiled_template);
    }

    initButtons() {
        this.buttonBold("bold");
        this.buttonItalic("italic");
        this.buttonStrike("strike");
        this.buttonOpenDialogAlignment("dialog-alignment");
        this.buttonOpenDialogImage("dialog-image");
        this.buttonOpenDialogResizeText("resize-text");
        this.buttonOpenDialogTextColor("dialog-text-color");
        this.buttonView("view");
        this.buttonSend();
        // this.buttonAlignLeft();
    }

    initDialogButton()
    {
        this.buttonHeader();
        this.buttonTextColorChange();
    }

    

    buttonOpenDialog(button, template, header_text = "")
    {
        button.click(() => {
            fetch('/plugins/lora/etext/src/template/dialog/'+template+'.html')
            .then(response => response.text()) // getting content from template
            .then(data => {
                this.openDialog(data, header_text);
            })
            .catch(error => {
                console.error('Error loading template:', error);
            });
        });
        
    }

    openDialog(dialog_content, header_text = "")
    {
        //Compile content;
        var modified_content = replaceVariables(dialog_content, {header: header_text});

        $("#dialog-"+this.editor_id).show(200);
        $("#dialog-"+this.editor_id+">.dialog-header").html(header_text);
        $("#dialog-"+this.editor_id+">.dialog-body").html(modified_content);

        this.initDialogButton();
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

            //resultBlockElement.toggle(200).text(blockContent);
       
            var back_to_tags = this.convertBlocktoTags(blockContent);
            //resultElement.toggle(200).html(back_to_tags);
        }

        //Save to hidden field in editor
        var hiddenFieldContent = $(".editor-content[target=editor-"+uid+"]");
        var block_fieldContent = this.convertTagsToBlocks(editorContent);
        hiddenFieldContent.text(block_fieldContent);
            
    }

}