<?php
namespace App\Middleware;

/**
 * Description of FormToken
 *
 * @author michaelmik
 */
class FormToken 
{
    public function __construct() 
    {
        if(!isset($_SESSION['token']))
        {
        $this->generateFormToken();
        }
    }
    
    public function return(): Bool
    {
        return $this->isEqualToken();
    }

    public function error()
    {
        return [];
    }

    public function isEqualToken()
    {
        if(isset($_SESSION['token']))
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
        else
        {
            return false;
        }
    }
    
    public function generateFormToken()
    {
        if(!isset($_SESSION["token"]))
        {
            $generate_token = bin2hex(random_bytes(32));
            $_SESSION["token"] = $generate_token;
        }
        
    }
}
