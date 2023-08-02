/**
     * @param {element id} triggerId        trigger to view dialog
     * @param {string} loadHref             dialog HTML page
     * @returns {boolean}
     */
 function loadDialog(triggerId, loadHref, external_prefix="")
 {
     
     $("#"+triggerId).click(function(e)
     {
        // $(".easyText-Dialog").remove();
         e.preventDefault();
        // var dialogDiv = "<div class='easyText-Dialog' id='dialogDiv'></div>";
        
        //var dialog = "/resources/easytext/dialog/eT_panel/"+loadHref+".php";
        var dialog = "/plugins/lora/easytext/dialogs/"+loadHref+".php";
         //$("body").append(dialogDiv);
         var dialog_block = "<div class=''></div>";
         $(".easyText-Dialog_block").toggle("drop", 200);
         
         $(".easyText-Dialog").load(dialog, function()
         {
             
         //For Each function in et dialog
             
             $(".dialog-color-choose").click(function()
             {
                 var color = $(this).attr("name");
                 var select = $("."+external_prefix+"easyText_textarea").selection();
                 $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[col:"+color+"]"+select+"[*/Color]"});
                 $("#dialogDiv").hide(100); 
             });
         
         //Insert Color Code
             $("#easyText_color_insert").click(function(){
                var select = $("."+external_prefix+"easyText_textarea").selection();
                var colorChooser = $("#colorChooser").val();
                $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[col:"+colorChooser+"]"+select+"[*/Color]"});
                $("#dialogDiv").hide(100);
             });
             
             
         //Insert Image from gallery
             $("#image_choose_gallery img").click(function(){
                  var fullPath = $(this).attr("id");
                  var imageName = fullPath.replace("../../../../web/upload/user_upload/"+user+"/image/", "");
                  var imgContent = "[Img]"+imageName+"[/Img]";
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: imgContent});
                  $("#dialogDiv").hide(100);
                  
             });
             
             $("#url_img_toArea").click(function(){
                 var url = $("#image_url").val();
                 //var textArea_content = $("."+external_prefix+"easyText_textarea");
                 //textArea_content.val(textArea_content.val()+"[Img]"+url+"[/Img]");
                 var imgContent = "[Img]"+url+"[/Img]";
                 $("."+external_prefix+"easyText_textarea").selection('replace', {text: imgContent});
                     $("#dialogDiv").hide(100);
             });
             
         //Insert Emoticon from Gallery
             $(".emoji-dialog-emoticon").click(function(e){
                 e.preventDefault();
                 var imageName = $(this).attr("id");
                 switch(imageName)
                 {
                     case "smile": var emojiName = ":)"; break;
                     case "sad": var emojiName = ":("; break;
                     case "gloomy": var emojiName = ";/"; break;    
                     case "happy": var emojiName = ":D"; break;
                     case "wonder": var emojiName = ":O"; break;
                     case "smile_crying": var emojiName = ";D"; break;
                     case "tong": var emojiName = ":P"; break;
                     case "flirt": var emojiName = ";)"; break;
                     case "loving": var emojiName = ":*"; break;
                     case "snd_heart": var emojiName = ";)"; break;
                     case "angry": var emojiName = "3:("; break;
                     case "dvl_smile": var emojiName = "3:D"; break;
                     case "frog": var emojiName = "**frog**"; break;
                     case "love": var emojiName = "<3"; break;
                     case "like": var emojiName = "**y**"; break;
                     case "clown": var emojiName = "**clown**"; break;
                     case "ill": var emojiName = "**ill**"; break;
                     case "music": var emojiName = "**music**"; break;
                     case "sick": var emojiName = "**sick**"; break;
                     case "gem": var emojiName = "**gem**"; break;
                     case "pan": var emojiName = "**pan**"; break;
                     case "grenade": var emojiName = "**grenade**"; break;
                 }
                 
                 var textArea_content = $("."+external_prefix+"easyText_textarea");
                 textArea_content.val(textArea_content.val()+" "+emojiName);
                 $('#dialogDiv').hide(100);
             });
             
             //Function on header dialog
             $("#range_header").on("input", function(){
                 var valueRange = $("#range_header").val();
                 var headerId = "#header_view";
                 var numberId = "#header_num";
                 switch(valueRange)
                 {
                     case "1":
                         var fontSize = "2em";
                         var text = "1";
                         break;
                         
                     case "2":
                         var fontSize = "1.5em";
                         var text = "2";
                         break;
                         
                     case "3":
                         var fontSize = "1.17em";
                         var text = "3";
                         break;
                         
                     case "4":
                         var fontSize = "1em";
                         var text = "4";
                         break;
                         
                     case "5":
                         var fontSize = ".83em";
                         var text = "5";
                         break;
                         
                     case "6":
                         var fontSize = ".67em";
                         var text = "6";
                         break;
                 }
                 
                 $(headerId).css("fontSize",fontSize);
                 $(numberId).text(text);   
             });
             
             $("#insert_header").click(function(){
                  var select = $("."+external_prefix+"easyText_textarea").selection();
                  var headerSize = $("#range_header").val();
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[H"+headerSize+"]"+select+"[/H"+headerSize+"]"});
                  $("#dialogDiv").hide(100);
             });

             $("#add-grid").click(function(){
                var select = $("."+external_prefix+"easyText_textarea").selection();
                var column_count = $("#range-row-grid").val();

                var columns = "";
                for(i = 0; i < column_count; i++)
                {
                    columns += "[COLUMN]Add text here[/COLUMN]";
                }

                $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[ROW-"+column_count+"]"+columns+"[/ROW]"});
                $("#dialogDiv").hide(100);
            });
             
             $("#align_left").click(function(){
                  var select = $("."+external_prefix+"easyText_textarea").selection();
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[Text-Left]"+select+"[/Text-Left]"});
                  $("#dialogDiv").hide(100); 
             });
              $("#align_center").click(function(){
                  var select = $("."+external_prefix+"easyText_textarea").selection();
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[content-center]"+select+"[/content-center]"});
                  $("#dialogDiv").hide(100); 
             });
              $("#align_right").click(function(){
                  var select = $("."+external_prefix+"easyText_textarea").selection();
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[Text-Right]"+select+"[/Text-Right]"});
                  $("#dialogDiv").hide(100); 
             });
              $("#align_justify").click(function(){
                  var select = $("."+external_prefix+"easyText_textarea").selection();
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[Text-Justify]"+select+"[/Text-Justify]"});
                  $("#dialogDiv").hide(100); 
             });
             
             $("#add_fontawe").click(function(){
                  //var select = $("."+external_prefix+"easyText_textarea").selection();
                  var area = $("#text_fontawe").val();
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[FONT-"+area.toLowerCase()+"]"});
                  $("#dialogDiv").hide(100); 
             });

             
             
             $("#insert_list").click(function(){
                  //var select = $("."+external_prefix+"easyText_textarea").selection();
                  var list_style = $("#ul_style").val();
                  var count_lists = $("#list_count_rows").val();
                  var lists = "";
                  
                  for(i=0; i < count_lists-1; i++)
                  {
                     lists += "\n[Li][/Li]"; 
                  }
                     
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: "[Ul "+list_style+"]"+lists+"\n[/Ul]\n"});
                  $("#dialogDiv").hide(100); 
             });
             

             /* Adding Custom style */
             $(".es_style").click(function(){
                var style_type = $(this).attr("name");
                var split_type = style_type.split(":");

                /* Vars */
                var block_type = split_type[0];
                var block_name = split_type[1];

                var block = "[Style-"+block_type+"-"+block_name+"]";
                 
                if(block_type != "block")
                {
                    var suffix = "[/Span]";
                }
                else
                {
                    var suffix = "[/Style]";
                }

                var select = $("."+external_prefix+"easyText_textarea").selection();
                  $("."+external_prefix+"easyText_textarea").selection('replace', {text: block+select+suffix});
                  $("#dialogDiv").hide(100);
             });
             
              
             
         });
         
         
     
     
     });
     
    

     }
