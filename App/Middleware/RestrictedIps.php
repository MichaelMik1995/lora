<?php
declare (strict_types=1);

namespace App\Middleware;


/**
 * Description of RestrictedIps
 *
 * @author michaelmik
 */
class RestrictedIps 
{
    protected $restricted_ips;

    protected $ip;

    public function __construct()
    {
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->getBanned();
    }
    
    public function getBanned()
    {
        $this->restricted_ips = $this->writeBanned();
    }
    
    public function return(): Bool
    {
        if(in_array($this->ip, $this->restricted_ips))
        {

            $_SESSION["error_middleware"][] = "Vaše IP adresa je zaregitrována jako nežádoucí!";
            return false;
        }
        else{
            return true;
        }
    }

    private function writeBanned()
    {
        return [
            //"127.0.0.1",
            "123.456.7",
            //"::1"
        ];
    }    
}
