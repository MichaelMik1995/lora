/* 
 * EasyText 2019 MichaelMik9.
 *
 */


/*const boldButton = document.getElementById('easytext-b-bold');
const textArea = document.querySelector('.area-406079');

boldButton.addEventListener('click', () => {
  const selection = window.getSelection();
  const range = selection.getRangeAt(0);
  const selectedText = range.extractContents();
  const bold = document.createElement('b');
  bold.appendChild(selectedText);
  range.insertNode(bold);
  textArea.focus();
});*/


/**
 * 
 * @author michaelmik <michaelmik@email.cz>
 * 
 * @param {Element} trigger         trigger for start replacing text    
 * @param {Element} area            Element where is text for replace
 * @param {string} replaceStart     Prefix for replaced text
 * @param {string} replaceEnd       Suffix for replaces text 
 * 
 * @returns {string}                return replaceStart+selected-text+replaceEnd
 */
/*function replaceSelectedText(container_id, button_id, replaceStart, replaceEnd) {
    $("div[area-id="+container_id+"]").find("#"+button_id).on('click', function(e) 
    {
        e.preventDefault();
        var container = $(".area-"+container_id);//document.querySelector(".area-"+container_id);
        
        var selection = window.getSelection();
        
            var range = window.getSelection().getRangeAt(0);
            console.log(range.commonAncestorContainer);
            
                var startOffset = range.startOffset;
                range.deleteContents();
                var newNode = document.createElement("span");
                newNode.innerHTML = replaceStart + selection + replaceEnd;
                range.insertNode(newNode);
                range.setStart(newNode.firstChild, startOffset);
                range.setEnd(newNode.firstChild, startOffset);
    });
}
*/

/*function getSelectedText(container_id) 
{
    
    var div = $("#area-"+container_id); //Div s textem
    var len = div.text().length;         
    console.log(len);
    
    console.log(div);
    var start = div.prop('selectionStart');//div[0].selectionStart;
    var end = div.prop('selectionEnd');//div[0].selectionEnd;
    
    console.log(start+" -> "+end);
    
    var sel = div.html().substring(start, end);
    console.log(sel);

    return sel;
}*/

/*function getSelectedText(container_id) {
    var div = document.getElementById("area-" + container_id);
    
    div.focus();
    var selection = document.getSelection();
    console.log(selection);
    
    if (selection.rangeCount > 0) {
      var range = selection.getRangeAt(0);
      
      // Pokud se výběr nachází mimo element <div>, vrátíme prázdný řetězec
      if (!div.contains(range.commonAncestorContainer)) {
        console.log("výběr se nachází mimo element <div>");
        return "";
      }
      
      var clonedRange = range.cloneRange();
      clonedRange.selectNodeContents(div);
      clonedRange.setEnd(range.endContainer, range.endOffset);
      var start = clonedRange.toString().length - range.toString().length;
      var end = start + range.toString().length;

      console.log(start+" => "+end);
      
      var sel = div.textContent.substring(start, end);
      return sel;
    } else {
      return "";
    }
  }*/

  function getSelectedText(container_id) {
    var div = document.getElementById("area-" + container_id);
    
    div.focus();
    var selection = document.getSelection();
    
    if (selection.rangeCount > 0) {
      var range = selection.getRangeAt(0);
      
      // Pokud se výběr nachází mimo element <div>, vrátíme prázdný řetězec
      if (!div.contains(range.commonAncestorContainer)) {
        console.log("výběr se nachází mimo element <div>");
        return "";
      }
      
      var clonedRange = range.cloneRange();
      clonedRange.selectNodeContents(div);
      clonedRange.setEnd(range.endContainer, range.endOffset);
      var start = clonedRange.toString().length - range.toString().length;
      var end = start + range.toString().length;
  
      if (start === end && range.toString() === '') {
        // Výběr je typu "Caret", použijeme alternativní metodu
        var caretPosition = range.startOffset;
        var textContent = div.textContent;
        var sel = textContent.substring(0, caretPosition) + textContent.substring(caretPosition + 1);
        return sel;
      }
      
      console.log(start + " => " + end);
      
      var sel = div.textContent.substring(start, end);
      return sel;
    } else {
      return "";
    }
  }


function bbrep(container_id, start, end)
{
    var div = $("#area-"+container_id);
    var tmpVal = getSelectedText(container_id);
    div.html(div.html().replace(tmpVal, start + tmpVal + end));
}