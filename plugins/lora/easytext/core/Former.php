<?php
namespace Lora\Easytext\Core;
use Lora\Compiler\Compiler;

/**
 * Description of compiler
 *
 * @author michaelmik
 */
class Former
{
    /**
     * @var [type]
     */
    protected $compiler;

    public function __construct()
    {
        $this->compiler = new Compiler();
    }
  
    /**
     * @param string $textarea_name <p>name of textarea (ex.: textarea name='content')</p>
     * @param string $textarea_content <p>Content for textarea (usefull for editing text, in default: '')</p>
     * @param array $options <p>Usefull options (Avaliable: width, height, max_chars, hide_submit, submit_text, required, placeholder)</p>
     */
    public function compileForm(string $textarea_name, string $textarea_content, array $options)
    {
        //Default values for options
        $width = "100";
        $height = "12em";
        $max_chars = 4000;
        $hide_submit = 0;
        $submit_text = "Odeslat";
        $placeholder = "Aa ...";
        $required = true;
        $submit_classes = "";


        $get_content = file_get_contents(__DIR__. "/../template/form_bck.template");

        //Avaliable options (replaces default values)
        foreach($options as $key => $value)
        {
            switch($key)
            {
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
                    if($value == "0" || $value=="none" || $value==null || $value==true)
                    {
                        $required = "";
                    }
                    else
                    {
                        $required = "required";
                    }
                     
                    break;
                case "submit_class":
                    $submit_classes = $value;
                    break;
            }
        }

        if($hide_submit == 0)
        {
            $get_button_content = file_get_contents(__DIR__. "/../template/button.template");
            $get_content = $get_content.$get_button_content;
        }

        
        return $content = $this->compiler->compile($get_content, [
            "{width}" => $width,
            "{height}" => $height,
            "{max_chars}" => $max_chars,
            "{submit_text}" => $submit_text,
            "{textarea_name}" => $textarea_name,
            "{textarea_content}" => $textarea_content,
            "{textarea_placeholder}" => $placeholder,
            "{addit_classes}" => $submit_classes,
            "{required}" => $required,
        ]);

    }
}
