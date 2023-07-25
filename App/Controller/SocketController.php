<?php
/*
declare (strict_types=1);

namespace App\Controller;

class SocketController extends Controller 
{
    protected $auth;
    protected $validation;
    
    public function index() 
    {
        
        $action = @$url[1];                                                 // $action [create|update|show ..] (/controller/ACTION/route_param)
        $route_param = @$url[2];                                            // for showing, editing, deleting row (/controller/action/ROUTE_PARAM)
        
        $container = $this->class["ArrayUtils"];   
            
        switch($action)
        {
            case "send-template":
                $ajax_token = $_POST['AJAXToken'];
                
                $validation_token = $_POST['token'];
                $validation_SID = $_POST['SID'];
                
                $fail = "";
                $return = "";
                
                if($ajax_token == "true" && $validation_token == $_SESSION["token"] && $validation_SID == $_SESSION["SID"])
                {
                    $data = $_POST["data"];
                    $module = $_POST['module'];
                    $template = $_POST['template'];
                    
                    $filename = "./App/Modules/". ucfirst($module)."Module/resources/templates/$template.template";
    
                    if(file_exists($filename))
                    {
                        $file_content = file_get_contents($filename);
                        
                        foreach($data as $key => $value)
                        {
                            $array_code[] = $key;
                            $array_vars[] = $value;  
                        }
                        
                        $return = str_replace($array_code, $array_vars, $file_content);
                    }
                    else
                    {
                        $fail .= "Template not exists! ";
                    }
                }
                else
                {
                    $fail .="Token or SID do not match! ";
                }
                
                echo json_encode(["return"=>$return,"fail"=>$fail]);   
                
                break;
        }
    }
}
?>
