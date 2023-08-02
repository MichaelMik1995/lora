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


