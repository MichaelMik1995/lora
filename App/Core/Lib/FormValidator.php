<?php
declare(strict_types=1);

namespace App\Core\Lib;

use App\Exception\LoraException;

trait FormValidator
{
    private $_instance;
    private array $failed_checks = [];

    private array $return_values = [];


    /**
     * Summary of input
     * @param mixed $field
     * @param array|string $options
     * @param string $field_name
     * @return FormValidator
     */
    public function input(mixed $field, array|string $options = null, string $field_name = "")
    {
        $_field = $this->healInput($field);

        if($options != null)
        {
            $this->checkOptions($_field, $options, $field_name);
        }

        $this->return_values[$field] = $_field;

        return $this;
    }

    /**
     * Summary of check
     * @return FormValidator
     */
    public function check()
    {
        if(!empty($this->failed_checks))
        {
            var_dump($this->failed_checks);
        }
        else
        {
            echo "<br>Validace úspěšná<br>";
        }
        return $this;
    }

    /**
     * Summary of returnFields
     * @return array
     */
    public function returnFields(): Array
    {
        return $this->return_values;
    }

    /**
     * Summary of validate
     * @return bool
     */
    public function validate(): Bool
    {
        if(!empty($this->failed_checks))
        {
            $errors = "";
            foreach($this->failed_checks as $error)
            {
                $errors .= $error[1].", ";
            }
            throw new LoraException("Chybná validace: ".rtrim($errors, ", "));
        }
        else
        {
            if($this->checkTokens() === true)
            {
                return true;
            }
            else
            {
                throw new LoraException("Tokeny nesouhlasí");
            }
        }
    }

    /**
     * Summary of error
     * @return array
     */
    public function error(): Array
    {
        $errors = [];
        if(!empty($this->failed_checks))
        {
            foreach($this->failed_checks as $error)
            {
                $errors[] = $error[1];
            }
            return $errors;
        }
        else
        {
            return [];
        }
    }

    /**
     * Summary of clearValidation
     * @return bool
     */
    public function clearValidation(): Bool
    {
        $this->failed_checks = [];
        $this->return_values = [];
        return true;
    }


    /**
     * Summary of checkInput
     * @param mixed $field
     * @return mixed
     */
    private function healInput(mixed $field): Mixed
    {
        if(isset($_POST[$field]))
        {
            if(is_array($_POST[$field]))
            {
                $healed_array = [];

                foreach($_POST[$field] as $key => $value)
                {
                    $_value = preg_replace('/\x00|<[^>]*>?/', '', $value);
                    $healed_array[$key] = $_value;
                }
                return $healed_array;
            } 
            else 
            {
                $str = preg_replace('/\x00|<[^>]*>?/', '', $_POST[$field]);
                return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
            }
        }
        else
        {
            return null;
        }
    }

    private function checkOptions(mixed $field, array|string $options, string $field_name = "")
    {
        
        if($field_name == "")
        {
            $field_name = $field;
        }

        if(gettype($options) == "string")
        {
            $remove_space = str_replace(" ", "", $options);
            $explode = explode(",", $remove_space);


            $validation = $explode;
        }
        else
        {
            $validation = $options;
        }

        
        if(in_array("required", $validation))
        {
            if($field == "")
            {
                $this->failed_checks[] = [$field, "Povinné pole \"$field_name\" nesmí být prázdné!"];
            }
        }
        
        if(in_array("email", $validation))
        {
            if(!filter_var($field, FILTER_VALIDATE_EMAIL)) 
            {
                $this->failed_checks[] = [$field, "Pole email \"$field\" není email!"];
            }
        }
        
        if(in_array("not0", $validation))
        {
            if(mb_strlen($field) <= 0)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" nesmí nabývat záporné hodnoty!"];
            }
        }
        
        if(in_array("antispam", $validation))
        {
            if($field != DATE("Y")+1)
            {
                $this->failed_checks[] = [$field, "Nesprávně vyplněný antispam!"];
            }
        }
        
        if(in_array("url", $validation))
        {
            
            if(!preg_match('/^([0-9 a-z\s\-]+)$/', $field))
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze malá písmena a pomlčky!"];
            }
        }
        
        if(in_array("small-chars", $validation))
        {
            if(!ctype_lower($field))
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze malá písmena!"];
            }
        }
        
        if(in_array("maxchars11", $validation))
        {
            if(mb_strlen($field) > 11)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 11 !"];
            }
        }
        
        if(in_array("maxchars64", $validation))
        {
            if(mb_strlen($field) > 64)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 64 !"];
            }
        }
        
        if(in_array("maxchars128", $validation))
        {
            if(mb_strlen($field) > 128)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 128 !"];
            }
        }
        
        if(in_array("maxchars256", $validation))
        {
            if(mb_strlen($field) > 256)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 256 !"];
            }
        }
        
        if(in_array("maxchars512", $validation))
        {
            if(mb_strlen($field) > 512)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 512 !"];
            }
        }
        
        if(in_array("maxchars1024", $validation))
        {
            if(mb_strlen($field) > 1024)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 1024 !"];
            }
        }
        
        if(in_array("maxchars2048", $validation))
        {
            if(mb_strlen($field) > 2048)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 2048 !"];
            }
        }
        
        if(in_array("maxchars4096", $validation))
        {
            if(mb_strlen($field) > 4096)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 4096 !"];
            }
        }
        
        if(in_array("maxchars6000", $validation))
        {
            if(mb_strlen($field) > 6000)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 6000 !"];
            }
        }

        if(in_array("maxchars6144", $validation))
        {
            if(mb_strlen($field) > 6144)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 6144 !"];
            }
        }
        
        if(in_array("maxchars9999", $validation))
        {
            if(mb_strlen($field) > 9999)
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat maximálně 9999 !"];
            }
        }
        
        if(in_array("chars8-16", $validation))
        {
            if(mb_strlen($field) < 8 || mb_strlen($field) > 16 )
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat 8 - 16 znaků!"];
            }
        }
        
        if(in_array("chars8-32", $validation))
        {
            if(mb_strlen($field) < 8 || mb_strlen($field) > 32 )
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat 8 - 32 znaků!"];
            }
        }
        
        if(in_array("0:1", $validation))
        {
            if(!($field == "1" || $field == "0"))
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze 0 nebo 1!"];
            }
        }
        
        if(in_array("string", $validation))
        {
            if(!gettype($field) == "string")
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze řetězec!"];
            }
        }
        
        if(in_array("int", $validation))
        {
            if(!is_numeric($field))
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze celé číslo!"];
            }
        }
        
        if(in_array("int1", $validation))
        {
            if(!(is_numeric($field) && mb_strlen($field) == 1))
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze jednu cifru!"];
            }
        }
        
        if(in_array("int2", $validation))
        {
            if(!(is_numeric($field) && mb_strlen($field) == 2))
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze dvě cifry!"];
            }
        }
        
        if(in_array("float", $validation))
        {
            if(!gettype($field) == "double")
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí obsahovat pouze desetinné číslo!"];
            }
        }
        
        if(in_array("confirmed", $validation))
        {
            if(!($field == "confirmed"))
            {
                $this->failed_checks[] = [$field, "Pole \"$field_name\" musí být splněno!"];
            }
        }
    }

    private static function checkTokens(): Bool
    {
        if(\hash_equals($_SESSION['token'], $_POST['token']))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}