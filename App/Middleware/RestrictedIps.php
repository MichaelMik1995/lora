<?php
declare (strict_types=1);

namespace App\Middleware;
use App\Core\Interface\MiddlewareInterface;


/**
 * Description of RestrictedIps
 *
 * @author michaelmik
 */
class RestrictedIps implements MiddlewareInterface
{
    private $restricted_ips;

    private $ip;
    private string $blacklist_file = ".blacklist";
    private array $blacklist;
    private string $remote_address;

    private array $error = [];

    public function __construct()
    {
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->process();
    }
    
    public function process()
    {
        $this->parseBlacklistFile();
        $this->remote_address = $_SERVER['REMOTE_ADDR'];
        $this->return();
    }

    
    public function return(): Bool
    {
        $condition_array = [];

        if(!empty($this->blacklist))
        {
            foreach ($this->blacklist as $pattern)
            {
                if($this->remote_address == $pattern || str_contains($this->remote_address, $pattern))
                {
                    $this->error[] = "IP: ".$this->remote_address." is matching with: ".$pattern." pattern";
                    $condition_array[] = "false";
                }
                else
                {
                    $condition_array[] = "true";
                }
            }
            
            if(in_array("false", $condition_array))
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }
    
    /**
     * Undocumented function
     *
     * @return array
     */
    public function error(): Array
    {
        return $this->error;
    }

    private function parseBlacklistFile()
    {
        $lines = file($this->blacklist_file, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
        $count = 0;

        foreach($lines as $line) 
        {
            $count += 1;
            $this->blacklist[] = $line;
        }
        
    }
}
