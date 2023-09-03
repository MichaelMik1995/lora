insertBlock(element_style, element_type = "div", element_style_type = "class") {

        const selection = window.getSelection();
    

        if (selection.toString().length === 0) return;
    

        const sizeBlock = $("<" + element_type + "></" + element_type + ">");
    
        if (element_style_type === "class") 
        {
            sizeBlock.addClass(element_style);
            
        } 
        else if (element_style_type === "style") 
        {
            sizeBlock.attr("style", element_style);
        }
    
        sizeBlock.text(selection.toString()); 
    

        const range = selection.getRangeAt(0);
    

        range.deleteContents();
    

        range.insertNode(sizeBlock[0]);
    

        const newRange = document.createRange();
        newRange.setStartBefore(sizeBlock[0]);
        newRange.setEndAfter(sizeBlock[0]);
    

        selection.removeAllRanges();
        selection.addRange(newRange);
    } 
