<?php
namespace App\Middleware;

/**
 * Description of Session
 *
 * @author michaelmik
 */
class Session 
{
    
    public function __construct()
    {
        $this->generateSID(0);
        $this->generateSJID(0);
    }

    public function return(): Bool
    {
        return $this->isEqualSID();
    }

    public function error()
    {
        return [];
    }
    
    public function isEqualSID()
    {
        if(isset($_SESSION['SID']) && isset($_POST["SID"]))
        {
            if(\hash_equals($_SESSION['SID'], $_POST['SID']))
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
            $this->generateSID();
            return true;
        }
    }
    
    public function generateSID(int $regenerate = 0)
    {
        if($regenerate == 0)
        {
            if(!isset($_SESSION["SID"]))
            {
                $generate = md5("SSDTok@Sez".rand(0000,9999).$_SERVER["REMOTE_ADDR"]);
                $_SESSION["SID"] = $generate;
                echo "<script>localStorage.setItem('SID', '".$generate."')</script>";
            }
        }
        else
        {
            if(isset($_SESSION["SID"]))
            {
                unset ($_SESSION["SID"]);
                
                $generate = md5("SSDTok@Sez".rand(0000,9999).$_SERVER["REMOTE_ADDR"]);
                
                $_SESSION["SID"] = $generate;
                echo "<script>localStorage.removeItem('SID')</script>";
                echo "<script>localStorage.setItem('SID', '".$generate."')</script>";
            }
        }
        
    }
    
    public function generateSJID(int $regenerate = 0)
    {
        if($regenerate == 0)
        {
            if(!isset($_SESSION["JSID"]))
            {
                $generate = md5("SSDTok@SezJS!".rand(0000,9999).$_SERVER["REMOTE_ADDR"]);
                $_SESSION["JSID"] = $generate;
                echo "<script>localStorage.setItem('JSID', '".$generate."')</script>";
            }
        }
        else
        {
            if(isset($_SESSION["JSID"]))
            {
                unset ($_SESSION["JSID"]);
                
                $generate = md5("SSDTok@SezJS!".rand(0000,9999).$_SERVER["REMOTE_ADDR"]);
                
                $_SESSION["JSID"] = $generate;
                echo "<script>localStorage.removeItem('SID')</script>";
                echo "<script>localStorage.setItem('JSID', '".$generate."')</script>";
            }
        }
        
    }
}
