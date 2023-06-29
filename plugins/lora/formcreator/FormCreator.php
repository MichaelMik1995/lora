<?php

declare (strict_types=1);
/*
    Plugin Formcreator generated for framework Lora, copyright by company MiroKa
    Plugin Description in Readme.MD
*/
namespace Lora\FormCreator;

use App\Exception\LoraException;
use App\Core\View\Template;
use Lora\Easytext\Easytext;


class FormCreator
{
    const 
        MSG_INVALID_ATTR = "Failed create input element with non-existing parameter",
        MSG_BAD_FORM = "Failed!";
        
    
    protected $default_opts;
    private $form_data = "";
    protected $lora_exception;
    
    protected $easy_text;
    
    public function __construct()
    {
        $this->defaultOptions();
        $this->lora_exception = new LoraException();
        $this->easy_text = new Easytext();
    }
    
    public function __destruct() 
    {
        $this->form_data = null;
    }
    
    
    /**
     * 
     * @param string $action    <p>URL for posting data</p>
     * @param array $options    <p>Attributes for form (ex.: ["enctype"=>"multipart/form-data"])
     * @param string $method    <p>form posting method (default: POST)</p>
     * @return $this            <p>returning method for wiring</p>
     */
    public function form(string $action = "#",  array $options = [], string $method = "POST")
    {
        $special_input_attrs = [
          "enctype",
        ];
        
        $input_start = "<form method='$method' action='/$action'  ";
        $input_end = ">".$this->csrfGen();
        
       $this->prepareAttrs($input_start, $input_end, $special_input_attrs, $options);
        
       return $this;
    }
    
    /**
     * Adds new line to form body (< br >)
     * @return $this
     */
    public function line()
    {
        $this->form_data .= "<br>";
        return $this;
    }
    
    /**
     * 
     * @param string $type      <p>input type (ex.: text, password etc..; default: text)</p>
     * @param array $options    <p>Specific attributes for inputs (ex.: value, size, min, multiple ...)</p>
     * @param int $line         <p>Adds automatic line if int=1 (default: 1)</p>
     * @return $this            <p>returning method for wiring</p>
     */
    public function input(string $type = "text", array $options = [], int $line = 1)
    {
        /** Specific attributes form this element **/
        $special_input_attrs = [
          "value",
            "min",
            "max",
            "size",
            "multiple",
            "readonly",
            "autofocus",
            "list",
            "placeholder",
            "disabled"
        ];
        
        
        $input_start = "<input type=\"$type\"";
        if($line == 1)
        {
            $input_end = "> <br>";
        }
        else
        {
            $input_end = ">";
        }
        
        
        $this->prepareAttrs($input_start, $input_end, $special_input_attrs, $options);
        
        return $this;
    }
    
    
    /**
     * 
     * @param array $options        <p>Specific attributes for element select (ex.: multiple, autofocus, size ...)</p>
     * @return $this                <p>returning method for wiring</p>
     */
    public function select(array $options)
    {
        /** Specific attributes form this element **/
        $special_input_attrs = [
            "multiple",
            "disabled",
            "autofocus",
            "size",
            "hidden",
        ];
        
        
        $input_start = "<select ";
        $input_end = ">";
        
        $this->prepareAttrs($input_start, $input_end, $special_input_attrs, $options);
        
        
        return $this;
    }
    
    
    /**
     * Ends element select (like < / select >)
     * @return $this
     */
    public function endSelect()
    {
        $this->form_data .= "</select>";
        return $this;
    }
    
    
    /**
     * Usefull for body bettwen select() and endSelect()
     * @param string $option_value <p>option value - for posting data</p>
     * @param string $option_name   <p>option name - display text in select</p>
     * @return $this
     */
    public function option(string $option_value, string $option_name)
    {
        $_option_value = htmlspecialchars($option_value);
        $_option_name = htmlspecialchars($option_name);
        $this->form_data .= "<option value='$_option_value'>$_option_name</option>";
        return $this;
    }
    
    /**
     * 
     * @param string $content   <p>text content in textarea (default: "")</p>
     * @param array $options    <p>Specific options for textearea element (ex.: cols, rows, wrap ...)</p>
     * @return $this
     */
    public function textarea(string $content = "", array $options = [])
    {
        $special_atrrs = [
          "cols",
            "rows",
            "disabled",
            "readonly",
            "wrap",
            "autofocus",
            "placeholder",
            "maxlenght",
        ];
        
        $input_start = "<textarea ";
        $input_end = ">";
        
        $this->prepareAttrs($input_start, $input_end, $special_atrrs, $options);
        
        $this->form_data .= htmlspecialchars($content)."</textarea>";
        
        
        return $this;
    }
    
    /**
     * Adds whole editor from easyText into form
     * @param string $name          <p>textarea name (default: content)</p>
     * @param string $content       <p>textarea content (default: "")</p>
     * @param array $options        <p>options for setup easytext (more in @see)</p>
     * @return $this
     * @see plugins\Lora\easytext\src\Easytext
     */
    public function textareaEasyText(string $name = "content", string $content = "", array $options = [])
    {
        $this->form_data .= $this->easy_text->form($name, $content, $options);
        return $this;
    }
    
    
    /**
     * 
     * @param array $options    <p>Set global attributes for elements (ex.: style, id ...) ! EXCEPT CLASS!</p>
     * @param string $class     <p>Set class for form cell (default: form-line)</p>
     * @return $this
     */
    public function formCell(array $options = [], string $class = "form-line")
    {
       
        $special_atrrs = [];
        
        $input_start = "<div class='$class' ";
        $input_end = ">";
        
        $this->prepareAttrs($input_start, $input_end, $special_atrrs, $options);
        
        
        return $this;
    }
    
    /**
     * Ends form cell
     * @return $this
     */
    public function endFormCell()
    {
        $this->form_data .= "</div>";
        return $this;
    }
    
    /**
     * 
     * @param string $label_text    <p>Set label text in element label (ex.: < label > $text < / label >)</p>
     * @param string $label_for     <p>Label for input id (default: #)</p>
     * @param string $class         <p>Set class for label (default: "")</p>
     * @return $this
     */
    public function label(string $label_text, string $label_for = "#", string $class = "")
    {
        $this->form_data .= "<label class='$class' for='$label_for' >$label_text</label>";
        return $this;
    }
    
    
    /**
     * If in form uses textareaEasyText with paramaterer "hide_submit"=>"0", this submit is not required
     * @param string $value     <p>Submit text (default: send)</p>
     * @param string $class     <p>submit class (default: button button-create)<p>
     * @param string $name      <p>submit name (if form uses atrribute action, this is not required)</p>
     * @return $this
     */
    public function submit(string $value = "Send", string $class = "button button-create", string $name = "")
    {
        $this->form_data .= "<button class='$class' type='submit' name='$name'>$value</button>";
        return $this;
    }
    
    /**
     * end form
     * @return $this
     */
    public function endForm()
    {
        $this->form_data .= "</form>";
        return $this;
    }
    
    public function __toString()
    {
        return $this->form_data;
    }
    
    /**
     * defines usefull global atrributes for elements
     * @return type
     */
    private function defaultOptions()
    {
        return $this->default_opts = [
            "class",
            "title",
            "name",
            "id",   
            "style",
            "required",
            "tabindex",
        ];
    }
    
    private function usefullOptions(array $special_options)
    {
        return array_merge($special_options, $this->default_opts);
    }
    
    /**
     * 
     * @param string $element_start         <p>Part of element before $options</p>
     * @param string $element_end           <p>Part of element after $options</p>
     * @param array $special_input_attrs    <p>Special attributes for this element</p>
     * @param array $options                <p>Inject requires options for this element</p>
     */
    private function prepareAttrs(string $element_start, string $element_end, array $special_input_attrs, array $options)
    {
        $result = [];
        $input_attrs = "";
        
        $_options = $this->usefullOptions($special_input_attrs);
        
        foreach($options as $key => $value)
        {
            
            if(in_array($key, $_options)) //classd 
            {
                
                $input_attrs .= " ".htmlspecialchars($key)."='". htmlspecialchars($value)."'";
                $result[] = "true";
            }
            else
            {
                $result[] = "false";
                $this->lora_exception->errorMessage(self::MSG_INVALID_ATTR." $key [$value]");
            }
        }
        
        if(!in_array("false", $result))
        {
            $this->form_data .= $element_start.$input_attrs.$element_end;
            
        }
        else
        {
            $this->form_data = "";
            $this->lora_exception->errorMessage(self::MSG_BAD_FORM);
        }
    }
    
    private function csrfGen()
    {
        $template = new Template();
        $token = $template->token;
        return $token;
    }
    
    
    
}
