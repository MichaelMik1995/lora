/**
 * 
 * @param {type} string
 * @param {type} color
 * @returns {undefined}
 */
function colorCode(string, color)
{
    var search = string;
    $(".eTcode:contains('"+search+"')").each(function() 
    {
            var regex = new RegExp(search, 'gi');
            $(this).html($(this).html().replace(regex, "<span style='color: "+color+";'>"+search+"</span>"));
    });
}
    
var vars = ["public int ", "public float ","public bool ","public int ","public float  ", "public bool ", "string ", "int ", "float "];
for (var key in vars) {var value = vars[key];colorCode(value, "#2383B9");}

var classes = ["void", "void Start", "void Update", "void FixedUpdate", "public class", "class ", "private class", ": MonoBehaviour","using ", "namespace ", "static "];
for (var key in classes) {var value = classes[key]; colorCode(value, "#F0B519");}

var comments = ["//"];
for (var key in comments) {var value = comments[key]; colorCode(value, "#339024");}

var thisVar = ["this","this","new","Debug"];
for (var key in thisVar) {var value = thisVar[key]; colorCode(value, "#70B7CF");}

var condition = ["i"+"f","el"+"se","{","}","=="," = "];
for (var key in condition) {var value = condition[key]; colorCode(value, "#E3B13E");}

var methods = ["Play","GetComponent","GetKey","KeyCode","Vector2","Vector3","GetContacts"];
for (var key in methods) {var value = methods[key]; colorCode(value, "#35CB35");}

