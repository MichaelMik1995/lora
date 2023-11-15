class EtextInEditor
{
    constructor(editor_id)
    {
        this.editor_id = editor_id;
        console.log("Module EtextInEditor fo plugin ETEXT successfully loaded");
        console.log("ETEXT id: " + this.editor_id);
    }

    generateBorderElement(header_content, content)
    {
        fetch('/plugins/lora/etext/src/template/border_element.html')
        .then(response => response.text()) // getting content from template
        .then(data => {
            var border_object = data.replace(/{header_content}/gi, header_content);
            border_object = border_object.replace(/{content}/gi, content);

            console.log(border_object);
        })
        .catch(error => {
            console.error('Error loading template:', error);
        });
    }

    UIElements()
    {
        $(".etext-editor-image").on("mouseenter", function() {
            alert("hovered");
            console.log($(this));
            var border_element = this.generateBorderElement("test", $(this));
            $(this).append(border_element);
            $(this).remove();
        });
    }


}