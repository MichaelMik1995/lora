<?php
namespace App\Core\Statistic;

use App\Exception\LoraException;
use App\Middleware\Auth;

/**
 * Description of Clicker
 *
 * @author michaelmik
 */
class Clicker 
{
    private $file;
    private $file_member;
    private $auth;
    //private $exception;
    
    public function __construct(Auth $auth) 
    {
        $this->file = "./log/statistic_click_guest.log";
        $this->file_member = "./log/statistic_click_member.log";
        //$this->exception = new LoraException();
        $this->auth = $auth;
    }
    
    
    public function webClick()
    {
        if(!isset($_SESSION[$this->auth->session_instance]))
        {
            $this->setClick($this->file);
        }
        else
        {
            if(@$_SESSION[$this->auth->session_instance]["uid"] != "952988803")
            {
                $this->setClick($this->file_member);
            }
        }
    }
    
    public function getWebClicks(string $file)
    {
        if(file_exists($file))
        {
            $file_open = fopen($file, "r");
            $clicks = fread($file_open, 11);
            fclose($file_open);
            return $clicks;
        }
        else
        {
            return "Unknown";
        }
    }
    
    private function setClick($file_path)
    {
        if(file_exists($file_path))
        {
            $file = fopen($file_path, "r");
            $previous_count = fread($file, 11);
            fclose($file);
            
            $file_reopen = fopen($file_path, "w");
            $new_click = $previous_count+1;
            fputs($file_reopen, $new_click);
            fclose($file_reopen);
        }
        else
        {
            $file = fopen($file_path, "w+");
            fwrite($file, 0);
            fclose($file);
        }
        
    }
    
    
}
