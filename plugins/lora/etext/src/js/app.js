'use strict';

class PluginEText
{
    constructor()
    {
        //General configuration
        const PLUGIN_VERSION = 1.0;

        //Console init
        console.log("Starting plugin eText. Version: " + PLUGIN_VERSION);
    }

    //Function only on generate editor element
    /**
     * 
     * @param {Element} element_to_replace <p>Element, which you can completely replace to EText live editor</p>
     * @param {Array} options 
     * @param {Void} callback 
     */
    load(element_to_replace, field_name = "content", options = null, callback = null)
    {
        //generate unique identifier for element
        var id = randomInt(11111, 99999999);
        console.log("Starting generation etext editor from element: "+element_to_replace.attr("id"));

        //Classes
        const LiveEditor = new liveEditor();
        return LiveEditor.constructEditor(element_to_replace, element_to_replace.html(), field_name, options);
    }
}

const EText = new PluginEText();

//Post process editor options | functions
function enableEditing(uid) {
    $(".e-editor[target=editor-"+uid+"]").attr("contentEditable", "true").focus();
}

function disableEditing() {
    $(".e-editor").attr("contentEditable", "false");
}

