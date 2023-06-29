<?php

namespace App\Middleware;

use App\Exception\LoraException;
use App\Middleware\FormToken;
use App\Middleware\Session;

/**
 * Description of Validation
 *
 * @author michaelmik
 */
class Validation
{
    public $input = [];
    protected $exception; 
    protected $is_validated_field = [];
    protected $form_token;
    protected $session;
    

    /**
     * 
     */
    public function __construct() 
    {
        

        $this->exception = new LoraException();
        $this->form_token = new FormToken();
        $this->session = new Session();
        
        $this->checkFilledInput();
    }
    
    /**
     * 
     */
    public function __destruct() 
    {
        unset($this->input);
    }
    
    /**
     * 
     * VALIDATION options:
     * <p>required, email, not0, antispam, url, small-chars, 0:1, string, int, float</p>
     * <p>chars8-16, chars8-32, int1, int2</p>
     * <p>max_chars[64,128,256,512,1024,2048,4096,6144,9999]</p>
     * @param string $field
     * @param array<array|string> $validation
     * @param string $field_name
     * 
     */
    public function validate($field, $validation = [], string $field_name="")
    {
        try {
            $this->checkValidate($field, $validation, $field_name);
            $this->is_validated_field[] = "true";
        } catch (LoraException $ex) {
            $this->exception->errorMessage($ex->getMessage());
            $this->is_validated_field[] = "false";
        }
    }
    
    /**
     * 
     * @param string $password1
     * @param string $password2
     */
    public function passwordConfirm(string $password1, string $password2)
    {
        try{
            $this->checkPasswordConfirm($password1, $password2);
            $this->is_validated_field[] = "true";
        } catch (LoraException $ex) {
            $this->exception->errorMessage($ex->getMessage());
            $this->is_validated_field[] = "false";
        }
    }
    
    /**
     * After checking Token -> heal input and returns string (input value)
     * 
     * @return string|null Input value
     */
    public function input(string $input_name): String|null
    {
        if($this->checkTokens() == true)
        {
            if(isset($_POST[$input_name]))
            {
                $str = preg_replace('/\x00|<[^>]*>?/', '', $_POST[$input_name]);
                return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
            }
            else
            {
                return null;
            }
        }
        else 
        {
            throw new LoraException("Tokeny nesouhlasí");   
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function isValidated()
    {
        if($this->checkValidated() == true)
        {
            if($this->checkTokens() == true)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    private function checkValidated()
    {
        if(in_array("false", $this->is_validated_field))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * 
     * @param string $password1
     * @param string $password2
     * @return boolean
     * @throws LoraException
     */
    private function checkPasswordConfirm(string $password1, string $password2)
    {
        if($password1 == $password2)
        {
            return true;
        }
        else
        {
            throw new LoraException("Zadaná hesla musí být stejná!");
        }
    }
    
    /**
     * 
     * @param string $field
     * @param array $validation
     * @param string $field_name
     * @throws LoraException
     */
    private function checkValidate($field, $validation = [], string $field_name="")
    {
        if(in_array("required", $validation))
        {
            if($field == "")
            {
                throw new LoraException("Povinné pole \"$field_name\" nesmí být prázdné!");
            }
        }
        
        if(in_array("email", $validation))
        {
            if(!filter_var($field, FILTER_VALIDATE_EMAIL)) 
            {
                throw new LoraException("Pole email \"$field\" není email!");
            }
        }
        
        if(in_array("not0", $validation))
        {
            if(mb_strlen($field) <= 0)
            {
                throw new LoraException("Pole \"$field_name\" nesmí nabývat záporné hodnoty!");
            }
        }
        
        if(in_array("antispam", $validation))
        {
            if($field != DATE("Y")+1)
            {
                throw new LoraException("Nesprávně vyplněný antispam!");
            }
        }
        
        if(in_array("url", $validation))
        {
            
            if(!preg_match('/^([0-9 a-z\s\-]+)$/', $field))
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze malá písmena a pomlčky!");
            }
        }
        
        if(in_array("small-chars", $validation))
        {
            if(!ctype_lower($field))
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze malá písmena!");
            }
        }
        
        if(in_array("maxchars11", $validation))
        {
            if(mb_strlen($field) > 11)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 11 !");
            }
        }
        
        if(in_array("maxchars64", $validation))
        {
            if(mb_strlen($field) > 64)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 64 !");
            }
        }
        
        if(in_array("maxchars128", $validation))
        {
            if(mb_strlen($field) > 128)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 128 !");
            }
        }
        
        if(in_array("maxchars256", $validation))
        {
            if(mb_strlen($field) > 256)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 256 !");
            }
        }
        
        if(in_array("maxchars512", $validation))
        {
            if(mb_strlen($field) > 512)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 512 !");
            }
        }
        
        if(in_array("maxchars1024", $validation))
        {
            if(mb_strlen($field) > 1024)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 1024 !");
            }
        }
        
        if(in_array("maxchars2048", $validation))
        {
            if(mb_strlen($field) > 2048)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 2048 !");
            }
        }
        
        if(in_array("maxchars4096", $validation))
        {
            if(mb_strlen($field) > 4096)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 4096 !");
            }
        }
        
        if(in_array("maxchars6144", $validation))
        {
            if(mb_strlen($field) > 6144)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 6144 !");
            }
        }
        
        if(in_array("maxchars9999", $validation))
        {
            if(mb_strlen($field) > 9999)
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat maximálně 9999 !");
            }
        }
        
        if(in_array("chars8-16", $validation))
        {
            if(mb_strlen($field) < 8 || mb_strlen($field) > 16 )
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat 8 - 16 znaků!");
            }
        }
        
        if(in_array("chars8-32", $validation))
        {
            if(mb_strlen($field) < 8 || mb_strlen($field) > 32 )
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat 8 - 32 znaků!");
            }
        }
        
        if(in_array("0:1", $validation))
        {
            if(!($field == "1" || $field == "0"))
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze 0 nebo 1!");
            }
            /*if(!preg_match('/^[1-9][0-9]{0-8}$/', $field))
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze 0 nebo 1!");
            }*/
        }
        
        if(in_array("string", $validation))
        {
            if(!gettype($field) == "string")
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze řetězec!");
            }
        }
        
        if(in_array("int", $validation))
        {
            if(!is_numeric($field))
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze celé číslo!");
            }
        }
        
        if(in_array("int1", $validation))
        {
            if(!(is_numeric($field) && mb_strlen($field) == 1))
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze jednu cifru!");
            }
        }
        
        if(in_array("int2", $validation))
        {
            if(!(is_numeric($field) && mb_strlen($field) == 2))
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze dvě cifry!");
            }
        }
        
        if(in_array("float", $validation))
        {
            if(!gettype($field) == "double")
            {
                throw new LoraException("Pole \"$field_name\" musí obsahovat pouze desetinné číslo!");
            }
        }
        
        if(in_array("confirmed", $validation))
        {
            if(!($field == "confirmed"))
            {
                throw new LoraException("Pole \"$field_name\" musí být splněno!");
            }
        }
    }
    
    /**
     * 
     */
    private function checkFilledInput()
    {
        if(!empty($_POST))
        {
            try{
                $this->checkTokens();
            } catch (LoraException $ex) {
                $this->exception->errorMessage($ex->getMessage());
            }
        }
    }
    
    /**
     * 
     * @throws LoraException
     */
    private function checkTokens()
    {
        if($this->form_token->isEqualToken() == true)
        {
            return true;
            
        }
        else
        {
            return false; //throw new LoraException("Generované token ID musí procházet!");
        }
        
    }
    
    /**
     * Fills $this->input[] with all $_POST Data (if $_POST != "")
     */
    private function fillInput()
    {
        unset($_SESSION["FORM"]);
        
        if(isset($_POST))
        {
            var_dump($_POST);
            foreach ($_POST as $key => $value)
            {
                if($key != "token" && $key != "SID")
                {
                    $this->input[htmlspecialchars($key, ENT_QUOTES)] = htmlspecialchars($value, ENT_QUOTES);
                    $_SESSION["FORM"][$key] = $value;
                }
            }
        }    
        
        $_SESSION["FORM"]["url"] = $_SERVER['HTTP_REFERER'];
    }
    
 
   

}
