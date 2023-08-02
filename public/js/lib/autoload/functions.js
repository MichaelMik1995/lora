if ( window.self !== window.top ) {
    window.top.location.href=window.location.href;
}

/**
 * On required event redirects to setted page (ex.: "auth/login" -> redirects to http(s)://www.exampleweb.com/auth/login)
 * @param string url <p>Url to redirect</p>
 * @returns bool true
 */
function redirect(url, request = 0) {
    console.log("RED: " + url);
    parse_url = url.replace(/\//g, "_");
    console.log("Redirecting... " + parse_url);
    document.location.href = url;
    return true;
}

/**
 * MReplace can replace multiple substrings in string
 * @param {Object} replaced_object          <p>Object for replacement (key->value)</p>
 * @param {String} string                   <p>Text for replacement</p>
 * @returns {String}                        <p>Returns translated string</p>
 */
function mreplace(str, find, replace) {

    return str.replace(new RegExp(find, 'g'), replace);
}

/**
 * 
 * @param element area_for_count    <p>Element with counted value (textarea, input, etc ...)</p>
 * @param element viewer            <p>Count number viewer element (div, span etc ..)</p>
 * @param int max_lenght            <p>[Optional] = max avaliable lenght; if not set = automatic sets from [area_for_count] attribute: maxlenght</p>
 * @returns bool:true
 */
function charCounter(area_for_count, viewer, max_lenght = "") {
    var area_lenght = $(area_for_count).val().length;
    $(viewer).text(area_lenght);
    if (max_lenght == "") {
        max_lenght = parseInt($(area_for_count).attr("maxlenght"));
    }

    if (area_lenght > max_lenght) {
        $(viewer).addClass("t-error");
    } else {
        $(viewer).removeClass("t-error");
    }

    return true;
}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function use_template(module, template, data) {
    var returning_data = "";
    $.post({
        url: "./App/Modules/" + ucfirst(module) + "Module/resources/ajaxphp/" + template + ".php",
        data: { data: data },
    }, (return_data) => {
        //var json_data = JSON.parse(return_data);
        returning_data = return_data;
    });

    return returning_data;
}

/**
 * 
 * @param {Integer} min
 * @param {Integer} max
 * @returns {Integer}
 */
function randomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min);
}

/**
 * Toggle input type text : password of element on OnClick event
 * @param {object} element
 * @returns void
 */
function toggleViewPassword(element)
{
    var type = $(element).attr("type");

    if(type == "password")
    {
        $(element).attr("type", "text");
    }
    else
    {
        $(element).attr("type", "password");
    }
}


/**
 * Use in event OnClick -> scrolls to anchor smoothly
 * @param {String} element 
 * @param {Integer} speed
 */
function scrollToAnchor(element, speed = 500)
{
    $('html, body').animate({
        scrollTop: $(element).offset().top
    }, speed);
}


function replaceVariables(string, data) 
{
    return string.replace(/\{(.*?)\}/g, (match, key) => data[key] || "");
}

/**
 * If selector is null|not null
 * @returns {Boolean}
 */
$.fn.exists = () => {
    return this.length !== 0;
}


