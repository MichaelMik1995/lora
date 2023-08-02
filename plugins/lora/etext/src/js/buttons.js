class editorButtons
{
    constructor()
    {

    }

    focusOnEditor()
    {
        enableEditing(this.editor_id);
    }

    
    buttonBold(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            //this.insertBlock("t-bolder", "span", "class");
            document.execCommand("bold");

            
            
        });
    }

    buttonItalic(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            //this.insertBlock("t-italic", "span", "class");
            document.execCommand("italic");
            
        });
    }

    buttonStrike(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            //this.insertBlock("t-striked", "span", "class");
            document.execCommand("strikeThrough");
            
        });
    }

    buttonView(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            this.updateResult(this.editor_id);
            
        });
    }

    buttonSend()
    {
        var button = $('.button-send[target=editor-'+this.editor_id+']');
        button.click( (e) => {
            e.preventDefault();
            var form = button.closest("form");

            this.updateResult(this.editor_id, true);

            form.submit();
        });
    }

    buttonOpenDialogAlignment(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            this.buttonOpenDialog(button, "contentAlign", "Zarovnání textu");
            
        });
    }

    buttonOpenDialogImage(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            this.buttonOpenDialog(button, "image", "Vložit obrázek");
            
        });
    }

    buttonOpenDialogResizeText(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            this.buttonOpenDialog(button, "resizeText", "Změnit velikost písma");
            
        });
    }

    buttonOpenDialogTextColor(button_id)
    {
        var button = $("div[id="+this.editor_id+"]  > div > div > div > button[id="+button_id+"]");
        button.click( () => {
            
            this.focusOnEditor();

            // TODO:
            this.buttonOpenDialog(button, "textColor", "Změnit barvu písma");
            
        });
    }

    

    buttonAlignLeft()
    {

    }

    buttonAlignCenter()
    {

    }

    buttonAlignRight()
    {

    }

    buttonTextColorChange()
    {
        var buttons = $(".etext-color");
        
        buttons.click((event) => {
            var color_hex = $(event.currentTarget).attr("data-color"); //#bfbfbf

            this.focusOnEditor();

            document.execCommand('foreColor', false, color_hex);
            //this.insertBlock("color: "+color_hex+"", "span", "style");
            
            $("#dialog-"+this.editor_id).hide();
            
        });
    }


    /* DIALOG BUTTONS AND OPERATIONS */
    buttonHeader()
    {
        var buttons = $(".edialog");
        buttons.click((event) => {
            const class_header = $(event.currentTarget).attr("data");

            var splitter = class_header.split("-");
            //this.focusOnEditor($(event.currentTarget));

            // TODO:
            //this.insertBlock(class_header, "span");
            document.execCommand('formatBlock', false, '<h'+splitter[1]+'>');

            
            $("#dialog-"+this.editor_id).hide();
            
        });
    }

    insertBlock(element_style, element_type = "div", element_style_type = "class") {
        // Získáme textový výběr uživatele
        const selection = window.getSelection();
    
        // Pokud není nic vybráno, nic se nevykoná
        if (selection.toString().length === 0) return;
    
        // Vytvoříme nový dokumentový fragment se svým vlastním HTML obsahem
        const sizeBlock = $("<" + element_type + "></" + element_type + ">");
    
        if (element_style_type === "class") 
        {
            sizeBlock.addClass(element_style);
            
        } 
        else if (element_style_type === "style") 
        {
            sizeBlock.attr("style", element_style);
        }
    
        sizeBlock.text(selection.toString()); // Přidáme text do elementu
    
        // Získáme rozsah (Range) selekce
        const range = selection.getRangeAt(0);
    
        // Smazat původní výběr
        range.deleteContents();
    
        // Vložit nový element s textem do rozsahu
        range.insertNode(sizeBlock[0]);
    
        // Vytvořit nový rozsah obsahující nový element s textem
        const newRange = document.createRange();
        newRange.setStartBefore(sizeBlock[0]);
        newRange.setEndAfter(sizeBlock[0]);
    
        // Obnovit označení nového elementu s textem
        selection.removeAllRanges();
        selection.addRange(newRange);
    }
    
}

/*
$('#colorBtn').click(function() {
        const color = $('#colorPicker').val();
        document.execCommand('foreColor', false, color);
        
      });

      $('#save').click(function() {
        updateResult();
      });

      $('#alignBtn[data-align]').click(function() {
        const align = $(this).data('align'); // Získáme hodnotu data-align atributu

        // Zkontrolujeme, zda je vybrán nějaký text
        const selection = window.getSelection().toString().trim();
        if (selection !== '') {
          // Pro vybraný text vložíme odpovídající blok s alignmentem
          const alignBlock = `<div class="content-${align}">${selection}</div>`;
          document.execCommand('insertHTML', false, alignBlock);
        }
      });

      $('#insertImage').click(function() {
        const imageUrl = prompt('Zadejte URL obrázku:', "16");
        if (imageUrl) {
          const imgTag = `<img src="${imageUrl}" class="height-256p" alt="Obrázek">`;
          document.execCommand('insertHTML', false, imgTag);
        }
      });

      $('#changeFontSize').click(function() {
        const selection = window.getSelection().toString();
        const fontSize = prompt('Zadejte velikost fontu (v pixelech):');
        if (fontSize) {
          const sizeBlock = `<span style="font-size: ${fontSize}px;">${selection}</span>`;
          document.execCommand('insertHTML', false, sizeBlock);
        }
      });
      */