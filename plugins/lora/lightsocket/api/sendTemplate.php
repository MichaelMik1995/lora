<?php

class Temp
{
    protected $post = [];
    protected $return = [];
    protected $error = "";
    
    public function __construct() 
    {
        session_start();
        $this->post = $_POST;
    }
    
    public function Template()
    {
        $data = $this->post["data"];
        $module = $this->post['module'];
        $template = $this->post['template'];
        $token = $this->post['token'];
        $SID = $this->post['SID'];

        if(hash_equals($_SESSION['token'], $token) && hash_equals($_SESSION['SID'], $SID))
        {
            $filename = __DIR__."/../templates/$template.template";

            $file_content = file_get_contents($filename);



            foreach($data as $key => $value)
            {
                $array_code[] = $key;
                $array_vars[] = $value;  
            }

            $return_element = str_replace($array_code, $array_vars, $file_content);

            //Replaces Template data
            $replace_template = [
                "@if" => '<?php',
                "@endif" => '?>'
            ];

            foreach($replace_template as $key => $value)
            {
                $replaced_code[] = $key;
                $replaced_vars[] = $value;  
            }

            $return_replaced = str_replace($replaced_code, $replaced_vars, $return_element);

            $this->return = $return_replaced;
        }
        else
        {
            
            $this->error .= "Failed to verify Tokens! ";
        }
    }
    
    
    public function sendReturn()
    {
        $this->Template();
        echo json_encode(["return" => $this->return, "error" => $this->error], JSON_UNESCAPED_SLASHES);
    }
}

$init = new Temp();
$init->sendReturn();
    
?>
