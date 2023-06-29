const Application = new APP();
const Validation = new VALIDATION();
const GUIDialog = new GUIDIALOG();
const GUITable = new GUIFLOATTABLES();
const WPage = new WPAGE();
const Counter = new counter();
const Form = new FormClass();
const Function = new ElementFunction();
const StF = new StylizeFunction();

Application.writeLog("DEBUG is ON");
Application.writeLog(Application.appname);
Application.writeLog(Application.appversion);

$(document).ready(function()
{
    $(".element-draggable").draggable(); 

    //Creates alternative images for img -> rel="altImage" + alternative='alternativePath\'
    var image_element_alt = $("img[alternative=on]");
    var image_el_at_alternative = image_element_alt.attr('alternativepath');
    Function.imgAlt(image_el_at_alternative, image_element_alt);
    
    //Call stylized func

});

