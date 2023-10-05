class APP
{
    constructor()
    {
        this.appname = "Stylize version 1.0";
        this.appversion = "1.0.0";
        this.debugon = true;
    }


    writeLog(content)
    {
        if(this.debugon == true)
        {
            var date = new Date();
            var months = ["Leden", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var month = months[date.getMonth()];
            console.log("[STYLIZE]: "+date.getDate()+". "+month+" "+date.getFullYear()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()+" -"+content);
        }
    }
}





class TOKEN
{
    constructor()
    {
        this.token = localStorage.getItem("TOKEN");
    }
}



class VALIDATION
{
    constructor()
    {
        this.input = [];
        Application.writeLog("Validation module loaded");
        this.errorString = "";
        this.validationStatus = [];
    }

    /**
     *
     * @param {String} password_input1  <p>First password input</p>
     * @param {String} password_input2  <p>Second (controll) password input</p>
     * @param {Function} bad_callback   <p>Callback if validate is WRONG</p>
     * @returns {True|Event}     <p>If validation is correct = returns TRUE else bad_callback()</p>
     */
    validatePasswords(password_input1, password_input2, bad_callback = null)
    {
        var password1 = $(password_input1).val();
        var password2 = $(password_input2).val();
        if(password1 != "" && password2 != "")
        {
            if(password1 === password2)
            {
                return true;
            }
            else
            {
                if(bad_callback !== null)
                {
                    bad_callback();
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            if(bad_callback !== null)
            {
                bad_callback();
            }
            else
            {
                return false;
            }
        }
    }

    /**
     *
     * @param {type} element_input -    ID or class or other selector: ex.: #this-element; .element
     * @param {Array} validation -      Array of required validations: maxchars8|
     * @param {String} true_class       Apply these classes if Validation of this input is TRUE
     * @param {String} error_class      Apply these classes if Validation of this input is FALSE
     * @returns {Boolean|getError()}
     */
    validate(element_input, validation = [], true_class="t-create", error_class = "t-error")
    {
        //input is required
        if(validation.indexOf("required") !== -1)
        {
            var length = $(element_input).val().length;
            if(length > 0)
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.required']);
            }
        }

        if(validation.indexOf("password-validate") !== -1)
        {
            var password1 = $(element_input).val();
            var password2 = $(element_input+"-2").val();
            if(password1 === password2)
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.passwordvalidate']);
            }
        }


        //Max|Min chars
        var loop_state_count = 15;
        var prev_i = 1;
        for(var i = 0; i < loop_state_count; i++)
        {
            var number = prev_i = prev_i*2;
            if(validation.indexOf("maxchars"+number) !== -1)
            {
                var length = $(element_input).val().length;
                if(length <= number)
                {
                    this.validationStatus.push("true");
                }
                else
                {
                    this.validationStatus.push("false");
                    this.setError(Lang['validation.maxchars'+number]);
                }
            }

            if(validation.indexOf("minchars"+number) !== -1)
            {
                var length = $(element_input).val().length;
                if(length >= number)
                {
                    this.validationStatus.push("true");
                }
                else
                {
                    this.validationStatus.push("false");
                    this.setError(Lang['validation.minchars'+number]);
                }
            }

            prev_i = number;
        }

        //if input has 1 or 0
        if(validation.indexOf("0or1") !== -1)
        {
            var length = $(element_input).val().length;
            if(length === 1 && ($(element_input).val() === "0" || $(element_input).val() === "1"))
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.0or1']);
            }
        }


        //URL
        if(validation.indexOf("url") !== -1)
        {
            var regex = /^[a-z]+(-[a-z]+)*$/;
            if(regex.test($(element_input).val()))
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.url']);
            }
        }

        //EMAIL
        if(validation.indexOf("email") !== -1)
        {
            var regex = /^\S+@\S+\.\S+$/;
            if(regex.test($(element_input).val()))
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.email']);
            }
        }

        // /^\S+@\S+\.\S+$/

        //'/^([0-9 a-z\s\-]+)$/'


        //Error writer element
        var error_writer = $("*[valid-for='"+element_input+"']");


        //Check all required validation statuses
        if(this.isValidated() === true)
        {
            $(element_input).removeClass(error_class);
            $(element_input).addClass(true_class);

            $(error_writer).removeClass(error_class);
            $(error_writer).addClass(true_class);

            $(error_writer).html("<i class='fa fa-check-circle'></i>");
            this.validationStatus = [];
            return true;
        }
        else
        {
            $(element_input).removeClass(true_class);
            $(element_input).addClass(error_class);

            $(error_writer).removeClass(true_class);
            $(error_writer).addClass(error_class);

            $(error_writer).html(this.errorString);
            this.validationStatus = [];
            return false;
        }

        this.errorString = "";
    }

    isValidated()
    {
        if(this.validationStatus.indexOf("false") !== -1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    getError()
    {
        return this.errorString;
    }

    setError(error_text)
    {
        var message = "<i class='fa fa-window-close'></i> "+ error_text + " ";
        this.errorString += message;
    }
}

class ArrayFunction
{
    constructor()
    {

    }

    /**
     * Find key in array
     *
     * @param {string} needle     <p>What want you find</p>
     * @param {array} haystack    <p>In which array you finds</p>
     * @returns {Boolean}       <p>Returns true if needle is in array</p>
     */
    inArray(needle, haystack)
    {
        var length = haystack.length;
        var result = false;

        for(var i = 0; i < length; i++)
        {
            if(haystack[i] == needle)
            {
                result = true;
            }
        }
        return result;
    }
}


class ElementFunction
{
    constructor()
    {
        Application.writeLog("Function module Loaded");
    }

    /**
     *
     * @param {Element} element
     * @param {Element} parent_element
     * @param {String} type
     * @returns {CSS}
     */
    alignCenter(element, parent, type="both")
    {
        //Element geometry
        var elementWidth = $(element).width();
        var elementHeight = $(element).height();

        //parent geometry
        var parentWidth = $(parent).width();
        var parentHeight = $(parent).height();

        var marginVertical = (parentHeight-elementHeight)/2;

        switch(type)
        {
            case "both":
                $(element).css({marginTop: marginVertical+"px", marginBottom: marginVertical+"px", textAlign: "center"});
                break;
        }

        console.log(parentHeight+"-"+elementHeight);
    }

    imgAlt(alt_image_url, img_element = $(this))
    {
        var image_element_src = $(img_element).attr('src'); //

        $.ajax({
            url: image_element_src,
            type: 'HEAD',
            error: function () {
                //file not exists
                $(img_element).attr('src', alt_image_url);

            },
            success: function ()
            {
                //file exists
            }
        });
    }
}



'use strict';

class FormClass
{
    /**
     *
     * @param {String} input_element
     * @returns {Event}
     */
    toggleTypePassword(input_element)
    {
       var type = $(input_element).attr("type");
       if(type === "text")
       {
           $(input_element).attr("type", "password");
       }
       else
       {
           $(input_element).attr("type", "text");
       }
    }
}



class LStorage
{
    constructor()
    {

    }

    getToken()
    {
        return localStorage.getItem("TOKEN");
    }

    getSID()
    {
        return localStorage.getItem("SID");
    }

    getCsrf()
    {
       return "<input hidden type='text' name='token' value='"+this.getToken()+"'> <input hidden type='text' name='SID' value='"+this.getSID()+"'>";
    }
}



/**
 * Class for L-Attributes
 * @type type
 */
class StylizeFunction
{
    constructor()
    {
        Application.writeLog("StylizeFunction module loaded");


            //this.stylesheetsOverride();

            this.copyElement();

            this.buttonCircle();
            this.contentAdaptive();
            this.childClasses();

            this.getAttribute();
            this.changeClass();
            this.listenURL();
            this.conditions();
            this.eventToggleClass();
            this.backgroundFunctions();
            this.validationValidate();
            this.redirect();
            this.contentHeightAuto();
            this.templateAttr();
    }

    buttonCircle()
    {
        $(document).ready(() => {
            var all_elements = $(".button-circle");

            if(all_elements.length > 0)
            {
                for(var i = 0; i <= all_elements.length; i++)
                {
                    var one_element = $("body .button-circle:eq("+ i +")");
                    var element_width = one_element.width();
                    var text_size = element_width/2;
                    $(one_element).css({"height": element_width+"px", "fontSize": text_size+"px"});
                }
            }

        });
    }

    contentAdaptive()
    {
        $(document).ready(() => {
            var all_elements = $(".t-adaptive");

            if(all_elements.length > 0)
            {
                for(var i = 0; i <= all_elements.length; i++)
                {
                    var one_element = $("body .t-adaptive:eq("+ i +")");
                    var element_height = one_element.height();
                    var text_size = element_height/3;
                    $(one_element).css({"fontSize": text_size+"px"});
                }
            }
        });
    }

    childClasses()
    {
        $(document).ready(() => {
            var all_elements = $("*[child-class]");

            if(all_elements.length > 0)
            {
                for(var i = 0; i <= all_elements.length; i++)
                {

                    //Grap each element and his attr **child-class**
                    var one_element = $("body *[child-class]:eq("+ i +")");
                    var get_classes = $(one_element).attr("child-class");

                    var each_element_in = $("body *[child-class]:eq("+ i +") > *");


                    if(each_element_in.length > 0)
                    {
                        for(var x = 0; x <= each_element_in.length; x++)
                        {
                            var each_el = $("body *[child-class]:eq("+ i +") > :eq("+ x +")");
                            each_el.addClass(get_classes);

                        }
                    }
                    else
                    {
                        console.log("StylizeFunction->childClasses: no child element in");
                    }
                }
            }
        });
    }

    listenURL()
    {
        $(document).ready(() => {
            var element = $("body *[listen-url]");
            if(element.length > 0)
            {
                for(var i = 0; i <= element.length; i++)
                {
                    //Grap each element and his attr **child-class**
                    var one_element = $("body *[listen-url]:eq("+ i +")");
                    var get_tracked_url = $(one_element).attr("listen-url");

                    var actual_url = window.location.href;
                    if (actual_url.indexOf(get_tracked_url) >= 0)
                    {
                        var get_tracked = $(one_element).attr("url-valid");

                        var explode = get_tracked.split(":");

                        if(explode[0] == "addClass")
                        {
                            if(!$(one_element).hasClass(explode[1]))
                            {
                                $(one_element).addClass(explode[1]);
                            }

                        }
                        else if(explode[0] == "removeClass")
                        {
                            $(one_element).removeClass(explode[1]);
                        }
                        else if(explode[0] == "toggleClass" && explode[2] != "")
                        {
                            $(one_element).removeClass(explode[1]).addClass(explode[2]);
                        }
                        else
                        {
                            $(one_element).attr(explode[0], explode[1]);
                        }
                    }
                }
            }

        });
    }

    getAttribute()
    {
        $(document).ready(() => {
            var element = $("body *[copy-attr]");
            if(element.length > 0)
            {
                for(var i = 0; i <= element.length; i++)
                {
                    //Grap each element and his attr **child-class**
                    var one_element = $("body *[copy-attr]:eq("+ i +")");

                    var get_value = $(one_element).attr("copy-attr");

                    var explode = get_value.split(":");

                    var copied_id = explode[0];
                    var copied_attr = explode[1];

                    var get_attr_value = $("#"+copied_id).attr(copied_attr);

                    $(one_element).attr(copied_attr,get_attr_value);
                }
            }

        });
    }

    changeClass()
    {
        //Adding new class
        this.loopSelectedElements("add-class", (i) => {
           var one_element = $("body *[add-class]:eq("+ i +")");

            var get_new_class = $(one_element).attr("add-class");

            var current_classes = $(one_element).attr("class");
            var add_class = current_classes+" "+get_new_class;

            $(one_element).attr("class", add_class);
        });

        //Remove class
        this.loopSelectedElements("remove-class", (i) => {
           var one_element = $("body *[remove-class]:eq("+ i +")");

            var get_new_class = $(one_element).attr("remove-class");

            var current_classes = $(one_element).attr("class");
            var remove_class = current_classes.replace(get_new_class, "");

            $(one_element).attr("class", remove_class);
        });

        //Toggle class
        this.loopSelectedElements("toggle-class", (i) => {
            //Grap each element and his attr **child-class**
            var one_element = $("body *[toggle-class]:eq("+ i +")");

            var get_value = $(one_element).attr("toggle-class");

            var explode = get_value.split(":");

            var old_class = explode[0];
            var new_class = explode[1];

            $(one_element).removeClass(old_class).addClass(new_class);
        });
    }

    copyElement()
    {
          this.loopSelectedElements("copy-element", (i,a, one_element) => {
               var get_copied_id = $(one_element).attr(a);
               var copied_html_data = $("#"+get_copied_id).html();
               var get_data = $(one_element).attr("data");
               var comma_separe = get_data.split(",");
               var replaced_data = copied_html_data;

               for(var x = 0; x < comma_separe.length; x++)
               {
                   var parameter = comma_separe[x];
                   var value_split = parameter.split(":");

                   replaced_data = replaced_data.replace("{"+value_split[0]+"}", value_split[1]);
               }

               $(one_element).append(replaced_data);

          });
    }

    loopSelectedElements(attribute, operation)
    {
        $(document).ready(() => {
            var element = $("body *["+attribute+"]");
            if(element.length > 0)
            {
                for(var i = 0; i <= element.length; i++)
                {
                    var one_element = $("body *["+attribute+"]:eq("+ i +")");
                    operation(i, attribute, one_element);
                }
            }
        });
    }

    eventToggleClass()
    {
        this.loopSelectedElements("event-toggle-class", (i,a,el) => {
            var get_attribute_value = $(el).attr(a);
            var split = get_attribute_value.split(":");

            $(el).on(split[0], (e) => {
               e.preventDefault();
               if(split[3] != "")
               {
                   if($(split[3]).hasClass(split[1]))
                   {
                       console.log("TRUE");
                       $(split[3]).removeClass(split[1]).addClass(split[2]);
                   }
                   else
                   {
                       $(split[3]).removeClass(split[2]).addClass(split[1]);
                   }

               }
               else
               {
                   if($(el).hasClass(split[1]))
                   {
                       $(el).removeClass(split[1]).addClass(split[2]);
                   }
                   else
                   {
                       $(el).removeClass(split[2]).addClass(split[1]);
                   }
               }

            });
        });
    }

    validationValidate()
    {
        this.loopSelectedElements("validation", (i,a,el) => {
            var getValue = $(el).attr(a);
            var array_explo = getValue.split(",");
            var get_id = $(el).attr("id");
            $(el).on("keyup", () => {
                Validation.errorString = "";
                Validation.validate("#"+get_id, array_explo);
            });
        });
    }

    redirect()
    {
        this.loopSelectedElements("redirect", (i,a,el) => {
            var get_value = $(el).attr(a);
            var array_explo = get_value.split(":");

            if(array_explo.length === 1)
            {
                $(el).on("click", () => {
                   redirect(get_value);
                });
            }
            else
            {
                $(el).on("click", () => {
                   redirect(array_explo[0], array_explo[1]);
                });
            }
        });
    }

    contentHeightAuto()
    {
        this.loopSelectedElements("content-height-auto", (i,a,el) => {
            var get_value = $(el).attr(a);
            var value_split = get_value.split(":");

            var element_w_height = Math.max.apply(null, $("body *["+a+"="+value_split[0]+"]").map(function ()
            {
                return $(this).height();
            }).get());

            /*if(value_split.lenght > 1)
            {
                $(document).resize(() => {
                    //if($(window).width() >= 768)
                    //{
                        $(el).height(element_w_height);
                    //}
                });
            }
            else
            {
                $( window ).on( "orientationchange", function( event ) {
                    $(el).height(element_w_height);
                });
                //if($(window).width() >= 768)
                //{

                //}
            }  */
            $(el).height(element_w_height);
            $( window ).on( "orientationchange", function() {
                $(el).height(element_w_height);
            }).resize(() => {
                $(el).height(element_w_height);
            });
        });
    }

    conditions()
    {
        this.loopSelectedElements("if", (i,a,el) => {
            var get_condition = $(el).attr(a);

            var explode = get_condition.split(" ");
            var first = explode[0];
            var cond = explode[1];
            var second = explode[2];

            if(cond === "==")
            {

            }
        });
    }

    templateAttr()
    {
        this.loopSelectedElements("template", (i,a,el) => {
           var get_condition = $(el).attr(a);
           if(get_condition === "1" || get_condition === "true")
           {
               $(el).addClass("display-0");
           }
        });
    }

    backgroundFunctions()
    {
        /*this.loopSelectedElements("background-fill", (i, a, el) => {
            var get_attribute = $(el).attr(a);

        });*/
    }
}



/**
 * Description of Web stylize javascript class module
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class WPAGE
{
    constructor()
    {
        Application.writeLog("Web module loaded");
    }

    /**
     *
     * @param {String} element
     * @param {Integer} interval (in /ms)
     * @param {String} page_to_load
     * @returns {undefined}
     */
    reloadDiv(element, interval)
    {
        // 60000 = 1 minute
        setInterval(function() { $(element).load(location.href + ' '+element); }, interval);
        console.log("test");
    }
}



function setToCenterOfParent(element, parent, ignoreWidth = false, ignoreHeight = false){
        parentWidth = $(parent).width();
        parentHeight = $(parent).height();

        elementWidth = $(element).width();
        elementHeight = $(element).height();

        if(!ignoreWidth)
            $(element).css('left', parentWidth/2 - elementWidth/2);
        if(!ignoreHeight)
            $(element).css('top', parentHeight/2 - elementHeight/2);
    }

/**
 * Function that allows write TAB at inputs (text-area, inputs, div etc)
 * @param string element
 * @returns Boolean
 */
function tabulator(element)
{
    $(element).keydown(function(e)
    {
        if (e.key === 'Tab')
        {
          e.preventDefault();
          var start = this.selectionStart;
          var end = this.selectionEnd;

          // set textarea value to: text before caret + tab + text after caret
          this.value = this.value.substring(0, start) +
            "\t" + this.value.substring(end);

          // put caret at right position again
          this.selectionStart =
            this.selectionEnd = start + 1;
        }
    });
return true;
}
/* TRIGGERS */


function cookieBar()
{
    if(getCookie("cookies_accepted") == "")
    {
        var element = "<div id='cookie_bar' class='row bottom-fixed pd-2 background-dark-3 bd-top-basic'>"+
            "<div class='column-8 column-10-xsm'>"+
                "<div class='row'>"+
                    "<div class='column-5'>"+
                        "<div class='header-6 pdy-1 t-bolder'>"+
                            "Vážíme si Vašeho soukromĂí (lišta ve vývoji)"+
                        "</div>"+
                        "<div class=''>"+
                            "Používáme cookies, abychom Vám umožnili pohodlně prohlĂ­ĹľenĂ­ webu a dĂ­ky analĂ˝ze provozu webu neustĂˇle zlepĹˇovali jeho funkce, vĂ˝kon a pouĹľitelnost."+
                            "<br><br>VĂ­ce informacĂ­ o registraci a sbÄ›ru dat <a class='a-link ws-href t-basic' href='/auth/rules' target='_blank'>zde</a>."+
                        "</div>"+
                    "</div>"+
                    "<div class='column-5'>"+
                        "<div class='header-6 pdy-1 t-bolder'>"+
                            "JakĂˇ data tento web sbĂ­rĂˇ?"+
                        "</div>"+
                        "<div class=''>"+
                            "WebovĂˇ strĂˇnka sbĂ­rĂˇ data v podobÄ› pĹ™ihlaĹˇovacĂ­ch ĂşdajĹŻ (pĹ™ihlaĹˇovacĂ­ jmĂ©no, email, otisk hesla)"+
                        "</div>"+
                    "</div>"+
                "</div>"+
            "</div>"+
            "<div class='column-1 column-10-xsm content-center mg-auto'>"+
                "<div class='pdy-1'><button id='cookies_accepted' class='button button-basic width-100'>PĹ™ijmout</button></div>"+
                "<div class='pdy-1'><button id='cookies_rejected' class='button button-basic width-100'>ZamĂ­tnout</button></div>"+
                "<div class='pdy-1'><button id='cookies_view_settings' class='button button-basic width-100'>NastavenĂ­</button></div>"+
            "</div>"+
        "</div>";

        $("body").append(element);
        $("#cookie_bar").show(200);
    }
}

$(document).ready(function(){
        //cookieBar();

    $("#cookies_accepted").click(function()
    {
        $("#cookie_bar").fadeOut(300);
        setCookie("cookies_accepted", true, 30);
    });

    $("#cookies_rejected").click(function()
    {
        $("#cookie_bar").fadeOut(300);
        setCookie("cookies_accepted", false, 30);
    });
});



/**
 *
 * @param {type} cname
 * @param {type} cvalue
 * @param {type} exdays
 * @returns {undefined}
 */
function setCookie(cname, cvalue, exdays)
{
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname)
{
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

/**
 * Description of counter stylize javascript class module
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class counter
{
    constructor()
    {
        Application.writeLog("counter module loaded");
    }

    /**
     *
     * @param {String} area_element Element for counting chars (textarea, input etc..)
     * @param {String} count_view_element   element for printing count chars
     * @param {Integer} max_chars   max allowed chars for area_element
     * @param {String} error_element    element for catching errors
     * @returns {Event}
     */
    counterChars(area_element, count_view_element, max_chars = 256, error_element = "#after-counter")
    {
        var value = $(area_element).val();
        var val_length = value.length;

        $(count_view_element).text(val_length);
        if(val_length > max_chars)
        {
            $(area_element).addClass("bd-bottom-error");

            if(!($("#counter-error-text").length))
            {
                $(error_element).html("<span id='counter-error-text' class='t-error'>Text nesmí přesáhnout limit!</span>");
            }
        }
        else
        {
            $(area_element).removeClass("bd-bottom-error");
            $("#counter-error-text").remove();
        }

    }
}



class GUIDIALOG
{
    constructor()
    {
        Application.writeLog("GUIDialog module Loaded");
    }

    /**
     *
     * @param {string} string
     * @param {array} variables
     * @returns {Boolean}
     */
    dialogInfo(string, variables = null)
    {
        this.generateDialog(string+"<div class='mgy-2'><button id='dialog_ok' class='button button-basic'>OK</button></div>", "Informace", variables);
        $("#dialog_ok").click(function(){
           $("#dialog_close").trigger("click");
        });
        return 1;
    }

    /**
     * Open confirm dialog = if user confirms -> do callback() else only hide dialog
     * @param string string
     * @param function callback
     * @param array variables [confirm_text, noconfirm_text]
     * @returns callback|null
     */
    dialogConfirm(string, callback = null, variables = null)
    {
        var confirm_button_text = "OK";
        var no_confirm_button_text = "Zavřít";

        if(variables !== null)
        {
            for (const [key, value] of Object.entries(variables))
            {
                switch(`${key}`)
                {
                    case "confirm_text":
                        confirm_button_text = `${value}`;
                        break;

                    case "noconfirm_text":
                        no_confirm_button_text = `${value}`;
                        break;

                }
            }
        }

        var dialog_content = "<div class='pdx-1 pdy-2 header-6'>"+string+"</div><button id='dialog_confirm_close' class='button button-warning mgx-1 bd-round-1'>"+no_confirm_button_text+"</button>"+
                        "<button type='submit' id='dialog_confirm_true' class='button button-basic bd-round-1'>"+confirm_button_text+"</button>";

        this.generateDialog(dialog_content, "Vyžádáno potvrzení", variables, callback);

        $("#dialog_confirm_close").click(function()
        {
            $("#dialog_close").trigger("click");
        });
    }


    dialogAntispam(header, callback = null, variables = null)
    {
        var result;

        if(variables !== null)
        {
            for (const [key, value] of Object.entries(variables))
            {
                switch(`${key}`)
                {
                    case "result":
                        result = "`${value}`";
                        break;
                }
            }
        }

        var dialog_content = "<div>"+header+"</div><div class='pdy-1 pdx-1 mgy-1'><input id='antispam_input' type='text' class='bd-basic bd-2 pd-2'><br><span id='error_text' class='display-0 t-error'></span></div>"+
                    "<div class='content-right content-center-sm pd-1 pdy-2'>"+
                        "<button id='dialog_confirm_reset' class='display-0 button button-basic mgx-1 bd-round-1'><i class='fa fa-xmark'></i> Reset</button>"+
                        "<button id='dialog_confirm_true' class='button button-basic bd-round-1'>OK</button>"+
                    "</div>";


        this.generateDialog(dialog_content, "Antispam", variables);

        $("#dialog_confirm_true").click(function()
        {
            console.log(result+$("#antispam_input").val());
            if(result === $("#antispam_input").val())
            {
                callback();
            }
            else
            {
                $("#antispam_input").addClass("bd-error t-error");
                $("#error_text").html("<i class='fa fa-triangle-exclamation'></i> NesprĂˇvnĂ˝ Ăşdaj!").slideDown(200);
                $("#dialog_confirm_reset").show(200);
            }
        });

        $("#dialog_confirm_reset").click(function(){
            $("#antispam_input").removeClass("bd-error t-error").val("");
            $("#error_text").slideUp(200, function(){$("#error_text").html("")});
            $(this).hide(200);
        });
    }

    /**
     *
     * @param {string} content
     * @param {Object} callback
     * @param {string} dialog_header
     * @param {Array} variables
     * @returns {Boolean}
     */
    dialogForm(content, callback, dialog_header = "FormulĂˇĹ™", variables = null)
    {
            var html_content = $(content).html();
            this.generateDialog(html_content, dialog_header, variables, callback);

            return 1;
    }


    /**
     *
     * @param {Element} content
     * @param {String} dialog_header
     * @param {Array} variables
     * @param {Function} callback
     * @returns {Dialog}
     */
    generateDialog(content, dialog_header, variables, callback)
    {

        //$("#dialog").fadeOut("slow", function() { $(this).remove()});

        //Defautl variables
        var dialog_width = "width-30"; //in percent
        var theme = "dark";

        if(variables !== null)
        {
            for (const [key, value] of Object.entries(variables))
            {
                switch(`${key}`)
                {
                    default:
                        console.log("Parameter: "+`${key}`+" - not found in object");
                        break;

                    case "width":
                        dialog_width = `${value}`;
                        break;

                    case "theme":
                        if(`${value}` === "light")
                        {
                            theme = "light";
                        }
                        else
                        {
                            theme = "dark";
                        }
                        break;
                }
            }
        }

        var dialog_classes = dialog_width+" stylize-dialog-panel width-100-xsm mgy-1 bd-round-3 background-"+theme+"-2 bd-2 bd-solid bd-"+theme+"-1";
        var dialog_element = "\
            <div id='dialog' class='display-0 stylize-dialog-info pdy-10'>"+
                "<div class='"+dialog_classes+"'>"+
                    "<div id='info_handler' class='row cursor-move pd-1 pdy-2 header-6 content-left t-bolder'>"+
                        "<div class='column-6'>"+dialog_header+"</div>"+
                        "<div class='column content-right'><button id='dialog_close' class='button-small button-basic mgx-1 bd-round-1'><i class='fa fa-xmark'></i></button></div>"+
                    "</div><hr>"+
                    "<div class='pdy-4 pdx-1 header-6 background-"+theme+"-3'>"+content+"</div>"+
                    "<div class='content-right content-center-sm pd-1 pdy-2'>"+
                    "</div>"+
                "</div>"+
            +"</div>";

        $("body").append(dialog_element).delay(200);
        $("#dialog").fadeIn("slow");

        $("#dialog").draggable({handle: "#info_handler"});

        $("#dialog [type='submit']").click(function(){
            callback();
        });

        $("#dialog_close").click(function(){
            $("#dialog").fadeOut("slow", function() { $(this).remove();});
        });
    }

    dialogImage(path = "public/img/user/952988803/images/thumb", variables = null)
    {

        const DImage = new DialogImage(path);
        const storage = new LStorage();

        var csrfgen = storage.getCsrf();
        var theme = "light";
        var offset = "1";
        var screenWidth = $(window.top).width();
        var screenHeight = $(window.top).height();
        var image_content = "";



        var dialog_padding = $(window.top).height()/3;

        $.post("./plugins/lora/stylize/src/ajaxphp/image_gallery.php",
        {
          path: path
        },

        function(data, status)
        {
            const json_data = data;
            const object_data = JSON.parse(json_data);
            image_content = object_data.images;


            if(variables !== null)
            {
                for (const [key, value] of Object.entries(variables))
                {
                    switch(`${key}`)
                    {
                        default:
                            console.log("Parameter: "+`${key}`+" - not found in object");
                            break;

                        case "width":
                            dialog_width = `${value}`;
                            break;

                        case "theme":
                            if(`${value}` === "light")
                            {
                                theme = "light";
                            }
                            else
                            {
                                theme = "dark";
                            }
                            break;
                    }
                }
            }
            //Generate Image UI
            var dialog_classes = "width-100 mg-auto bd-round-3 background-"+theme+"-2 bd-3 bd-solid bd-"+theme+"-1";
            var dialog_element = "\
                <div id='dialog' class='display-0 stylize-dialog-image pd-"+offset+"'>"+
                    "<div class='"+dialog_classes+" height-95' style='max-height: 95%; overflow: auto;'>"+
                        "<div class='row pd-1 pdy-2 header-6 content-left t-bolder'>"+
                            "<div class='column-6'>Dialog: </div>"+
                            "<div class='column content-right'><button id='dialog_close' class='button-small button-basic mgx-1 bd-round-1'><i class='fa fa-xmark'></i></button></div>"+
                        "</div><hr>"+
                        "<div class='row pd-1 pdx-1 background-"+theme+"-3 bd-3 bd-"+theme+"-2'>"+
                            "<div class='column-8 column-10-xsm pd-1 bd-3 bd-"+theme+"-2'>"+   //Column1 - Droppable
                                "<form class='' method='post' enctype='multipart/form-data'>"+csrfgen+"<input type='file' id='images' name='images' multiple></form>"+
                                "<div class='row pd-1 cols-5 cols-2-xsm images-view height-auto'>"+
                                    image_content+
                                "</div>"+
                            "</div>"+
                            "<div class='column-2 column-10-xsm pd-1'>"+   //Column1 - Droppable
                                "<div class='header-4'>Podrobnosti: </div><div id='image-description'></div>"+
                            "</div>"+
                        "</div><hr>"+
                        "<div id='form-add-images'>"+

                            "<button id='add-images' class='button button-basic'>VloĹľit ObrĂˇzky</button>"+
                        "</div>"+
                    "</div>"+

                +"</div>";

            $(".images-view").sortable();

            $("body").append(dialog_element).ready(function ()
            {
                //element_func.alignCenter("#image-drop", "#image-drop-div");

            });

            $(".image-thumbnail").click(function(){



                $.post("./plugins/lora/stylize/src/ajaxphp/image_description.php",
                {
                  image: $(this).attr("src")
                },
                function(data)
                {
                    const json_data_desc = data;
                    const description_data = JSON.parse(json_data_desc);
                    var description_side = "<div class='content-center'><img class='image-view' src='"+description_data.image+"' style='max-height:128px;'></div>"+
                            "<div class='width-100'>"+
                                "Velikost: "+description_data.filesize+"<br>"+
                                "RozliĹˇenĂ­: "+description_data.width+"x"+description_data.height+"<br>"+
                                "RozliĹˇenĂ­ nĂˇhledu: "+description_data.thumb_width+"x"+description_data.thumb_height+"<br>"+
                            "</div>";

                    $("#image-description").html(description_side);
                    $(this).attr("src", description_data.path);
                    $(".image-view").attr("src", description_data.path);

                    $(".image-view").click(function(){
                        DImage.openSlider($(this));
                    });
                });
            });

            $("#dialog").fadeIn("slow");

            $("#add-images").click(function(){
                $("#form-images").submit();
            });

            $("#dialog [type='submit']").click(function(){
                callback();
            });

            $("#dialog_close").click(function(){
                $("#dialog").fadeOut("slow", function() { $(this).remove();});
            });
        });
    }

    dialogNotification(id, title, content)
    {
        var element_notification = "<div id='dialog-notification-"+id+"' class='row mgy-2'>"+
                "<div class='column-2'>"+

                "</div>"+
                "<div class='column column-2-sm'>"+

                "</div>"+
                "<div class='column-2 column-6-sm'>"+
                    "<div class='background-dark-2 bd-round-3 bd-top-basic'>"+
                        "<div class='row background-dark pd-2'>"+
                            "<div class='column-5'>"+
                                title+
                            "</div>"+
                            "<div class='column-5 content-right'>"+
                                "<i onClick=\"$('#dialog-notification-"+id+"').fadeOut(300, () => {$('#test-notification-"+id+"').remove()});\" class='fa fa-window-close'></i>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                    "<div class='pd-2 background-dark-2'>"+
                        content+
                    "</div>"+
                "</div>"+
            "</div>"+
            "<script>setTimeout(() => {$('#test-notification-"+id+"').fadeOut(300, () => {$('#test-notification-"+id+"').remove()});}, 8000)</script>";

            return element_notification;
    }
}

class GUIFLOATTABLES
{
    constructor()
    {
        Application.writeLog("GUIFloatTables module loaded");
    }

    /**
     * Creating floating table element under object: event_object
     *
     * @param {String} content <p>HTML content to draw into floating table</p>
     * @param {Element} event_object <p>Targeted object (on event OnClick, onMouseOver etc ..)</p>
     * @param {Callback} callback   <p>Callback on draw table</p>
     * @param {Array} options       <p>Posible options: theme='light',minwidth='4em',minheight='10em',classes='pd-2',offsetx='0',offsety='35'</p>
     * @param {String} table_name   <p>ID of new created table (default: testable)</p>
     * @returns {HTML Element}
     */
    tableFloat(content, event_object = $(this), callback = null, options = null, table_name ="testable")
    {
        var theme = "light";
        var width = "4em";
        var height = "10em";
        var classes = "pd-2";
        var offsetX = 0;
        var offsetY = 35;

        if(options !== null)
        {
            for (const [key, value] of Object.entries(options))
            {
                switch(`${key}`)
                {
                    case "theme":
                        theme = `${value}`;
                        break;

                    case "minwidth":
                        width = `${value}`;
                        break;

                    case "minheight":
                        height = `${value}`;
                        break;

                    case "classes":
                        classes = `${value}`;
                        break;

                    case "offsetx":
                        offsetX = `${value}`;
                        break;

                    case "offsety":
                        offsetY = `${value}`;
                        break;
                }
            }
        }

        var objectPosX = $(event_object).position().left;
        var objectPosY = $(event_object).position().top;

        var tablePosX;

        if(offsetX < 0)
        {
            tablePosX = Math.round(objectPosX)-(offsetX*-1);
        }
        else if(offsetX > 0)
        {
            var rounded = Math.round(objectPosX);
            tablePosX = ((rounded*1) + (offsetX*1));
        }
        else
        {
            tablePosX = objectPosX*1;
        }

        var tablePosY;
        if(offsetY < 0)
        {
            tablePosY = Math.round(objectPosY)-(offsetY*-1);
        }
        else if(offsetY > 0)
        {
            var rounded = Math.round(objectPosY);
            tablePosY = ((rounded*1) + (offsetY*1));
        }
        else
        {
            tablePosY = objectPosY*1;
        }


        var table = "\
                <div onMouseLeave='$(this).remove()' id='"+table_name+"' class='background-"+theme+"-2 bd-round-2 bd-"+theme+"-1 "+classes+"' style='z-index: auto; position: absolute; left: "+tablePosX+"px; top: "+tablePosY+"px; min-width: "+width+"; min-height: "+height+"'>"+
                         content
                "</div>";

        if($("#"+table_name).is(":visible"))
        {
            $("#"+table_name).remove();
        }
        else
        {
            $("body").prepend(table);
        }

        if(callback != null)
        {
            callback();
        }

        $(event_object).on('click', () => {
            $("#"+table_name).remove();
        });

    }

}

$(document).ready(function(){
    var imageRel = $("*[rel='easySlider']");
    //var marginHorisontal = 1;
    //var marginVertical = 1;

    //Get Resolution PC
    var resX = $(window).width();
    var resY = $(window).height();

    //var getPositionX = parseInt(resX/100*marginHorisontal); //in px
    //var getPositionY = parseInt(resY/100*marginVertical); //in px

    //On image hover
    imageRel.hover(function()
    {
        $(this).css({"opacity":"0.5", "cursor":"pointer"});
    }, function(){
        $(this).css({"opacity":"1", "cursor":"default"});
    });

    //var padding = "style=\"padding: "+getPositionY+"px "+getPositionX+"px "+getPositionY+"px "+getPositionX+"px\"";
    //var createDiv = "<div id=\"eS_imageViewer\" class=\"eS_imageViewer\"></div>";

    //On image Click
    imageRel.click(function()
    {
        var createDiv = "<div title='KliknutĂ­m zavĹ™ete obrĂˇzek' id=\"eS_imageViewer\" class=\"eS_imageViewer mg-auto-all pd-5 pd-1-xsm pd-1-sm\"></div>";

        var imageSrc = $(this).attr("src");
        var open_image = imageSrc.replace("/thumb","");


        var imageViewerHeader = "\
                <div class=\"row pd-2\">"+
                "<div class='column-5'>"
                "</div>"+
                "<div class='column-5 content-right'>"+
                    "<button id='eS_close' class='button button-error bd-round-symetric'><i class='fa fa-window-close'></i></button>"+
                 "</div>"+
                "</div>";



        const img = new Image();
        img.onload = function()
        {
            let image_res_x;
            let image_res_y;

          image_res_x = this.width;
          image_res_y = this.height;
            var image_size;

            //alert("X - "+resX + " -> Y - "+resY);
            if(resX > resY)     //Computer landscape
            {
                if(image_res_x > image_res_y)       //if image landscape
                {
                    image_size = "width: 90%; height: auto;";
                }
                else if(image_res_x === image_res_y)
                {
                    image_size = "width: 90vh; height: auto;";
                }
                else
                {
                    image_size = "width:auto; height: 90vh;";
                }

            }
            else
            {                                   //Computer portrait
               if(image_res_x > image_res_y)    //Computer landscape
                {
                    image_size = "width: 95%; height: auto;";
                }
                else if(image_res_x === image_res_y)
                {
                    image_size = "width: 90vh; height: auto;";
                }
                else
                {
                    image_size = "width:auto; height: 95vh";
                }
            }

            var image = "<div class='width-100 content-center'><img style='z-index: 99; "+image_size+"' id=\"image_es\" src=\""+open_image+"\"></div>";


            $("html").prepend(createDiv).delay(300);
            $("#eS_imageViewer").fadeIn(400);
            $("#eS_imageViewer").html(imageViewerHeader+image);

            $("#eS_imageViewer").click(function()
            {
                $("#eS_imageViewer").fadeOut(400).html();
                setTimeout(() => {
                    $("#eS_imageViewer").remove();
                }, 300);
            });

        };

        img.src = open_image;
        img.id = "temp_image";




    });
});


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
