<?php

class externalEditor
{
    public function __construct()
    {
        
        header('Content-Type: application/json');
        
        $content = $_GET["content"];
        $name = $_GET["name"];
        $options = $_GET["options"];
        
        $get_content = file_get_contents("../../../../../plugins/lora/easytext/template/form_external.template");
        
        //Default values for options
        $width = "100";
        $height = "12em";
        $max_chars = 4000;
        $hide_submit = 0;
        $submit_text = "Odeslat";
        $placeholder = "Aa ...";
        $required = true;
        $submit_classes = "";
        
        if($options != "")
        {
            foreach($options as $key => $value)
            {
                switch($key)
                {
                    case "id":
                        $id = $value;
                        break;
                    case "width":
                        $width = $value;
                        break;
                    case "height":
                        $height = $value;
                        break;
                    case "max_chars":
                        $max_chars = $value;
                        break;
                    case "hide_submit":
                        $hide_submit = $value;
                        break;
                    case "submit_text":
                        $submit_text = $value;
                        break;
                    case "placeholder":
                        $placeholder = $value;
                        break;
                    case "required":
                        $required = $value;
                        break;
                    case "submit_class":
                        $submit_classes = $value;
                        break;
                }
            }
        }
        
        $translator = [
            "{id}" => rand(00,99),
           "{width}" => $width,
            "{height}" => $height,
            "{max_chars}" => $max_chars,
            "{submit_text}" => $submit_text,
            "{textarea_name}" => $name,
            "{textarea_content}" => $content,
            "{textarea_placeholder}" => $placeholder,
            "{addit_classes}" => $submit_classes, 
        ];
        
        $array_code = [];
        $array_vars = [];
        
            foreach($translator as $key => $value)
            {
                $array_code[] = $key;
                $array_vars[] = $value;
            }

            $compiled_form = str_replace($array_code, $array_vars, $get_content);
        
        echo json_encode(["editor" => $compiled_form]);
    }
}

$tool = new externalEditor();


?>