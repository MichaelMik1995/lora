'use strict';

/**
 * PluginEText - WYSIWYG Editor Plugin
 * Version: 1.0
 * 
 * This plugin provides a WYSIWYG editor functionality that can be applied to HTML elements.
 * It allows for live editing and content compilation.
 * 
 * @class PluginEText
 */
class PluginEText {

    constructor() 
    {
        // General configuration
        const PLUGIN_VERSION = 1.0;

        // Console init
        console.log("Starting plugin eText. Version: " + PLUGIN_VERSION);
    }

    /**
     * Load function to initialize the WYSIWYG editor on the specified element.
     * 
     * @param {Object} element_to_replace - jQuery element to be replaced with the live editor.
     * @param {Array} options - Configuration options for the editor.
     * @param {function} callback - Callback function after editor is loaded.
     */
    load(element_to_replace, options = null, callback = null) {
        // Generate unique identifier for the element
        var id = randomInt(11111, 99999999);
        console.log("Starting generation eText editor from element: " + element_to_replace.attr("id"));

        var $element = $(element_to_replace);
        if (options == null && $element.attr("etext-options") != undefined) {
            var options_attr = $element.attr("etext-options").replace(/'/gi, "\"");
            console.log(options_attr);
            options = JSON.parse(options_attr);
        }

        // Instantiate live editor and construct the editor
        var LiveEditor = new liveEditor();
    
        LiveEditor.constructEditor(element_to_replace, element_to_replace.html(), options, callback);

        console.log(LiveEditor.returnEditorId());
        var inEditor = new EtextInEditor(LiveEditor.editor_id);
        inEditor.UIElements();
        return true;
    }

    /**
     * Compile function to compile the content of the editor element.
     * 
     * @param {Object} element_to_replace - jQuery element containing the editor content.
     * @param {boolean} is_string - Indicates whether the compiled content should be returned as a string.
     */
    compile(element_to_replace, is_string = false) {
        var LiveEditor = new liveEditor();
        return LiveEditor.compileContent(element_to_replace, is_string);
    }
}

/**
 * EText instance to be used for accessing the PluginEText functionality.
 */
const EText = new PluginEText();

// Post process editor options and functions

/**
 * Enable editing mode on a specific editor element.
 * 
 * @param {string} uid - Unique identifier of the editor element.
 */
function enableEditing(uid) {
    $(".e-editor[target=editor-" + uid + "]").attr("contentEditable", "true").focus();
}

/**
 * Disable editing mode on all editor elements.
 */
function disableEditing() {
    $(".e-editor").attr("contentEditable", "false");
}

$(document).ready(() => {
    $("[etext-event]").each((index, element) => {
        setTimeout(() => {
            var $element = $(element);
            var event_type = $element.attr("etext-event");
            var element_id = $element.attr("id");
            console.log(element_id, event_type);

            if (event_type === "compile") {
                var compiled_content = EText.compile($element.html(), true);
                $($element).html(compiled_content);
            } else if (event_type === "load") {
                EText.load($element);
            }
        }, 500);
    });
});